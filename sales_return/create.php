<?php require_once '../component/header.php'; ?>
<?php require_once '../component/sidebar.php'; ?>

<?php
    // STEP 1: no sale selected yet - show sale picker
    $selected_sale_id = isset($_GET['sale_id']) ? (int)$_GET['sale_id'] : 0;

    $sale = null;
    $items = [];

    if($selected_sale_id > 0){
        // get sale + customer + warehouse info
        // (returned stock always goes back to the warehouse the sale was made from)
        $sale_result = $crud->common_query("SELECT sales.*, customers.name as customer_name, warehouses.warehouse_name FROM sales
            JOIN customers on customers.id = sales.customer_id
            LEFT JOIN warehouses on warehouses.id = sales.warehouse_id
            WHERE sales.id = $selected_sale_id AND sales.deleted_at IS NULL");
        $sale = $sale_result['status'] ? $sale_result['data'][0] : null;

        if($sale){
            // get line items for this sale, with remaining returnable quantity
            // remaining = original quantity - already returned quantity (only counting Active returns)
            $items_result = $crud->common_query("SELECT sale_details.*, products.product_name,
                (sale_details.quantity - IFNULL((
                    SELECT SUM(srd.quantity) FROM sales_return_details srd
                    JOIN sales_returns sr ON sr.id = srd.sale_return_id
                    WHERE sr.sale_id = sale_details.sale_id
                        AND srd.product_id = sale_details.product_id
                        AND sr.deleted_at IS NULL AND srd.deleted_at IS NULL
                        AND sr.status = 1
                ), 0)) as remaining_qty
                FROM sale_details
                JOIN products on products.id = sale_details.product_id
                WHERE sale_details.sale_id = $selected_sale_id AND sale_details.deleted_at IS NULL");

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
                <h4>Add Sales Return</h4>
                <h6>Return products from an existing sale</h6>
            </div>
        </div>

        <?php if(!$selected_sale_id || !$sale): ?>
            <!-- STEP 1: pick a sale -->
            <div class="card">
                <div class="card-body">
                    <form action="create.php" method="GET">
                        <div class="row">
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Select Sale <span class="text-danger">*</span></label>
                                    <select name="sale_id" class="select form-control" required>
                                        <option value="">Select Sale</option>
                                        <?php
                                            $sales_list = $crud->common_query("SELECT sales.*, customers.name as customer_name FROM sales
                                                JOIN customers on customers.id = sales.customer_id
                                                WHERE sales.deleted_at IS NULL ORDER BY sales.id DESC");
                                            if($sales_list['status']){
                                                foreach($sales_list['data'] as $s){
                                        ?>
                                                <option value="<?php echo $s->id; ?>">
                                                    #<?php echo $s->id; ?> - <?php echo htmlspecialchars($s->customer_name); ?> (<?php echo htmlspecialchars($s->sale_date); ?>)
                                                </option>
                                        <?php   }
                                            } else { ?>
                                                <option value="">No sales available</option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12 d-flex align-items-end">
                                <div class="form-group mb-0 w-100">
                                    <button type="submit" class="btn btn-submit w-100">Load Sale</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <?php if($selected_sale_id && !$sale): ?>
                <div class="alert alert-danger">That sale could not be found.</div>
            <?php endif; ?>

        <?php elseif(empty($sale->warehouse_id)): ?>
            <!-- can't process a stock return without knowing which warehouse to return it to -->
            <div class="alert alert-danger">
                Sale #<?php echo $sale->id; ?> has no warehouse assigned, so returned stock cannot be placed anywhere. Please contact an administrator.
            </div>
            <a href="create.php" class="btn btn-cancel">Choose Another Sale</a>

        <?php elseif(empty($items)): ?>
            <!-- sale found but nothing left to return -->
            <div class="alert alert-danger">
                All products from Sale #<?php echo $sale->id; ?> have already been fully returned.
            </div>
            <a href="create.php" class="btn btn-cancel">Choose Another Sale</a>

        <?php else: ?>
            <!-- STEP 2: show returnable products for the selected sale -->
            <div class="card">
                <div class="card-body">
                    <form action="<?php echo $base_url; ?>sales_return/store.php" method="POST">
                        <input type="hidden" name="sale_id" value="<?php echo $sale->id; ?>">

                        <div class="row">
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Customer</label>
                                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($sale->customer_name); ?>" readonly>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Original Sale Date</label>
                                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($sale->sale_date); ?>" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Return Date <span class="text-danger">*</span></label>
                                    <input autocomplete="off" name="return_date" type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Returning To Warehouse</label>
                                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($sale->warehouse_name); ?>" readonly>
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
                                <button type="submit" class="btn btn-submit me-2">Save Sales Return</button>
                                <a href="<?php echo $base_url; ?>sales_return/list.php" class="btn btn-cancel">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>

<?php require_once '../component/footer.php'; ?>

<?php if($selected_sale_id && $sale && !empty($items)): ?>
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
