<?php require_once "../component/header.php"; ?>
<!-- Sidebar Start -->
<?php require_once "../component/sidebar.php"; ?>
<!-- Sidebar End -->

<?php
$account_id = $_GET['account_id'] ?? 0;


$account_info = $crud->common_query("SELECT * FROM account_heads WHERE id = $account_id AND deleted_at IS NULL");
$account = $account_info['data'][0] ?? null;


$ledger_sql = "SELECT * FROM ledger 
               WHERE account_head_id = $account_id 
               ORDER BY id DESC";
$ledger_data = $crud->common_query($ledger_sql);
?>
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-12">
                <h3>
                    Ledger: 
                    <?= $account ? htmlspecialchars($account->account_name) : 'Select an Account' ?>
                </h3>
            </div>
        </div>

        <div class="card shadow-sm border-0 mt-4">
            <div class="card-body p-4">
                
                <form method="GET" class="mb-4">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="account_id" class="form-label">Select Account</label>
                            <select name="account_id" id="account_id" class="form-select" onchange="this.form.submit()">
                                <option value="">-- Select Account --</option>
                                <?php
                                $accounts = $crud->common_query("SELECT id, account_name FROM account_heads WHERE deleted_at IS NULL");
                                foreach ($accounts['data'] as $a) {
                                    $selected = ($a->id == $account_id) ? 'selected' : '';
                                    echo "<option value='{$a->id}' {$selected}>{$a->account_name}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </form>

                <?php if ($account) { ?>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Voucher Type</th>
                                    <th>Particulars</th>
                                    <th class="text-end">Debit (Dr)</th>
                                    <th class="text-end">Credit (Cr)</th>
                                    <th class="text-end">Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $balance = $account->opening_balance ?? 0;
                                foreach ($ledger_data['data'] as $row) {
                                    $balance += ($row->dr - $row->cr);
                                ?>
                                <tr>
                                    <td><?= date('d-m-Y', strtotime($row->created_at)) ?></td>
                                    <td>
                                        <?php
                                        if ($row->payment_voucher_id) echo '<span class="badge bg-primary">Payment</span>';
                                        elseif ($row->receive_voucher_id) echo '<span class="badge bg-success">Receive</span>';
                                        elseif ($row->journal_voucher_id) echo '<span class="badge bg-info">Journal</span>';
                                        else echo '<span class="badge bg-secondary">General</span>';
                                        ?>
                                    </td>
                                    <td><?= htmlspecialchars($row->remarks ?? 'N/A') ?></td>
                                    <td class="text-end"><?= number_format($row->dr, 2) ?></td>
                                    <td class="text-end"><?= number_format($row->cr, 2) ?></td>
                                    <td class="text-end fw-bold"><?= number_format($balance, 2) ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot class="table-active">
                                <tr>
                                    <th colspan="3" class="text-end">Closing Balance</th>
                                    <td class="text-end fw-bold">
                                        <?= number_format($balance, 2) ?>
                                    </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                <?php } else { ?>
                    <div class="alert alert-info">
                        Please select an account from the dropdown above to view its ledger.
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<?php require_once "../component/footer.php"; ?>