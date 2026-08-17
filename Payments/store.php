<?php
require_once "../component/connection.php";

// Only fields that exist in the dreams `payments` table
$data = [
    'sale_id'        => $_POST['sale_id'],
    'amount'         => $_POST['amount'],
    'payment_method' => $_POST['payment_method'],
    'payment_date'   => $_POST['payment_date'],
    'transaction_id' => !empty($_POST['transaction_id']) ? $_POST['transaction_id'] : null,
];

// Optional audit column, only add if your crud/table tracks logged-in user
if (isset($_SESSION['user_id'])) {
    $data['created_by'] = $_SESSION['user_id'];
}

$result = $crud->common_insert("payments", $data);

if ($result['status']) {
    $_SESSION['message'] = array('success', 'Success', $result['message']);
} else {
    $_SESSION['message'] = array('danger', 'Error', $result['message']);
}

echo "<script>window.location.href = '" . $base_url . "payments/list.php';</script>";
