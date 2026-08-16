<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/component/connection.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/crud/crud_class.php";

$crud = new crud_class();

// ---- Delete (account_heads এ deleted_at নেই, তাই status = Inactive করে দেওয়া হচ্ছে) ----
if(isset($_GET['delete_id'])){
    $crud->common_update("account_heads", ["status" => "Inactive"], ["id" => (int) $_GET['delete_id']]);
    header("Location: " . $base_url . "accounts/list.php");
    exit;
}

// ---- Filter by type ----
$where = [];
if(!empty($_GET['type'])){
    $where['account_type'] = $_GET['type'];
}

// account_heads এ deleted_at কলাম নেই -> use_soft_delete = false
$accounts = $crud->common_select(
    "account_heads", "*", $where, "AND", "account_code", "ASC", "", "", false
);

require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/component/header.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/component/sidebar.php";
?>

<div class="page-wrapper">
<div class="content">

    <div class="page-header">
        <div class="page-title">
            <h4>Account Heads</h4>
            <h6>Chart of Accounts</h6>
        </div>
        <div class="page-btn">
            <a href="<?= $base_url ?>accounts/create.php" class="btn btn-added">
                <i class="fa fa-plus-circle me-2"></i>Add Account Head
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">

            <form method="get" class="mb-3">
                <select name="type" class="form-select" style="max-width:220px;display:inline-block" onchange="this.form.submit()">
                    <option value="">-- Accounts --</option>
                    <?php foreach(["Asset","Liability","Income","Expense","Equity","VAT"] as $t): ?>
                        <option value="<?= $t ?>" <?= (($_GET['type'] ?? '') === $t) ? 'selected' : '' ?>><?= $t ?></option>
                    <?php endforeach; ?>
                </select>
            </form>

            <div class="table-responsive">
                <table class="table datanew">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th class="text-end">Opening Balance</th>
                            <th class="text-end">Current Balance</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if($accounts['status']): foreach($accounts['data'] as $acc): ?>
                        <tr>
                            <td><?= htmlspecialchars($acc->account_code) ?></td>
                            <td>
                                <?= htmlspecialchars($acc->account_name) ?>
                                <?php if(!empty($acc->parent_id)): ?>
                                    <br><small class="text-muted">Parent ID: <?= $acc->parent_id ?></small>
                                <?php endif; ?>
                            </td>
                            <td><span class="badge bg-info"><?= $acc->account_type ?></span></td>
                            <td class="text-end"><?= number_format($acc->opening_balance, 2) ?></td>
                            <td class="text-end"><?= number_format($acc->current_balance, 2) ?></td>
                            <td>
                                <span class="badge <?= $acc->status === 'Active' ? 'bg-success' : 'bg-danger' ?>">
                                    <?= $acc->status ?>
                                </span>
                            </td>
                            <td>
                                <a href="<?= $base_url ?>accounts/create.php?id=<?= $acc->id ?>" class="me-2" title="Edit">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="<?= $base_url ?>accounts/list.php?delete_id=<?= $acc->id ?>" title="Inactive করুন"
                                   onclick="return confirm('আপনি কি নিশ্চিত এই একাউন্টটি Inactive করতে চান?');">
                                    <i class="fa fa-trash text-danger"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; else: ?>
                        <tr><td colspan="7" class="text-center">কোনো Account Head পাওয়া যায়নি</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>
</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/component/footer.php"; ?>
