<?php require_once '../component/header.php'; ?>
<?php require_once '../component/sidebar.php'; ?>
<?php
    $id = $_GET['id'];
    $result = $crud->common_select('expense_categories', '*', ['id' => $id]);
    $category = $result['data'][0];
?>

<div class="page-wrapper">
    <div class="content">

        <div class="page-header">
            <div class="page-title">
                <h4>Edit Expense Category</h4>
                <h6>Update expense category details</h6>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="<?php echo $base_url; ?>expense_categories/edit.php?id=<?php echo $id; ?>" method="POST">
                    <div class="row">
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Category Name <span class="text-danger">*</span></label>
                                <input autocomplete="off" value="<?php echo htmlspecialchars($category->category_name); ?>" name="category_name" type="text" class="form-control" placeholder="Category Name" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" class="select form-control">
                                    <option value="1" <?php echo ($category->status == 1) ? 'selected' : ''; ?>>Active</option>
                                    <option value="0" <?php echo ($category->status == 0) ? 'selected' : ''; ?>>Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" class="form-control" rows="4" placeholder="Description"><?php echo htmlspecialchars($category->description); ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-submit me-2">Save</button>
                            <a href="<?php echo $base_url; ?>expense_categories/list.php" class="btn btn-cancel">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<?php require_once '../component/footer.php'; ?>
