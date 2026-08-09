<?php
require_once '../component/connection.php';

 $crud->conn->begin_transaction();
    $error=0;
    $data = [
        "customer_id" => $_POST['customer_id'],
        "user_id" => $_SESSION['user_id'],
        "sale_date" => $_POST['sale_date'],
        "total_amount" => $_POST['total_amount'],
        "discount" => $_POST['discount'],
        "tax" => $_POST['tax'],
        "status" => $_POST['status'],
        "created_at" => date('Y-m-d H:i:s'),
        "created_by" => $_SESSION['user_id']
    ];

    // warehouse is optional in the sales table, only include it if one was picked
    if(!empty($_POST['warehouse_id'])){
        $data["warehouse_id"] = $_POST['warehouse_id'];
    }

    $result = $crud->common_insert('sales', $data);

    if($result['status']){
        // reduce stock for each product sold via stock_transfers table
       // <!-- `id`, `product_id`, `warehouse_id`, `quantity`, `transfer_date`, `sale_id`, `purchase_id`, `sale_return_id`, `purchase_return_id`, `status`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by` -->
       foreach($_POST['product_id'] as $index => $product_id){
            $stock_data = [
                "sale_id" => $result['data'],
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
                "sale_id" => $result['data'],
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
                "message" => "Sale added successfully."
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


echo "<script>window.location='list.php'</script>";
