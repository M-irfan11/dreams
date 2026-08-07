<?php require_once "../component/header.php"; ?>
<?php require_once "../component/sidebar.php"; ?>

<div class="page-wrapper">
    <div class="content">

        <div class="page-header">
            <div class="page-title">
                <h4>Add Product</h4>
            </div>
        </div>

        <div class="card">
            <div class="card-body">

                <form action="store.php" method="POST">

                    <div class="form-group">
                        <label>Category ID</label>
                        <input type="number" name="category_id" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Supplier ID</label>
                        <input type="number" name="supplier_id" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Product Name</label>
                        <input type="text" name="product_name" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Brand</label>
                        <input type="text" name="brand" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Purchase Price</label>
                        <input type="text" name="purchase_price" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Selling Price</label>
                        <input type="text" name="selling_price" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Barcode</label>
                        <input type="text" name="barcode" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary">Save Product</button>

                </form>

            </div>
        </div>

    </div>
</div>

<?php require_once "../component/footer.php"; ?>