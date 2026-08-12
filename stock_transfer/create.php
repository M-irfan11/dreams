<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/component/connection.php";

if (!isset($_SESSION['is_logged_in']) || !$_SESSION['is_logged_in']) {
    header("Location: {$base_url}login.php");
    exit;
}

$error = "";

// -----------------------------------------------------------------
// Handle form submission (insert)
// -----------------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $product_id   = (int)($_POST['product_id'] ?? 0);
    $quantity     = (int)($_POST['quantity'] ?? 0);
    $transfer_date = $_POST['transfer_date'] ?? '';
    $status       = (int)($_POST['status'] ?? 1);

    // Optional reference fields
    $sale_id             = !empty($_POST['sale_id']) ? (int)$_POST['sale_id'] : null;
    $purchase_id         = !empty($_POST['purchase_id']) ? (int)$_POST['purchase_id'] : null;
    $sale_return_id      = !empty($_POST['sale_return_id']) ? (int)$_POST['sale_return_id'] : null;
    $purchase_return_id  = !empty($_POST['purchase_return_id']) ? (int)$_POST['purchase_return_id'] : null;

    if ($product_id <= 0 || $quantity <= 0 || empty($transfer_date)) {
        $error = "Please select a product, valid quantity and transfer date.";
    } else {
        $data = [
            "product_id"    => $product_id,
            "quantity"      => $quantity,
            "transfer_date" => $transfer_date,
            "status"        => $status
        ];

        if ($sale_id !== null)            $data["sale_id"] = $sale_id;
        if ($purchase_id !== null)        $data["purchase_id"] = $purchase_id;
        if ($sale_return_id !== null)     $data["sale_return_id"] = $sale_return_id;
        if ($purchase_return_id !== null) $data["purchase_return_id"] = $purchase_return_id;

        $result = $crud->common_insert("stock_transfers", $data);

        $_SESSION['flash_message'] = $result['message'];
        $_SESSION['flash_type']    = $result['status'] ? "success" : "error";

        if ($result['status']) {
            header("Location: {$base_url}stock_transfer/list.php");
            exit;
        } else {
            $error = $result['message'];
        }
    }
}

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
?>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/component/header.php"; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/component/sidebar.php"; ?>

<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Add Stock Transfer</h4>
                <h6>Record a stock movement (in/out)</h6>
            </div>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">
                <form action="<?= $base_url ?>stock_transfer/create.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Product</label>
                        <select name="product_id" class="form-control" required>
                            <option value="">-- Select Product --</option>
                            <?php foreach ($products as $p): ?>
                                <option value="<?= (int)$p->id ?>"
                                    <?= (isset($_POST['product_id']) && $_POST['product_id'] == $p->id) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($p->product_name) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Quantity</label>
                        <input type="number" name="quantity" class="form-control" min="1"
                               value="<?= htmlspecialchars($_POST['quantity'] ?? 1) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Transfer Date</label>
                        <input type="date" name="transfer_date" class="form-control"
                               value="<?= htmlspecialchars($_POST['transfer_date'] ?? date('Y-m-d')) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control" required>
                            <option value="1" <?= (($_POST['status'] ?? '1') == '1') ? 'selected' : '' ?>>In</option>
                            <option value="0" <?= (($_POST['status'] ?? '') == '0') ? 'selected' : '' ?>>Out</option>
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
                                        <?= (isset($_POST['sale_id']) && $_POST['sale_id'] == $s->sale_id) ? 'selected' : '' ?>>
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
                                        <?= (isset($_POST['purchase_id']) && $_POST['purchase_id'] == $pu->id) ? 'selected' : '' ?>>
                                        Purchase #<?= (int)$pu->id ?> - <?= htmlspecialchars($pu->purchase_date) ?> (<?= htmlspecialchars($pu->total_amount) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Sale Return ID</label>
                            <input type="number" name="sale_return_id" class="form-control"
                                   value="<?= htmlspecialchars($_POST['sale_return_id'] ?? '') ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Purchase Return ID</label>
                            <input type="number" name="purchase_return_id" class="form-control"
                                   value="<?= htmlspecialchars($_POST['purchase_return_id'] ?? '') ?>">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-submit me-2">Save</button>
                    <a href="<?= $base_url ?>stock_transfer/list.php" class="btn btn-cancel">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>

</div> <!-- /.main-wrapper -->

<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/component/footer.php"; ?>
