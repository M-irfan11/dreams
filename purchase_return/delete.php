<?php

require_once '../component/connection.php';

$crud->conn->begin_transaction();

try {

    if(!isset($_GET['id'])){
        throw new Exception("No purchase return specified.");
    }

    $id = (int)$_GET['id'];

    $return_result = $crud->common_select('purchase_returns', '*', ['id' => $id]);
    if(!$return_result['status']){
        throw new Exception("Purchase return not found.");
    }
    $purchase_return = $return_result['data'][0];


    // -------------------------
    // IF THIS RETURN WAS ACTIVE, REVERSE THE STOCK IT REMOVED
    // (deleting it should not leave stock missing that was never really returned)
    // -------------------------

    if((int)$purchase_return->status === 1){

        $wh_result = $crud->common_query("SELECT warehouse_id FROM stocks
            WHERE purchase_return_id = $id AND deleted_at IS NULL LIMIT 1");
        if(!$wh_result['status']){
            throw new Exception("Cannot adjust stock - the original stock movement for this return could not be found.");
        }
        $warehouse_id = $wh_result['data'][0]->warehouse_id;

        $details_result = $crud->common_select('purchase_return_details', '*', ['purchase_return_id' => $id]);
        $details = $details_result['status'] ? $details_result['data'] : [];

        foreach($details as $item){
            $stock_result = $crud->common_insert('stocks', [
                "product_id" => $item->product_id,
                "quantity" => $item->quantity,
                "warehouse_id" => $warehouse_id,
                "stock_date" => date('Y-m-d'),
                "purchase_id" => $purchase_return->purchase_id,
                "purchase_return_id" => $id,
                "created_at" => date('Y-m-d H:i:s')
            ]);

            if(!$stock_result['status']){
                throw new Exception($stock_result['message']);
            }

            // soft delete the detail row too
            $crud->common_update('purchase_return_details', [
                "deleted_at" => date('Y-m-d H:i:s'),
                "updated_by" => $_SESSION['user_id']
            ], ["id" => $item->id]);
        }
    }


    // -------------------------
    // SOFT DELETE THE RETURN ITSELF
    // -------------------------

    $result = $crud->common_update('purchase_returns', [
        "deleted_at" => date('Y-m-d H:i:s'),
        "updated_by" => $_SESSION['user_id']
    ], ["id" => $id]);

    if(!$result['status']){
        throw new Exception($result['message']);
    }

    $crud->conn->commit();

    $_SESSION['message'] = [
        "type" => "success",
        "title" => "Deleted",
        "message" => "Purchase return deleted successfully."
    ];

} catch (Exception $e){

    $crud->conn->rollback();

    $_SESSION['message'] = [
        "type" => "danger",
        "title" => "Error",
        "message" => $e->getMessage()
    ];
}

header("Location: list.php");
exit();
