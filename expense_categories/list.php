<?php require_once '../component/header.php'; ?>
<?php require_once '../component/sidebar.php'; ?>

<div class="page-wrapper">
    <div class="content">

        <?php
            // Session message (set by expense_categories/add.php, edit.php, delete.php)
            if(isset($_SESSION['message'])){
                $msg = $_SESSION['message'];
                $alert_class = $msg['type'] === 'success' ? 'alert-success' : 'alert-danger';
                echo '<div class="alert ' . $alert_class . '">
                        <strong>' . $msg['title'] . '</strong> ' . $msg['message'] . '
                      </div>';
                unset($_SESSION['message']);
            }

            // Fetch all expense categories
            $categories = $crud->common_select('expense_categories');
        ?>

        <div class="page-header">
            <div class="page-title">
                <h4>EXPENSE CATEGORY LIST</h4>
                <h6>Manage your expense categories</h6>
            </div>
            <div class="page-btn">
                <a href="<?php echo $base_url; ?>expense_categories/create.php" class="btn btn-added">
                    <img src="<?php echo $base_url; ?>assets/img/icons/plus.svg" alt="img">Add New Category
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
                                <th>Category Name</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($categories['status']): ?>
                                <?php foreach($categories['data'] as $cat): ?>
                                <tr>
                                    <td>
                                        <label class="checkboxs">
                                            <input type="checkbox">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </td>
                                    <td><?php echo $cat->id; ?></td>
                                    <td class="text-bolds"><?php echo htmlspecialchars($cat->category_name); ?></td>
                                    <td><?php echo htmlspecialchars($cat->description); ?></td>
                                    <td>
                                        <?php echo $cat->status == 1 ? '<span class="badges bg-lightgreen">Active</span>' : '<span class="badges bg-lightred">Inactive</span>'; ?>
                                    </td>
                                    <td>
                                        <a class="me-3" href="update.php?id=<?php echo $cat->id; ?>">
                                            <img src="<?php echo $base_url; ?>assets/img/icons/edit.svg" alt="img">
                                        </a>
                                        <a class="me-3 confirm-text" href="delete.php?id=<?php echo $cat->id; ?>">
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
