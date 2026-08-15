<?php

require_once '../component/connection.php';

$crud->conn->begin_transaction();

try {

    $id = (int)$_GET['id'];
    $return_date = $_POST['return_date'];
    $new_status = (int)$_POST['status'];
    $reason = $_POST['reason'];

    // -------------------------
    // GET CURRENT RECORD (need old status + warehouse to know if stock needs adjusting)
    // -------------------------

    $old_result = $crud->common_select('sales_returns', '*', ['id' => $id]);
    if(!$old_result['status']){
        throw new Exception("Sales return not found.");
    }
    $old = $old_result['data'][0];
    $old_status = (int)$old->status;


    // -------------------------
    // IF STATUS CHANGED, ADJUST STOCK
    // -------------------------

    if($old_status !== $new_status){

        // need the original sale's warehouse (same warehouse the stock was returned to)
        $sale_result = $crud->common_select('sales', '*', ['id' => $old->sale_id]);
        if(!$sale_result['status'] || empty($sale_result['data'][0]->warehouse_id)){
            throw new Exception("Cannot adjust stock - original sale or its warehouse could not be found.");
        }
        $warehouse_id = $sale_result['data'][0]->warehouse_id;

        // get the returned line items
        $details_result = $crud->common_select('sales_return_details', '*', ['sale_return_id' => $id]);
        $details = $details_result['status'] ? $details_result['data'] : [];

        foreach($details as $item){

            if($old_status == 1 && $new_status == 2){
                // Active -> Cancelled: undo the earlier stock IN (subtract it back out)
                $qty = "-" . $item->quantity;
            } elseif($old_status == 2 && $new_status == 1){
                // Cancelled -> Active: re-apply the stock IN
                $qty = $item->quantity;
            } else {
                continue;
            }

            $stock_result = $crud->common_insert('stocks', [
                "product_id" => $item->product_id,
                "quantity" => $qty,
                "warehouse_id" => $warehouse_id,
                "stock_date" => $return_date,
                "sale_id" => $old->sale_id,
                "sale_return_id" => $id,
                "created_at" => date('Y-m-d H:i:s')
            ]);

            if(!$stock_result['status']){
                throw new Exception($stock_result['message']);
            }
        }
    }


    // -------------------------
    // UPDATE THE RETURN RECORD
    // -------------------------

    $data = [
        "return_date" => $return_date,
        "status" => $new_status,
        "reason" => $reason,
        "updated_at" => date('Y-m-d H:i:s'),
        "updated_by" => $_SESSION['user_id']
    ];

    $result = $crud->common_update('sales_returns', $data, ["id" => $id]);

    if(!$result['status']){
        throw new Exception($result['message']);
    }

    $crud->conn->commit();

    $_SESSION['message'] = [
        "type" => "success",
        "title" => "Success",
        "message" => "Sales return updated successfully."
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

    header("Location: update.php?id=" . (int)$_GET['id']);
    exit();
}
