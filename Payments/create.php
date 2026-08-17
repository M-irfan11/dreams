<?php require_once "../component/header.php"; ?>
<!-- Sidebar Start -->
<?php require_once "../component/sidebar.php"; ?>
<!-- Sidebar End -->

<!-- Main Content -->
<div class="main-content">
    <div class="row">
        <div class="col-12">
            <div class="d-flex align-items-lg-center flex-column flex-md-row flex-lg-row mt-3">
                <div class="flex-grow-1">
                    <h3 class="mb-2 text-size-26 text-color-2">Add New Payment</h3>
                </div>
                <div class="mt-3 mt-lg-0">
                    <a href="<?= $base_url ?>payments/list.php" class="cursor-pointer bg-white bg-primary text-white d-flex align-items-center px-3 py-2 rounded-2 text-normal fw-bolder letter-spacing-26">
                        <i class="fa-solid fa-arrow-left me-3"></i>
                        Back to List
                    </a>
                </div>
            </div><!-- end card header -->
        </div>
        <!--end col-->
    </div>

    <div class="mt-4">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form action="<?= $base_url ?>payments/store.php" method="POST">
                    <div class="row">
                        <!-- Sale Selection -->
                        <div class="col-md-12 mb-3">
                            <label for="sale_id" class="form-label text-color-2 text-normal fw-bold">Select Customer / Sale</label>
                            <select class="form-select" id="sale_id" name="sale_id" required>
                                <option value="">-- Choose Sale --</option>
                                <?php
                                // Get all sales
                                $sales = $crud->common_select("sales", "*", [], 'AND', 'id', 'DESC');
                                if($sales['status'] && !empty($sales['data'])) {
                                    foreach($sales['data'] as $sale) {
                                        // Get customer name
                                        $customer_name = 'N/A';
                                        if(isset($sale->customer_id)) {
                                            $customer = $crud->common_select("customers", "name", ['id' => $sale->customer_id]);
                                            if($customer['status'] && !empty($customer['data'])) {
                                                // NOTE: change "name" above/below to your actual column
                                                // if the customers table uses a different field.
                                                $customer_name = $customer['data'][0]->name;
                                            }
                                        }
                                ?>
                                    <option value="<?= $sale->id ?>">
                                        <?= htmlspecialchars($customer_name) ?> - SALE-<?= str_pad($sale->id, 6, '0', STR_PAD_LEFT) ?>
                                        ($<?= number_format($sale->total_amount, 2) ?>)
                                    </option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Amount -->
                        <div class="col-md-6 mb-3">
                            <label for="amount" class="form-label text-color-2 text-normal fw-bold">Amount</label>
                            <input type="number" step="0.01" class="form-control" id="amount" name="amount" placeholder="Enter amount" required>
                        </div>

                        <!-- Payment Date -->
                        <div class="col-md-6 mb-3">
                            <label for="payment_date" class="form-label text-color-2 text-normal fw-bold">Payment Date</label>
                            <input type="date" class="form-control" id="payment_date" name="payment_date" value="<?= date('Y-m-d') ?>" required>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Payment Method -->
                        <div class="col-md-6 mb-3">
                            <label for="payment_method" class="form-label text-color-2 text-normal fw-bold">Payment Method</label>
                            <select class="form-select" id="payment_method" name="payment_method" required>
                                <option value="">-- Choose Method --</option>
                                <option value="Cash">Cash</option>
                                <option value="Bkash">Bkash</option>
                                <option value="Nagad">Nagad</option>
                                <option value="Card">Card</option>
                                <option value="Bank">Bank</option>
                            </select>
                        </div>

                        <!-- Transaction ID -->
                        <div class="col-md-6 mb-3">
                            <label for="transaction_id" class="form-label text-color-2 text-normal fw-bold">Transaction ID</label>
                            <input type="text" class="form-control" id="transaction_id" name="transaction_id" placeholder="Enter transaction ID (optional)">
                            <small class="text-muted">Only required for online payments (Bkash, Nagad, Card, Bank)</small>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <button type="submit" class="btn bg-white bg-primary text-white d-flex align-items-center px-4 py-2 rounded-2 text-normal fw-bolder letter-spacing-26">
                                <i class="fa-solid fa-plus me-2"></i>
                                Save Payment
                            </button>
                            <a href="<?= $base_url ?>payments/list.php" class="btn bg-white text-color-1 d-inline-flex align-items-center px-4 py-2 rounded-2 text-normal fw-bolder letter-spacing-26 ms-2 border">
                                <i class="fa-solid fa-times me-2"></i>
                                Cancel
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once "../component/footer.php"; ?>
