<?php
require_once "../component/connection.php";
require_once "crud_class.php";

$obj = new crud_class();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid Request");
}

$id = $_POST['id'];

$data = [
    "product_name" => $_POST['product_name'],
    "brand" => $_POST['brand'],
    "selling_price" => $_POST['selling_price'],
    "updated_by" => 1
];

$result = $obj->common_update("products",$data,["id"=>$id]);

if($result['status']){
    header("Location: list.php?msg=updated");
    exit;
}else{
    echo $result['message'];
}