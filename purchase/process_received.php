<?php
    require_once '../component/connection.php';

    $crud->conn->begin_transaction();

    function getAccountId($crud, $code) {
        $r = $crud->common_select('account_heads', '*', ["account_code" => $code]);
        return $r['status'] ? $r['data'][0]->id : null;
    }


    /* get last received voucher number */
    $voucher_no = $crud->common_query("SELECT max(id) as max_id FROM payment_vouchers");
    $voucher_no = 'RCV' . str_pad($voucher_no['data'][0]->max_id + 1, 6, '0', STR_PAD_LEFT);
    $payment_voucher = [
        'voucher_no' => $voucher_no,
        'voucher_date' => $_POST['received_date'],
        'pay_to' => $_POST['pay_to'],
        'narration' => "purchase received for purchase ID: " . $_POST['purchase_id'],
        'source_type' => 'purchases',
        'source_id' => $_POST['purchase_id'],
        'cr' => $_POST['amount'] ?? 0,
        'dr' => $_POST['amount'] ?? 0,
        'created_by' => $_SESSION['user_id'],
        'status' => 1
    ];

    $payment_voucher_result = $crud->common_insert("payment_vouchers", $payment_voucher);
    $voucher_id = $payment_voucher_result['data'];


    $details_data = [
        'payment_voucher_id' => $voucher_id,
        'account_head_id' => getAccountId($crud, '3100'),
        'dr' => $_POST['amount'] ?? 0,
        'cr' => 0,
        'remarks' => "payment for purchase ID: " . $_POST['purchase_id'],
        'created_by' => $_SESSION['user_id']
    ];
    $payment_voucher_detail_result = $crud->common_insert("payment_voucher_details", $details_data);
    
    $ledger_data = [
        'payment_voucher_id' => $voucher_id,
        'account_head_id' => getAccountId($crud, '3100'),
        'dr' => $_POST['amount'] ?? 0,
        'cr' => 0,
        'remarks' => "payment for purchase ID: " . $_POST['purchase_id'],
        'created_by' => $_SESSION['user_id']
    ];
    $crud->common_insert("ledger", $ledger_data);
   
    // this is for debit side entry only

    $details_data = [
        'payment_voucher_id' => $voucher_id,
        'account_head_id' => $_POST['account_head_id'],
        'dr' => 0,
        'cr' => $_POST['amount'] ?? 0,
        'remarks' => "payment for purchase ID: " . $_POST['purchase_id'],
        'created_by' => $_SESSION['user_id']
    ];
    $payment_voucher_detail_result = $crud->common_insert("payment_voucher_details", $details_data);
    

        $ledger_data = [
            'payment_voucher_id' => $voucher_id,
            'account_head_id' =>  $_POST['account_head_id'],
            'dr' => 0,
            'cr' => $_POST['amount'] ?? 0,
            'remarks' => "payment for purchase ID: " . $_POST['purchase_id'],
            'created_by' => $_SESSION['user_id']
        ];
        $crud->common_insert("ledger", $ledger_data);

// Ledger

if ($payment_voucher_result['status']) {
     $crud->conn->commit();
    $_SESSION['message'] = [
        "type"    => "success",
        "title"   => "Success",
        "message" => "Voucher created!"
    ];
} else {
    $crud->conn->rollback();
    $_SESSION['message'] = [
        "type"    => "danger",
        "title"   => "Error",
        "message" => $payment_voucher_result['message']
    ];
}


if ($payment_voucher_result['status']) {
    echo "<script>window.location='bill_receipt.php?id={$voucher_id}'</script>";
} else {
    echo "<script>window.location='list.php'</script>";
}