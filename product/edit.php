
<?php require_once "../component/connection.php"; ?>

<?php
// Handle form submission (update)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {

    $id = $_POST['id'];

    $data = [
        'category_id'    => $_POST['category_id'],
        'supplier_id'    => $_POST['supplier_id'],
        'product_name'   => $_POST['product_name'],
        'brand'          => $_POST['brand'],
        'purchase_price' => $_POST['purchase_price'],
        'selling_price'  => $_POST['selling_price'],
        'barcode'        => $_POST['barcode'],
    ];

    $result = $crud->common_update("products", $data, ["id" => $id]);

    if ($result['status']) {
        header("Location: list.php");
        exit;
    } else {
        echo "<div class='alert alert-danger'>Update Failed: " . htmlspecialchars($result['message']) . "</div>";
    }
}

// Load product for the form (GET request from the Edit link/list, or after a failed POST)
$id = $_GET['id'] ?? ($_POST['id'] ?? null);

if (empty($id)) {
    echo "<div class='alert alert-danger'>Invalid ID</div>";
    require_once "../component/footer.php";
    exit;
}

$product = $crud->common_select("products", "*", ["id" => $id]);

if (!$product['status'] || empty($product['data'])) {
    echo "<div class='alert alert-danger'>Product not found</div>";
    require_once "../component/footer.php";
    exit;
}

$row = $product['data'][0];
?>
<?php require_once "../component/header.php"; ?>
<?php require_once "../component/sidebar.php"; ?>



<div class="page-wrapper">
    <div class="content">

        <div class="page-header">
            <div class="page-title">
                <h4>Edit Product</h4>
            </div>
        </div>

        <div class="card">
            <div class="card-body">

                <form action="edit.php" method="POST">

                    <input type="hidden" name="id" value="<?= htmlspecialchars($row->id) ?>">

                    <div class="form-group">
                        <label>Category ID</label>
                        <input type="number" name="category_id" class="form-control"
                               value="<?= htmlspecialchars($row->category_id) ?>">
                    </div>

                    <div class="form-group">
                        <label>Supplier ID</label>
                        <input type="number" name="supplier_id" class="form-control"
                               value="<?= htmlspecialchars($row->supplier_id) ?>">
                    </div>

                    <div class="form-group">
                        <label>Product Name</label>
                        <input type="text" name="product_name" class="form-control"
                               value="<?= htmlspecialchars($row->product_name) ?>">
                    </div>

                    <div class="form-group">
                        <label>Brand</label>
                        <input type="text" name="brand" class="form-control"
                               value="<?= htmlspecialchars($row->brand) ?>">
                    </div>

                    <div class="form-group">
                        <label>Purchase Price</label>
                        <input type="text" name="purchase_price" class="form-control"
                               value="<?= htmlspecialchars($row->purchase_price) ?>">
                    </div>

                    <div class="form-group">
                        <label>Selling Price</label>
                        <input type="text" name="selling_price" class="form-control"
                               value="<?= htmlspecialchars($row->selling_price) ?>">
                    </div>

                    <div class="form-group">
                        <label>Barcode</label>
                        <input type="text" name="barcode" class="form-control"
                               value="<?= htmlspecialchars($row->barcode) ?>">
                    </div>

                    <button type="submit" class="btn btn-primary">Update Product</button>
                    <a href="list.php" class="btn btn-secondary">Cancel</a>

                </form>

            </div>
        </div>

    </div>
</div>

<?php require_once "../component/footer.php"; ?>