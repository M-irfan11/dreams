<?php
<<<<<<< HEAD
require_once "../component/connection.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $data = [
        'supplier_id' => $_POST['supplier_id'],
        'purchase_date' => $_POST['purchase_date'],
        'total_amount' => $_POST['total_amount'],
        'discount_amount' => $_POST['discount_amount'],
        'discount_type' => $_POST['discount_type'],
        'vat' => $_POST['vat'],
        'grand_total' => $_POST['grand_total'],
         'ref' => $_POST['ref'],
          'status' => $_POST['status']
    ];

    $ref = $_POST['ref'];

    $check = $crud->common_select("purchases", "*", ["ref" => $ref]);

    if ($check["status"]) {
        echo "<script>
                alert('⚠️ Barcode already exists!');
                window.history.back();
              </script>";
        exit;
    } else {
        $insert = $crud->common_insert("purchases", $data);

        if ($insert["status"]) {
            header("Location: list.php");
            exit;
        } else {
            echo "Error: " . $insert["message"];
        }
    }
}

=======

require_once '../component/connection.php';

if ($_POST) {

    // Start transaction
    $crud->conn->begin_transaction();

    try {

        // Purchase information
        $data = [
            "supplier_id"     => $_POST['supplier_id'],
            "purchase_date"   => $_POST['purchase_date'],
            "ref"             => $_POST['ref'],
            "total_amount"    => $_POST['total_amount'],
            "discount_amount" => $_POST['discount_amount'],
            "discount_type"   => $_POST['discount_type'],
            "vat"             => $_POST['vat'],
            "grand_total"     => $_POST['grand_total'],
            "status"          => 1,
            "created_at"      => date('Y-m-d H:i:s'),
            "created_by"      => $_SESSION['user_id']
        ];

        // Insert purchase
        $purchase = $crud->common_insert('purchases', $data);

        if (!$purchase['status']) {
            throw new Exception($purchase['message']);
        }

        // Get newly created purchase ID
        $purchase_id = $purchase['data'];

        // Insert purchase products
        foreach ($_POST['product_id'] as $index => $product_id) {

            $quantity = $_POST['quantity'][$index];
            $purchase_price = $_POST['purchase_price'][$index];
            $subtotal = $_POST['subtotal'][$index];

            // Purchase details
            $detail_data = [
                "purchase_id"    => $purchase_id,
                "product_id"     => $product_id,
                "quantity"       => $quantity,
                "purchase_price" => $purchase_price,
                "subtotal"       => $subtotal,
                "created_at"     => date('Y-m-d H:i:s'),
                "created_by"     => $_SESSION['user_id']
            ];

            $detail = $crud->common_insert(
                'purchase_details',
                $detail_data
            );

            if (!$detail['status']) {
                throw new Exception($detail['message']);
            }


            // Add stock
            $stock_data = [
                "product_id"   => $product_id,
                "quantity"     => $quantity,
                "status"       => 1,
                "transfer_date"=> $_POST['purchase_date'],
                "purchase_id"  => $purchase_id,
                "created_at"   => date('Y-m-d H:i:s'),
                "created_by"   => $_SESSION['user_id']
            ];

            $stock = $crud->common_insert(
                'stock_transfers',
                $stock_data
            );

            if (!$stock['status']) {
                throw new Exception($stock['message']);
            }
        }


        // Everything successful
        $crud->conn->commit();

        $_SESSION['message'] = [
            "type" => "success",
            "title" => "Success",
            "message" => "Purchase added successfully."
        ];

        header("Location: list.php");
        exit();

    } catch (Exception $e) {

        // Something failed
        $crud->conn->rollback();

        $_SESSION['message'] = [
            "type" => "danger",
            "title" => "Error",
            "message" => $e->getMessage()
        ];

        header("Location: add.php");
        exit();
    }
}

?>
>>>>>>> b909d02b82be3b4237510179e503cd15ac547ac9
