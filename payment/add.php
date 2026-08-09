<?php
require_once '../component/connection.php';

if($_POST){
    $data = [
        "sale_id" => $_POST['sale_id'],
        "amount" => $_POST['amount'],
        "payment_method" => $_POST['payment_method'],
        "payment_date" => $_POST['payment_date'],
        "transaction_id" => $_POST['transaction_id'],
        "created_at" => date('Y-m-d H:i:s'),
        "created_by" => $_SESSION['user_id']
    ];

    $result = $crud->common_insert('payments', $data);

    if($result['status']){
        $_SESSION['message'] = array(
            "type" => "success",
            "title" => "Success",
            "message" => "Payment added successfully."
        );
    } else {
        $_SESSION['message'] = array(
            "type" => "danger",
            "title" => "Error",
            "message" => $result['message']
        );
    }
}

echo "<script>window.location='list.php'</script>";
