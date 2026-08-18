<?php
    require_once "../../component/connection.php";
    $voucher_id = $_POST['voucher_id'];
    /* get last payment voucher number */
    $payment_voucher = [
        'voucher_date' => $_POST['voucher_date'],
        'pay_to' => $_POST['pay_to'],
        'narration' => $_POST['narration'],
        'dr' => $_POST['total_dr'] ?? 0,
        'cr' => $_POST['total_cr'] ?? 0,
        'status' => 1
    ];

    $payment_voucher_result = $crud->common_update("payment_vouchers", $payment_voucher, ['id' => $voucher_id]);
   $crud->common_delete("payment_voucher_details", ['payment_voucher_id' => $voucher_id]);
   $crud->common_delete("ledger", ['payment_voucher_id' => $voucher_id]);

    foreach ($_POST['account_head_id'] as $index => $account_head_id) {
        $details_data = [
            'payment_voucher_id' => $voucher_id,
            'account_head_id' => $account_head_id,
            'dr' => $_POST['dr'][$index] ?? 0,
            'cr' => $_POST['cr'][$index] ?? 0,
            'remarks' => $_POST['remarks'][$index] ?? '',
            'created_by' => $_SESSION['user_id']
        ];
        $payment_voucher_detail_result = $crud->common_insert("payment_voucher_details", $details_data);
        $ledger_data = [
            'payment_voucher_id' => $voucher_id,
            'account_head_id' => $account_head_id,
            'dr' => $_POST['dr'][$index] ?? 0,
            'cr' => $_POST['cr'][$index] ?? 0,
            'remarks' => $_POST['remarks'][$index] ?? '',
            'created_by' => $_SESSION['user_id']
        ];
        $crud->common_insert("ledger", $ledger_data);
    }


// Ledger
if ($payment_voucher_result['status']) {
    $_SESSION['message'] = ['success', 'Success', 'Voucher updated!'];
} else {
    $_SESSION['message'] = ['danger', 'Error', $payment_voucher_result['message']];
}
echo "<script>window.location.href = '" . $base_url . "accounts/payment/list.php';</script>";