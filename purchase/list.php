<?php require_once '../component/header.php'; ?>
<?php require_once '../component/sidebar.php'; ?>

<div class="page-wrapper">
    <div class="content">

        <?php
            // Session message (set by purchase/add.php, edit.php, delete.php)
            if(isset($_SESSION['message'])){
                $msg = $_SESSION['message'];
                $alert_class = $msg['type'] === 'success' ? 'alert-success' : 'alert-danger';
                echo '<div class="alert ' . $alert_class . '">
                        <strong>' . $msg['title'] . '</strong> ' . $msg['message'] . '
                      </div>';
                unset($_SESSION['message']);
            }

            // Fetch all purchases, joined with suppliers
            $purchase = $crud->common_query('SELECT purchases.*, suppliers.name AS supplier_name FROM `purchases` JOIN suppliers on suppliers.id=purchases.supplier_id ');
            
        ?>

        <div class="page-header">
            <div class="page-title">
                <h4>PURCHASE LIST</h4>
                <h6>Manage your purchases</h6>
            </div>
            <div class="page-btn">
                <a href="<?php echo $base_url; ?>purchase/create.php" class="btn btn-added">
                    <img src="<?php echo $base_url; ?>assets/img/icons/plus.svg" alt="img">Add New Purchases
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
                                <th>Supplier Name</th>
                                <th>Reference</th>
                                <th>Date</th>
                                <th>Total Amount</th>
                                <th>Discount</th>
                                <th>Vat</th>
                                <th>Grand Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($purchase['status']): ?>
                                <?php $sl = 1; foreach($purchase['data'] as $pur): ?>
                                <tr>
                                    <td>
                                        <label class="checkboxs">
                                            <input type="checkbox">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </td>
                                    <td><?php echo $sl++; ?></td>
                                    <td class="text-bolds"><?php echo htmlspecialchars($pur->supplier_name); ?></td>
                                    <td><?php echo htmlspecialchars($pur->ref); ?></td>
                                    <td><?php echo htmlspecialchars($pur->purchase_date); ?></td>
                                    <td><?php echo htmlspecialchars($pur->total_amount); ?></td>
                                    <td>
                                        <?php
                                            if($pur->discount_type == 2){
                                                echo htmlspecialchars($pur->discount_amount) . '%';
                                            } else {
                                                echo '৳' . htmlspecialchars($pur->discount_amount);
                                            }
                                        ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($pur->vat); ?></td>
                                    <td><?php echo htmlspecialchars($pur->grand_total); ?></td>
                                    <td>
                                        <a class="me-3" href="received.php?id=<?php echo $pur->id; ?>">
                                            <img src="<?php echo $base_url; ?>assets/img/icons/dollar.svg" alt="img">
                                        </a>
                                        <a class="me-3" href="update.php?id=<?php echo $pur->id; ?>">
                                            <img src="<?php echo $base_url; ?>assets/img/icons/edit.svg" alt="img">
                                        </a>
                                        <a class="me-3 confirm-text" href="delete.php?id=<?php echo $pur->id; ?>">
                                            <img src="<?php echo $base_url; ?>assets/img/icons/delete.svg" alt="img">
                                        </a>
                                        <a  class="btn btn-sm btn-primary" href="invoice.php?id=<?php echo $pur->id; ?>">Invoice</a>
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