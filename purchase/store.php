<?php
require_once '../component/connection.php';

// account_code diye account_id ber kora
function getAccountId($crud, $code) {
    $r = $crud->common_select('account_heads', '*', ["account_code" => $code]);
    return $r['status'] ? $r['data'][0]->account_id : null;
}

$crud->conn->begin_transaction();
$error = 0;
$error_messages = []; // collect the REAL reason for any failure, instead of reusing $result['message']

$data = [
    "supplier_id" => $_POST['supplier_id'],
    "purchase_date" => $_POST['purchase_date'],
    "total_amount" => $_POST['total_amount'],
    "discount_amount" => $_POST['discount_amount'],
    "discount_type" => $_POST['discount_type'],
    "vat" => $_POST['vat'],
    "grand_total" => $_POST['grand_total'],
    "ref" => $_POST['ref'],
    "status" => 1,
    "created_at" => date('Y-m-d H:i:s'),
    "created_by" => $_SESSION['user_id']
];

$result = $crud->common_insert('purchases', $data);

if ($result['status']) {

    $purchase_id = $result['data'];

    // set opening balance for the product in stock_transfers table
    // <!-- `id`, `purchase_id`, `product_id`, `quantity`, `purchase_price`, `subtotal`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by` -->
    foreach ($_POST['product_id'] as $index => $product_id) {
        $stock_data = [
            "purchase_id" => $purchase_id,
            "product_id" => $product_id,
            "quantity" => $_POST['quantity'][$index],
            "purchase_price" => $_POST['purchase_price'][$index],
            "subtotal" => $_POST['subtotal'][$index],
            "created_at" => date('Y-m-d H:i:s'),
            "created_by" => $_SESSION['user_id']
        ];
        $pd = $crud->common_insert('purchase_details', $stock_data);
        if (!$pd['status']) {
            $error++;
            $error_messages[] = "Purchase detail: " . $pd['message'];
        }
        // add stock in stocks table
        $st = $crud->common_insert('stocks', [
            "product_id" => $product_id,
            "quantity" => $_POST['quantity'][$index],
            "warehouse_id" => $_POST['warehouse_id'],
            "stock_date" => $_POST['purchase_date'],
            "purchase_id" => $purchase_id,
            "created_at" => date('Y-m-d H:i:s')
        ]);
        if (!$st['status']) {
            $error++;
            $error_messages[] = "Stock: " . $st['message'];
        }
    }

    // -------------------------
    // JOURNAL ENTRIES (accounting posting) - OPTIONAL
    // Dr Inventory  = grand_total - vat
    // Dr VAT Input  = vat
    // Cr Accounts Payable = grand_total
    //
    // If the Accounts module (chart_of_accounts) isn't set up yet,
    // we simply SKIP posting journal entries - the purchase itself
    // must still save successfully. This does NOT count as an error.
    // -------------------------

    $grand_total = (float) $_POST['grand_total'];
    $vat = (float) ($_POST['vat'] ?: 0);
    $inventory_amount = $grand_total - $vat;

    $inventory_acc = getAccountId($crud, '1300');
    $vat_input_acc = getAccountId($crud, '2200');
    $payable_acc   = getAccountId($crud, '2000');

    if ($inventory_acc && $payable_acc) {

        $je1 = $crud->common_insert('journal_entries', [
            "entry_date" => $_POST['purchase_date'],
            "reference_type" => "Purchase",
            "reference_id" => $purchase_id,
            "account_id" => $inventory_acc,
            "debit" => $inventory_amount,
            "credit" => 0,
            "description" => "Purchase #$purchase_id - Inventory",
            "created_by" => $_SESSION['user_id']
        ]);
        if (!$je1['status']) {
            $error++;
            $error_messages[] = "Journal (Inventory): " . $je1['message'];
        }

        if ($vat > 0 && $vat_input_acc) {
            $je2 = $crud->common_insert('journal_entries', [
                "entry_date" => $_POST['purchase_date'],
                "reference_type" => "Purchase",
                "reference_id" => $purchase_id,
                "account_id" => $vat_input_acc,
                "debit" => $vat,
                "credit" => 0,
                "description" => "Purchase #$purchase_id - VAT Input",
                "created_by" => $_SESSION['user_id']
            ]);
            if (!$je2['status']) {
                $error++;
                $error_messages[] = "Journal (VAT): " . $je2['message'];
            }
        }

        $je3 = $crud->common_insert('journal_entries', [
            "entry_date" => $_POST['purchase_date'],
            "reference_type" => "Purchase",
            "reference_id" => $purchase_id,
            "account_id" => $payable_acc,
            "debit" => 0,
            "credit" => $grand_total,
            "description" => "Purchase #$purchase_id - Payable",
            "created_by" => $_SESSION['user_id']
        ]);
        if (!$je3['status']) {
            $error++;
            $error_messages[] = "Journal (Payable): " . $je3['message'];
        }

    }
    // else: chart_of_accounts not set up yet - journal entries skipped, purchase still proceeds

    if ($error == 0) {
        $crud->conn->commit();
        $_SESSION['message'] = array(
            "type" => "success",
            "title" => "Success",
            "message" => "Purchase added successfully."
        );
    } else {
        $crud->conn->rollback();
        $_SESSION['message'] = array(
            "type" => "danger",
            "title" => "Error",
            "message" => implode(" | ", $error_messages)
        );
    }

} else {
    $_SESSION['message'] = array(
        "type" => "danger",
        "title" => "Error",
        "message" => $result['message']
    );
}

echo "<script>window.location='list.php'</script>";
