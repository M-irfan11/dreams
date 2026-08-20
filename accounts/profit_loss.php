<?php require_once "../component/header.php"; ?>
<!-- Sidebar Start -->
<?php require_once "../component/sidebar.php"; ?>
<!-- Sidebar End -->

<?php

// ---- Revenue (Income) line items ----
$income_items_query = $crud->common_query("
    SELECT ah.id, ah.account_name, SUM(l.cr) as total
    FROM ledger l
    INNER JOIN account_heads ah ON ah.id = l.account_head_id
    WHERE ah.account_type = 'Income'
    GROUP BY ah.id, ah.account_name
    ORDER BY ah.account_name ASC
");
$income_items = $income_items_query['data'] ?? [];

$total_income = 0;
foreach ($income_items as $item) {
    $total_income += (float) $item->total;
}

// ---- Expense line items ----
$expense_items_query = $crud->common_query("
    SELECT ah.id, ah.account_name, SUM(l.dr) as total
    FROM ledger l
    INNER JOIN account_heads ah ON ah.id = l.account_head_id
    WHERE ah.account_type = 'Expense'
    GROUP BY ah.id, ah.account_name
    ORDER BY ah.account_name ASC
");
$expense_items = $expense_items_query['data'] ?? [];

$total_expense = 0;
foreach ($expense_items as $item) {
    $total_expense += (float) $item->total;
}

$net_profit = $total_income - $total_expense;
?>

<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-12">
                <h3 class="mb-3">Profit / Loss Statement</h3>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle mb-0">
                        <thead>
                            <tr class="bg-light">
                                <th style="width:50%">Revenue</th>
                                <th class="text-end" style="width:25%">Amount</th>
                                <th class="text-end" style="width:25%">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($income_items) > 0): ?>
                                <?php foreach ($income_items as $item): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($item->account_name) ?></td>
                                        <td class="text-end"><?= number_format((float) $item->total, 2) ?></td>
                                        <td></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="text-center text-muted">No revenue entries found</td>
                                </tr>
                            <?php endif; ?>

                            <tr class="fw-bold bg-light">
                                <td colspan="2">Total Revenue</td>
                                <td class="text-end"><?= number_format($total_income, 2) ?></td>
                            </tr>

                            <?php foreach ($expense_items as $item): ?>
                                <tr>
                                    <td><?= htmlspecialchars($item->account_name) ?></td>
                                    <td class="text-end"><?= number_format((float) $item->total, 2) ?></td>
                                    <td></td>
                                </tr>
                            <?php endforeach; ?>

                            <tr class="fw-bold bg-light">
                                <td colspan="2">Total Expenses</td>
                                <td class="text-end"><?= number_format($total_expense, 2) ?></td>
                            </tr>

                            <tr class="fw-bold <?= ($net_profit >= 0) ? 'bg-success bg-opacity-10' : 'bg-danger bg-opacity-10' ?>">
                                <td colspan="2" class="<?= ($net_profit >= 0) ? 'text-success' : 'text-danger' ?>">
                                    <?= ($net_profit >= 0) ? 'Total Income (Net Profit)' : 'Total Loss (Net Loss)' ?>
                                </td>
                                <td class="text-end <?= ($net_profit >= 0) ? 'text-success' : 'text-danger' ?>">
                                    <?= number_format(abs($net_profit), 2) ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once "../component/footer.php"; ?>