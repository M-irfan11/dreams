<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/component/connection.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/crud/crud_class.php";

$crud = new crud_class();
$accounts = $crud->common_select("chart_of_accounts", "*", [], "AND", "account_code", "ASC");

// account_id => account_name map, parent account er nam dekhanor jonno
$account_map = [];
if ($accounts['status']) {
    foreach ($accounts['data'] as $acc) {
        $account_map[$acc->account_id] = $acc->account_name;
    }
}

require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/component/header.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/component/sidebar.php";
?>

<div class="page-wrapper">
<div class="content">

<div class="page-header">
<div class="row">
<div class="col-sm-8">
<h4 class="page-title">Chart of Accounts</h4>
</div>
<div class="col-sm-4 text-end">
    <a href="<?= $base_url ?>accounts/create.php" class="btn btn-primary" style="white-space:nowrap; padding:10px 24px; border-radius:6px; font-weight:500;">
         <i class="fa fa-plus" style="margin-right:6px;"></i>Add Account
    </a>
</div>
</div>
</div>

<div class="card">
<div class="card-body">
<div class="table-responsive">
<table class="table table-bordered table-hover">
<thead>
<tr>
    <th>Code</th>
    <th>Account Name</th>
    <th>Type</th>
    <th>Parent Account</th>
    <th>Opening Balance</th>
    <th>Current Balance</th>
    <th>Status</th>
    <th>Action</th>
</tr>
</thead>
<tbody>
<?php if ($accounts['status']): ?>
    <?php foreach ($accounts['data'] as $acc): ?>
    <tr>
        <td><?= htmlspecialchars($acc->account_code) ?></td>
        <td><?= htmlspecialchars($acc->account_name) ?></td>
        <td><?= htmlspecialchars($acc->account_type) ?></td>
        <td><?= $acc->parent_id ? htmlspecialchars($account_map[$acc->parent_id] ?? '-') : '-' ?></td>
        <td><?= number_format($acc->opening_balance, 2) ?></td>
        <td><?= number_format($acc->current_balance, 2) ?></td>
        <td>
            <span class="badge <?= $acc->status == 'Active' ? 'bg-success' : 'bg-secondary' ?>">
                <?= htmlspecialchars($acc->status) ?>
            </span>
        </td>
        <td>
            <a href="<?= $base_url ?>accounts/edit.php?id=<?= $acc->account_id ?>" class="btn btn-sm btn-info">Edit</a>
            <a href="<?= $base_url ?>accounts/delete.php?id=<?= $acc->account_id ?>"
               class="btn btn-sm btn-danger"
               onclick="return confirm('Are you sure you want to delete this account?');">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr><td colspan="8" class="text-center">No accounts found</td></tr>
<?php endif; ?>
</tbody>
</table>
</div>
</div>
</div>

</div>
</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/component/footer.php"; ?>
