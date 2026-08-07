<?php
require_once '../component/connection.php';

if(isset($_GET['id'])){

    $id = $_GET['id'];
    $result = $crud->common_delete('suppliers', ["id" => $id]);

    if($result['status']){
        $_SESSION['message'] = array(
            "type" => "success",
            "title" => "Deleted",
            "message" => "Supplier deleted successfully."
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
