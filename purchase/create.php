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
<div class="page-wrapper">
    <div class="content">

        <div class="page-header">
            <div class="page-title">
                <h4>Add Purchase</h4>
                <h6>Create a new purchase</h6>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="<?php echo $base_url; ?>purchase/store.php" method="POST">
                    <div class="row">
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Warehouse <span class="text-danger">*</span></label>
                                <select
                                    name="warehouse_id"
                                    id="warehouse_id"
                                    class="form-control"
                                    required
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
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Purchase Date</label>
                                <input autocomplete="off" name="purchase_date" type="date" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Reference</label>
                                <input autocomplete="off" name="ref" type="text" class="form-control" placeholder="Reference">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Supplier</label>
                                <select name="supplier_id" class="select form-control">
                                    <option value="">Select Supplier</option>
                                    <?php
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
                    </div>

                    <div class="row">
                        
                        <div class="col-12">
                            <div class="form-group">
                                <label>Product Name</label>
                                <select name="product_id" class="select form-control">
                                    <option value="">Select Product</option>
                                    <?php
                                        $products = $crud->common_select('products');
                                        if($products['status']){
                                            foreach($products['data'] as $product){
                                    ?>
                                                <option value="<?php echo $product->id; ?>" data-price="<?php echo htmlspecialchars($product->purchase_price); ?>"><?php echo htmlspecialchars($product->product_name); ?></option>
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
                                    <th>Purchase Price</th>
                                    <th>Subtotal</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="purchaseItems">
                                <!-- Purchase items will be added here dynamically -->
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end">Total:</td>
                                    <td><input type="text" name="total_amount" id="totalAmount" class="form-control" readonly></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end">Discount:
                                        <select name="discount_type" id="discountType" class="select">
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
                                    <td colspan="3" class="text-end">Grand Total:</td>
                                    <td><input type="text" name="grand_total" id="grandTotal" class="form-control" readonly></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-submit me-2">Save</button>
                            <a href="<?php echo $base_url; ?>purchase/list.php" class="btn btn-cancel">Cancel</a>
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
        const purchaseItemsBody = document.getElementById('purchaseItems');
        const totalAmountInput = document.getElementById('totalAmount');
        const discountType = document.getElementById('discountType');
        const discountAmountInput = document.getElementById('discountAmount');
        const vatAmountInput = document.getElementById('vatAmount');
        const grandTotalInput = document.getElementById('grandTotal');

        let purchaseItems = [];

        productSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const productId = selectedOption.value;
            const productName = selectedOption.text;
            const purchasePrice = parseFloat(selectedOption.dataset.price);

            if(productId && !purchaseItems.some(item => item.product_id === productId)) {
                const newItem = {
                    product_id: productId,
                    product_name: productName,
                    quantity: 1,
                    purchase_price: purchasePrice,
                    subtotal: purchasePrice
                };
                purchaseItems.push(newItem);
                renderPurchaseItems();
                calculateTotals();
            }
        });

        function renderPurchaseItems() {
            purchaseItemsBody.innerHTML = '';
            purchaseItems.forEach((item, index) => {
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
                        ${item.purchase_price.toFixed(2)}
                        <input type="hidden" name="purchase_price[]" value="${item.purchase_price}">
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
                purchaseItemsBody.appendChild(row);
            });

            document.querySelectorAll('.quantity-input').forEach(input => {
                input.addEventListener('input', function() {
                    const index = this.dataset.index;
                    const newQuantity = parseInt(this.value);
                    if(newQuantity > 0) {
                        purchaseItems[index].quantity = newQuantity;
                        purchaseItems[index].subtotal = newQuantity * purchaseItems[index].purchase_price;
                        renderPurchaseItems();
                        calculateTotals();
                    }
                });
            });

            document.querySelectorAll('.remove-item').forEach(button => {
                button.addEventListener('click', function() {
                    const index = this.dataset.index;
                    purchaseItems.splice(index, 1);
                    renderPurchaseItems();
                    calculateTotals();
                });
            });
        }

        function calculateTotals() {
            const totalAmount = purchaseItems.reduce((sum, item) => sum + item.subtotal, 0);
            totalAmountInput.value = totalAmount.toFixed(2);
            let discountAmount = parseFloat(discountAmountInput.value) || 0;
            if(discountType.value === '2') { // Percentage
                discountAmount = (discountAmount / 100) * totalAmount;
            }

            const vatAmount = (parseFloat(vatAmountInput.value) / 100 * (totalAmount - discountAmount)) || 0;
            const grandTotal = totalAmount - discountAmount + vatAmount;
            grandTotalInput.value = grandTotal.toFixed(2);
        }

        discountAmountInput.addEventListener('input', calculateTotals);
        vatAmountInput.addEventListener('input', calculateTotals);
        discountType.addEventListener('change', calculateTotals);
    });
</script>