<?php require_once '../component/header.php'; ?>
<?php require_once '../component/sidebar.php'; ?>

<?php
    // STEP 1: no purchase selected yet - show purchase picker
    $selected_purchase_id = isset($_GET['purchase_id']) ? (int)$_GET['purchase_id'] : 0;

    $purchase = null;
    $items = [];

    if($selected_purchase_id > 0){
        // get purchase + supplier info
        $purchase_result = $crud->common_query("SELECT purchases.*, suppliers.name as supplier_name FROM purchases
            JOIN suppliers on suppliers.id = purchases.supplier_id
            WHERE purchases.id = $selected_purchase_id AND purchases.deleted_at IS NULL");
        $purchase = $purchase_result['status'] ? $purchase_result['data'][0] : null;

        if($purchase){
            // get line items for this purchase, with remaining returnable quantity
            // remaining = original quantity - already returned quantity (only counting Active returns)
            $items_result = $crud->common_query("SELECT purchase_details.*, products.product_name,
                (purchase_details.quantity - IFNULL((
                    SELECT SUM(prd.quantity) FROM purchase_return_detail prd
                    JOIN purchase_return pr ON pr.id = prd.purchase_return_id
                    WHERE pr.purchase_id = purchase_details.purchase_id
                        AND prd.product_id = purchase_details.product_id
                        AND pr.deleted_at IS NULL AND prd.deleted_at IS NULL
                        AND pr.status = 1
                ), 0)) as remaining_qty
                FROM purchase_details
                JOIN products on products.id = purchase_details.product_id
                WHERE purchase_details.purchase_id = $selected_purchase_id AND purchase_details.deleted_at IS NULL");

            if($items_result['status']){
                // only keep products that still have returnable quantity left
                foreach($items_result['data'] as $item){
                    if($item->remaining_qty > 0){
                        $items[] = $item;
                    }
                }
            }
        }
    }
?>

<div class="page-wrapper">
    <div class="content">

        <div class="page-header">
            <div class="page-title">
                <h4>Add Purchase Return</h4>
                <h6>Return products from an existing purchase</h6>
            </div>
        </div>

        <?php if(!$selected_purchase_id || !$purchase): ?>
            <!-- STEP 1: pick a purchase -->
            <div class="card">
                <div class="card-body">
                    <form action="create.php" method="GET">
                        <div class="row">
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Select Purchase <span class="text-danger">*</span></label>
                                    <select name="purchase_id" class="select form-control" required>
                                        <option value="">Select Purchase</option>
                                        <?php
                                            $purchases_list = $crud->common_query("SELECT purchases.*, suppliers.name as supplier_name FROM purchases
                                                JOIN suppliers on suppliers.id = purchases.supplier_id
                                                WHERE purchases.deleted_at IS NULL ORDER BY purchases.id DESC");
                                            if($purchases_list['status']){
                                                foreach($purchases_list['data'] as $p){
                                        ?>
                                                <option value="<?php echo $p->id; ?>">
                                                    #<?php echo $p->id; ?> - <?php echo htmlspecialchars($p->supplier_name); ?> (<?php echo htmlspecialchars($p->purchase_date); ?>)
                                                </option>
                                        <?php   }
                                            } else { ?>
                                                <option value="">No purchases available</option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12 d-flex align-items-end">
                                <div class="form-group mb-0 w-100">
                                    <button type="submit" class="btn btn-submit w-100">Load Purchase</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <?php if($selected_purchase_id && !$purchase): ?>
                <div class="alert alert-danger">That purchase could not be found.</div>
            <?php endif; ?>

        <?php elseif(empty($items)): ?>
            <!-- purchase found but nothing left to return -->
            <div class="alert alert-danger">
                All products from Purchase #<?php echo $purchase->id; ?> have already been fully returned.
            </div>
            <a href="create.php" class="btn btn-cancel">Choose Another Purchase</a>

        <?php else: ?>
            <!-- STEP 2: show returnable products for the selected purchase -->
            <div class="card">
                <div class="card-body">
                    <form action="<?php echo $base_url; ?>purchase_return/store.php" method="POST">
                        <input type="hidden" name="purchase_id" value="<?php echo $purchase->id; ?>">

                        <div class="row">
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Supplier</label>
                                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($purchase->supplier_name); ?>" readonly>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Original Purchase Date</label>
                                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($purchase->purchase_date); ?>" readonly>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Return Date <span class="text-danger">*</span></label>
                                    <input autocomplete="off" name="return_date" type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table datanew">
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Original Qty</th>
                                        <th>Remaining Returnable</th>
                                        <th>Return Qty</th>
                                        <th>Unit Price</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($items as $index => $item): ?>
                                    <tr>
                                        <td>
                                            <?php echo htmlspecialchars($item->product_name); ?>
                                            <input type="hidden" name="product_id[]" value="<?php echo $item->product_id; ?>">
                                            <input type="hidden" name="unit_price[]" value="<?php echo $item->unit_price; ?>">
                                        </td>
                                        <td><?php echo $item->quantity; ?></td>
                                        <td><?php echo $item->remaining_qty; ?></td>
                                        <td>
                                            <input name="quantity[]" type="number" min="0" max="<?php echo $item->remaining_qty; ?>" value="0"
                                                class="form-control return-qty" data-price="<?php echo $item->unit_price; ?>" data-index="<?php echo $index; ?>">
                                        </td>
                                        <td><?php echo number_format($item->unit_price, 2); ?></td>
                                        <td>
                                            <span class="subtotal-display" id="subtotal-<?php echo $index; ?>">0.00</span>
                                            <input type="hidden" name="subtotal[]" id="subtotal-input-<?php echo $index; ?>" value="0">
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="5" class="text-end">Total Return Amount:</td>
                                        <td><span id="grandTotal">0.00</span></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Return Reason</label>
                                    <textarea name="reason" class="form-control" rows="3" placeholder="Reason for return"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-submit me-2">Save Purchase Return</button>
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

<?php if($selected_purchase_id && $purchase && !empty($items)): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const qtyInputs = document.querySelectorAll('.return-qty');

        function calculateTotals() {
            let grandTotal = 0;
            qtyInputs.forEach(function(input) {
                const index = input.dataset.index;
                const price = parseFloat(input.dataset.price);
                let qty = parseInt(input.value) || 0;
                const max = parseInt(input.max);

                // never allow return qty above remaining returnable quantity
                if(qty > max){
                    qty = max;
                    input.value = max;
                }
                if(qty < 0){
                    qty = 0;
                    input.value = 0;
                }

                const subtotal = qty * price;
                document.getElementById('subtotal-' + index).textContent = subtotal.toFixed(2);
                document.getElementById('subtotal-input-' + index).value = subtotal.toFixed(2);
                grandTotal += subtotal;
            });
            document.getElementById('grandTotal').textContent = grandTotal.toFixed(2);
        }

        qtyInputs.forEach(function(input) {
            input.addEventListener('input', calculateTotals);
        });
    });
</script>
<?php endif; ?>
