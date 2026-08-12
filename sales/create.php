<?php require_once '../component/header.php'; ?>
<?php require_once '../component/sidebar.php'; ?>

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
                                                    <input autocomplete="off" name="sales_date" type="date" class="form-control">
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label class="form-label">Reference</label>
                                                    <input autocomplete="off" name="ref" type="text" class="form-control" placeholder="Reference">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-sm-6">
                                                    <label class="form-label">Supplier</label>
                                                    <select name="supplier_id" class="form-select form-control">
                                                        <option value="">Select Supplier</option>
                                                        <?php
                                                            // Fetch all suppliers for the dropdown
                                                            $suppliers = $crud->common_select('suppliers');
                                                            if($suppliers['status']){
                                                                foreach($suppliers['data'] as $supplier){
                                                        ?>
                                                                    <option value="<?php echo $supplier->id; ?>"><?php echo htmlspecialchars($supplier->supplier_name); ?></option>
                                                        <?php   }
                                                            } else { ?>
                                                                <option value="">No suppliers available</option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            
                                            
                                            <div class="mb-3 row">
                                                <label class="form-label col-sm-2 col-form-label">Product Name</label>
                                                <div class="col-sm-10">
                                                    <select name="product_id" class="form-select form-control">
                                                        <option value="">Select Product</option>
                                                        <?php
                                                            // Fetch all products for the dropdown
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
                                                        <td><input type="text" name="vat" id="vatAmount" class="form-control"></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="text-end">sub Total:</td>
                                                        <td><input type="text" name="sub_total" id="subTotal" class="form-control" readonly></td>
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
    document.addEventListener('DOMContentLoaded', function() {
        const productSelect = document.querySelector('select[name="product_id"]');
        const salesItemsBody = document.getElementById('salesItems');
        const totalAmountInput = document.getElementById('totalAmount');
        const discountType = document.getElementById('discountType');
        const discountAmountInput = document.getElementById('discountAmount');
        const vatAmountInput = document.getElementById('vatAmount');
        const subTotalInput = document.getElementById('subTotal');

        let salesItems = [];

        productSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const productId = selectedOption.value;
            const productName = selectedOption.text;
            const salesPrice = parseFloat(selectedOption.dataset.price);

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
            let discountAmount = parseFloat(discountAmountInput.value) || 0;
            if(discountType.value === '2') { // Percentage
                discountAmount = (discountAmount / 100) * totalAmount;
            }
            
            const vatAmount = (parseFloat(vatAmountInput.value) / 100 * (totalAmount - discountAmount)) || 0;
            const subTotal = totalAmount - discountAmount + vatAmount;
            subTotalInput.value = subTotal.toFixed(2);
        }

        discountAmountInput.addEventListener('input', calculateTotals);
        vatAmountInput.addEventListener('input', calculateTotals);
        discountType.addEventListener('change', calculateTotals);
    });
</script>
