<?php require_once '../component/header.php'; ?>
<?php require_once '../component/sidebar.php'; ?>
<?php
    $warehouses = $crud->common_select('warehouses');
    if(!$warehouses['status']){
        $warehouses = [];
    } else {
        $warehouses = $warehouses['data'];
    }
?>
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="main-body">
                <div class="page-wrapper">
                    <div class="page-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Add sales</h5> 
                                    </div>
                                    <div class="card-body">
                                        <form action="<?php echo $base_url; ?>sales/add.php" method="POST">
                                            <div class="row">
                                                <div class="form-group col-sm-6">
                                                    <label class="form-label">sales Date</label>
                                                    <input autocomplete="off" name="sale_date" type="date" class="form-control">
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label class="form-label">Reference</label>
                                                    <input autocomplete="off" name="ref" type="text" class="form-control" placeholder="Reference">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-sm-6">
                                                    <label class="form-label">Customer</label>
                                                    <select name="customer_id" class="form-select form-control">
                                                        <option value="">Select Customer</option>
                                                        <?php
                                                            // Fetch all customers for the dropdown
                                                            $customers = $crud->common_select('customers');
                                                            if($customers['status']){
                                                                foreach($customers['data'] as $customer){ ?>
                                                                    <option value="<?php echo $customer->id; ?>"><?php echo htmlspecialchars($customer->name); ?></option> 
                                                        <?php   }
                                                            } else { ?>
                                                                <option value="">No customers available</option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <div class="form-group">
                                                        <label>Warehouse <span class="text-danger">*</span></label>
                                                        <select
                                                            name="warehouse_id"
                                                            id="warehouse_id"
                                                            class="form-control"
                                                            required
                                                            onchange="fetchProducts(this.value)"
                                                        >
                                                            <option value="">
                                                                Select Warehouse
                                                            </option>
                                                            <?php if (!empty($warehouses)) { ?>
                                                                <?php foreach ($warehouses as $warehouse) { ?>
                                                                    <option value="<?= (int)$warehouse->id ?>">
                                                                        <?= htmlspecialchars($warehouse->warehouse_name) ?>
                                                                    </option>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        </select>
                                                        <?php if (empty($warehouses)) { ?>
                                                            <small class="text-danger">
                                                                No warehouses available.
                                                            </small>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            
                                            <div class="mb-3 row">
                                                <label class="form-label col-sm-2 col-form-label">Product Name</label>
                                                <div class="col-sm-10">
                                                    <select name="product_id" id="product_id" class="form-select form-control">
                                                        <option value="">Select Product</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Product Name</th>
                                                        <th>Quantity</th>
                                                        <th>sales Price</th>
                                                        <th>Subtotal</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="salesItems">
                                                    <!-- sales items will be added here dynamically -->
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="3" class="text-end">Total:</td>
                                                        <td><input type="text" name="total_amount" id="totalAmount" class="form-control" readonly></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="text-end">Discount:
                                                            <select name="discount_type" id="discountType">
                                                                <option value="1">৳</option>
                                                                <option value="2">%</option>
                                                            </select>
                                                        </td>
                                                        <td><input type="text" name="discount_amount" id="discountAmount" class="form-control"></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="text-end">VAT:</td>
                                                        <td>
                                                            <!-- user can type an exact amount here, or leave blank for the default 5% -->
                                                            <input type="text" id="vatInput" class="form-control">
                                                            <small class="form-text text-muted">Default vat 15% will auto add</small>
                                                            <!-- the amount actually used (typed or default) is calculated into this hidden field and submitted -->
                                                            <input type="hidden" name="vat" id="vatAmount">
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="text-end"> Total:</td>
                                                        <td><input type="text" name="grand_total" id="grandTotal" class="form-control" readonly></td>
                                                        <td></td>
                                                    </tr>
                                                </tfoot>
                                            </table>

                                            
                                            <div class="mb-3 row">
                                                <label class="form-label col-sm-2 col-form-label"></label>
                                                <div class="col-sm-10">
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body end -->
<?php require_once '../component/footer.php'; ?>
<script>
    function fetchProducts(warehouseId) {
        if (!warehouseId) {
            document.querySelector('select[name="product_id"]').innerHTML = '<option value="">Select Product</option>';
            return;
        }

        fetch('get_product_stock.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'warehouse_id=' + encodeURIComponent(warehouseId)
        })
        .then(response => response.text())
        .then(data => {
            document.querySelector('select[name="product_id"]').innerHTML = data;
        })
        .catch(error => console.error('Error fetching products:', error));
    }

    
    document.addEventListener('DOMContentLoaded', function() {
        const productSelect = document.querySelector('select[name="product_id"]');
        const salesItemsBody = document.getElementById('salesItems');
        const totalAmountInput = document.getElementById('totalAmount');
        const discountType = document.getElementById('discountType');
        const discountAmountInput = document.getElementById('discountAmount');
        const vatInput = document.getElementById('vatInput');
        const vatAmountInput = document.getElementById('vatAmount');
        const grandTotalInput = document.getElementById('grandTotal');

        let salesItems = [];

        productSelect.addEventListener('change', function() {
            const selectedOption = document.querySelector('select[name="product_id"]');
            const productId = selectedOption.selectedOptions[0].value;
            const productName = selectedOption.selectedOptions[0].text;
            const salesPrice = parseFloat(selectedOption.selectedOptions[0].dataset.price) || 0;

            if(productId && !salesItems.some(item => item.product_id === productId)) {
                const newItem = {
                    product_id: productId,
                    product_name: productName,
                    quantity: 1,
                    selling_price: salesPrice,
                    subtotal: salesPrice
                };
                salesItems.push(newItem);
                rendersalesItems();
                calculateTotals();
            }
        });

        function rendersalesItems() {
            salesItemsBody.innerHTML = '';
            salesItems.forEach((item, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>
                        ${item.product_name}
                        <input type="hidden" name="product_id[]" value="${item.product_id}">
                    </td>
                    <td>
                        <input name="quantity[]" type="number" min="1" value="${item.quantity}" class="form-control quantity-input" data-index="${index}">
                    </td>
                    <td>
                        ${item.selling_price.toFixed(2)}
                        <input type="hidden" name="selling_price[]" value="${item.selling_price}">
                    </td>
                    <td>
                        ${item.subtotal.toFixed(2)}
                        <input type="hidden" name="subtotal[]" value="${item.subtotal}">
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm remove-item" data-index="${index}">Remove</button>
                    </td>
                `;
                salesItemsBody.appendChild(row);
            });

            // Add event listeners for quantity change and remove buttons
            document.querySelectorAll('.quantity-input').forEach(input => {
                input.addEventListener('input', function() {
                    const index = this.dataset.index;
                    const newQuantity = parseInt(this.value);
                    if(newQuantity > 0) {
                        salesItems[index].quantity = newQuantity;
                        salesItems[index].subtotal = newQuantity * salesItems[index].selling_price;
                        rendersalesItems();
                        calculateTotals();
                    }
                });
            });

            document.querySelectorAll('.remove-item').forEach(button => {
                button.addEventListener('click', function() {
                    const index = this.dataset.index;
                    salesItems.splice(index, 1);
                    rendersalesItems();
                    calculateTotals();
                });
            });
        }

        function calculateTotals() {
            const totalAmount = salesItems.reduce((sum, item) => sum + item.subtotal, 0);
            totalAmountInput.value = totalAmount.toFixed(2);
            const discountAmount = parseFloat(discountAmountInput.value) || 0;

            // taxAmount is recalculated fresh every time from vatInput (or the 5%
            // default) - the result always goes into the hidden field that actually
            // gets submitted, so it never goes stale after a quantity/discount change
            const taxAmount = parseFloat(vatInput.value) || (totalAmount * 0.15);
            vatAmountInput.value = taxAmount.toFixed(2);

            const grandTotal = totalAmount - discountAmount + taxAmount;
            grandTotalInput.value = grandTotal.toFixed(2);
        }

        discountAmountInput.addEventListener('input', calculateTotals);
        vatInput.addEventListener('input', calculateTotals);
        discountType.addEventListener('change', calculateTotals);
    });
</script>