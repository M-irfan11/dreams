<?php require_once '../component/header.php'; ?>
<?php require_once '../component/sidebar.php'; ?>

    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="main-body">
                <div class="page-wrapper">
                    <div class="page-body">

                        <?php
                            // Session message (set by warehouse/add.php, edit.php, delete.php)
                            if(isset($_SESSION['message'])){
                                $msg = $_SESSION['message'];
                                $alert_class = $msg['type'] === 'success' ? 'alert-success' : 'alert-danger';
                                echo '<div class="alert ' . $alert_class . '">
                                        <strong>' . $msg['title'] . '</strong> ' . $msg['message'] . '
                                      </div>';
                                unset($_SESSION['message']);
                            }

                            // Fetch all warehouses, latest first
                            $warehouses = $crud->common_select('warehouses', "*", [], "AND", "id", "DESC");
                        ?>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5>Warehouses</h5>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addWarehouseModal">
                                            <i class="feather icon-plus"></i> Add Warehouse
                                        </button>
                                    </div>
                                    <div class="card-body table-border-style">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Name</th>
                                                        <th>Location</th>
                                                        <th>Manager</th>
                                                        <th>Added On</th>
                                                        <th class="text-end">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $sl = 1;
                                                        $has_rows = false;
                                                        if($warehouses['status']):
                                                            foreach($warehouses['data'] as $wh):
                                                                // Skip soft-deleted rows
                                                                if(!empty($wh->deleted_at)) continue;
                                                                $has_rows = true;
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $sl++; ?></td>
                                                            <td><?php echo htmlspecialchars($wh->warehouse_name); ?></td>
                                                            <td><?php echo htmlspecialchars($wh->location); ?></td>
                                                            <td><?php echo htmlspecialchars($wh->manager_name); ?></td>
                                                            <td><?php echo htmlspecialchars($wh->created_at); ?></td>
                                                            <td class="text-end">
                                                                <button type="button" class="btn btn-sm btn-warning"
                                                                    data-bs-toggle="modal" data-bs-target="#editWarehouseModal"
                                                                    data-id="<?php echo $wh->id; ?>"
                                                                    data-name="<?php echo htmlspecialchars($wh->warehouse_name); ?>"
                                                                    data-location="<?php echo htmlspecialchars($wh->location); ?>"
                                                                    data-manager="<?php echo htmlspecialchars($wh->manager_name); ?>"
                                                                    onclick="fillEditForm(this)">
                                                                    <i class="feather icon-edit"></i>
                                                                </button>
                                                                <a href="delete.php?id=<?php echo $wh->id; ?>"
                                                                    class="btn btn-sm btn-danger"
                                                                    onclick="return confirm('Delete this warehouse?');">
                                                                    <i class="feather icon-trash-2"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                            endforeach;
                                                        endif;
                                                        if(!$has_rows):
                                                    ?>
                                                        <tr><td colspan="6" class="text-center">No warehouses found.</td></tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Warehouse Modal -->
    <div class="modal fade" id="addWarehouseModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="add.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Warehouse</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Warehouse Name</label>
                            <input type="text" name="warehouse_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Location</label>
                            <textarea name="location" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Manager Name</label>
                            <input type="text" name="manager_name" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Warehouse</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Warehouse Modal -->
    <div class="modal fade" id="editWarehouseModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="edit.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Warehouse</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="edit_id">
                        <div class="mb-3">
                            <label class="form-label">Warehouse Name</label>
                            <input type="text" name="warehouse_name" id="edit_warehouse_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Location</label>
                            <textarea name="location" id="edit_location" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Manager Name</label>
                            <input type="text" name="manager_name" id="edit_manager_name" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Warehouse</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Edit button e click korle modal er field gula purano data diye fill kore dey
        function fillEditForm(btn){
            document.getElementById('edit_id').value = btn.getAttribute('data-id');
            document.getElementById('edit_warehouse_name').value = btn.getAttribute('data-name');
            document.getElementById('edit_location').value = btn.getAttribute('data-location');
            document.getElementById('edit_manager_name').value = btn.getAttribute('data-manager');
        }
    </script>

<?php require_once '../component/footer.php'; ?>
