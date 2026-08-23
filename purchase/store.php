<?php
require_once '../component/connection.php';

// account_code diye account_heads.id ber kora
// NOTE: primary key column name is `id`, not `account_id`
function getAccountId($crud, $code) {
    $r = $crud->common_select('account_heads', '*', ["account_code" => $code]);
    return $r['status'] ? $r['data'][0]->id : null;
}

// ekta ledger row insert kore, sale_id/purchase_id soho
function postLedger($crud, $account_head_id, $dr, $cr, $remarks, $sale_id = null, $purchase_id = null) {
    $ledger_data = [
        "account_head_id" => $account_head_id,
        "dr"              => $dr,
        "cr"              => $cr,
        "remarks"         => $remarks,
        "created_by"      => $_SESSION['user_id'],
        "created_at"      => date('Y-m-d H:i:s')
    ];
    if ($sale_id)     $ledger_data["sale_id"] = $sale_id;
    if ($purchase_id) $ledger_data["purchase_id"] = $purchase_id;

    return $crud->common_insert('ledger', $ledger_data);
}

$crud->conn->begin_transaction();
$error = 0;
$error_messages = [];

$data = [
    "supplier_id"      => $_POST['supplier_id'],
    "purchase_date"    => $_POST['purchase_date'],
    "total_amount"     => $_POST['total_amount'],
    "discount_amount"  => $_POST['discount_amount'],
    "discount_type"    => $_POST['discount_type'],
    "vat"              => $_POST['vat'],
    "grand_total"      => $_POST['grand_total'],
    "ref"              => $_POST['ref'],
    "status"           => 1,
    "created_at"       => date('Y-m-d H:i:s'),
    "created_by"       => $_SESSION['user_id']
];

$result = $crud->common_insert('purchases', $data);

if ($result['status']) {

    $purchase_id = $result['data'];

    // -------------------------
    // PURCHASE DETAILS + STOCK IN
    // -------------------------
    foreach ($_POST['product_id'] as $index => $product_id) {
        $pd_data = [
            "purchase_id"    => $purchase_id,
            "product_id"     => $product_id,
            "quantity"       => $_POST['quantity'][$index],
            "purchase_price" => $_POST['purchase_price'][$index],
            "subtotal"       => $_POST['subtotal'][$index],
            "created_at"     => date('Y-m-d H:i:s'),
            "created_by"     => $_SESSION['user_id']
        ];
        $pd = $crud->common_insert('purchase_details', $pd_data);
        if (!$pd['status']) {
            $error++;
            $error_messages[] = "Purchase detail: " . $pd['message'];
        }

        $st = $crud->common_insert('stocks', [
            "product_id"   => $product_id,
            "quantity"     => $_POST['quantity'][$index],
            "warehouse_id" => $_POST['warehouse_id'],
            "stock_date"   => $_POST['purchase_date'],
            "purchase_id"  => $purchase_id,
            "created_at"   => date('Y-m-d H:i:s')
        ]);
        if (!$st['status']) {
            $error++;
            $error_messages[] = "Stock: " . $st['message'];
        }
    }

    // -------------------------
    // LEDGER POSTING (accounting)
    // Dr Purchase/COGS   = grand_total - vat
    // Dr VAT Receivable  = vat (if any)
    // Cr Accounts Payable = grand_total
    // -------------------------
    $grand_total = (float) $_POST['grand_total'];
    $vat = (float) ($_POST['vat'] ?: 0);
    $purchase_amount = $grand_total - $vat;

    $payable_acc   = getAccountId($crud, '3100');
    $revenue_acc   = getAccountId($crud, '4100');
    $vat_output_acc = getAccountId($crud, '2100');

    if (!$payable_acc || !$revenue_acc) {
        $error++;
        $error_messages[] = "Ledger accounts PAYABLE / REVENUE not found in account_heads.";
    } else {

        $l1 = postLedger($crud, $revenue_acc, $purchase_amount, 0, "Purchase #$purchase_id - COGS", null, $purchase_id);
        if (!$l1['status']) { $error++; $error_messages[] = "Ledger PURCHASE: " . $l1['message']; }

        if ($vat > 0 && $vat_output_acc) {
            $l2 = postLedger($crud, $vat_output_acc, $vat, 0, "Purchase #$purchase_id - VAT Input", null, $purchase_id);
            if (!$l2['status']) { $error++; $error_messages[] = "Ledger VAT: " . $l2['message']; }
        }

        $l3 = postLedger($crud, $payable_acc, 0, $grand_total, "Purchase #$purchase_id - Payable", null, $purchase_id);
        if (!$l3['status']) { $error++; $error_messages[] = "Ledger AP: " . $l3['message']; }
    }

    if ($error == 0) {
        $crud->conn->commit();
        $_SESSION['message'] = [
            "type"    => "success",
            "title"   => "Success",
            "message" => "Purchase added successfully."
        ];
    } else {
        $crud->conn->rollback();
        $_SESSION['message'] = [
            "type"    => "danger",
            "title"   => "Error",
            "message" => implode(" | ", $error_messages)
        ];
    }

} else {
    $_SESSION['message'] = [
        "type"    => "danger",
        "title"   => "Error",
        "message" => $result['message']
    ];
}

echo "<script>window.location='list.php'</script>";