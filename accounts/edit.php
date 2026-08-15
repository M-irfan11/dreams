<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/component/connection.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/crud/crud_class.php";

$crud = new crud_class();
$error = "";

if (!isset($_GET['id'])) {
    header("Location: {$base_url}accounts/list.php");
    exit;
}

$id = intval($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $data = [
        "account_code"    => trim($_POST['account_code']),
        "account_name"    => trim($_POST['account_name']),
        "account_type"    => $_POST['account_type'],
        "account_subtype" => trim($_POST['account_subtype']),
        "opening_balance" => $_POST['opening_balance'] !== '' ? $_POST['opening_balance'] : 0,
        "status"          => $_POST['status'],
        "description"     => trim($_POST['description']),
        "parent_id"       => !empty($_POST['parent_id']) ? $_POST['parent_id'] : null,
    ];

    $result = $crud->common_update("chart_of_accounts", $data, ["account_id" => $id]);

    if ($result['status']) {
        header("Location: {$base_url}accounts/list.php");
        exit;
    } else {
        $error = $result['message'];
    }
}

// existing record ta niye asha
$record = $crud->common_select("chart_of_accounts", "*", ["account_id" => $id]);
if (!$record['status']) {
    header("Location: {$base_url}accounts/list.php");
    exit;
}
$account = $record['data'][0];

// parent dropdown, nijeke nije parent hisebe dekhabe na
$parents = $crud->common_select("chart_of_accounts", "*", [], "AND", "account_code", "ASC");

require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/component/header.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/component/sidebar.php";
?>

<div class="page-wrapper">
<div class="content">

<h4 class="page-title">Edit Account</h4>

<?php if ($error): ?>
<div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<div class="card">
<div class="card-body">
<form method="POST">
<div class="row">

<div class="col-md-6 mb-3">
<label>Account Code *</label>
<input type="text" name="account_code" class="form-control" value="<?= htmlspecialchars($account->account_code) ?>" required>
</div>

<div class="col-md-6 mb-3">
<label>Account Name *</label>
<input type="text" name="account_name" class="form-control" value="<?= htmlspecialchars($account->account_name) ?>" required>
</div>

<div class="col-md-6 mb-3">
<label>Account Type *</label>
<select name="account_type" class="form-control" required>
<?php foreach (['Asset','Liability','Income','Expense','Equity','VAT'] as $type): ?>
<option value="<?= $type ?>" <?= $account->account_type == $type ? 'selected' : '' ?>><?= $type ?></option>
<?php endforeach; ?>
</select>
</div>

<div class="col-md-6 mb-3">
<label>Account Subtype</label>
<input type="text" name="account_subtype" class="form-control" value="<?= htmlspecialchars($account->account_subtype ?? '') ?>">
</div>

<div class="col-md-6 mb-3">
<label>Parent Account</label>
<select name="parent_id" class="form-control">
<option value="">-- None (Top Level) --</option>
<?php if ($parents['status']): foreach ($parents['data'] as $p): ?>
    <?php if ($p->account_id == $account->account_id) continue; // nijeke nije parent banano jabe na ?>
<option value="<?= $p->account_id ?>" <?= $account->parent_id == $p->account_id ? 'selected' : '' ?>>
<?= htmlspecialchars($p->account_code . " - " . $p->account_name) ?>
</option>
<?php endforeach; endif; ?>
</select>
</div>

<div class="col-md-6 mb-3">
<label>Opening Balance</label>
<input type="number" step="0.01" name="opening_balance" class="form-control" value="<?= htmlspecialchars($account->opening_balance) ?>">
</div>

<div class="col-md-6 mb-3">
<label>Status</label>
<select name="status" class="form-control">
<option value="Active" <?= $account->status == 'Active' ? 'selected' : '' ?>>Active</option>
<option value="Inactive" <?= $account->status == 'Inactive' ? 'selected' : '' ?>>Inactive</option>
</select>
</div>

<div class="col-md-12 mb-3">
<label>Description</label>
<textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($account->description ?? '') ?></textarea>
</div>

</div>

<button type="submit" class="btn btn-primary">Update Account</button>
<a href="<?= $base_url ?>accounts/list.php" class="btn btn-secondary">Cancel</a>
</form>
</div>
</div>

</div>
</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/component/footer.php"; ?>
