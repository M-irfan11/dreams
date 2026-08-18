<?php require_once "../component/header.php"; ?>
<!-- Sidebar Start -->
<?php require_once "../component/sidebar.php"; ?>
<!-- Sidebar End -->
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-12">
                <h3>Add New Account Head</h3>
            </div>
        </div>
        <div class="mt-4">
            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <form action="account_head_store.php" method="POST" class="p-4">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="account_code" class="form-label">Account Code</label>
                                <input type="text" class="form-control" id="account_code" name="account_code" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="account_name" class="form-label">Account Name</label>
                                <input type="text" class="form-control" id="account_name" name="account_name" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="account_type" class="form-label">Account Type</label>
                                <select class="form-select" id="account_type" name="account_type" required>
                                    <option value="1">Asset</option>
                                    <option value="2">Liability</option>
                                    <option value="3">Income</option>
                                    <option value="4">Expense</option>
                                    <option value="5">Equity</option>
                                    <option value="6">VAT</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="account_subtype" class="form-label">Account Subtype</label>
                                <input type="text" class="form-control" id="account_subtype" name="account_subtype">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="parent_id" class="form-label">Parent Account</label>
                                <select class="form-select" id="parent_id" name="parent_id">
                                    <option value="">Select Parent</option>
                                    <?php
                                    $parents = $crud->common_query("SELECT id, account_name FROM account_heads WHERE deleted_at IS NULL");
                                    foreach ($parents['data'] as $p) {
                                        echo "<option value='{$p->id}'>{$p->account_name}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="opening_balance" class="form-label">Opening Balance</label>
                                <input type="number" step="0.01" class="form-control" id="opening_balance" name="opening_balance" value="0.00">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <button type="submit" class="btn btn-primary">Save Account</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once "../component/footer.php"; ?>