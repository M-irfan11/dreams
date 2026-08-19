<?php require_once "../../component/header.php"; ?>
<!-- Sidebar Start -->
<?php require_once "../../component/sidebar.php"; ?>
<!-- Sidebar End -->
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-12">
                <h3>Received Vouchers</h3>
                <a href="create.php" class="btn btn-primary">Add Payment</a>
            </div>
        </div>
        <div class="mt-4">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Voucher No</th>
                        <th>Date</th>
                        <th>Received From</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM receive_vouchers WHERE deleted_at IS NULL";
                    $result = $crud->common_query($sql);
                    foreach ($result['data'] as $v) {
                    ?>
                    <tr>
                        <td><?= $v->voucher_no ?></td>
                        <td><?= $v->voucher_date ?></td>
                        <td><?= $v->received_from ?></td>
                        <td><?= number_format($v->cr, 2) ?></td>
                        <td><?= $v->status == 1 ? 'Active' : 'Inactive' ?></td>
                        <td>
                            <a href="edit.php?id=<?= $v->id ?>" class="btn btn-sm btn-info">Edit</a>
                            <a href="delete.php?id=<?= $v->id ?>&type=receive" class="btn btn-sm btn-danger">Delete</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require_once "../../component/footer.php"; ?>