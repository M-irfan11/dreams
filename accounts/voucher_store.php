<?php
require_once "../component/connection.php";

$type = $_POST['type']; // payment, receive, journal
$voucher_no = 'VCH-' . date('Ymd') . '-' . rand(100, 999);
$voucher_date = $_POST['voucher_date'];
$narration = $_POST['narration'];
$account_head_id = $_POST['account_head_id'];
$dr = $_POST['dr'] ?? 0;
$cr = $_POST['cr'] ?? 0;

if ($type == 'payment') {
    $data = [
        'voucher_no' => $voucher_no,
        'voucher_date' => $voucher_date,
        'pay_to' => $narration,
        'narration' => $narration,
        'dr' => $dr,
        'cr' => $cr,
        'created_by' => $_SESSION['user_id']
    ];
    $result = $crud->common_insert("payment_vouchers", $data);
    $voucher_id = $result['data'];
    $table = "payment_vouchers";
} elseif ($type == 'receive') {
    $data = [
        'voucher_no' => $voucher_no,
        'voucher_date' => $voucher_date,
        'received_from' => $narration,
        'narration' => $narration,
        'dr' => $dr,
        'cr' => $cr,
        'created_by' => $_SESSION['user_id']
    ];
    $result = $crud->common_insert("receive_vouchers", $data);
    $voucher_id = $result['data'];
    $table = "receive_vouchers";
} else {
    $data = [
        'voucher_no' => $voucher_no,
        'voucher_date' => $voucher_date,
        'narration' => $narration,
        'created_by' => $_SESSION['user_id']
    ];
    $result = $crud->common_insert("journal_vouchers", $data);
    $voucher_id = $result['data'];
    $table = "journal_vouchers";
}

// Details
$details_data = [
    $type . '_voucher_id' => $voucher_id,
    'account_head_id' => $account_head_id,
    'dr' => $dr,
    'cr' => $cr,
    'remarks' => $narration,
    'created_by' => $_SESSION['user_id']
];
$crud->common_insert($type . "_voucher_details", $details_data);

// Ledger
$ledger_data = [
    $type . '_voucher_id' => $voucher_id,
    'account_head_id' => $account_head_id,
    'dr' => $dr,
    'cr' => $cr,
    'remarks' => $narration,
    'created_by' => $_SESSION['user_id']
];
$crud->common_insert("ledger", $ledger_data);

if ($result['status']) {
    $_SESSION['message'] = ['success', 'Success', 'Voucher created!'];
} else {
    $_SESSION['message'] = ['danger', 'Error', $result['message']];
}
echo "<script>window.location.href = '" . $base_url . "accounts/" . $type . "_vouchers.php';</script>";