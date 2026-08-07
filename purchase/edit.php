<?php
require_once '../component/connection.php';

 $crud->conn->begin_transaction();
if($_POST){
    $id = $_GET['id'];
    $error=0;
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
        "updated_at" => date('Y-m-d H:i:s'),
        "updated_by" => $_SESSION['user_id']
    ];

    $result = $crud->common_update('purchases', $data, ["id" => $id]);

    if($result['status']){
        // set opening balance for the product in stock_transfers table
        $crud->common_delete('purchase_details', ["purchase_id" => $id]);
        $crud->common_delete('stock_transfers', ["purchase_id" => $id]);
       foreach($_POST['product_id'] as $index => $product_id){
            $stock_data = [
                "purchase_id" => $id,
                "product_id" => $product_id,
                "quantity" => $_POST['quantity'][$index],
                "purchase_price" => $_POST['purchase_price'][$index],
                "subtotal" => $_POST['subtotal'][$index],
                "created_at" => date('Y-m-d H:i:s'),
                "created_by" => $_SESSION['user_id']
            ];
            $pd=$crud->common_insert('purchase_details', $stock_data);
            if(!$pd['status']){
                $error++;
            }
            // add stock in stock_transfers table
            $st=$crud->common_insert('stock_transfers', [
                "product_id" => $product_id,
                "quantity" => $_POST['quantity'][$index],
                "status" => 1,
                "transfer_date" => $_POST['purchase_date'],
                "purchase_id" => $id,
                "created_at" => date('Y-m-d H:i:s'),
                "created_by" => $_SESSION['user_id']
            ]);
            if(!$st['status']){
                $error++;
            }
        }
      
        if($result['status'] && $error==0){
            $crud->conn->commit();
             $_SESSION['message'] = array(
                "type" => "success",
                "title" => "Success",
                "message" => "Product added successfully."
            );
        } else {
            $crud->conn->rollback();
                $_SESSION['message'] = array(
                    "type" => "danger",
                    "title" => "Error",
                    "message" => $result['message']
                );
        }

       
    } else {
        $_SESSION['message'] = array(
            "type" => "danger",
            "title" => "Error",
            "message" => $result['message']
        );
    }

}
echo "<script>window.location='list.php'</script>";