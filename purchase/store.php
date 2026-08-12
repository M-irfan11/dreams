<?php
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

