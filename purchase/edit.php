<?php
require_once '../component/connection.php';

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

        // remove old purchase_details AND old stock entries for this purchase
        // (uses `stocks` table now, to match stocks/list.php reporting)
        $crud->common_delete('purchase_details', ["purchase_id" => $id]);
        $crud->common_delete('stocks', ["purchase_id" => $id]);

        // remove old ledger entries for this purchase, since amounts may have changed
        $crud->common_delete('ledger', ["purchase_id" => $id]);

        foreach ($_POST['product_id'] as $index => $product_id) {
            $stock_data = [
                "purchase_id"    => $id,
                "product_id"     => $product_id,
                "quantity"       => $_POST['quantity'][$index],
                "purchase_price" => $_POST['purchase_price'][$index],
                "subtotal"       => $_POST['subtotal'][$index],
                "created_at"     => date('Y-m-d H:i:s'),
                "created_by"     => $_SESSION['user_id']
            ];
            $pd = $crud->common_insert('purchase_details', $stock_data);
            if (!$pd['status']) {
                $error++;
                $error_messages[] = "Purchase detail: " . $pd['message'];
            }

            // add stock in `stocks` table (positive quantity = stock IN)
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

        // -------------------------
        // RE-POST LEDGER (old entries already deleted above)
        // Dr Purchase/COGS    = grand_total - vat
        // Dr VAT Receivable   = vat (if any)
        // Cr Accounts Payable = grand_total
        // -------------------------
        function getAccountId($crud, $code) {
            $r = $crud->common_select('account_heads', '*', ["account_code" => $code]);
            return $r['status'] ? $r['data'][0]->id : null;
        }
        function postLedger($crud, $account_head_id, $dr, $cr, $remarks, $purchase_id) {
            return $crud->common_insert('ledger', [
                "account_head_id" => $account_head_id,
                "dr"              => $dr,
                "cr"              => $cr,
                "remarks"         => $remarks,
                "purchase_id"     => $purchase_id,
                "created_by"      => $_SESSION['user_id'],
                "created_at"      => date('Y-m-d H:i:s')
            ]);
        }

        $grand_total = (float) $_POST['grand_total'];
        $vat = (float) ($_POST['vat'] ?: 0);
        $purchase_amount = $grand_total - $vat;

        $purchase_acc  = getAccountId($crud, 'PURCHASE');
        $payable_acc   = getAccountId($crud, 'AP');
        $vat_input_acc = getAccountId($crud, 'VAT_INPUT');

        if (!$purchase_acc || !$payable_acc) {
            $error++;
            $error_messages[] = "Ledger accounts PURCHASE / AP not found.";
        } else {
            $l1 = postLedger($crud, $purchase_acc, $purchase_amount, 0, "Purchase #$id - COGS (edited)", $id);
            if (!$l1['status']) { $error++; $error_messages[] = "Ledger PURCHASE: " . $l1['message']; }

            if ($vat > 0 && $vat_input_acc) {
                $l2 = postLedger($crud, $vat_input_acc, $vat, 0, "Purchase #$id - VAT Input (edited)", $id);
                if (!$l2['status']) { $error++; $error_messages[] = "Ledger VAT: " . $l2['message']; }
            }

            $l3 = postLedger($crud, $payable_acc, 0, $grand_total, "Purchase #$id - Payable (edited)", $id);
            if (!$l3['status']) { $error++; $error_messages[] = "Ledger AP: " . $l3['message']; }
        }

        if ($result['status'] && $error == 0) {
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