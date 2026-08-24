<?php require_once '../component/header.php'; ?>
<?php require_once '../component/sidebar.php'; ?>
<?php
    $id = (int)$_GET['id'];

    $return_result = $crud->common_query("SELECT purchase_returns.*, suppliers.name FROM purchase_returns
        JOIN suppliers on suppliers.id = purchase_returns.supplier_id
        WHERE purchase_returns.id = $id AND purchase_returns.deleted_at IS NULL");
    $purchase_return = $return_result['status'] ? $return_result['data'][0] : null;

    // line items - shown read-only for reference, not editable here
    $details_result = $crud->common_query("SELECT purchase_return_details.*, products.product_name FROM purchase_return_details
        JOIN products on products.id = purchase_return_details.product_id
        WHERE purchase_return_details.purchase_return_id = $id AND purchase_return_details.deleted_at IS NULL");
    $details = $details_result['status'] ? $details_result['data'] : [];
?>

<div class="page-wrapper">
    <div class="content">

        <div class="page-header">
            <div class="page-title">
                <h4>Edit Purchase Return</h4>
                <h6>Update return date, status, or reason</h6>
            </div>
        </div>

        <?php if(!$purchase_return): ?>
            <div class="alert alert-danger">Purchase return not found.</div>

        <?php else: ?>
            <div class="card">
                <div class="card-body">
                    <form action="<?php echo $base_url; ?>purchase_return/edit.php?id=<?php echo $id; ?>" method="POST">
                        <div class="row">
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Purchase ID</label>
                                    <input type="text" class="form-control" value="#<?php echo $purchase_return->purchase_id; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Supplier</label>
                                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($purchase_return->name); ?>" readonly>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Total Amount</label>
                                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($purchase_return->total_amount); ?>" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Return Date <span class="text-danger">*</span></label>
                                    <input autocomplete="off" value="<?php echo $purchase_return->return_date; ?>" name="return_date" type="date" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="select form-control">
                                        <option value="1" <?php echo ($purchase_return->status == 1) ? 'selected' : ''; ?>>Active</option>
                                        <option value="2" <?php echo ($purchase_return->status == 2) ? 'selected' : ''; ?>>Cancelled</option>
                                    </select>
                                    <small class="text-muted">Changing status to/from Cancelled will automatically adjust stock.</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Return Reason</label>
                                    <textarea name="reason" class="form-control" rows="3"><?php echo htmlspecialchars($purchase_return->reason); ?></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- returned products - read only, not editable in this step -->
                        <div class="table-responsive">
                            <table class="table datanew">
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Return Qty</th>
                                        <th>Purchase Price</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($details as $item): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($item->product_name); ?></td>
                                        <td><?php echo $item->quantity; ?></td>
                                        <td><?php echo number_format($item->unit_price, 2); ?></td>
                                        <td><?php echo number_format($item->subtotal, 2); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-submit me-2">Save Changes</button>
                                <a href="<?php echo $base_url; ?>purchase_return/list.php" class="btn btn-cancel">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>

<?php require_once '../component/footer.php'; ?>
