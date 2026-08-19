<?php
    require_once "../../component/connection.php";
    /* get last payment voucher number */
    $voucher_no = $crud->common_query("SELECT max(id) as max_id FROM receive_vouchers");
    $voucher_no = 'PAY' . str_pad($voucher_no['data'][0]->max_id + 1, 6, '0', STR_PAD_LEFT);
    $receive_voucher = [
        'voucher_no' => $voucher_no,
        'voucher_date' => $_POST['voucher_date'],
        'pay_to' => $_POST['pay_to'],
        'narration' => $_POST['narration'],
        'cr' => $_POST['totalAmount'] ?? 0,
        'dr' => $_POST['totalAmount'] ?? 0,
        'created_by' => $_SESSION['user_id'],
        'status' => 1
    ];

    $receive_voucher_result = $crud->common_insert("receive_vouchers", $receive_voucher);
    $voucher_id = $receive_voucher_result['data'];

    //this is for debit side entry only    
    foreach ($_POST['account_head_id'] as $index => $account_head_id) {
        $details_data = [
            'receive_voucher_id' => $voucher_id,
            'account_head_id' => $account_head_id,
            'cr' => $_POST['dr'][$index] ?? 0,
            'dr' => 0,
            'remarks' => $_POST['remarks'][$index] ?? '',
            'created_by' => $_SESSION['user_id']
        ];
        $receive_voucher_detail_result = $crud->common_insert("receive_voucher_details", $details_data);
        $ledger_data = [
            'receive_voucher_id' => $voucher_id,
            'account_head_id' => $account_head_id,
            'cr' => $_POST['dr'][$index] ?? 0,
            'dr' => 0,
            'remarks' => $_POST['remarks'][$index] ?? '',
            'created_by' => $_SESSION['user_id']
        ];
        $crud->common_insert("ledger", $ledger_data);
    }


// this is for credit side entry only

    $details_data = [
            'receive_voucher_id' => $voucher_id,
            'account_head_id' => $_POST['pay_dr'],
            'cr' => 0,
            'dr' => $_POST['totalAmount'] ?? 0,
            'remarks' => $_POST['narration'],
            'created_by' => $_SESSION['user_id']
        ];
        $receive_voucher_detail_result = $crud->common_insert("receive_voucher_details", $details_data);
        $ledger_data = [
            'receive_voucher_id' => $voucher_id,
            'account_head_id' =>  $_POST['pay_dr'],
            'dr' => 0,
            'cr' => $_POST['totalAmount'] ?? 0,
            'remarks' => $_POST['narration'],
            'created_by' => $_SESSION['user_id']
        ];
        $crud->common_insert("ledger", $ledger_data);

// Ledger
if ($receive_voucher_result['status']) {
    $_SESSION['message'] = ['success', 'Success', 'Voucher created!'];
} else {
    $_SESSION['message'] = ['danger', 'Error', $receive_voucher_result['message']];
}
echo "<script>window.location.href = '" . $base_url . "accounts/receive/list.php';</script>";