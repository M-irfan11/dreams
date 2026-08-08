<?php

require_once '../component/connection.php';


// ==========================================================
// START TRANSACTION
// ==========================================================

$crud->conn->begin_transaction();

$error = 0;


// ==========================================================
// VALIDATE REQUIRED DATA
// ==========================================================

if (
    empty($_POST['warehouse_id']) ||
    empty($_POST['supplier_id']) ||
    empty($_POST['purchase_date']) ||
    empty($_POST['product_id']) ||
    empty($_POST['quantity']) ||
    empty($_POST['purchase_price']) ||
    empty($_POST['subtotal'])
) {

    $crud->conn->rollback();

    $_SESSION['message'] = [
        "type" => "danger",
        "title" => "Error",
        "message" => "Required purchase information is missing."
    ];

    echo "<script>window.location='add.php'</script>";
    exit;
}


// ==========================================================
// PURCHASE DATA
// ==========================================================

$data = [

    "supplier_id" => $_POST['supplier_id'],

    "warehouse_id" => $_POST['warehouse_id'],

    "purchase_date" => $_POST['purchase_date'],

    "total_amount" => $_POST['total_amount'] ?? 0,

    "discount_amount" => $_POST['discount_amount'] ?? 0,

    "discount_type" => $_POST['discount_type'] ?? "amount",

    "vat" => $_POST['vat'] ?? 0,

    "grand_total" => $_POST['grand_total'] ?? 0,

    "ref" => $_POST['ref'] ?? "",

    "status" => 1,

    "created_at" => date('Y-m-d H:i:s'),

    "created_by" => $_SESSION['user_id'] ?? null
];


// ==========================================================
// INSERT PURCHASE
// ==========================================================

$result = $crud->common_insert(
    'purchases',
    $data
);


// ==========================================================
// PURCHASE INSERT SUCCESS
// ==========================================================

if ($result['status']) {

    $purchase_id = $result['data'];


    // ======================================================
    // INSERT PURCHASE DETAILS + STOCK
    // ======================================================

    foreach ($_POST['product_id'] as $index => $product_id) {


        // --------------------------------------------------
        // GET PRODUCT VALUES
        // --------------------------------------------------

        $quantity =
            $_POST['quantity'][$index] ?? 0;

        $purchase_price =
            $_POST['purchase_price'][$index] ?? 0;

        $subtotal =
            $_POST['subtotal'][$index] ?? 0;


        // --------------------------------------------------
        // VALIDATE PRODUCT
        // --------------------------------------------------

        if (
            empty($product_id) ||
            $quantity <= 0 ||
            $purchase_price < 0
        ) {

            $error++;

            continue;
        }


        // ==================================================
        // PURCHASE DETAILS
        // ==================================================

        $purchase_detail_data = [

            "purchase_id" => $purchase_id,

            "product_id" => $product_id,

            "quantity" => $quantity,

            "purchase_price" => $purchase_price,

            "subtotal" => $subtotal,

            "created_at" => date('Y-m-d H:i:s'),

            "created_by" => $_SESSION['user_id'] ?? null
        ];


        $pd = $crud->common_insert(
            'purchase_details',
            $purchase_detail_data
        );


        if (!$pd['status']) {

            $error++;
        }


        // ==================================================
        // STOCK TRANSFER
        // ==================================================

        /*
         * Stock is added to the selected warehouse.
         *
         * This requires stock_transfers.warehouse_id
         * to exist in your database.
         */

        $stock_data = [

            "warehouse_id" => $_POST['warehouse_id'],

            "product_id" => $product_id,

            "quantity" => $quantity,

            "status" => 1,

            "transfer_date" => $_POST['purchase_date'],

            "purchase_id" => $purchase_id,

            "created_at" => date('Y-m-d H:i:s'),

            "created_by" => $_SESSION['user_id'] ?? null
        ];


        $st = $crud->common_insert(
            'stock_transfers',
            $stock_data
        );


        if (!$st['status']) {

            $error++;
        }

    }


    // ======================================================
    // COMMIT / ROLLBACK
    // ======================================================

    if ($error == 0) {

        $crud->conn->commit();


        $_SESSION['message'] = [

            "type" => "success",

            "title" => "Success",

            "message" => "Purchase added successfully."
        ];


        echo "<script>window.location='list.php'</script>";
        exit;

    } else {

        $crud->conn->rollback();


        $_SESSION['message'] = [

            "type" => "danger",

            "title" => "Error",

            "message" => "Purchase could not be completed."
        ];


        echo "<script>window.location='add.php'</script>";
        exit;
    }


}


// ==========================================================
// PURCHASE INSERT FAILED
// ==========================================================

else {

    $crud->conn->rollback();


    $_SESSION['message'] = [

        "type" => "danger",

        "title" => "Error",

        "message" => $result['message']
    ];


    echo "<script>window.location='add.php'</script>";
    exit;
}

?>