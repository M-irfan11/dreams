<?php
require_once('../component/connection.php');
require_once('../component/header_auth.php');

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
        $data["created_by"] = $_SESSION['user_id'];
    }

    $result = $crud->common_insert("products", $data);

    if($result['status']){
        $_SESSION['message'] = [
            "type" => "success",
            "title" => "Success!",
            "message" => "Product added successfully."
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

// Dropdown data
$categories = $crud->common_select("categories");
$suppliers  = $crud->common_select("suppliers");
?>

<div class="page-wrapper">
    <div class="content">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-3">Add Product</h4>
                <form method="POST">
                    <div class="row">

                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>Product Name</label>
                                <input type="text" name="product_name" class="form-control" placeholder="Product Name" required>
                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>Brand</label>
                                <input type="text" name="brand" class="form-control" placeholder="Brand">
                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>Category</label>
                                <select name="category_id" class="form-control" required>
                                    <option value="">Select Category</option>
                                    <?php if($categories['status']): ?>
                                        <?php foreach($categories['data'] as $cat): ?>
                                            <option value="<?= $cat->categories_id ?>"><?= htmlspecialchars($cat->name) ?></option>
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
                                            <option value="<?= $sup->id ?>"><?= htmlspecialchars($sup->supplier_name) ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>Purchase Price</label>
                                <input type="number" step="0.01" name="purchase_price" class="form-control" placeholder="0.00" required>
                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>Selling Price</label>
                                <input type="number" step="0.01" name="selling_price" class="form-control" placeholder="0.00" required>
                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>Barcode</label>
                                <input type="text" name="barcode" class="form-control" placeholder="Barcode">
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-primary me-2">Save</button>
                            <a href="list.php" class="btn btn-secondary">Cancel</a>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once('../component/footer.php'); ?>
