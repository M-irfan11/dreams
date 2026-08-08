<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/component/connection.php";

if (!isset($_SESSION['is_logged_in']) || !$_SESSION['is_logged_in']) {
    header("Location: {$base_url}login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: {$base_url}stock/list.php");
    exit;
}

$id           = (int)($_POST['id'] ?? 0);
$product_id   = (int)($_POST['product_id'] ?? 0);
$warehouse_id = (int)($_POST['warehouse_id'] ?? 0);
$quantity     = (int)($_POST['quantity'] ?? 0);

if ($id <= 0 || $product_id <= 0 || $warehouse_id <= 0) {
    $_SESSION['flash_message'] = "Invalid data submitted.";
    $_SESSION['flash_type']    = "error";
    header("Location: {$base_url}stock/edit.php?id={$id}");
    exit;
}

$data = [
    "product_id"   => $product_id,
    "warehouse_id" => $warehouse_id,
    "quantity"     => $quantity
];

$where = ["id" => $id];

$result = $crud->common_update("stocks", $data, $where);

$_SESSION['flash_message'] = $result['status'] ? "Stock record updated successfully" : $result['message'];
$_SESSION['flash_type']    = $result['status'] ? "success" : "error";

header("Location: {$base_url}stock/list.php");
exit;