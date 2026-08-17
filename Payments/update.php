<?php
require_once "../component/connection.php";

$id = $_GET['id'];

// Only fields that exist in the dreams `payments` table
// sale_id intentionally excluded from update (locked in edit.php form)
$data = [
    'amount'         => $_POST['amount'],
    'payment_method' => $_POST['payment_method'],
    'payment_date'   => $_POST['payment_date'],
    'transaction_id' => !empty($_POST['transaction_id']) ? $_POST['transaction_id'] : null,
];

if (isset($_SESSION['user_id'])) {
    $data['updated_by'] = $_SESSION['user_id'];
}

$result = $crud->common_update("payments", $data, ['id' => $id]);

if ($result['status']) {
    $_SESSION['message'] = array('success', 'Success', $result['message']);
} else {
    $_SESSION['message'] = array('danger', 'Error', $result['message']);
}

echo "<script>window.location.href = '" . $base_url . "payments/list.php';</script>";
