<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/component/connection.php";

if (!isset($_SESSION['is_logged_in']) || !$_SESSION['is_logged_in']) {
    header("Location: {$base_url}login.php");
    exit;
}

$id = (int)($_GET['id'] ?? 0);

if ($id <= 0) {
    $_SESSION['flash_message'] = "Invalid stock transfer record.";
    $_SESSION['flash_type']    = "error";
    header("Location: {$base_url}stock_transfer/list.php");
    exit;
}

// Soft delete: set deleted_at instead of removing the row,
// consistent with common_select()/common_query() filtering on deleted_at IS NULL
$result = $crud->common_update("stock_transfers", ["deleted_at" => date("Y-m-d H:i:s")], ["id" => $id]);

$_SESSION['flash_message'] = $result['status'] ? "Stock transfer record deleted successfully" : $result['message'];
$_SESSION['flash_type']    = $result['status'] ? "success" : "error";

header("Location: {$base_url}stock_transfer/list.php");
exit;
