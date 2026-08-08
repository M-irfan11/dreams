<?php
require_once '../component/connection.php';

if($_POST){

    $data = [
        "warehouse_name" => $_POST['warehouse_name'],
        "location"       => $_POST['location'],
        "manager_name"   => $_POST['manager_name'],
    ];

    $result = $crud->common_insert('warehouses', $data);

    if($result['status']){
        $_SESSION['message'] = array(
            "type" => "success",
            "title" => "Success",
            "message" => "Warehouse added successfully."
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
