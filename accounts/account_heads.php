<?php require_once "../component/header.php"; ?>
<!-- Sidebar Start -->
<?php require_once "../component/sidebar.php"; ?>
<!-- Sidebar End -->
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-12">
                <h3>Account Heads</h3>
                <a href="account_head_create.php" class="btn btn-success">+ Add Account</a>
            </div>
        </div>
        <div class="mt-4">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Balance</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM account_heads WHERE deleted_at IS NULL";
                    $result = $crud->common_query($sql);
                    foreach ($result['data'] as $acc) {
                    ?>
                    <tr>
                        <td><?= $acc->account_code ?></td>
                        <td><?= $acc->account_name ?></td>
                        <td><?= $acc->account_type ?></td>
                        <td><?= number_format($acc->current_balance, 2) ?></td>
                        <td><?= $acc->status == 1 ? 'Active' : 'Inactive' ?></td>
                        <td>
                            
                            <a href="ledger.php?account_id=<?= $acc->id ?>" class="btn btn-sm btn-info">
                                <i class="fa-solid fa-book"></i> Ledger
                            </a>
                            <a href="account_head_edit.php?id=<?= $acc->id ?>" class="btn btn-sm btn-primary">Edit</a>
                            <a href="account_head_delete.php?id=<?= $acc->id ?>" class="btn btn-sm btn-danger">Delete</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require_once "../component/footer.php"; ?>