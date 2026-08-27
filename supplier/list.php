<?php
require_once('../component/connection.php');

$result = $crud->common_select('suppliers', '*', [], 'AND', 'id', 'DESC');
$suppliers = $result['data'];
?>

<?php require_once('../component/header.php'); ?>
<?php require_once('../component/sidebar.php'); ?>

<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <h4>Supplier List</h4>
            <a href="create.php" class="btn btn-primary">+ Add Supplier</a>
        </div>

        <?php if(isset($_GET['msg']) && $_GET['msg'] == 'added'){ ?>
            <div class="alert alert-success">Supplier Added Successfully</div>
        <?php } ?>

        <?php if(isset($_GET['msg']) && $_GET['msg'] == 'updated'){ ?>
            <div class="alert alert-success">Supplier Updated Successfully</div>
        <?php } ?>

        <?php if(isset($_GET['msg']) && $_GET['msg'] == 'deleted'){ ?>
            <div class="alert alert-success">Supplier Deleted Successfully</div>
        <?php } ?>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Contact</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>City</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if(!empty($suppliers)){ ?>
                        <?php foreach($suppliers as $row){ ?>
                            <tr>
                                <td><?= $row->id; ?></td>
                                <td><?= $row->name; ?></td>
                                <td><?= $row->contact_person; ?></td>
                                <td><?= $row->phone; ?></td>
                                <td><?= $row->email; ?></td>
                                <td><?= $row->city; ?></td>
                                <td>
                                    <?= $row->status == 1 ? 'Active' : 'Inactive'; ?>
                                </td>
                                <td>
                                    <a href="edit.php?id=<?= $row->id; ?>" class="btn btn-sm btn-info" title="Edit">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                    <a href="delete.php?id=<?= $row->id; ?>" class="btn btn-sm btn-danger delete-btn" title="Delete">
                                        <i class="fa fa-trash"></i> Delete
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="8" class="text-center">No suppliers found</td>
                        </tr>
                    <?php } ?>
                </tbody>

            </table>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var deleteButtons = document.querySelectorAll('.delete-btn');
    deleteButtons.forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            if (!confirm('Are you sure you want to delete this supplier?')) {
                e.preventDefault();
            }
        });
    });
});
</script>

<?php include('../component/footer.php'); ?>