<?php
require_once '../component/connection.php';

if($_POST){
    $id = $_GET['id'];

    // basic validation - category name is required
    if(empty(trim($_POST['category_name']))){
        $_SESSION['message'] = array(
            "type" => "danger",
            "title" => "Error",
            "message" => "Category name is required."
        );
        echo "<script>window.location='update.php?id=$id'</script>";
        exit;
    }

    $data = [
        "category_name" => $_POST['category_name'],
        "description" => $_POST['description'],
        "status" => $_POST['status'],
        "updated_at" => date('Y-m-d H:i:s'),
        "updated_by" => $_SESSION['user_id']
    ];

    $result = $crud->common_update('expense_categories', $data, ["id" => $id]);

    if($result['status']){
        $_SESSION['message'] = array(
            "type" => "success",
            "title" => "Success",
            "message" => "Expense category updated successfully."
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
