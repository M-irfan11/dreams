<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/component/connection.php";

if (!isset($_SESSION['is_logged_in']) || !$_SESSION['is_logged_in']) {
    header("Location: {$base_url}login.php");
    exit;
}

$id = (int)($_GET['id'] ?? 0);

if ($id <= 0) {
    $_SESSION['flash_message'] = "Invalid stock transfer record.";
    $_SESSION['flash_type']    = "error";
    header("Location: {$base_url}stock_transfer/list.php");
    exit;
}

// -----------------------------------------------------------------
// Fetch the existing stock transfer record
// -----------------------------------------------------------------
$transfer_result = $crud->common_select("stock_transfers", "*", ["id" => $id]);

if (empty($transfer_result['data'])) {
    $_SESSION['flash_message'] = "Stock transfer record not found.";
    $_SESSION['flash_type']    = "error";
    header("Location: {$base_url}stock_transfer/list.php");
    exit;
}

$transfer = $transfer_result['data'][0];

// -----------------------------------------------------------------
// Data for product dropdown
// -----------------------------------------------------------------
$products_result = $crud->common_select("products", "id, product_name");
$products = $products_result['data'];

// Data for optional sale / purchase reference dropdowns
$sales_result     = $crud->common_select("sales", "sale_id, sale_date, total_amount", [], "AND", "sale_id", "DESC");
$purchases_result = $crud->common_select("purchases", "id, purchase_date, total_amount", [], "AND", "id", "DESC");
$sales     = $sales_result['data'];
$purchases = $purchases_result['data'];

require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/component/header.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/component/sidebar.php";
?>

<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Edit Stock Transfer</h4>
                <h6>Update stock transfer record #<?= (int)$transfer->id ?></h6>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="<?= $base_url ?>stock_transfer/update.php" method="POST">
                    <input type="hidden" name="id" value="<?= (int)$transfer->id ?>">

                    <div class="mb-3">
                        <label class="form-label">Product</label>
                        <select name="product_id" class="form-control" required>
                            <option value="">-- Select Product --</option>
                            <?php foreach ($products as $p): ?>
                                <option value="<?= (int)$p->id ?>"
                                    <?= ((int)$p->id === (int)$transfer->product_id) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($p->product_name) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Quantity</label>
                        <input type="number" name="quantity" class="form-control" min="1"
                               value="<?= (int)$transfer->quantity ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Transfer Date</label>
                        <input type="date" name="transfer_date" class="form-control"
                               value="<?= htmlspecialchars($transfer->transfer_date) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control" required>
                            <option value="1" <?= ((int)$transfer->status === 1) ? 'selected' : '' ?>>In</option>
                            <option value="0" <?= ((int)$transfer->status === 0) ? 'selected' : '' ?>>Out</option>
                        </select>
                    </div>

                    <hr>
                    <p class="text-muted">Optional reference (leave blank if not related to a sale/purchase)</p>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Sale (optional)</label>
                            <select name="sale_id" class="form-control">
                                <option value="">-- None --</option>
                                <?php foreach ($sales as $s): ?>
                                    <option value="<?= (int)$s->sale_id ?>"
                                        <?= ((int)$s->sale_id === (int)($transfer->sale_id ?? 0)) ? 'selected' : '' ?>>
                                        Sale #<?= (int)$s->sale_id ?> - <?= htmlspecialchars($s->sale_date) ?> (<?= htmlspecialchars($s->total_amount) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Purchase (optional)</label>
                            <select name="purchase_id" class="form-control">
                                <option value="">-- None --</option>
                                <?php foreach ($purchases as $pu): ?>
                                    <option value="<?= (int)$pu->id ?>"
                                        <?= ((int)$pu->id === (int)($transfer->purchase_id ?? 0)) ? 'selected' : '' ?>>
                                        Purchase #<?= (int)$pu->id ?> - <?= htmlspecialchars($pu->purchase_date) ?> (<?= htmlspecialchars($pu->total_amount) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Sale Return ID</label>
                            <input type="number" name="sale_return_id" class="form-control"
                                   value="<?= htmlspecialchars($transfer->sale_return_id ?? '') ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Purchase Return ID</label>
                            <input type="number" name="purchase_return_id" class="form-control"
                                   value="<?= htmlspecialchars($transfer->purchase_return_id ?? '') ?>">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-submit me-2">Update</button>
                    <a href="<?= $base_url ?>stock_transfer/list.php" class="btn btn-cancel">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>

</div> <!-- /.main-wrapper -->

<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/component/footer.php"; ?>
