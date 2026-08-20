<?php
require_once '../component/connection.php';

$crud->conn->begin_transaction();

if ($_POST) {
    $id = $_GET['id'];
    $error = 0;
    $error_messages = [];

    $data = [
        "customer_id"  => $_POST['customer_id'],
        "sale_date"    => $_POST['sale_date'],
        "total_amount" => $_POST['total_amount'],
        "discount"     => $_POST['discount'],
        "tax"          => $_POST['tax'],
        "status"       => $_POST['status'],
        "updated_at"   => date('Y-m-d H:i:s'),
        "updated_by"   => $_SESSION['user_id']
    ];

    if (!empty($_POST['warehouse_id'])) {
        $data["warehouse_id"] = $_POST['warehouse_id'];
    }

    $result = $crud->common_update('sales', $data, ["id" => $id]);

    if ($result['status']) {

        // rebuild sale line items, stock, and ledger for this sale
        // NOTE: delete by sale_id, not by the sale_details' own `id`
        $crud->common_delete('sale_details', ["sale_id" => $id]);
        $crud->common_delete('stocks', ["sale_id" => $id]);
        $crud->common_delete('ledger', ["sale_id" => $id]);

        foreach ($_POST['product_id'] as $index => $product_id) {
            $stock_data = [
                "sale_id"    => $id,
                "product_id" => $product_id,
                "quantity"   => $_POST['quantity'][$index],
                "unit_price" => $_POST['unit_price'][$index],
                "subtotal"   => $_POST['subtotal'][$index],
                "created_at" => date('Y-m-d H:i:s'),
                "created_by" => $_SESSION['user_id']
            ];
            $sd = $crud->common_insert('sale_details', $stock_data);
            if (!$sd['status']) {
                $error++;
                $error_messages[] = "Sale detail: " . $sd['message'];
            }

            // reduce stock in `stocks` table (negative quantity = stock OUT)
            $st = $crud->common_insert('stocks', [
                "product_id"   => $product_id,
                "quantity"     => "-" . $_POST['quantity'][$index],
                "warehouse_id" => $_POST['warehouse_id'] ?? null,
                "stock_date"   => $_POST['sale_date'],
                "sale_id"      => $id,
                "created_at"   => date('Y-m-d H:i:s')
            ]);
            if (!$st['status']) {
                $error++;
                $error_messages[] = "Stock: " . $st['message'];
            }
        }

        // -------------------------
        // RE-POST LEDGER (old entries already deleted above)
        // Dr Accounts Receivable = grand_total (total - discount + tax)
        // Cr Sales Income        = total - discount
        // Cr VAT Payable         = tax (if any)
        // -------------------------
        function getAccountId($crud, $code) {
            $r = $crud->common_select('account_heads', '*', ["account_code" => $code]);
            return $r['status'] ? $r['data'][0]->id : null;
        }
        function postLedger($crud, $account_head_id, $dr, $cr, $remarks, $sale_id) {
            return $crud->common_insert('ledger', [
                "account_head_id" => $account_head_id,
                "dr"              => $dr,
                "cr"              => $cr,
                "remarks"         => $remarks,
                "sale_id"         => $sale_id,
                "created_by"      => $_SESSION['user_id'],
                "created_at"      => date('Y-m-d H:i:s')
            ]);
        }

        $total_amount = (float) $_POST['total_amount'];
        $discount     = (float) ($_POST['discount'] ?: 0);
        $tax          = (float) ($_POST['tax'] ?: 0);

        $revenue_amount    = $total_amount - $discount;
        $receivable_amount = $revenue_amount + $tax;

        $receivable_acc = getAccountId($crud, 'AR');
        $sales_acc      = getAccountId($crud, 'SALES');
        $vat_output_acc = getAccountId($crud, 'VAT_OUTPUT');

        if (!$receivable_acc || !$sales_acc) {
            $error++;
            $error_messages[] = "Ledger accounts AR / SALES not found.";
        } else {
            $l1 = postLedger($crud, $receivable_acc, $receivable_amount, 0, "Sale #$id - Receivable (edited)", $id);
            if (!$l1['status']) { $error++; $error_messages[] = "Ledger AR: " . $l1['message']; }

            $l2 = postLedger($crud, $sales_acc, 0, $revenue_amount, "Sale #$id - Revenue (edited)", $id);
            if (!$l2['status']) { $error++; $error_messages[] = "Ledger SALES: " . $l2['message']; }

            if ($tax > 0 && $vat_output_acc) {
                $l3 = postLedger($crud, $vat_output_acc, 0, $tax, "Sale #$id - VAT Output (edited)", $id);
                if (!$l3['status']) { $error++; $error_messages[] = "Ledger VAT: " . $l3['message']; }
            }
        }

        if ($error == 0) {
            $crud->conn->commit();
            $_SESSION['message'] = [
                "type"    => "success",
                "title"   => "Success",
                "message" => "Sale updated successfully."
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