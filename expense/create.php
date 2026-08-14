<?php require_once '../component/header.php'; ?>
<?php require_once '../component/sidebar.php'; ?>

<div class="page-wrapper">
    <div class="content">

        <div class="page-header">
            <div class="page-title">
                <h4>Add Expense</h4>
                <h6>Create a new expense</h6>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="<?php echo $base_url; ?>expense/add.php" method="POST">
                    <div class="row">
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Expense Category <span class="text-danger">*</span></label>
                                <select name="category_id" class="select form-control" required>
                                    <option value="">Select Category</option>
                                    <?php
                                        // only active categories
                                        $categories = $crud->common_select('expense_categories', '*', ['status' => 1]);
                                        if($categories['status']){
                                            foreach($categories['data'] as $cat){
                                    ?>
                                                <option value="<?php echo $cat->id; ?>"><?php echo htmlspecialchars($cat->category_name); ?></option>
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
                                <input autocomplete="off" name="expense_date" type="date" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Amount <span class="text-danger">*</span></label>
                                <input autocomplete="off" name="amount" type="number" step="0.01" min="0" class="form-control" placeholder="Amount" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Payment Method</label>
                                <select name="payment_method" class="select form-control">
                                    <option value="Cash">Cash</option>
                                    <option value="Bank">Bank</option>
                                    <option value="Card">Card</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" class="form-control" rows="4" placeholder="Description"></textarea>
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
