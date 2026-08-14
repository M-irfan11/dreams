<?php
require_once '../component/connection.php';

if(isset($_GET['id'])){

    $id = $_GET['id'];

    // soft delete - set deleted_at instead of removing the row
    $result = $crud->common_update('expenses', [
        "deleted_at" => date('Y-m-d H:i:s'),
        "updated_by" => $_SESSION['user_id']
    ], ["id" => $id]);

    if($result['status']){
        $_SESSION['message'] = array(
            "type" => "success",
            "title" => "Deleted",
            "message" => "Expense deleted successfully."
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
