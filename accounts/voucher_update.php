<?php
require_once "../component/connection.php";

$id = $_POST['id'];
$type = $_POST['type'] ?? 'payment';
$voucher_date = $_POST['voucher_date'];
$narration = $_POST['narration'];
$account_head_id = $_POST['account_head_id'];
$dr = $_POST['dr'] ?? 0;
$cr = $_POST['cr'] ?? 0;

$crud->conn->begin_transaction();

try {
    // Update Voucher Header
    $voucher_data = [
        'voucher_date' => $voucher_date,
        'narration' => $narration,
        'updated_by' => $_SESSION['user_id']
    ];
    if ($type == 'payment') {
        $voucher_data['pay_to'] = $narration;
    } elseif ($type == 'receive') {
        $voucher_data['received_from'] = $narration;
    }
    $result = $crud->common_update("{$type}_vouchers", $voucher_data, ['id' => $id]);
    if (!$result['status']) {
        throw new Exception("Failed to update voucher.");
    }

    // Update Voucher Details
    $details_data = [
        'account_head_id' => $account_head_id,
        'dr' => $dr,
        'cr' => $cr,
        'remarks' => $narration,
        'updated_by' => $_SESSION['user_id']
    ];
    $result = $crud->common_update("{$type}_voucher_details", $details_data, ["{$type}_voucher_id" => $id]);
    if (!$result['status']) {
        throw new Exception("Failed to update voucher details.");
    }

    // Update Ledger
    $ledger_data = [
        'account_head_id' => $account_head_id,
        'dr' => $dr,
        'cr' => $cr,
        'remarks' => $narration,
        'updated_by' => $_SESSION['user_id']
    ];
    $result = $crud->common_update("ledger", $ledger_data, ["{$type}_voucher_id" => $id]);
    if (!$result['status']) {
        throw new Exception("Failed to update ledger.");
    }

    $crud->conn->commit();
    $_SESSION['message'] = ['success', 'Success', 'Voucher updated successfully!'];
} catch (Exception $e) {
    $crud->conn->rollback();
    $_SESSION['message'] = ['danger', 'Error', $e->getMessage()];
}

echo "<script>window.location.href = '" . $base_url . "accounts/{$type}_vouchers.php';</script>";