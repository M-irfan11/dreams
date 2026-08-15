<?php require_once '../component/header.php'; ?>
<?php require_once '../component/sidebar.php'; ?>

<div class="page-wrapper">
    <div class="content">

        <?php
            // Session message (set by sales_return/store.php, edit.php, delete.php)
            if(isset($_SESSION['message'])){
                $msg = $_SESSION['message'];
                $alert_class = $msg['type'] === 'success' ? 'alert-success' : 'alert-danger';
                echo '<div class="alert ' . $alert_class . '">
                        <strong>' . $msg['title'] . '</strong> ' . $msg['message'] . '
                      </div>';
                unset($_SESSION['message']);
            }

            // Fetch all sales returns, joined with customers and users (created by)
            $returns = $crud->common_query('SELECT sales_returns.*, customers.name as customer_name, users.full_name FROM `sales_returns`
                JOIN customers on customers.id=sales_returns.customer_id
                LEFT JOIN users on users.id=sales_returns.created_by
                WHERE sales_returns.deleted_at IS NULL
                ORDER BY sales_returns.id DESC');
        ?>

        <div class="page-header">
            <div class="page-title">
                <h4>SALES RETURN LIST</h4>
                <h6>Manage your sales returns</h6>
            </div>
            <div class="page-btn">
                <a href="<?php echo $base_url; ?>sales_return/create.php" class="btn btn-added">
                    <img src="<?php echo $base_url; ?>assets/img/icons/plus.svg" alt="img">Add New Sales Return
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
                                <th>ID</th>
                                <th>Sale ID</th>
                                <th>Customer</th>
                                <th>Return Date</th>
                                <th>Total Amount</th>
                                <th>Reason</th>
                                <th>Status</th>
                                <th>Created By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($returns['status']): ?>
                                <?php foreach($returns['data'] as $ret): ?>
                                <tr>
                                    <td>
                                        <label class="checkboxs">
                                            <input type="checkbox">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </td>
                                    <td><?php echo $ret->id; ?></td>
                                    <td><?php echo $ret->sale_id; ?></td>
                                    <td class="text-bolds"><?php echo htmlspecialchars($ret->customer_name); ?></td>
                                    <td><?php echo htmlspecialchars($ret->return_date); ?></td>
                                    <td><?php echo htmlspecialchars($ret->total_amount); ?></td>
                                    <td><?php echo htmlspecialchars($ret->reason); ?></td>
                                    <td>
                                        <?php echo $ret->status == 1 ? '<span class="badges bg-lightgreen">Active</span>' : '<span class="badges bg-lightred">Cancelled</span>'; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($ret->full_name); ?></td>
                                    <td>
                                        <?php // view.php will be added in a later step ?>
                                        <a class="me-3" href="update.php?id=<?php echo $ret->id; ?>">
                                            <img src="<?php echo $base_url; ?>assets/img/icons/edit.svg" alt="img">
                                        </a>
                                        <a class="me-3 confirm-text" href="delete.php?id=<?php echo $ret->id; ?>">
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
