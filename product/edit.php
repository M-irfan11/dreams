<?php
require_once('../component/connection.php');
require_once('../component/header_auth.php');

if(empty($_GET['id']) && empty($_POST['id'])){
    header("Location: list.php");
    exit;
}

$id = $_POST['id'] ?? $_GET['id'];

if($_POST){
    $data = [
        "category_id"    => $_POST['category_id'],
        "supplier_id"    => $_POST['supplier_id'],
        "product_name"   => $_POST['product_name'],
        "brand"          => $_POST['brand'],
        "purchase_price" => $_POST['purchase_price'],
        "selling_price"  => $_POST['selling_price'],
        "barcode"        => $_POST['barcode'],
    ];

    if(!empty($_SESSION['user_id'])){
        $data["updated_by"] = $_SESSION['user_id'];
    }

    $result = $crud->common_update("products", $data, ["id" => $id]);

    if($result['status']){
        $_SESSION['message'] = [
            "type" => "success",
            "title" => "Success!",
            "message" => "Product updated successfully."
        ];
    } else {
        $_SESSION['message'] = [
            "type" => "error",
            "title" => "Failed!",
            "message" => $result['message']
        ];
    }

    header("Location: list.php");
    exit;
}

require_once('../component/header.php');
require_once('../component/sidebar.php');

// Fetch product to edit
$product_result = $crud->common_select("products", "*", ["id" => $id]);

if(!$product_result['status']){
    $_SESSION['message'] = [
        "type" => "error",
        "title" => "Not Found!",
        "message" => "Product not found."
    ];
    header("Location: list.php");
    exit;
}

$product = $product_result['data'][0];

// Dropdown data
$categories = $crud->common_select("categories");
$suppliers  = $crud->common_select("suppliers");
?>

<div class="page-wrapper">
    <div class="content">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-3">Edit Product</h4>
                <form method="POST">
                    <input type="hidden" name="id" value="<?= $product->id ?>">
                    <div class="row">

                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>Product Name</label>
                                <input type="text" name="product_name" class="form-control" value="<?= htmlspecialchars($product->product_name) ?>" required>
                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>Brand</label>
                                <input type="text" name="brand" class="form-control" value="<?= htmlspecialchars($product->brand) ?>">
                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>Category</label>
                                <select name="category_id" class="form-control" required>
                                    <option value="">Select Category</option>
                                    <?php if($categories['status']): ?>
                                        <?php foreach($categories['data'] as $cat): ?>
                                            <option value="<?= $cat->categories_id ?>" <?= $cat->categories_id == $product->category_id ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($cat->name) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>Supplier</label>
                                <select name="supplier_id" class="form-control" required>
                                    <option value="">Select Supplier</option>
                                    <?php if($suppliers['status']): ?>
                                        <?php foreach($suppliers['data'] as $sup): ?>
                                            <option value="<?= $sup->id ?>" <?= $sup->id == $product->supplier_id ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($sup->supplier_name) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>Purchase Price</label>
                                <input type="number" step="0.01" name="purchase_price" class="form-control" value="<?= htmlspecialchars($product->purchase_price) ?>" required>
                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>Selling Price</label>
                                <input type="number" step="0.01" name="selling_price" class="form-control" value="<?= htmlspecialchars($product->selling_price) ?>" required>
                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>Barcode</label>
                                <input type="text" name="barcode" class="form-control" value="<?= htmlspecialchars($product->barcode) ?>">
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-primary me-2">Update</button>
                            <a href="list.php" class="btn btn-secondary">Cancel</a>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once('../component/footer.php'); ?>
