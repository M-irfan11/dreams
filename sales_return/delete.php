<?php

require_once '../component/connection.php';

$crud->conn->begin_transaction();

try {

    if(!isset($_GET['id'])){
        throw new Exception("No sales return specified.");
    }

    $id = (int)$_GET['id'];

    $return_result = $crud->common_select('sales_returns', '*', ['id' => $id]);
    if(!$return_result['status']){
        throw new Exception("Sales return not found.");
    }
    $sales_return = $return_result['data'][0];


    // -------------------------
    // IF THIS RETURN WAS ACTIVE, REVERSE THE STOCK IT ADDED
    // (deleting it should not leave stock sitting there that was never really returned)
    // -------------------------

    if((int)$sales_return->status === 1){

        $sale_result = $crud->common_select('sales', '*', ['id' => $sales_return->sale_id]);
        if(!$sale_result['status'] || empty($sale_result['data'][0]->warehouse_id)){
            throw new Exception("Cannot adjust stock - original sale or its warehouse could not be found.");
        }
        $warehouse_id = $sale_result['data'][0]->warehouse_id;

        $details_result = $crud->common_select('sales_return_details', '*', ['sale_return_id' => $id]);
        $details = $details_result['status'] ? $details_result['data'] : [];

        foreach($details as $item){
            $stock_result = $crud->common_insert('stocks', [
                "product_id" => $item->product_id,
                "quantity" => "-" . $item->quantity,
                "warehouse_id" => $warehouse_id,
                "stock_date" => date('Y-m-d'),
                "sale_id" => $sales_return->sale_id,
                "sale_return_id" => $id,
                "created_at" => date('Y-m-d H:i:s')
            ]);

            if(!$stock_result['status']){
                throw new Exception($stock_result['message']);
            }

            // soft delete the detail row too
            $crud->common_update('sales_return_details', [
                "deleted_at" => date('Y-m-d H:i:s'),
                "updated_by" => $_SESSION['user_id']
            ], ["id" => $item->id]);
        }
    }


    // -------------------------
    // SOFT DELETE THE RETURN ITSELF
    // -------------------------

    $result = $crud->common_update('sales_returns', [
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
        "message" => "Sales return deleted successfully."
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
