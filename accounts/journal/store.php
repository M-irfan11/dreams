<?php
    require_once "../../component/connection.php";
    /* get last payment voucher number */
    $voucher_no = $crud->common_query("SELECT max(id) as max_id FROM journal_vouchers");
    $voucher_no = 'J' . str_pad($voucher_no['data'][0]->max_id + 1, 6, '0', STR_PAD_LEFT);
    $journal_voucher = [
        'voucher_no' => $voucher_no,
        'voucher_date' => $_POST['voucher_date'],
        'narration' => $_POST['narration'],
        'dr' => $_POST['total_dr'] ?? 0,
        'cr' => $_POST['total_cr'] ?? 0,
        'created_by' => $_SESSION['user_id'],
        'status' => 1
    ];

    $journal_voucher_result = $crud->common_insert("journal_vouchers", $journal_voucher);
    $voucher_id = $journal_voucher_result['data'];

    foreach ($_POST['account_head_id'] as $index => $account_head_id) {
        $details_data = [
            'journal_voucher_id' => $voucher_id,
            'account_head_id' => $account_head_id,
            'dr' => $_POST['dr'][$index] ?? 0,
            'cr' => $_POST['cr'][$index] ?? 0,
            'remarks' => $_POST['remarks'][$index] ?? '',
            'created_by' => $_SESSION['user_id']
        ];
        $journal_voucher_detail_result = $crud->common_insert("journal_voucher_details", $details_data);
        $ledger_data = [
            'journal_voucher_id' => $voucher_id,
            'account_head_id' => $account_head_id,
            'dr' => $_POST['dr'][$index] ?? 0,
            'cr' => $_POST['cr'][$index] ?? 0,
            'remarks' => $_POST['remarks'][$index] ?? '',
            'created_by' => $_SESSION['user_id']
        ];
        $crud->common_insert("ledger", $ledger_data);
    }


// Ledger
if ($journal_voucher_result['status']) {
    $_SESSION['message'] = ['success', 'Success', 'Voucher created!'];
} else {
    $_SESSION['message'] = ['danger', 'Error', $journal_voucher_result['message']];
}
echo "<script>window.location.href = '" . $base_url . "accounts/journal/list.php';</script>";