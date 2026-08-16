<?php

require_once '../component/connection.php';

$crud->conn->begin_transaction();

try {

    $purchase_id = (int)$_POST['purchase_id'];
    $return_date = $_POST['return_date'];
    $reason = $_POST['reason'];

    // -------------------------
    // GET THE PURCHASE (for supplier_id)
    // -------------------------

    $purchase_result = $crud->common_select('purchases', '*', ['id' => $purchase_id]);
    if(!$purchase_result['status']){
        throw new Exception("Original purchase not found.");
    }
    $purchase = $purchase_result['data'][0];

    // stock returns come out of whichever warehouse the original purchase went into
    // (purchases has no warehouse_id column - pull it from the stock-in rows this purchase created)
    $wh_result = $crud->common_query("SELECT warehouse_id FROM stocks
        WHERE purchase_id = $purchase_id AND purchase_return_id IS NULL AND deleted_at IS NULL LIMIT 1");
    if(!$wh_result['status']){
        throw new Exception("This purchase has no warehouse assigned - cannot process a stock return.");
    }
    $warehouse_id = $wh_result['data'][0]->warehouse_id;


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

        // recalculate remaining returnable quantity for this product on this purchase
        $check = $crud->common_query("SELECT purchase_details.quantity,
            (purchase_details.quantity - IFNULL((
                SELECT SUM(prd.quantity) FROM purchase_return_details prd
                JOIN purchase_returns pr ON pr.id = prd.purchase_return_id
                WHERE pr.purchase_id = $purchase_id
                    AND prd.product_id = $product_id
                    AND pr.deleted_at IS NULL AND prd.deleted_at IS NULL
                    AND pr.status = 1
            ), 0)) as remaining_qty
            FROM purchase_details
            WHERE purchase_details.purchase_id = $purchase_id AND purchase_details.product_id = $product_id
                AND purchase_details.deleted_at IS NULL");

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
    // INSERT PURCHASE RETURN
    // -------------------------

    $data = [
        "purchase_id" => $purchase_id,
        "supplier_id" => $purchase->supplier_id,
        "return_date" => $return_date,
        "total_amount" => $total_amount,
        "reason" => $reason,
        "status" => 1, // 1 = Active
        "created_at" => date('Y-m-d H:i:s'),
        "created_by" => $_SESSION['user_id']
    ];

    $result = $crud->common_insert('purchase_returns', $data);

    if(!$result['status']){
        throw new Exception($result['message']);
    }

    $purchase_return_id = $result['data'];


    // -------------------------
    // INSERT RETURN DETAILS + STOCK OUT
    // -------------------------

    foreach($return_items as $item){

        $detail_result = $crud->common_insert('purchase_return_details', [
            "purchase_return_id" => $purchase_return_id,
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

        // STOCK OUT - negative quantity removes it from the stocks ledger
        // (a purchase brought stock IN as a positive row - a purchase return takes it back OUT)
        $stock_data = [
            "product_id" => $item['product_id'],
            "quantity" => "-" . $item['quantity'],
            "warehouse_id" => $warehouse_id,
            "stock_date" => $return_date,
            "purchase_id" => $purchase_id,
            "purchase_return_id" => $purchase_return_id,
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
        "message" => "Purchase return saved successfully."
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

    $back_purchase_id = isset($_POST['purchase_id']) ? (int)$_POST['purchase_id'] : 0;
    header("Location: create.php?purchase_id=$back_purchase_id");
    exit();
}
