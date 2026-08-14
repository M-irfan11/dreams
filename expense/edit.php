<?php
require_once '../component/connection.php';

if($_POST){
    $id = $_GET['id'];

    // basic validation - category, date and amount are required
    if(empty($_POST['category_id']) || empty($_POST['expense_date']) || $_POST['amount'] === ''){
        $_SESSION['message'] = array(
            "type" => "danger",
            "title" => "Error",
            "message" => "Category, date and amount are required."
        );
        echo "<script>window.location='update.php?id=$id'</script>";
        exit;
    }

    $data = [
        "category_id" => $_POST['category_id'],
        "expense_date" => $_POST['expense_date'],
        "amount" => $_POST['amount'],
        "payment_method" => $_POST['payment_method'],
        "description" => $_POST['description'],
        "updated_at" => date('Y-m-d H:i:s'),
        "updated_by" => $_SESSION['user_id']
    ];

    $result = $crud->common_update('expenses', $data, ["id" => $id]);

    if($result['status']){
        $_SESSION['message'] = array(
            "type" => "success",
            "title" => "Success",
            "message" => "Expense updated successfully."
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
