<?php
 require_once '../component/header.php';
 require_once '../component/sidebar.php';

// -----------------------------------------------------------------
// Fetch stock list joined with product & warehouse names
// NOTE: change `products.product_name` / `warehouse.name` below
// if your actual column names are different.
// -----------------------------------------------------------------
$sql = "SELECT stocks.id, stocks.product_id, stocks.warehouse_id, SUM(stocks.quantity) AS quantity, stocks.updated_at,
               products.product_name AS product_name,
               warehouses.warehouse_name AS warehouse_name
        FROM stocks
        JOIN products   ON products.id   = stocks.product_id
        JOIN warehouses ON warehouses.id = stocks.warehouse_id
        GROUP BY stocks.product_id, stocks.warehouse_id
        ";

$stock_result = $crud->common_query($sql);
$stocks = $stock_result['data'];

// Flash message (set by create.php / update.php / delete.php)
$flash_message = $_SESSION['flash_message'] ?? "";
$flash_type    = $_SESSION['flash_type'] ?? "";
unset($_SESSION['flash_message'], $_SESSION['flash_type']);
?>

<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Stock Management</h4>
                <h6>Manage your product stock across warehouses</h6>
            </div>
            <div class="page-btn">
                <a href="<?= $base_url ?>stock/create.php" class="btn btn-added">
                    <i class="fa fa-plus-circle me-2"></i>Add Stock
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
                                <th>Warehouse</th>
                                <th>Quantity</th>
                                <th>Last Updated</th>
                                <!-- <th class="text-end">Action</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($stocks)): ?>
                                <?php foreach ($stocks as $row): ?>
                                    <tr>
                                        <td><?= (int)$row->id ?></td>
                                        <td><?= htmlspecialchars($row->product_name) ?></td>
                                        <td><?= htmlspecialchars($row->warehouse_name) ?></td>
                                        <td><?= (int)$row->quantity ?></td>
                                        <td><?= htmlspecialchars($row->updated_at) ?></td>
                                        <!-- <td class="text-end">
                                            <a href="<?= $base_url ?>stock/edit.php?id=<?= (int)$row->id ?>" class="me-2">
                                                <i data-feather="edit" class="feather-edit"></i>
                                            </a>
                                            <a href="<?= $base_url ?>stock/delete.php?id=<?= (int)$row->id ?>"
                                               onclick="return confirm('Are you sure you want to delete this stock record?');">
                                                <i data-feather="trash-2" class="feather-trash-2"></i>
                                            </a>
                                        </td> -->
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">No stock records found</td>
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
