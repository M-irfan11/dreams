<?php require_once "../component/header.php"; ?>
<!-- Sidebar Start -->
<?php require_once "../component/sidebar.php"; ?>
<!-- Sidebar End -->

<?php
$id = $_GET['id'];
$type = $_GET['type'] ?? 'payment';

$sql = "SELECT * FROM {$type}_vouchers WHERE id = $id AND deleted_at IS NULL";
$result = $crud->common_query($sql);
if (!$result['status'] || empty($result['data'])) {
    $_SESSION['message'] = ['danger', 'Error', 'Voucher not found.'];
    echo "<script>window.location.href = '" . $base_url . "accounts/{$type}_vouchers.php';</script>";
    exit;
}
$voucher = $result['data'][0];

$details_sql = "SELECT * FROM {$type}_voucher_details WHERE {$type}_voucher_id = $id";
$details = $crud->common_query($details_sql);
?>
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-12">
                <h3>Edit Voucher</h3>
            </div>
        </div>
        <form action="voucher_update.php" method="POST">
            <input type="hidden" name="id" value="<?= $id ?>">
            <input type="hidden" name="type" value="<?= $type ?>">
            <div class="row">
                <div class="col-md-6">
                    <label>Voucher Date</label>
                    <input type="date" name="voucher_date" class="form-control" value="<?= $voucher->voucher_date ?>" required>
                </div>
                <div class="col-md-6">
                    <label>Narration</label>
                    <input type="text" name="narration" class="form-control" value="<?= $voucher->narration ?>" required>
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
                            $selected = ($a->id == $details['data'][0]->account_head_id) ? 'selected' : '';
                            echo "<option value='{$a->id}' {$selected}>{$a->account_name}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label>Dr</label>
                    <input type="number" step="0.01" name="dr" class="form-control" value="<?= $details['data'][0]->dr ?? 0 ?>" step="0.01">
                </div>
                <div class="col-md-3">
                    <label>Cr</label>
                    <input type="number" step="0.01" name="cr" class="form-control" value="<?= $details['data'][0]->cr ?? 0 ?>" step="0.01">
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Update Voucher</button>
        </form>
    </div>
</div>
<?php require_once "../component/footer.php"; ?>