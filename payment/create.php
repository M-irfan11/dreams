<?php require_once '../component/header.php'; ?>
<?php require_once '../component/sidebar.php'; ?>

<div class="page-wrapper">
    <div class="content">

        <div class="page-header">
            <div class="page-title">
                <h4>Add Payment</h4>
                <h6>Create a new payment</h6>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="<?php echo $base_url; ?>payment/add.php" method="POST">
                    <div class="row">
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Sale</label>
                                <select name="sale_id" class="select form-control" required>
                                    <option value="">Select Sale</option>
                                    <?php
                                        $sales = $crud->common_select('sales');
                                        if($sales['status']){
                                            foreach($sales['data'] as $sale){
                                    ?>
                                                <option value="<?php echo $sale->id; ?>">
                                                    <?php echo 'Sale #' . $sale->id . ' - ৳' . htmlspecialchars($sale->grand_total); ?>
                                                </option>
                                    <?php   }
                                        } else { ?>
                                            <option value="">No sales available</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Payment Date</label>
                                <input autocomplete="off" name="payment_date" type="date" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Amount</label>
                                <input autocomplete="off" name="amount" type="number" step="0.01" min="0" class="form-control" placeholder="Amount" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Payment Method</label>
                                <select name="payment_method" class="select form-control" required>
                                    <option value="">Select Method</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Card">Card</option>
                                    <option value="Bank Transfer">Bank Transfer</option>
                                    <option value="bKash">bKash</option>
                                    <option value="Nagad">Nagad</option>
                                    <option value="Rocket">Rocket</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Transaction ID</label>
                                <input autocomplete="off" name="transaction_id" type="text" class="form-control" placeholder="Transaction ID (optional)">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-submit me-2">Save</button>
                            <a href="<?php echo $base_url; ?>payment/list.php" class="btn btn-cancel">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<?php require_once '../component/footer.php'; ?>
