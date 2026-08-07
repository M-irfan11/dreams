<?php
require_once "../component/connection.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $data = [
        'category_id' => $_POST['category_id'],
        'supplier_id' => $_POST['supplier_id'],
        'product_name' => $_POST['product_name'],
        'brand' => $_POST['brand'],
        'purchase_price' => $_POST['purchase_price'],
        'selling_price' => $_POST['selling_price'],
        'barcode' => $_POST['barcode']
    ];

    $barcode = $_POST['barcode'];

    $check = $crud->common_select("products", "*", ["barcode" => $barcode]);

    if ($check["status"]) {
        echo "<script>
                alert('⚠️ Barcode already exists!');
                window.history.back();
              </script>";
        exit;
    } else {
        $insert = $crud->common_insert("products", $data);

        if ($insert["status"]) {
            header("Location: list.php");
            exit;
        } else {
            echo "Error: " . $insert["message"];
        }
    }
}