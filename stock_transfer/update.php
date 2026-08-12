<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/component/connection.php";

if (!isset($_SESSION['is_logged_in']) || !$_SESSION['is_logged_in']) {
    header("Location: {$base_url}login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: {$base_url}stock_transfer/list.php");
    exit;
}

$id            = (int)($_POST['id'] ?? 0);
$product_id    = (int)($_POST['product_id'] ?? 0);
$quantity      = (int)($_POST['quantity'] ?? 0);
$transfer_date = $_POST['transfer_date'] ?? '';
$status        = (int)($_POST['status'] ?? 1);

$sale_id             = !empty($_POST['sale_id']) ? (int)$_POST['sale_id'] : null;
$purchase_id         = !empty($_POST['purchase_id']) ? (int)$_POST['purchase_id'] : null;
$sale_return_id      = !empty($_POST['sale_return_id']) ? (int)$_POST['sale_return_id'] : null;
$purchase_return_id  = !empty($_POST['purchase_return_id']) ? (int)$_POST['purchase_return_id'] : null;

if ($id <= 0 || $product_id <= 0 || $quantity <= 0 || empty($transfer_date)) {
    $_SESSION['flash_message'] = "Invalid data submitted.";
    $_SESSION['flash_type']    = "error";
    header("Location: {$base_url}stock_transfer/edit.php?id={$id}");
    exit;
}

$data = [
    "product_id"    => $product_id,
    "quantity"      => $quantity,
    "transfer_date" => $transfer_date,
    "status"        => $status,
    "sale_id"             => $sale_id,
    "purchase_id"         => $purchase_id,
    "sale_return_id"      => $sale_return_id,
    "purchase_return_id"  => $purchase_return_id
];

$where = ["id" => $id];

$result = $crud->common_update("stock_transfers", $data, $where);

$_SESSION['flash_message'] = $result['status'] ? "Stock transfer record updated successfully" : $result['message'];
$_SESSION['flash_type']    = $result['status'] ? "success" : "error";

header("Location: {$base_url}stock_transfer/list.php");
exit;
