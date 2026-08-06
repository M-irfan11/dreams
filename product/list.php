<?php
require_once('../component/connection.php');
require_once('../component/header_auth.php');
require_once('../component/header.php');
require_once('../component/sidebar.php');

// Session message (set by add.php, edit.php, delete.php)
if(isset($_SESSION['message'])){
    $msg = $_SESSION['message'];
    $alert_class = $msg['type'] === 'success' ? 'alert-success' : 'alert-danger';
    echo '<div class="alert ' . $alert_class . '">
            <strong>' . htmlspecialchars($msg['title']) . '</strong> ' . htmlspecialchars($msg['message']) . '
          </div>';
    unset($_SESSION['message']);
}

// Fetch all products with category, supplier, and stock info
$products = $crud->common_query("SELECT products.*, categories.name as category_name, suppliers.supplier_name,
    (SELECT COALESCE(SUM(quantity),0) FROM stock_transfers WHERE stock_transfers.product_id = products.id) as stock
    FROM products
    LEFT JOIN categories ON categories.categories_id = products.category_id
    LEFT JOIN suppliers ON suppliers.id = products.supplier_id
    ORDER BY products.id DESC");
?>

<div class="page-wrapper">
<div class="content">

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Product List</h4>
    <a href="add.php" class="btn btn-primary">Add Product</a>
</div>

<table class="table table-bordered">
<thead>
<tr>
<th>#</th>
<th>Name</th>
<th>Brand</th>
<th>Category</th>
<th>Supplier</th>
<th>Barcode</th>
<th>Purchase Price</th>
<th>Selling Price</th>
<th>Stock</th>
<th>Action</th>
</tr>
</thead>

<tbody>
<?php if($products['status']): ?>
<?php $sl = 1; foreach($products['data'] as $row): ?>
<tr>
<td><?= $sl++ ?></td>
<td><?= htmlspecialchars($row->product_name) ?></td>
<td><?= htmlspecialchars($row->brand) ?></td>
<td><?= htmlspecialchars($row->category_name) ?></td>
<td><?= htmlspecialchars($row->supplier_name) ?></td>
<td><?= htmlspecialchars($row->barcode) ?></td>
<td><?= htmlspecialchars($row->purchase_price) ?></td>
<td><?= htmlspecialchars($row->selling_price) ?></td>
<td><?= htmlspecialchars($row->stock) ?></td>
<td>
<a href="edit.php?id=<?= $row->id ?>" class="btn btn-warning btn-sm">Edit</a>
<a href="delete.php?id=<?= $row->id ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
</td>
</tr>
<?php endforeach; ?>
<?php else: ?>
<tr><td colspan="10" class="text-center">No products found.</td></tr>
<?php endif; ?>
</tbody>
</table>

</div>
</div>

<?php require_once('../component/footer.php'); ?>
