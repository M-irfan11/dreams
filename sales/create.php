<?php require_once '../component/header.php'; ?>
<?php require_once '../component/sidebar.php'; ?>

<div class="page-wrapper">
    <div class="content">

        <div class="page-header">
            <div class="page-title">
                <h4>Add Sale</h4>
                <h6>Create a new sale</h6>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="<?php echo $base_url; ?>sales/add.php" method="POST">
                    <div class="row">
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Sale Date</label>
                                <input autocomplete="off" name="sale_date" type="date" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Customer</label>
                                <select name="customer_id" class="select form-control">
                                    <option value="">Select Customer</option>
                                    <?php
                                        $customers = $crud->common_select('customers');
                                        if($customers['status']){
                                            foreach($customers['data'] as $customer){
                                    ?>
                                                <option value="<?php echo $customer->customer_id; ?>"><?php echo htmlspecialchars($customer->name); ?></option>
                                    <?php   }
                                        } else { ?>
                                            <option value="">No customers available</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Warehouse</label>
                                <select name="warehouse_id" class="select form-control">
                                    <option value="">Select Warehouse</option>
                                    <?php
                                        $warehouses = $crud->common_select('warehouses');
                                        if($warehouses['status']){
                                            foreach($warehouses['data'] as $warehouse){
                                    ?>
                                                <option value="<?php echo $warehouse->id; ?>"><?php echo htmlspecialchars($warehouse->warehouse_name); ?></option>
                                    <?php   }
                                        } else { ?>
                                            <option value="">No warehouses available</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" class="select form-control">
                                    <option value="1">Paid</option>
                                    <option value="2" selected>Pending</option>
                                    <option value="3">Cancelled</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Product Name</label>
                                <select name="product_id" class="select form-control">
                                    <option value="">Select Product</option>
                                    <?php
                                        $products = $crud->common_select('products');
                                        if($products['status']){
                                            foreach($products['data'] as $product){
                                    ?>
                                                <option value="<?php echo $product->id; ?>" data-price="<?php echo htmlspecialchars($product->selling_price); ?>"><?php echo htmlspecialchars($product->product_name); ?></option>
                                    <?php   }
                                        } else { ?>
                                            <option value="">No products available</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table datanew">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Subtotal</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="saleItems">
                                <!-- Sale items will be added here dynamically -->
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end">Total:</td>
                                    <td><input type="text" name="total_amount" id="totalAmount" class="form-control" readonly></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end">Discount:</td>
                                    <td><input type="text" name="discount" id="discountAmount" class="form-control"></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end">Tax:</td>
                                    <td><input type="text" name="tax" id="taxAmount" class="form-control"></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end">Grand Total:</td>
                                    <td><input type="text" id="grandTotal" class="form-control" readonly></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-submit me-2">Save</button>
                            <a href="<?php echo $base_url; ?>sales/list.php" class="btn btn-cancel">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<?php require_once '../component/footer.php'; ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const productSelect = document.querySelector('select[name="product_id"]');
        const saleItemsBody = document.getElementById('saleItems');
        const totalAmountInput = document.getElementById('totalAmount');
        const discountAmountInput = document.getElementById('discountAmount');
        const taxAmountInput = document.getElementById('taxAmount');
        const grandTotalInput = document.getElementById('grandTotal');

        let saleItems = [];

        productSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const productId = selectedOption.value;
            const productName = selectedOption.text;
            const unitPrice = parseFloat(selectedOption.dataset.price);

            if(productId && !saleItems.some(item => item.product_id === productId)) {
                const newItem = {
                    product_id: productId,
                    product_name: productName,
                    quantity: 1,
                    unit_price: unitPrice,
                    subtotal: unitPrice
                };
                saleItems.push(newItem);
                renderSaleItems();
                calculateTotals();
            }
        });

        function renderSaleItems() {
            saleItemsBody.innerHTML = '';
            saleItems.forEach((item, index) => {
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
                        ${item.unit_price.toFixed(2)}
                        <input type="hidden" name="unit_price[]" value="${item.unit_price}">
                    </td>
                    <td>
                        ${item.subtotal.toFixed(2)}
                        <input type="hidden" name="subtotal[]" value="${item.subtotal}">
                    </td>
                    <td>
                        <a class="me-3 remove-item" href="javascript:void(0);" data-index="${index}">
                            <img src="<?php echo $base_url; ?>assets/img/icons/delete.svg" alt="img">
                        </a>
                    </td>
                `;
                saleItemsBody.appendChild(row);
            });

            document.querySelectorAll('.quantity-input').forEach(input => {
                input.addEventListener('input', function() {
                    const index = this.dataset.index;
                    const newQuantity = parseInt(this.value);
                    if(newQuantity > 0) {
                        saleItems[index].quantity = newQuantity;
                        saleItems[index].subtotal = newQuantity * saleItems[index].unit_price;
                        renderSaleItems();
                        calculateTotals();
                    }
                });
            });

            document.querySelectorAll('.remove-item').forEach(button => {
                button.addEventListener('click', function() {
                    const index = this.dataset.index;
                    saleItems.splice(index, 1);
                    renderSaleItems();
                    calculateTotals();
                });
            });
        }

        function calculateTotals() {
            const totalAmount = saleItems.reduce((sum, item) => sum + item.subtotal, 0);
            totalAmountInput.value = totalAmount.toFixed(2);
            const discountAmount = parseFloat(discountAmountInput.value) || 0;
            const taxAmount = parseFloat(taxAmountInput.value) || 0;
            const grandTotal = totalAmount - discountAmount + taxAmount;
            grandTotalInput.value = grandTotal.toFixed(2);
        }

        discountAmountInput.addEventListener('input', calculateTotals);
        taxAmountInput.addEventListener('input', calculateTotals);
    });
</script>
