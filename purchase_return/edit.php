<?php

require_once '../component/connection.php';

$crud->conn->begin_transaction();

try {

    $id = (int)$_GET['id'];
    $return_date = $_POST['return_date'];
    $new_status = (int)$_POST['status'];
    $reason = $_POST['reason'];

    // -------------------------
    // GET CURRENT RECORD (need old status to know if stock needs adjusting)
    // -------------------------

    $old_result = $crud->common_select('purchase_returns', '*', ['id' => $id]);
    if(!$old_result['status']){
        throw new Exception("Purchase return not found.");
    }
    $old = $old_result['data'][0];
    $old_status = (int)$old->status;


    // -------------------------
    // IF STATUS CHANGED, ADJUST STOCK
    // -------------------------

    if($old_status !== $new_status){

        // warehouse this return originally moved stock out of
        $wh_result = $crud->common_query("SELECT warehouse_id FROM stocks
            WHERE purchase_return_id = $id AND deleted_at IS NULL LIMIT 1");
        if(!$wh_result['status']){
            throw new Exception("Cannot adjust stock - the original stock movement for this return could not be found.");
        }
        $warehouse_id = $wh_result['data'][0]->warehouse_id;

        // get the returned line items
        $details_result = $crud->common_select('purchase_return_details', '*', ['purchase_return_id' => $id]);
        $details = $details_result['status'] ? $details_result['data'] : [];

        foreach($details as $item){

            if($old_status == 1 && $new_status == 2){
                // Active -> Cancelled: undo the earlier stock OUT (add it back)
                $qty = $item->quantity;
            } elseif($old_status == 2 && $new_status == 1){
                // Cancelled -> Active: re-apply the stock OUT
                $qty = "-" . $item->quantity;
            } else {
                continue;
            }

            $stock_result = $crud->common_insert('stocks', [
                "product_id" => $item->product_id,
                "quantity" => $qty,
                "warehouse_id" => $warehouse_id,
                "stock_date" => $return_date,
                "purchase_id" => $old->purchase_id,
                "purchase_return_id" => $id,
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

    $result = $crud->common_update('purchase_returns', $data, ["id" => $id]);

    if(!$result['status']){
        throw new Exception($result['message']);
    }

    $crud->conn->commit();

    $_SESSION['message'] = [
        "type" => "success",
        "title" => "Success",
        "message" => "Purchase return updated successfully."
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
