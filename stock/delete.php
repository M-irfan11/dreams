<?php
require_once '../component/connection.php'; 


$product_id   = isset($_GET['product_id']) ? (int) $_GET['product_id'] : 0;
$warehouse_id = isset($_GET['warehouse_id']) ? (int) $_GET['warehouse_id'] : 0;

if ($product_id > 0 && $warehouse_id > 0) {
    $where = [
        "product_id"   => $product_id,
        "warehouse_id" => $warehouse_id
    ];

    $delete_result = $crud->common_delete("stocks", $where, "AND");

    if ($delete_result["status"]) {
        $_SESSION['flash_message'] = "Stock record deleted successfully";
        $_SESSION['flash_type']    = "success";
    } else {
        $_SESSION['flash_message'] = "Failed to delete stock record: " . $delete_result["message"];
        $_SESSION['flash_type']    = "error";
    }
} else {
    $_SESSION['flash_message'] = "Invalid stock record";
    $_SESSION['flash_type']    = "error";
}

header("Location: list.php");
exit;