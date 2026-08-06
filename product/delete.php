<?php
require_once('../component/connection.php');
require_once('../component/header_auth.php');

if(empty($_GET['id'])){
    header("Location: list.php");
    exit;
}

$id = $_GET['id'];

// Soft delete: set deleted_at instead of removing the row
$data = ["deleted_at" => date("Y-m-d H:i:s")];

if(!empty($_SESSION['user_id'])){
    $data["updated_by"] = $_SESSION['user_id'];
}

$result = $crud->common_update("products", $data, ["id" => $id]);

if($result['status']){
    $_SESSION['message'] = [
        "type" => "success",
        "title" => "Success!",
        "message" => "Product deleted successfully."
    ];
} else {
    $_SESSION['message'] = [
        "type" => "error",
        "title" => "Failed!",
        "message" => $result['message']
    ];
}

header("Location: list.php");
exit;
