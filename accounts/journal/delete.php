<?php
require_once '../../component/connection.php';
 $crud->conn->begin_transaction();
if(isset($_GET['id'])){

    $id = $_GET['id'];
    $result = $crud->common_delete('journal_vouchers', ["id" => $id]);

    if($result['status']){
        $crud->common_delete('journal_voucher_details', ["id" => $id]);
        
        $crud->conn->commit();
        $_SESSION['message'] = array(
            "type" => "success",
            "title" => "Deleted",
            "message" => "journal voucher deleted successfully."
        );
    } else {
        $crud->conn->rollback();
        $_SESSION['message'] = array(
            "type" => "danger",
            "title" => "Error",
            "message" => $result['message']
        );
    }
}

echo "<script>window.location='list.php'</script>";
