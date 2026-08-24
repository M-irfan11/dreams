<?php
require_once '../component/connection.php';

function getAccountId($crud, $code) {
    $r = $crud->common_select('account_heads', '*', ["account_code" => $code]);
    return $r['status'] ? $r['data'][0]->id : null;
}

function add_journal_voucher($crud, $purchase_id, $account_ids, $grand_total, $description, $purchase_date) {
    $voucher_no = $crud->common_query("SELECT max(id) as max_id FROM journal_vouchers");
    $voucher_no = 'J' . str_pad($voucher_no['data'][0]->max_id + 1, 6, '0', STR_PAD_LEFT);

    $journal_voucher = [
        'voucher_no' => $voucher_no,
        'voucher_date' => $purchase_date,
        'source_type' => 'Purchase',
        'source_id' => $purchase_id,
        'narration' => $description ?? 'Purchase Voucher',
        'dr' => $grand_total ?? 0,
        'cr' => $grand_total ?? 0,
        'created_by' => $_SESSION['user_id'],
        'status' => 1
    ];

    $journal_voucher_result = $crud->common_insert("journal_vouchers", $journal_voucher);
    $voucher_id = $journal_voucher_result['data'];

    foreach ($account_ids as $account_head_id) {
        $details_data = [
            'journal_voucher_id' => $voucher_id,
            'account_head_id' => $account_head_id['account_id'],
            'dr' => $account_head_id['dr'] ?? 0,
            'cr' => $account_head_id['cr'] ?? 0,
            'remarks' => $account_head_id['remarks'] ?? '',
            'created_by' => $_SESSION['user_id']
        ];
        $crud->common_insert("journal_voucher_details", $details_data);

        $ledger_data = [
            'journal_voucher_id' => $voucher_id,
            'account_head_id' => $account_head_id['account_id'],
            'dr' => $account_head_id['dr'] ?? 0,
            'cr' => $account_head_id['cr'] ?? 0,
            'remarks' => $account_head_id['remarks'] ?? '',
            'created_by' => $_SESSION['user_id']
        ];
        $crud->common_insert("ledger", $ledger_data);
    }

    return $voucher_id;
}

$crud->conn->begin_transaction();

if ($_POST) {
    $id = $_GET['id'];
    $error = 0;
    $error_messages = [];

    $data = [
        "supplier_id"     => $_POST['supplier_id'],
        "purchase_date"   => $_POST['purchase_date'],
        "total_amount"    => $_POST['total_amount'],
        "discount_amount" => $_POST['discount_amount'],
        "discount_type"   => $_POST['discount_type'],
        "vat"             => $_POST['vat'],
        "grand_total"     => $_POST['grand_total'],
        "ref"             => $_POST['ref'],
        "status"          => 1,
        "updated_at"      => date('Y-m-d H:i:s'),
        "updated_by"      => $_SESSION['user_id']
    ];

    $result = $crud->common_update('purchases', $data, ["id" => $id]);

    if ($result['status']) {
        $crud->common_delete('purchase_details', ["purchase_id" => $id]);
        $crud->common_delete('stocks', ["purchase_id" => $id]);

        $vouchers = $crud->common_select('journal_vouchers', '*', ["source_id" => $id, "source_type" => 'Purchase']);
        if ($vouchers['status'] && !empty($vouchers['data'])) {
            foreach ($vouchers['data'] as $voucher) {
                $crud->common_delete('journal_voucher_details', ["journal_voucher_id" => $voucher->id]);
                $crud->common_delete('ledger', ["journal_voucher_id" => $voucher->id]);
            }
            $crud->common_delete('journal_vouchers', ["source_id" => $id, "source_type" => 'Purchase']);
        }

        foreach ($_POST['product_id'] as $index => $product_id) {
            $pd_data = [
                "purchase_id"    => $id,
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
                "purchase_id"  => $id,
                "created_at"   => date('Y-m-d H:i:s')
            ]);
            if (!$st['status']) {
                $error++;
                $error_messages[] = "Stock: " . $st['message'];
            }
        }

        $grand_total = (float) $_POST['grand_total'];
        $vat = (float) ($_POST['vat'] ?: 0);
        $purchase_amount = $grand_total - $vat;

        $payable_acc   = getAccountId($crud, '3100');
        $revenue_acc   = getAccountId($crud, '4100');
        $vat_output_acc = getAccountId($crud, '2100');

        if (!$payable_acc || !$revenue_acc || !$vat_output_acc) {
            $error++;
            $error_messages[] = "Accounting accounts 3100 / 4100 / 2100 not found.";
        } else {
            $journal_voucher_id = add_journal_voucher($crud, $id, [
                ['account_id' => $revenue_acc, 'dr' => $purchase_amount, 'cr' => 0, 'remarks' => "Purchase #$id - Revenue"],
                ['account_id' => $vat_output_acc, 'dr' => $vat, 'cr' => 0, 'remarks' => "Purchase #$id - VAT Output"],
                ['account_id' => $payable_acc, 'dr' => 0, 'cr' => $grand_total, 'remarks' => "Purchase #$id - Receivable"]
            ], $grand_total, "Purchase #$id", $_POST['purchase_date']);
        }

        if ($error == 0) {
            $crud->conn->commit();
            $_SESSION['message'] = [
                "type"    => "success",
                "title"   => "Success",
                "message" => "Purchase updated successfully."
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
}

echo "<script>window.location='list.php'</script>";