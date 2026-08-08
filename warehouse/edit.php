<?php
require_once '../component/connection.php';

if($_POST){

    $id = $_POST['id'];

    $data = [
        "warehouse_name" => $_POST['warehouse_name'],
        "location"       => $_POST['location'],
        "manager_name"   => $_POST['manager_name'],
    ];

    $result = $crud->common_update('warehouses', $data, ["id" => $id]);

    if($result['status']){
        $_SESSION['message'] = array(
            "type" => "success",
            "title" => "Success",
            "message" => "Warehouse updated successfully."
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
