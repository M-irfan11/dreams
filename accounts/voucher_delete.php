<?php
require_once "../component/connection.php";

$id = $_GET['id'];
$type = $_GET['type'] ?? 'payment';
$result = $crud->common_update("{$type}_vouchers", ['deleted_at' => date('Y-m-d H:i:s')], ['id' => $id]);

if ($result['status']) {
    $_SESSION['message'] = ['success', 'Success', 'Voucher deleted!'];
} else {
    $_SESSION['message'] = ['danger', 'Error', $result['message']];
}
echo "<script>window.location.href = '" . $base_url . "accounts/{$type}_vouchers.php';</script>";