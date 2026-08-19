<?php
    require_once "../../component/connection.php";
    $voucher_id = $_POST['voucher_id'];
    /* get last receive voucher number */
    $receive_voucher = [
        'voucher_date' => $_POST['voucher_date'],
        'received_from' => $_POST['received_from'],
        'narration' => $_POST['narration'],
        'cr' => $_POST['total_dr'] ?? 0,
        'dr' => $_POST['total_cr'] ?? 0,
        'status' => 1
    ];

    $receive_voucher_result = $crud->common_update("receive_vouchers", $receive_voucher, ['id' => $voucher_id]);
   $crud->common_delete("receive_voucher_details", ['receive_voucher_id' => $voucher_id]);
   $crud->common_delete("ledger", ['receive_voucher_id' => $voucher_id]);

    foreach ($_POST['account_head_id'] as $index => $account_head_id) {
        $details_data = [
            'receive_voucher_id' => $voucher_id,
            'account_head_id' => $account_head_id,
            'cr' => $_POST['dr'][$index] ?? 0,
            'dr' => $_POST['cr'][$index] ?? 0,
            'remarks' => $_POST['remarks'][$index] ?? '',
            'created_by' => $_SESSION['user_id']
        ];
        $receive_voucher_detail_result = $crud->common_insert("receive_voucher_details", $details_data);
        $ledger_data = [
            'receive_voucher_id' => $voucher_id,
            'account_head_id' => $account_head_id,
            'cr' => $_POST['dr'][$index] ?? 0,
            'dr' => $_POST['cr'][$index] ?? 0,
            'remarks' => $_POST['remarks'][$index] ?? '',
            'created_by' => $_SESSION['user_id']
        ];
        $crud->common_insert("ledger", $ledger_data);
    }


// Ledger
if ($receive_voucher_result['status']) {
    $_SESSION['message'] = ['success', 'Success', 'Voucher updated!'];
} else {
    $_SESSION['message'] = ['danger', 'Error', $receive_voucher_result['message']];
}
echo "<script>window.location.href = '" . $base_url . "accounts/receive/list.php';</script>";