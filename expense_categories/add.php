<?php
require_once '../component/connection.php';

// basic validation - category name is required
if(empty(trim($_POST['category_name']))){
    $_SESSION['message'] = array(
        "type" => "danger",
        "title" => "Error",
        "message" => "Category name is required."
    );
    echo "<script>window.location='create.php'</script>";
    exit;
}

$data = [
    "category_name" => $_POST['category_name'],
    "description" => $_POST['description'],
    "status" => $_POST['status'],
    "created_at" => date('Y-m-d H:i:s'),
    "created_by" => $_SESSION['user_id']
];

$result = $crud->common_insert('expense_categories', $data);

if($result['status']){
    $_SESSION['message'] = array(
        "type" => "success",
        "title" => "Success",
        "message" => "Expense category added successfully."
    );
} else {
    $_SESSION['message'] = array(
        "type" => "danger",
        "title" => "Error",
        "message" => $result['message']
    );
}

echo "<script>window.location='list.php'</script>";
