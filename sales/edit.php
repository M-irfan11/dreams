<?php
require_once '../component/connection.php';

 $crud->conn->begin_transaction();
if($_POST){
    $id = $_GET['id'];
    $error=0;
    $data = [
        "customer_id" => $_POST['customer_id'],
        "sale_date" => $_POST['sale_date'],
        "total_amount" => $_POST['total_amount'],
        "discount" => $_POST['discount'],
        "tax" => $_POST['tax'],
        "status" => $_POST['status'],
        "updated_at" => date('Y-m-d H:i:s'),
        "updated_by" => $_SESSION['user_id']
    ];

    // warehouse is optional in the sales table, only include it if one was picked
    if(!empty($_POST['warehouse_id'])){
        $data["warehouse_id"] = $_POST['warehouse_id'];
    }

    $result = $crud->common_update('sales', $data, ["id" => $id]);

    if($result['status']){
        // rebuild sale line items and stock movement for this sale
        $crud->common_delete('sale_details', ["id" => $id]);
        $crud->common_delete('stock_transfers', ["id" => $id]);
       foreach($_POST['product_id'] as $index => $product_id){
            $stock_data = [
                "id" => $id,
                "product_id" => $product_id,
                "quantity" => $_POST['quantity'][$index],
                "unit_price" => $_POST['unit_price'][$index],
                "subtotal" => $_POST['subtotal'][$index],
                "created_at" => date('Y-m-d H:i:s'),
                "created_by" => $_SESSION['user_id']
            ];
            $sd=$crud->common_insert('sale_details', $stock_data);
            if(!$sd['status']){
                $error++;
            }
            // remove stock in stock_transfers table (status 0 = out)
            $st=$crud->common_insert('stock_transfers', [
                "product_id" => $product_id,
                "quantity" => $_POST['quantity'][$index],
                "status" => 0,
                "transfer_date" => $_POST['sale_date'],
                "id" => $id,
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
                "message" => "Sale updated successfully."
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
