<?php
    require_once '../component/connection.php';

    $crud->conn->begin_transaction();

    function getAccountId($crud, $code) {
        $r = $crud->common_select('account_heads', '*', ["account_code" => $code]);
        return $r['status'] ? $r['data'][0]->id : null;
    }


    /* get last payment voucher number */
    $voucher_no = $crud->common_query("SELECT max(id) as max_id FROM receive_vouchers");
    $voucher_no = 'RCV' . str_pad($voucher_no['data'][0]->max_id + 1, 6, '0', STR_PAD_LEFT);
    $receive_voucher = [
        'voucher_no' => $voucher_no,
        'voucher_date' => $_POST['payment_date'],
        'received_from' => $_POST['received_from'],
        'narration' => "Sale Payment for Sale ID: " . $_POST['sale_id'],
        'source_type' => 'Sales',
        'source_id' => $_POST['sale_id'],
        'cr' => $_POST['amount'] ?? 0,
        'dr' => $_POST['amount'] ?? 0,
        'created_by' => $_SESSION['user_id'],
        'status' => 1
    ];

    $receive_voucher_result = $crud->common_insert("receive_vouchers", $receive_voucher);
    $voucher_id = $receive_voucher_result['data'];


    $details_data = [
        'receive_voucher_id' => $voucher_id,
        'account_head_id' => getAccountId($crud, '1200'),
        'cr' => $_POST['amount'] ?? 0,
        'dr' => 0,
        'remarks' => "Sale Payment for Sale ID: " . $_POST['sale_id'],
        'created_by' => $_SESSION['user_id']
    ];
    $receive_voucher_detail_result = $crud->common_insert("receive_voucher_details", $details_data);
    
    $ledger_data = [
        'receive_voucher_id' => $voucher_id,
        'account_head_id' => getAccountId($crud, '1200'),
        'cr' => $_POST['amount'] ?? 0,
        'dr' => 0,
        'remarks' => "Sale Payment for Sale ID: " . $_POST['sale_id'],
        'created_by' => $_SESSION['user_id']
    ];
    $crud->common_insert("ledger", $ledger_data);
   
    // this is for debit side entry only

    $details_data = [
        'receive_voucher_id' => $voucher_id,
        'account_head_id' => $_POST['account_head_id'],
        'cr' => 0,
        'dr' => $_POST['amount'] ?? 0,
        'remarks' => "Sale Payment for Sale ID: " . $_POST['sale_id'],
        'created_by' => $_SESSION['user_id']
    ];
    $receive_voucher_detail_result = $crud->common_insert("receive_voucher_details", $details_data);
    

        $ledger_data = [
            'receive_voucher_id' => $voucher_id,
            'account_head_id' =>  $_POST['account_head_id'],
            'cr' => 0,
            'dr' => $_POST['amount'] ?? 0,
            'remarks' => "Sale Payment for Sale ID: " . $_POST['sale_id'],
            'created_by' => $_SESSION['user_id']
        ];
        $crud->common_insert("ledger", $ledger_data);

// Ledger

if ($receive_voucher_result['status']) {
    $crud->conn->commit();
    $_SESSION['message'] = [
        'type' => 'success',
        'title' => 'Success',
        'message' => 'Voucher created!'
    ];
} else {
    $crud->conn->rollback();
    $_SESSION['message'] = [
        'type' => 'danger',
        'title' => 'Error',
        'message' => $receive_voucher_result['message']
    ];
}



if ($receive_voucher_result['status']) {
    echo "<script>window.location='payment_receipt.php?id={$voucher_id}'</script>";
} else {
    echo "<script>window.location='list.php'</script>";
}