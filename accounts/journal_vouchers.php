<?php require_once "../component/header.php"; ?>
<!-- Sidebar Start -->
<?php require_once "../component/sidebar.php"; ?>
<!-- Sidebar End -->
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-12">
                <h3>Journal Vouchers</h3>
                <a href="voucher_create.php?type=journal" class="btn btn-primary">Add Journal</a>
            </div>
        </div>
        <div class="mt-4">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Voucher No</th>
                        <th>Date</th>
                        <th>Narration</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM journal_vouchers WHERE deleted_at IS NULL";
                    $result = $crud->common_query($sql);
                    foreach ($result['data'] as $v) {
                    ?>
                    <tr>
                        <td><?= $v->voucher_no ?></td>
                        <td><?= $v->voucher_date ?></td>
                        <td><?= $v->narration ?></td>
                        <td><?= $v->status == 1 ? 'Active' : 'Inactive' ?></td>
                        <td>
                            <a href="voucher_view.php?id=<?= $v->id ?>&type=journal" class="btn btn-sm btn-info">View</a>
                            <a href="voucher_delete.php?id=<?= $v->id ?>&type=journal" class="btn btn-sm btn-danger">Delete</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require_once "../component/footer.php"; ?>