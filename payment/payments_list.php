<?php require_once "../component/header.php"; ?>
<?php require_once "../component/sidebar.php"; ?>
<?php $conn = $crud->conn; ?>

<?php 

// Soft delete instead of hard DELETE, since the table has a `deleted_at` column
if(isset($_GET['delete'])){
    $del_id = intval($_GET['delete']);
    $conn->query("UPDATE payments SET deleted_at = NOW() WHERE id = '$del_id'");
    echo "<script>window.location='payments_list.php';</script>";
}

// Query matches the actual `payments` table columns:
// id, sale_id, amount, payment_method, payment_date, transaction_id,
// created_at, updated_at, deleted_at, created_by, updated_by
$sql = "SELECT p.* 
        FROM payments p 
        WHERE p.deleted_at IS NULL
        ORDER BY p.payment_date DESC, p.id DESC";
$result = $conn->query($sql);
?>

<div class="page-wrapper">
    <div class="content">
        <div class="row"> 
            <div class="col-sm-4 col-3">
                <h4 class="page-title">Payments</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card-box">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table datatable" style="width:100%">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>sale_id</th>
                                    <th>Payment Type</th>
                                    <th>Paid Date</th>
                                    <th class="text-center">Paid Amount</th>
                                    <th>Trx ID</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                if($result->num_rows > 0){
                                    while($row = $result->fetch_object()){ ?>
                                    <tr>
                                        <td>
                                            <a href="../invoices/invoice_view.php?id=<?php echo $row->sale_id; ?>">
                                                #INV-<?php echo str_pad($row->sale_id, 4, '0', STR_PAD_LEFT); ?>
                                            </a>
                                        </td>
                                        <td><?php echo $row->sale_id; ?></td>
                                        <td><?php echo $row->payment_method; ?></td>
                                        <td><?php echo date('d M Y', strtotime($row->payment_date)); ?></td>
                                        <td class="text-center"><b><?php echo number_format($row->amount, 2); ?></b></td>
                                        <td><?php echo $row->transaction_id; ?></td>
                                        <td class="text-center">
                                            <a href="../invoices/invoice_view.php?id=<?php echo $row->sale_id; ?>" class="btn btn-info btn-sm">
                                                <i class="fa fa-eye"></i> View
                                            </a>
                                            <a href="payments_list.php?delete=<?php echo $row->id; ?>" 
                                               onclick="return confirm('Are you sure to delete this payment?')" 
                                               class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash"></i> Delete
                                            </a>
                                        </td>
                                    </tr>
                                <?php } 
                                } else {
                                    echo "<tr><td colspan='7' class='text-center'>No Payments Found</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once "../component/footer.php" ?>