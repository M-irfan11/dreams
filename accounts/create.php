<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/component/connection.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/crud/crud_class.php";

$crud = new crud_class();
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $data = [
        "account_code"    => trim($_POST['account_code']),
        "account_name"    => trim($_POST['account_name']),
        "account_type"    => $_POST['account_type'],
        "account_subtype" => trim($_POST['account_subtype']),
        "opening_balance" => $_POST['opening_balance'] !== '' ? $_POST['opening_balance'] : 0,
        "current_balance" => $_POST['opening_balance'] !== '' ? $_POST['opening_balance'] : 0,
        "status"          => $_POST['status'],
        "description"     => trim($_POST['description']),
    ];

    if (!empty($_POST['parent_id'])) {
        $data["parent_id"] = $_POST['parent_id'];
    }

    $result = $crud->common_insert("chart_of_accounts", $data);

    if ($result['status']) {
        header("Location: {$base_url}accounts/list.php");
        exit;
    } else {
        $error = $result['message'];
    }
}

// parent dropdown er jonno shob account list kore anlam
$parents = $crud->common_select("chart_of_accounts", "*", [], "AND", "account_code", "ASC");

require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/component/header.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/component/sidebar.php";
?>

<div class="page-wrapper">
<div class="content">

<h4 class="page-title">Add Account</h4>

<?php if ($error): ?>
<div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<div class="card">
<div class="card-body">
<form method="POST">
<div class="row">

<div class="col-md-6 mb-3">
<label>Account Code *</label>
<input type="text" name="account_code" class="form-control" placeholder="e.g. 1130" required>
</div>

<div class="col-md-6 mb-3">
<label>Account Name *</label>
<input type="text" name="account_name" class="form-control" placeholder="e.g. Accounts Receivable" required>
</div>

<div class="col-md-6 mb-3">
<label>Account Type *</label>
<select name="account_type" class="form-control" required>
<option value="Asset">Asset</option>
<option value="Liability">Liability</option>
<option value="Income">Income</option>
<option value="Expense">Expense</option>
<option value="Equity">Equity</option>
<option value="VAT">VAT</option>
</select>
</div>

<div class="col-md-6 mb-3">
<label>Account Subtype</label>
<input type="text" name="account_subtype" class="form-control" placeholder="e.g. Current Asset">
</div>

<div class="col-md-6 mb-3">
<label>Parent Account</label>
<select name="parent_id" class="form-control">
<option value="">-- None (Top Level) --</option>
<?php if ($parents['status']): foreach ($parents['data'] as $p): ?>
<option value="<?= $p->account_id ?>"><?= htmlspecialchars($p->account_code . " - " . $p->account_name) ?></option>
<?php endforeach; endif; ?>
</select>
</div>

<div class="col-md-6 mb-3">
<label>Opening Balance</label>
<input type="number" step="0.01" name="opening_balance" class="form-control" value="0.00">
</div>

<div class="col-md-6 mb-3">
<label>Status</label>
<select name="status" class="form-control">
<option value="Active">Active</option>
<option value="Inactive">Inactive</option>
</select>
</div>

<div class="col-md-12 mb-3">
<label>Description</label>
<textarea name="description" class="form-control" rows="3"></textarea>
</div>

</div>

<button type="submit" class="btn btn-primary">Save Account</button>
<a href="<?= $base_url ?>accounts/list.php" class="btn btn-secondary">Cancel</a>
</form>
</div>
</div>

</div>
</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/component/footer.php"; ?>
