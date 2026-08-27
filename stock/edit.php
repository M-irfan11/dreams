<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/component/connection.php";

// Login Check

if (!isset($_SESSION['is_logged_in']) || !$_SESSION['is_logged_in']) {
    header("Location: {$base_url}login.php");
    exit;
}


// Get ID + Warehouse ID from URL
// Example:
// edit.php?id=9&warehouse_id=2

$id = (int)($_GET['id'] ?? 0);
$warehouse_id = (int)($_GET['warehouse_id'] ?? 0);


// Validate ID

if ($id <= 0 || $warehouse_id <= 0) {

    $_SESSION['flash_message'] = "Invalid stock record or warehouse.";
    $_SESSION['flash_type'] = "error";

    header("Location: {$base_url}stock/list.php");
    exit;
}


// Fetch Stock Record
// ID + Warehouse ID দুইটাই মিলতে হবে

$stock_result = $crud->common_select(
    "stocks",
    "*",
    [
        "id" => $id,
        "warehouse_id" => $warehouse_id
    ]
);

// Check Stock Record

if (
    !$stock_result['status'] ||
    empty($stock_result['data'])
) {

    $_SESSION['flash_message'] = "Stock record not found.";
    $_SESSION['flash_type'] = "error";

    header("Location: {$base_url}stock/list.php");
    exit;
}

$stock = $stock_result['data'][0];


// Get Products
$products_result = $crud->common_select(
    "products",
    "id, product_name"
);

$products = $products_result['data'] ?? [];
// Get Warehouses
$warehouse_result = $crud->common_select(
    "warehouses",
    "id, warehouse_name"
);

$warehouses = $warehouse_result['data'] ?? [];
// Header + Sidebar
require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/component/header.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/component/sidebar.php";
?>

<div class="page-wrapper">
    <div class="content">

        <!-- Page Header -->
        <div class="page-header">

            <div class="page-title">
                <h4>Edit Stock</h4>
                <h6>
                    Update stock record
                    #<?= (int)$stock->id ?>
                </h6>
            </div>

        </div>
        <!-- Stock Edit Card -->
        <div class="card">

            <div class="card-body">

                <form
                    action="<?= $base_url ?>stock/update.php"
                    method="POST" >
                    <!-- Stock ID -->
                    <input
                        type="hidden"
                        name="id"
                        value="<?= (int)$stock->id ?>"  >
                    <!-- Warehouse ID -->
                    <input
                        type="hidden"
                        name="warehouse_id"
                        value="<?= (int)$stock->warehouse_id ?>">
                         <!-- Product -->
                    <div class="mb-3">

                        <label class="form-label">
                            Product
                        </label>

                        <select
                            name="product_id"
                            class="form-control"
                            required >
                            <option value="">
                                -- Select Product --
                            </option>
                            <?php foreach ($products as $p): ?>
                                <option
                                    value="<?= (int)$p->id ?>"
                                    <?= (
                                        (int)$p->id ===
                                        (int)$stock->product_id
                                    ) ? 'selected' : '' ?>
                                >

                                    <?= htmlspecialchars(
                                        $p->product_name
                                    ) ?>

                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <!-- Warehouse -->
                    <div class="mb-3">

                        <label class="form-label">
                            Warehouse
                        </label>
                        <select
                            name="warehouse_id"
                            class="form-control"
                            required
                        >
                            <option value="">
                                -- Select Warehouse --
                            </option>

                            <?php foreach ($warehouses as $w): ?>

                                <option
                                    value="<?= (int)$w->id ?>"
                                    <?= (
                                        (int)$w->id ===
                                        (int)$stock->warehouse_id
                                    ) ? 'selected' : '' ?>
                                >

                                    <?= htmlspecialchars(
                                        $w->warehouse_name
                                    ) ?>

                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <!-- Quantity -->
                    <div class="mb-3">
                        <label class="form-label">
                            Quantity
                        </label>
                        <input
                            type="number"
                            name="quantity"
                            class="form-control"
                            min="0"
                            value="<?= (int)$stock->quantity ?>"
                            required  >
                    </div>
                    <!-- Buttons -->
                    <button
                        type="submit"
                        class="btn btn-submit me-2"
                    >
                        Update
                    </button>
                    <a
                        href="<?= $base_url ?>stock/list.php"
                        class="btn btn-cancel" >
                        Cancel
                    </a>
                </form>
            </div>
        </div>
    </div>
</div>

</div> <!-- /.main-wrapper -->
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/component/footer.php";
?>