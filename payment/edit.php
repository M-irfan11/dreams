<?php
require_once '../component/connection.php';

if($_POST){
    $id = $_GET['id'];
    $data = [
        "sale_id" => $_POST['sale_id'],
        "amount" => $_POST['amount'],
        "payment_method" => $_POST['payment_method'],
        "payment_date" => $_POST['payment_date'],
        "transaction_id" => $_POST['transaction_id'],
        "updated_at" => date('Y-m-d H:i:s'),
        "updated_by" => $_SESSION['user_id']
    ];

    $result = $crud->common_update('payments', $data, ["payment_id" => $id]);

    if($result['status']){
        $_SESSION['message'] = array(
            "type" => "success",
            "title" => "Success",
            "message" => "Payment updated successfully."
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
