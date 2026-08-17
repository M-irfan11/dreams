<?php
require_once "../component/connection.php";

$id = $_GET['id'];

$result = $crud->common_delete("payments", ['id' => $id]);

if ($result['status']) {
    $_SESSION['message'] = array('success', 'Success', 'Payment deleted successfully.');
} else {
    $_SESSION['message'] = array('danger', 'Error', $result['message']);
}

echo "<script>window.location.href = '" . $base_url . "payments/list.php';</script>";
