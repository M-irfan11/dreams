<?php
require_once "../component/connection.php";

$data = [
    'account_code' => $_POST['account_code'],
    'account_name' => $_POST['account_name'],
    'account_type' => $_POST['account_type'],
    'account_subtype' => $_POST['account_subtype'] ?? null,
    'parent_id' => $_POST['parent_id'] ?? null,
    'opening_balance' => $_POST['opening_balance'] ?? 0,
    'status' => $_POST['status'] ?? 1,
    'description' => $_POST['description'] ?? null,
    'created_by' => $_SESSION['user_id']
];

$result = $crud->common_insert("account_heads", $data);

if ($result['status']) {
    $_SESSION['message'] = ['success', 'Success', 'Account head added successfully!'];
} else {
    $_SESSION['message'] = ['danger', 'Error', $result['message']];
}

echo "<script>window.location.href = '" . $base_url . "accounts/account_heads.php';</script>";