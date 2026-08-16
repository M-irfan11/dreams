<?php

require_once '../component/connection.php';

// account_code diye account_id ber kora
function getAccountId($crud, $code) {
    $r = $crud->common_select('chart_of_accounts', '*', ["account_code" => $code]);
    return $r['status'] ? $r['data'][0]->account_id : null;
}

$crud->conn->begin_transaction();

try {

    // -------------------------
    // SALE INFORMATION
    // -------------------------

    $data = [
        "customer_id"  => $_POST['customer_id'],
        "user_id"      => $_SESSION['user_id'],
        "sale_date"    => $_POST['sale_date'],
        "total_amount" => $_POST['total_amount'],
        "discount"     => $_POST['discount'],
        "tax"          => $_POST['tax'],
        "status"       => $_POST['status'],
        "created_at"   => date('Y-m-d H:i:s'),
        "created_by"   => $_SESSION['user_id']
    ];


    // Warehouse optional
    if (!empty($_POST['warehouse_id'])) {
        $data["warehouse_id"] = $_POST['warehouse_id'];
    }


    // -------------------------
    // INSERT SALE
    // -------------------------

    $result = $crud->common_insert('sales', $data);

    if (!$result['status']) {
        throw new Exception($result['message']);
    }

    // New sale ID
    $sale_id = $result['data'];


    // -------------------------
    // INSERT SALE DETAILS
    // + STOCK OUT
    // -------------------------

    foreach ($_POST['product_id'] as $index => $product_id) {

        $quantity     = $_POST['quantity'][$index];
        $unit_price   = $_POST['unit_price'][$index];
        $subtotal     = $_POST['subtotal'][$index];


        // -------------------------
        // SALE DETAILS
        // -------------------------

        $sale_detail = [
            "sale_id"      => $sale_id,
            "product_id"   => $product_id,
            "quantity"     => $quantity,
            "unit_price"   => $unit_price,
            "subtotal"     => $subtotal,
            "created_at"   => date('Y-m-d H:i:s'),
            "created_by"   => $_SESSION['user_id']
        ];

        $detail_result = $crud->common_insert(
            'sale_details',
            $sale_detail
        );

        if (!$detail_result['status']) {
            throw new Exception($detail_result['message']);
        }


        // -------------------------
        // STOCK OUT
        // status = 0 means OUT
        // -------------------------

        $stock_data = [
            "product_id"    => $product_id,
            "quantity"      => $quantity,
            "status"        => 0,
            "transfer_date" => $_POST['sale_date'],
            "sale_id"       => $sale_id,
            "created_at"    => date('Y-m-d H:i:s'),
            "created_by"    => $_SESSION['user_id']
        ];


        // Add warehouse if selected
        if (!empty($_POST['warehouse_id'])) {
            $stock_data["warehouse_id"] = $_POST['warehouse_id'];
        }


        $stock_result = $crud->common_insert(
            'stock_transfers',
            $stock_data
        );

        if (!$stock_result['status']) {
            throw new Exception($stock_result['message']);
        }
    }


    // -------------------------
    // JOURNAL ENTRIES (accounting posting)
    // Dr Accounts Receivable = total_amount - discount + tax
    // Cr Sales Revenue       = total_amount - discount
    // Cr VAT Payable         = tax
    // -------------------------

    $total_amount = (float) $_POST['total_amount'];
    $discount = (float) ($_POST['discount'] ?: 0);
    $tax = (float) ($_POST['tax'] ?: 0);

    $revenue_amount = $total_amount - $discount;
    $receivable_amount = $revenue_amount + $tax;

    $receivable_acc = getAccountId($crud, '1200');
    $revenue_acc    = getAccountId($crud, '4000');
    $vat_output_acc = getAccountId($crud, '2100');

    if (!$receivable_acc || !$revenue_acc) {
        throw new Exception("Accounting accounts not set up. Please add accounts 1200 and 4000 first.");
    }

    $je1 = $crud->common_insert('journal_entries', [
        "entry_date" => $_POST['sale_date'],
        "reference_type" => "Sales",
        "reference_id" => $sale_id,
        "account_id" => $receivable_acc,
        "debit" => $receivable_amount,
        "credit" => 0,
        "description" => "Sale #$sale_id - Receivable",
        "created_by" => $_SESSION['user_id']
    ]);
    if (!$je1['status']) {
        throw new Exception($je1['message']);
    }

    $je2 = $crud->common_insert('journal_entries', [
        "entry_date" => $_POST['sale_date'],
        "reference_type" => "Sales",
        "reference_id" => $sale_id,
        "account_id" => $revenue_acc,
        "debit" => 0,
        "credit" => $revenue_amount,
        "description" => "Sale #$sale_id - Revenue",
        "created_by" => $_SESSION['user_id']
    ]);
    if (!$je2['status']) {
        throw new Exception($je2['message']);
    }

    if ($tax > 0 && $vat_output_acc) {
        $je3 = $crud->common_insert('journal_entries', [
            "entry_date" => $_POST['sale_date'],
            "reference_type" => "Sales",
            "reference_id" => $sale_id,
            "account_id" => $vat_output_acc,
            "debit" => 0,
            "credit" => $tax,
            "description" => "Sale #$sale_id - VAT Output",
            "created_by" => $_SESSION['user_id']
        ]);
        if (!$je3['status']) {
            throw new Exception($je3['message']);
        }
    }


    $crud->conn->commit();

    $_SESSION['message'] = [
        "type"    => "success",
        "title"   => "Success",
        "message" => "Sale added successfully."
    ];

    header("Location: list.php");
    exit();


} catch (Exception $e) {

    // Something failed
    $crud->conn->rollback();

    $_SESSION['message'] = [
        "type"    => "danger",
        "title"   => "Error",
        "message" => $e->getMessage()
    ];

    header("Location: add.php");
    exit();
}
?>