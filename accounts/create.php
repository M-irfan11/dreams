<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/component/connection.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/crud/crud_class.php";

$crud = new crud_class();

$editId  = isset($_GET['id']) ? (int) $_GET['id'] : null;
$account = null;

if($editId){
    $res = $crud->common_select("account_heads", "*", ["id" => $editId], "AND", "", "ASC", "1", "", false);
    if($res['status']) $account = $res['data'][0];
}

$errors = [];

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $data = [
        "account_code"    => trim($_POST['account_code']),
        "account_name"    => trim($_POST['account_name']),
        "account_type"    => $_POST['account_type'],
        "account_subtype" => trim($_POST['account_subtype']),
        "parent_id"       => !empty($_POST['parent_id']) ? (int) $_POST['parent_id'] : null,
        "opening_balance" => $_POST['opening_balance'] !== '' ? $_POST['opening_balance'] : 0,
        "description"     => trim($_POST['description']),
        "status"          => $_POST['status'],
    ];

    if($data['account_code'] === '') $errors[] = "Account Code দিতে হবে";
    if($data['account_name'] === '') $errors[] = "Account Name দিতে হবে";

    // Account Code ইউনিক কিনা চেক
    if(empty($errors)){
        $dupWhere = ["account_code" => $data['account_code']];
        $dup = $crud->common_select("account_heads", "id", $dupWhere, "AND", "", "ASC", "1", "", false);
        if($dup['status'] && (!$editId || $dup['data'][0]->id != $editId)){
            $errors[] = "এই Account Code আগে থেকেই আছে";
        }
    }

    if(empty($errors)){
        if($editId){
            $crud->common_update("account_heads", $data, ["id" => $editId]);
        } else {
            // নতুন একাউন্ট -> current_balance শুরু হবে opening_balance দিয়ে
            $data["current_balance"] = $data["opening_balance"];
            $data["total_debit"]     = 0;
            $data["total_credit"]    = 0;
            $crud->common_insert("account_heads", $data);
        }
        header("Location: " . $base_url . "accounts/list.php");
        exit;
    }
}

// Parent dropdown এর জন্য সব একাউন্ট আনা হচ্ছে
$allAccounts = $crud->common_select("account_heads", "*", [], "AND", "account_name", "ASC", "", "", false);

require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/component/header.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/component/sidebar.php";
?>

<div class="page-wrapper">
<div class="content">

    <div class="page-header">
        <div class="page-title">
            <h4><?= $editId ? 'Edit' : 'Add' ?> Account Head</h4>
        </div>
    </div>

    <?php if(!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <form method="post">
                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Account Code <span class="text-danger">*</span></label>
                        <input type="text" name="account_code" class="form-control"
                               value="<?= htmlspecialchars($account->account_code ?? '') ?>"
                               placeholder="CASH, SALES, AR" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Account Name <span class="text-danger">*</span></label>
                        <input type="text" name="account_name" class="form-control"
                               value="<?= htmlspecialchars($account->account_name ?? '') ?>"
                               placeholder="Cash in Hand" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Account Type <span class="text-danger">*</span></label>
                        <select name="account_type" class="form-select" required>
                            <?php foreach(["Asset","Liability","Income","Expense","Equity","VAT"] as $t): ?>
                                <option value="<?= $t ?>" <?= (($account->account_type ?? '') === $t) ? 'selected' : '' ?>>
                                    <?= $t ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Account Subtype</label>
                        <input type="text" name="account_subtype" class="form-control"
                               value="<?= htmlspecialchars($account->account_subtype ?? '') ?>"
                               placeholder="Current Asset, Fixed Asset">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Parent Account</label>
                        <select name="parent_id" class="form-select">
                            <option value="">-- None --</option>
                            <?php if($allAccounts['status']): foreach($allAccounts['data'] as $a): ?>
                                <?php if($editId && $a->id == $editId) continue; ?>
                                <option value="<?= $a->id ?>" <?= (($account->parent_id ?? null) == $a->id) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($a->account_code . ' - ' . $a->account_name) ?>
                                </option>
                            <?php endforeach; endif; ?>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Opening Balance</label>
                        <input type="number" step="0.01" name="opening_balance" class="form-control"
                               value="<?= htmlspecialchars($account->opening_balance ?? '0.00') ?>"
                               <?= $editId ? 'readonly' : '' ?>>
                        <?php if($editId): ?>
                            <small class="text-muted">Opening balance এডিটে বদলানো যাবে না, Journal Voucher দিয়ে সমন্বয় করুন</small>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="Active" <?= (($account->status ?? 'Active') === 'Active') ? 'selected' : '' ?>>Active</option>
                            <option value="Inactive" <?= (($account->status ?? '') === 'Inactive') ? 'selected' : '' ?>>Inactive</option>
                        </select>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($account->description ?? '') ?></textarea>
                    </div>

                </div>

                <button type="submit" class="btn btn-submit">Save</button>
                <a href="<?= $base_url ?>accounts/list.php" class="btn btn-cancel">Cancel</a>
            </form>
        </div>
    </div>

</div>
</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/component/footer.php"; ?>
