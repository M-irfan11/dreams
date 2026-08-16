<?php
require_once '../component/connection.php';

// basic validation - category, date and amount are required
if(empty($_POST['category_id']) || empty($_POST['expense_date']) || $_POST['amount'] === ''){
    $_SESSION['message'] = array(
        "type" => "danger",
        "title" => "Error",
        "message" => "Category, date and amount are required."
    );
    echo "<script>window.location='create.php'</script>";
    exit;
}

$data = [
    "category_id" => $_POST['category_id'],
    "expense_date" => $_POST['expense_date'],
    "amount" => $_POST['amount'],
    "payment_method" => $_POST['payment_method'],
    "description" => $_POST['description'],
    "created_at" => date('Y-m-d H:i:s'),
    "created_by" => $_SESSION['user_id']
];

$result = $crud->common_insert('expenses', $data);

if($result['status']){
    $_SESSION['message'] = array(
        "type" => "success",
        "title" => "Success",
        "message" => "Expense added successfully."
    );
} else {
    $_SESSION['message'] = array(
        "type" => "danger",
        "title" => "Error",
        "message" => $result['message']
    );
}

echo "<script>window.location='list.php'</script>";
