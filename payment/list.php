<?php require_once '../component/header.php'; ?>
<?php require_once '../component/sidebar.php'; ?>

<div class="page-wrapper">
    <div class="content">

        <?php
            // Session message (set by payment/add.php, edit.php, delete.php)
            if(isset($_SESSION['message'])){
                $msg = $_SESSION['message'];
                $alert_class = $msg['type'] === 'success' ? 'alert-success' : 'alert-danger';
                echo '<div class="alert ' . $alert_class . '">
                        <strong>' . $msg['title'] . '</strong> ' . $msg['message'] . '
                      </div>';
                unset($_SESSION['message']);
            }

            // Fetch all payments, joined with sales
            $payment = $crud->common_query('SELECT payments.*, sales.id as sale_ref, sales.grand_total as sale_total FROM `payments` JOIN sales on sales.id=payments.sale_id WHERE payments.deleted_at IS NULL');
        ?>

        <div class="page-header">
            <div class="page-title">
                <h4>PAYMENT LIST</h4>
                <h6>Manage your payments</h6>
            </div>
            <div class="page-btn">
                <a href="<?php echo $base_url; ?>payment/create.php" class="btn btn-added">
                    <img src="<?php echo $base_url; ?>assets/img/icons/plus.svg" alt="img">Add New Payment
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
                                <th>Sale Ref</th>
                                <th>Amount</th>
                                <th>Payment Method</th>
                                <th>Payment Date</th>
                                <th>Transaction ID</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($payment['status']): ?>
                                <?php $sl = 1; foreach($payment['data'] as $pay): ?>
                                <tr>
                                    <td>
                                        <label class="checkboxs">
                                            <input type="checkbox">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </td>
                                    <td><?php echo $sl++; ?></td>
                                    <td class="text-bolds">#<?php echo htmlspecialchars($pay->sale_ref); ?></td>
                                    <td>৳<?php echo htmlspecialchars($pay->amount); ?></td>
                                    <td><?php echo htmlspecialchars($pay->payment_method); ?></td>
                                    <td><?php echo htmlspecialchars($pay->payment_date); ?></td>
                                    <td><?php echo htmlspecialchars($pay->transaction_id); ?></td>
                                    <td>
                                        <a class="me-3" href="update.php?id=<?php echo $pay->payment_id; ?>">
                                            <img src="<?php echo $base_url; ?>assets/img/icons/edit.svg" alt="img">
                                        </a>
                                        <a class="me-3 confirm-text" href="delete.php?id=<?php echo $pay->payment_id; ?>">
                                            <img src="<?php echo $base_url; ?>assets/img/icons/delete.svg" alt="img">
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<?php require_once '../component/footer.php'; ?>
