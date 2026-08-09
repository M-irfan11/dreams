<?php require_once '../component/header.php'; ?>
<?php require_once '../component/sidebar.php'; ?>
<?php
    $id = $_GET['id'];
    $result = $crud->common_select('payments', '*', ['payment_id' => $id]);
    $payment = $result['data'][0];
?>

<div class="page-wrapper">
    <div class="content">

        <div class="page-header">
            <div class="page-title">
                <h4>Edit Payment</h4>
                <h6>Update payment details</h6>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="<?php echo $base_url; ?>payment/edit.php?id=<?php echo $id; ?>" method="POST">
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
                                                <option value="<?php echo $sale->id; ?>" <?php echo ($sale->id == $payment->sale_id) ? 'selected' : ''; ?>>
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
                                <input autocomplete="off" value="<?php echo $payment->payment_date; ?>" name="payment_date" type="date" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Amount</label>
                                <input autocomplete="off" value="<?php echo htmlspecialchars($payment->amount); ?>" name="amount" type="number" step="0.01" min="0" class="form-control" placeholder="Amount" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Payment Method</label>
                                <?php
                                    $methods = ["Cash", "Card", "Bank Transfer", "bKash", "Nagad", "Rocket"];
                                ?>
                                <select name="payment_method" class="select form-control" required>
                                    <option value="">Select Method</option>
                                    <?php foreach($methods as $method): ?>
                                        <option value="<?php echo $method; ?>" <?php echo ($payment->payment_method == $method) ? 'selected' : ''; ?>><?php echo $method; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Transaction ID</label>
                                <input autocomplete="off" value="<?php echo htmlspecialchars($payment->transaction_id); ?>" name="transaction_id" type="text" class="form-control" placeholder="Transaction ID (optional)">
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
