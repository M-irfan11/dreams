<?php require_once "../component/header.php"; ?>
<!-- Sidebar Start -->
<?php require_once "../component/sidebar.php"; ?>
<!-- Sidebar End -->
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-12">
                <h3>Create Voucher</h3>
            </div>
        </div>
        <form action="voucher_store.php" method="POST">
            <input type="hidden" name="type" value="<?= $_GET['type'] ?? 'payment' ?>">
            <div class="row">
                <div class="col-md-6">
                    <label>Voucher Date</label>
                    <input type="date" name="voucher_date" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label>Narration</label>
                    <input type="text" name="narration" class="form-control" required>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-6">
                    <label>Account Head</label>
                    <select name="account_head_id" class="form-select" required>
                        <option value="">Select Account</option>
                        <?php
                        $accounts = $crud->common_query("SELECT id, account_name FROM account_heads WHERE deleted_at IS NULL");
                        foreach ($accounts['data'] as $a) {
                            echo "<option value='{$a->id}'>{$a->account_name}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label>Dr</label>
                    <input type="number" step="0.01" name="dr" class="form-control" value="0.00">
                </div>
                <div class="col-md-3">
                    <label>Cr</label>
                    <input type="number" step="0.01" name="cr" class="form-control" value="0.00">
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Save Voucher</button>
        </form>
    </div>
</div>
<?php require_once "../component/footer.php"; ?>