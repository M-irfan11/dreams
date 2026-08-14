<?php require_once '../component/header.php'; ?>
<?php require_once '../component/sidebar.php'; ?>
<?php
    $id = $_GET['id'];
    $result = $crud->common_select('expenses', '*', ['id' => $id]);
    $expense = $result['data'][0];
?>

<div class="page-wrapper">
    <div class="content">

        <div class="page-header">
            <div class="page-title">
                <h4>Edit Expense</h4>
                <h6>Update expense details</h6>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="<?php echo $base_url; ?>expense/edit.php?id=<?php echo $id; ?>" method="POST">
                    <div class="row">
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Expense Category <span class="text-danger">*</span></label>
                                <select name="category_id" class="select form-control" required>
                                    <option value="">Select Category</option>
                                    <?php
                                        // only active categories (plus the currently-selected one, even if now inactive)
                                        $categories = $crud->common_select('expense_categories', '*', ['status' => 1]);
                                        if($categories['status']){
                                            foreach($categories['data'] as $cat){
                                    ?>
                                                <option value="<?php echo $cat->id; ?>" <?php echo ($cat->id == $expense->category_id) ? 'selected' : ''; ?>><?php echo htmlspecialchars($cat->category_name); ?></option>
                                    <?php   }
                                        } else { ?>
                                            <option value="">No categories available</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Expense Date <span class="text-danger">*</span></label>
                                <input autocomplete="off" value="<?php echo $expense->expense_date; ?>" name="expense_date" type="date" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Amount <span class="text-danger">*</span></label>
                                <input autocomplete="off" value="<?php echo $expense->amount; ?>" name="amount" type="number" step="0.01" min="0" class="form-control" placeholder="Amount" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Payment Method</label>
                                <select name="payment_method" class="select form-control">
                                    <option value="Cash" <?php echo ($expense->payment_method == 'Cash') ? 'selected' : ''; ?>>Cash</option>
                                    <option value="Bank" <?php echo ($expense->payment_method == 'Bank') ? 'selected' : ''; ?>>Bank</option>
                                    <option value="Card" <?php echo ($expense->payment_method == 'Card') ? 'selected' : ''; ?>>Card</option>
                                    <option value="Other" <?php echo ($expense->payment_method == 'Other') ? 'selected' : ''; ?>>Other</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" class="form-control" rows="4" placeholder="Description"><?php echo htmlspecialchars($expense->description); ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-submit me-2">Save</button>
                            <a href="<?php echo $base_url; ?>expense/list.php" class="btn btn-cancel">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<?php require_once '../component/footer.php'; ?>
