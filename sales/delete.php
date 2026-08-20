<?php
require_once '../component/connection.php';
 $crud->conn->begin_transaction();
if(isset($_GET['id'])){

    $id = $_GET['id'];
    $result = $crud->common_delete('sales', ["id" => $id]);

    if($result['status']){
        $crud->common_delete('sale_details', ["id" => $id]);
        $crud->common_delete('stock_transfers', ["id" => $id]);
        $vouchers = $crud->common_select('journal_vouchers','*' , ["source_id" => $id, "source_type" => 'Sales']);
        if($vouchers['status'] && !empty($vouchers['data'])){
            foreach($vouchers['data'] as $voucher){
                $crud->common_delete('journal_voucher_details', ["journal_voucher_id" => $voucher->id]);
                $crud->common_delete('ledger', ["journal_voucher_id" => $voucher->id]);
            }
            $crud->common_delete('journal_vouchers', ["source_id" => $id, "source_type" => 'Sales']);
        }
        $crud->conn->commit();
        $_SESSION['message'] = array(
            "type" => "success",
            "title" => "Deleted",
            "message" => "Sale deleted successfully."
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
