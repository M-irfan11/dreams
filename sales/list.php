<?php require_once '../component/header.php'; ?>
<?php require_once '../component/sidebar.php'; ?>

<div class="page-wrapper">
    <div class="content">

        <?php
            // Session message (set by sales/add.php, edit.php, delete.php)
            if(isset($_SESSION['message'])){
                $msg = $_SESSION['message'];
                $alert_class = $msg['type'] === 'success' ? 'alert-success' : 'alert-danger';
                echo '<div class="alert ' . $alert_class . '">
                        <strong>' . $msg['title'] . '</strong> ' . $msg['message'] . '
                      </div>';
                unset($_SESSION['message']);
            }

            // Fetch all sales, joined with customers
            $sales = $crud->common_query('SELECT sales.*, customers.name as customer_name FROM `sales` JOIN customers on customers.id=sales.customer_id ');
        ?>

        <div class="page-header">
            <div class="page-title">
                <h4>SALES LIST</h4>
                <h6>Manage your sales</h6>
            </div>
            <div class="page-btn">
                <a href="<?php echo $base_url; ?>sales/create.php" class="btn btn-added">
                    <img src="<?php echo $base_url; ?>assets/img/icons/plus.svg" alt="img">Add New Sale
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-top">
                    <div class="search-set">
                        <div class="search-path">
                            <a class="btn btn-filter" id="filter_search">
                                <img src="<?php echo $base_url; ?>assets/img/icons/filter.svg" alt="img">
                                <span><img src="<?php echo $base_url; ?>assets/img/icons/closes.svg" alt="img"></span>
                            </a>
                        </div>
                        <div class="search-input">
                            <a class="btn btn-searchset"><img src="<?php echo $base_url; ?>assets/img/icons/search-white.svg" alt="img"></a>
                        </div>
                    </div>
                    <div class="wordset">
                        <ul>
                            <li>
                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="pdf"><img src="<?php echo $base_url; ?>assets/img/icons/pdf.svg" alt="img"></a>
                            </li>
                            <li>
                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="excel"><img src="<?php echo $base_url; ?>assets/img/icons/excel.svg" alt="img"></a>
                            </li>
                            <li>
                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="print"><img src="<?php echo $base_url; ?>assets/img/icons/printer.svg" alt="img"></a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table datanew">
                        <thead>
                            <tr>
                                <th>
                                    <label class="checkboxs">
                                        <input type="checkbox" id="select-all">
                                        <span class="checkmarks"></span>
                                    </label>
                                </th>
                                <th>#</th>
                                <th>Customer Name</th>
                                <th>Sale Date</th>
                                <th>Total Amount</th>
                                <th>Discount</th>
                                <th>Tax</th>
                                <th>Grand Total</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($sales['status']): ?>
                                <?php $sl = 1; foreach($sales['data'] as $sale): ?>
                                <tr>
                                    <td>
                                        <label class="checkboxs">
                                            <input type="checkbox">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </td>
                                    <td><?php echo $sl++; ?></td>
                                    <td class="text-bolds"><?php echo htmlspecialchars($sale->customer_name); ?></td>
                                    <td><?php echo htmlspecialchars($sale->sale_date); ?></td>
                                    <td><?php echo htmlspecialchars($sale->total_amount); ?></td>
                                    <td>৳<?php echo htmlspecialchars($sale->discount); ?></td>
                                    <td>৳<?php echo htmlspecialchars($sale->tax); ?></td>
                                    <td><?php echo number_format($sale->total_amount - $sale->discount + $sale->tax, 2); ?></td>
                                    <td>
                                        <?php
                                            if($sale->status == 1){
                                                echo 'Paid';
                                            } elseif($sale->status == 3){
                                                echo 'Cancelled';
                                            } else {
                                                echo 'Pending';
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <a class="me-3" href="update.php?id=<?php echo $sale->sale_id; ?>">
                                            <img src="<?php echo $base_url; ?>assets/img/icons/edit.svg" alt="img">
                                        </a>
                                        <a class="me-3 confirm-text" href="delete.php?id=<?php echo $sale->sale_id; ?>">
                                            <img src="<?php echo $base_url; ?>assets/img/icons/delete.svg" alt="img">
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <?php // Empty tbody when there's no data — DataTables shows its own
                                  // "No data available in table" message instead of a manual row,
                                  // since a manual colspan row breaks its cell-index mapping. ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<?php require_once '../component/footer.php'; ?>
