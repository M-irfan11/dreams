<?php
require_once "../component/connection.php"; 

// Handle form submission FIRST — before any HTML output
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        "account_code"    => $crud->conn->real_escape_string($_POST['account_code']),
        "account_name"    => $crud->conn->real_escape_string($_POST['account_name']),
        "account_type"    => $crud->conn->real_escape_string($_POST['account_type']),
        "account_subtype" => $crud->conn->real_escape_string($_POST['account_subtype']),
        "opening_balance" => (float)$_POST['opening_balance'],
        "status"          => $crud->conn->real_escape_string($_POST['status']),
        "description"     => $crud->conn->real_escape_string($_POST['description']),
    ];

    if (!empty($_POST['parent_id'])) {
        $data["parent_id"] = (int)$_POST['parent_id'];
    }

    $edit_id = (int)$_POST['id'];
    $crud->common_update("account_heads", $data, ["id" => $edit_id]);

    header("Location: account_heads.php");
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$result = $crud->common_select("account_heads", "*", ["id" => $id]);
$acc = $result['data'][0] ?? null;

if (!$acc) {
    require_once "../component/header.php";
    require_once "../component/sidebar.php";
    echo "<div class='page-wrapper'><div class='content'><div class='alert alert-danger'>Account not found.</div></div></div>";
    require_once "../component/footer.php";
    exit;
}

$all_accounts = $crud->common_query("SELECT * FROM account_heads WHERE deleted_at IS NULL AND id != $id");
?>
<?php require_once "../component/header.php"; ?>
<!-- Sidebar Start -->
<?php require_once "../component/sidebar.php"; ?>
<!-- Sidebar End -->
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-12">
                <h3>Edit Account Head</h3>
            </div>
        </div>

        <div class="mt-4">
            <form method="POST" action="account_head_edit.php?id=<?= $acc->id ?>">
                <input type="hidden" name="id" value="<?= $acc->id ?>">

                <div class="mb-3">
                    <label class="form-label">Account Code</label>
                    <input type="text" name="account_code" class="form-control" value="<?= htmlspecialchars($acc->account_code) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Account Name</label>
                    <input type="text" name="account_name" class="form-control" value="<?= htmlspecialchars($acc->account_name) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Account Type</label>
                    <select name="account_type" class="form-control" required>
                        <?php
                        $types = ['Asset', 'Liability', 'Income', 'Expense', 'Equity'];
                        foreach ($types as $type) {
                            $selected = ($acc->account_type == $type) ? 'selected' : '';
                            echo "<option value='$type' $selected>$type</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Account Subtype</label>
                    <input type="text" name="account_subtype" class="form-control" value="<?= htmlspecialchars($acc->account_subtype) ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Parent Account</label>
                    <select name="parent_id" class="form-control">
                        <option value="">-- None --</option>
                        <?php foreach ($all_accounts['data'] as $p) {
                            $selected = ($acc->parent_id == $p->id) ? 'selected' : '';
                            echo "<option value='{$p->id}' $selected>{$p->account_name}</option>";
                        } ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Opening Balance</label>
                    <input type="number" step="0.01" name="opening_balance" class="form-control" value="<?= $acc->opening_balance ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="Active" <?= $acc->status == 'Active' ? 'selected' : '' ?>>Active</option>
                        <option value="Inactive" <?= $acc->status == 'Inactive' ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control"><?= htmlspecialchars($acc->description) ?></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="account_heads.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
<?php require_once "../component/footer.php"; ?>