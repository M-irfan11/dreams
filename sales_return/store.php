<?php

require_once '../component/connection.php';

$crud->conn->begin_transaction();

try {

    $sale_id = (int)$_POST['sale_id'];
    $return_date = $_POST['return_date'];
    $reason = $_POST['reason'];

    // -------------------------
    // GET THE SALE (for customer_id)
    // -------------------------

    $sale_result = $crud->common_select('sales', '*', ['id' => $sale_id]);
    if(!$sale_result['status']){
        throw new Exception("Original sale not found.");
    }
    $sale = $sale_result['data'][0];

    // stock returns go back to whichever warehouse the original sale was made from
    if(empty($sale->warehouse_id)){
        throw new Exception("This sale has no warehouse assigned - cannot process a stock return.");
    }
    $warehouse_id = $sale->warehouse_id;


    // -------------------------
    // VALIDATE + BUILD RETURN ITEMS
    // (never trust the browser - recheck remaining returnable quantity here)
    // -------------------------

    $return_items = [];
    $total_amount = 0;

    foreach($_POST['product_id'] as $index => $product_id){

        $quantity = (int)$_POST['quantity'][$index];

        // skip products the user left at 0
        if($quantity <= 0){
            continue;
        }

        $unit_price = $_POST['unit_price'][$index];
        $subtotal = $_POST['subtotal'][$index];

        // recalculate remaining returnable quantity for this product on this sale
        $check = $crud->common_query("SELECT sale_details.quantity,
            (sale_details.quantity - IFNULL((
                SELECT SUM(srd.quantity) FROM sales_return_details srd
                JOIN sales_returns sr ON sr.id = srd.sale_return_id
                WHERE sr.sale_id = $sale_id
                    AND srd.product_id = $product_id
                    AND sr.deleted_at IS NULL AND srd.deleted_at IS NULL
                    AND sr.status = 1
            ), 0)) as remaining_qty
            FROM sale_details
            WHERE sale_details.sale_id = $sale_id AND sale_details.product_id = $product_id
                AND sale_details.deleted_at IS NULL");

        if(!$check['status']){
            throw new Exception("Could not verify returnable quantity for product ID $product_id.");
        }

        $remaining_qty = $check['data'][0]->remaining_qty;

        if($quantity > $remaining_qty){
            throw new Exception("Return quantity for product ID $product_id exceeds the remaining returnable quantity ($remaining_qty).");
        }

        $return_items[] = [
            "product_id" => $product_id,
            "quantity" => $quantity,
            "unit_price" => $unit_price,
            "subtotal" => $subtotal
        ];

        $total_amount += $subtotal;
    }

    if(empty($return_items)){
        throw new Exception("Please enter a return quantity for at least one product.");
    }


    // -------------------------
    // INSERT SALES RETURN
    // -------------------------

    $data = [
        "sale_id" => $sale_id,
        "customer_id" => $sale->customer_id,
        "return_date" => $return_date,
        "total_amount" => $total_amount,
        "reason" => $reason,
        "status" => 1, // 1 = Active
        "created_at" => date('Y-m-d H:i:s'),
        "created_by" => $_SESSION['user_id']
    ];

    $result = $crud->common_insert('sales_returns', $data);

    if(!$result['status']){
        throw new Exception($result['message']);
    }

    $sale_return_id = $result['data'];


    // -------------------------
    // INSERT RETURN DETAILS + STOCK IN
    // -------------------------

    foreach($return_items as $item){

        $detail_result = $crud->common_insert('sales_return_details', [
            "sale_return_id" => $sale_return_id,
            "product_id" => $item['product_id'],
            "quantity" => $item['quantity'],
            "unit_price" => $item['unit_price'],
            "subtotal" => $item['subtotal'],
            "created_at" => date('Y-m-d H:i:s'),
            "created_by" => $_SESSION['user_id']
        ]);

        if(!$detail_result['status']){
            throw new Exception($detail_result['message']);
        }

        // STOCK IN - positive quantity adds back to the stocks ledger
        // (mirrors add.php, which inserts a NEGATIVE quantity into `stocks` for a sale)
        $stock_data = [
            "product_id" => $item['product_id'],
            "quantity" => $item['quantity'],
            "warehouse_id" => $warehouse_id,
            "stock_date" => $return_date,
            "sale_id" => $sale_id,
            "sale_return_id" => $sale_return_id,
            "created_at" => date('Y-m-d H:i:s')
        ];

        $stock_result = $crud->common_insert('stocks', $stock_data);

        if(!$stock_result['status']){
            throw new Exception($stock_result['message']);
        }
    }

    $crud->conn->commit();

    $_SESSION['message'] = [
        "type" => "success",
        "title" => "Success",
        "message" => "Sales return saved successfully."
    ];

    header("Location: list.php");
    exit();

} catch (Exception $e){

    $crud->conn->rollback();

    $_SESSION['message'] = [
        "type" => "danger",
        "title" => "Error",
        "message" => $e->getMessage()
    ];

    $back_sale_id = isset($_POST['sale_id']) ? (int)$_POST['sale_id'] : 0;
    header("Location: create.php?sale_id=$back_sale_id");
    exit();
}
