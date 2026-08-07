<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<?php require_once "../component/header.php"; ?>
<?php require_once "../component/sidebar.php"; ?>
<?php require_once "../component/connection.php"; ?>

<?php
$result = $crud->common_select("products");
?>

<!-- Main Content -->
<div class="page-wrapper">
<div class="content">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">📦 Product List</h4>

        <a href="create.php" class="btn btn-primary">
            + Add Product
        </a>
    </div>

    <div class="card">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-hover">

                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Brand</th>
                            <th>Price</th>
                            <th width="180">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php
                    if ($result['status'] && !empty($result['data'])) {
                        foreach ($result['data'] as $row) {
                    ?>
                        <tr>
                            <td><?= $row->id ?></td>
                            <td><?= $row->product_name ?></td>
                            <td><?= $row->brand ?></td>
                            <td>৳ <?= $row->selling_price ?></td>
                            <td>
                                <a href="edit.php?id=<?= $row->id ?>" 
                                   class="btn btn-sm btn-warning">
                                   Edit
                                </a>

                                <a href="delete.php?id=<?= $row->id ?>" 
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Delete করবা?')">
                                   Delete
                                </a>
                            </td>
                        </tr>
                    <?php
                        }
                    } else {
                    ?>
                        <tr>
                            <td colspan="5" class="text-center text-danger">
                                No Data Found
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>
</div>

<?php require_once "../component/footer.php"; ?>