<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/component/header.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/component/sidebar.php";

// -----------------------------------------------------------------
// Fetch stock transfer list joined with product name
// NOTE: change `products.product_name` below if your actual
// column name is different.
// -----------------------------------------------------------------
$sql = "SELECT stock_transfers.id, stock_transfers.product_id, stock_transfers.quantity,
               stock_transfers.transfer_date, stock_transfers.sale_id, stock_transfers.purchase_id,
               stock_transfers.sale_return_id, stock_transfers.purchase_return_id,
               stock_transfers.status,
               products.product_name AS product_name
        FROM stock_transfers
        JOIN products ON products.id = stock_transfers.product_id";

$transfer_result = $crud->common_query($sql);
$transfers = $transfer_result['data'];

// Flash message (set by create.php / update.php / delete.php)
$flash_message = $_SESSION['flash_message'] ?? "";
$flash_type    = $_SESSION['flash_type'] ?? "";
unset($_SESSION['flash_message'], $_SESSION['flash_type']);
?>

<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Stock Transfer</h4>
                <h6>Track stock movement in and out</h6>
            </div>
            <div class="page-btn">
                <a href="<?= $base_url ?>stock_transfer/create.php" class="btn btn-added">
                    <i class="fa fa-plus-circle me-2"></i>Add Stock Transfer
                </a>
            </div>
        </div>

        <?php if (!empty($flash_message)): ?>
            <div class="alert alert-<?= $flash_type === 'error' ? 'danger' : 'success' ?>">
                <?= htmlspecialchars($flash_message) ?>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table datanew">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Transfer Date</th>
                                <th>Status</th>
                                <th>Ref (Sale/Purchase)</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($transfers)): ?>
                                <?php foreach ($transfers as $row): ?>
                                    <tr>
                                        <td><?= (int)$row->id ?></td>
                                        <td><?= htmlspecialchars($row->product_name) ?></td>
                                        <td><?= (int)$row->quantity ?></td>
                                        <td><?= htmlspecialchars($row->transfer_date) ?></td>
                                        <td>
                                            <?php if ((int)$row->status === 1): ?>
                                                <span class="badge bg-success">In</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Out</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php
                                                $refs = [];
                                                if (!empty($row->sale_id))            $refs[] = "Sale #" . (int)$row->sale_id;
                                                if (!empty($row->purchase_id))         $refs[] = "Purchase #" . (int)$row->purchase_id;
                                                if (!empty($row->sale_return_id))      $refs[] = "Sale Return #" . (int)$row->sale_return_id;
                                                if (!empty($row->purchase_return_id))  $refs[] = "Purchase Return #" . (int)$row->purchase_return_id;
                                                echo !empty($refs) ? htmlspecialchars(implode(", ", $refs)) : "-";
                                            ?>
                                        </td>
                                        <td class="text-end">
                                            <a href="<?= $base_url ?>stock_transfer/edit.php?id=<?= (int)$row->id ?>" class="me-2">
                                                <i data-feather="edit" class="feather-edit"></i>
                                            </a>
                                            <a href="<?= $base_url ?>stock_transfer/delete.php?id=<?= (int)$row->id ?>"
                                               onclick="return confirm('Are you sure you want to delete this stock transfer record?');">
                                                <i data-feather="trash-2" class="feather-trash-2"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center">No stock transfer records found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

</div> <!-- /.main-wrapper -->

<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/component/footer.php"; ?>
