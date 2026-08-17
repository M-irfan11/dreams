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
                    <h3 class="mb-2 text-size-26 text-color-2">Payments</h3>
                </div>
                <div class="mt-3 mt-lg-0">
                    <div class="d-flex align-items-center">
                        <!-- Filter Button (by payment method, since payments table has no status column) -->
                        <div class="cursor-pointer bg-white d-flex align-items-center text-color-1 px-3 py-2 rounded-2 text-normal fw-bolder letter-spacing-26 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-filter me-3"></i>
                            Filter by
                            <i class="fa-solid fa-chevron-right ms-3 text-size-sm"></i>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="<?= $base_url ?>payments/list.php?method=Cash">Cash</a></li>
                                <li><a class="dropdown-item" href="<?= $base_url ?>payments/list.php?method=Bkash">Bkash</a></li>
                                <li><a class="dropdown-item" href="<?= $base_url ?>payments/list.php?method=Nagad">Nagad</a></li>
                                <li><a class="dropdown-item" href="<?= $base_url ?>payments/list.php?method=Card">Card</a></li>
                                <li><a class="dropdown-item" href="<?= $base_url ?>payments/list.php?method=Bank">Bank</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="<?= $base_url ?>payments/list.php">All</a></li>
                            </ul>
                        </div>
                        <!-- Add Payment Button -->
                        <a href="<?= $base_url ?>payments/create.php" class="cursor-pointer ms-4 bg-white bg-primary text-white d-flex align-items-center px-3 py-2 rounded-2 text-normal fw-bolder letter-spacing-26">
                            <i class="fa-solid fa-plus me-3"></i>
                            Add Payment
                        </a>
                    </div>
                </div>
            </div><!-- end card header -->
        </div>
        <!--end col-->
    </div>
    <div class="mt-4">
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive table-rounded-top">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="select-all" class="custom-checkbox"></th>
                                <th>Sale</th>
                                <th>Customer Name</th>
                                <th>Amount</th>
                                <th>Payment Date</th>
                                <th>Method</th>
                                <th>Transaction ID</th>
                                <th class="text-center"><i class="fas fa-ellipsis-h"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Get current page number
                            if(isset($_GET['page']) && is_numeric($_GET['page'])){
                                $page = (int)$_GET['page'];
                            } else {
                                $page = 1;
                            }

                            $records_per_page = 10;
                            $offset = ($page - 1) * $records_per_page;

                            // Build filter condition (payment_method, since no status column exists)
                            $conditions = [];
                            if(isset($_GET['method']) && !empty($_GET['method'])) {
                                $conditions['payment_method'] = $_GET['method'];
                            }

                            // Fetch payments from database
                            $payments = $crud->common_select(
                                "payments",
                                "*",
                                $conditions,
                                'AND',
                                'id',
                                'DESC',
                                $records_per_page,
                                $offset
                            );

                            if($payments['status'] && !empty($payments['data'])){
                                foreach ($payments['data'] as $payment) {
                                    // Get customer name from sale
                                    $customer_name = 'N/A';
                                    $sale = $crud->common_select("sales", "*", ['id' => $payment->sale_id]);
                                    if($sale['status'] && !empty($sale['data'])) {
                                        $sale_data = $sale['data'][0];
                                        if(isset($sale_data->customer_id)) {
                                            $customer = $crud->common_select("customers", "name", ['id' => $sale_data->customer_id]);
                                            if($customer['status'] && !empty($customer['data'])) {
                                                $customer_name = $customer['data'][0]->name;
                                            }
                                        }
                                    }
                            ?>
                            <tr>
                                <td><input type="checkbox" class="custom-checkbox row-checkbox"></td>
                                <td>
                                    <a href="<?= $base_url ?>sales/view.php?id=<?= $payment->sale_id ?>" class="text-primary fw-bold">
                                        SALE-<?= str_pad($payment->sale_id, 6, '0', STR_PAD_LEFT) ?>
                                    </a>
                                </td>
                                <td><?= htmlspecialchars($customer_name) ?></td>
                                <td>$<?= number_format($payment->amount, 2) ?></td>
                                <td><?= date('d-m-Y', strtotime($payment->payment_date)) ?></td>
                                <td>
                                    <?php
                                    $method_icons = [
                                        'Cash' => 'fa-money-bill-wave',
                                        'Bkash' => 'fa-mobile-screen',
                                        'Nagad' => 'fa-mobile-screen',
                                        'Card' => 'fa-credit-card',
                                        'Bank' => 'fa-building-columns'
                                    ];
                                    $icon = $method_icons[$payment->payment_method] ?? 'fa-money-bill';
                                    ?>
                                    <span class="badge bg-info">
                                        <i class="fa-solid <?= $icon ?> me-1"></i>
                                        <?= htmlspecialchars($payment->payment_method) ?>
                                    </span>
                                </td>
                                <td><?= $payment->transaction_id ? htmlspecialchars($payment->transaction_id) : '-' ?></td>
                                <td class="text-center">
                                    <a href="<?= $base_url ?>payments/show.php?id=<?= $payment->id ?>" class="btn btn-sm btn-info mb-2 mb-lg-0 me-0 me-lg-2">
                                        <i class="fa-regular fa-eye"></i>
                                    </a>
                                    <a href="<?= $base_url ?>payments/edit.php?id=<?= $payment->id ?>" class="btn btn-sm btn-primary mb-2 mb-lg-0 me-0 me-lg-2">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </a>
                                    <a href="<?= $base_url ?>payments/delete.php?id=<?= $payment->id ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this payment?')">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php
                                }
                            } else {
                            ?>
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fa-regular fa-circle-xmark fa-2x mb-2 d-block"></i>
                                        No payments found
                                    </div>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <div class="pb-3 ps-3 mt-3 d-flex justify-content-center justify-content-md-between justify-content-lg-between flex-wrap flex-md-nowrap">
                    <nav aria-label="Page navigation" class="mb-3 mb-md-0 mb-lg-0">
                        <?php
                        // Get total records with filter
                        $total_conditions = [];
                        if(isset($_GET['method']) && !empty($_GET['method'])) {
                            $total_conditions['payment_method'] = $_GET['method'];
                        }
                        $total_records = $crud->number_of_records("payments", $total_conditions);
                        $total_pages = ceil($total_records / $records_per_page);
                        ?>
                        <ul class="pagination">
                            <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                                <a class="page-link" href="<?= $base_url ?>payments/list.php?page=<?= $page-1 ?><?= isset($_GET['method']) ? '&method='.$_GET['method'] : '' ?>" aria-label="Previous">
                                    <i class="fa-solid fa-chevron-left text-size-12"></i>
                                </a>
                            </li>
                            <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                                    <a class="page-link" href="<?= $base_url ?>payments/list.php?page=<?= $i ?><?= isset($_GET['method']) ? '&method='.$_GET['method'] : '' ?>">
                                        <?= $i ?>
                                    </a>
                                </li>
                            <?php } ?>
                            <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
                                <a class="page-link" href="<?= $base_url ?>payments/list.php?page=<?= $page+1 ?><?= isset($_GET['method']) ? '&method='.$_GET['method'] : '' ?>" aria-label="Next">
                                    <i class="fa-solid fa-chevron-right text-size-12"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once "../component/footer.php"; ?>
