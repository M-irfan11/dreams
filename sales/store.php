<?php

require_once '../component/connection.php';

$crud->conn->begin_transaction();

try {

    // -------------------------
    // SALE INFORMATION
    // -------------------------

    $data = [
        "customer_id"  => $_POST['customer_id'],
        "user_id"      => $_SESSION['user_id'],
        "sale_date"    => $_POST['sale_date'],
        "total_amount" => $_POST['total_amount'],
        "discount"     => $_POST['discount'],
        "tax"          => $_POST['tax'],
        "status"       => $_POST['status'],
        "created_at"   => date('Y-m-d H:i:s'),
        "created_by"   => $_SESSION['user_id']
    ];


    // Warehouse optional
    if (!empty($_POST['warehouse_id'])) {
        $data["warehouse_id"] = $_POST['warehouse_id'];
    }


    // -------------------------
    // INSERT SALE
    // -------------------------

    $result = $crud->common_insert('sales', $data);

    if (!$result['status']) {
        throw new Exception($result['message']);
    }

    // New sale ID
    $sale_id = $result['data'];


    // -------------------------
    // INSERT SALE DETAILS
    // + STOCK OUT
    // -------------------------

    foreach ($_POST['product_id'] as $index => $product_id) {

        $quantity     = $_POST['quantity'][$index];
        $unit_price   = $_POST['unit_price'][$index];
        $subtotal     = $_POST['subtotal'][$index];


        // -------------------------
        // SALE DETAILS
        // -------------------------

        $sale_detail = [
            "sale_id"      => $sale_id,
            "product_id"   => $product_id,
            "quantity"     => $quantity,
            "unit_price"   => $unit_price,
            "subtotal"     => $subtotal,
            "created_at"   => date('Y-m-d H:i:s'),
            "created_by"   => $_SESSION['user_id']
        ];

        $detail_result = $crud->common_insert(
            'sale_details',
            $sale_detail
        );

        if (!$detail_result['status']) {
            throw new Exception($detail_result['message']);
        }


        // -------------------------
        // STOCK OUT
        // status = 0 means OUT
        // -------------------------

        $stock_data = [
            "product_id"    => $product_id,
            "quantity"      => $quantity,
            "status"        => 0,
            "transfer_date" => $_POST['sale_date'],
            "sale_id"       => $sale_id,
            "created_at"    => date('Y-m-d H:i:s'),
            "created_by"    => $_SESSION['user_id']
        ];


        // Add warehouse if selected
        if (!empty($_POST['warehouse_id'])) {
            $stock_data["warehouse_id"] = $_POST['warehouse_id'];
        }


        $stock_result = $crud->common_insert(
            'stock_transfers',
            $stock_data
        );

        if (!$stock_result['status']) {
            throw new Exception($stock_result['message']);
        }
    }



    $crud->conn->commit();

    $_SESSION['message'] = [
        "type"    => "success",
        "title"   => "Success",
        "message" => "Sale added successfully."
    ];

    header("Location: list.php");
    exit();


} catch (Exception $e) {

    // Something failed
    $crud->conn->rollback();

    $_SESSION['message'] = [
        "type"    => "danger",
        "title"   => "Error",
        "message" => $e->getMessage()
    ];

    header("Location: add.php");
    exit();
}
?>