<?php require_once 'component/header.php'; ?>
<?php require_once 'component/sidebar.php'; ?>
<?php require_once 'component/auth.php'; ?>
<?php require_role(['Super Admin']); ?>
<?php

    // which year to show - default to current year
    $year = isset($_GET['year']) ? (int)$_GET['year'] : (int)date('Y');

    // get list of years that actually have sales, so the dropdown is real
    $years_result = $crud->common_query("SELECT DISTINCT YEAR(sale_date) as yr FROM sales WHERE deleted_at IS NULL ORDER BY yr DESC");
    $years = $years_result['status'] ? $years_result['data'] : [];


    // -------------------------
    // 1. TOTAL REVENUE (from sales, not cancelled)
    // -------------------------

    $revenue_result = $crud->common_query("SELECT SUM(total_amount - discount + tax) as total
        FROM sales
        WHERE YEAR(sale_date) = $year
        AND status != 3
        AND deleted_at IS NULL");
    $total_revenue = $revenue_result['status'] ? ($revenue_result['data'][0]->total ?? 0) : 0;


    // -------------------------
    // 2. SALES RETURNS (reduces revenue)
    // -------------------------

    $sales_return_result = $crud->common_query("SELECT SUM(total_amount) as total
        FROM sales_returns
        WHERE YEAR(return_date) = $year
        AND status = 1
        AND deleted_at IS NULL");
    $total_sales_returns = $sales_return_result['status'] ? ($sales_return_result['data'][0]->total ?? 0) : 0;

    $net_revenue = $total_revenue - $total_sales_returns;


    // -------------------------
    // 3. COST OF GOODS SOLD
    // (estimated using each product's current purchase price x quantity sold)
    // -------------------------

    $cogs_result = $crud->common_query("SELECT SUM(sale_details.quantity * products.purchase_price) as total
        FROM sale_details
        JOIN sales ON sales.id = sale_details.sale_id
        JOIN products ON products.id = sale_details.product_id
        WHERE YEAR(sales.sale_date) = $year
        AND sales.status != 3
        AND sales.deleted_at IS NULL
        AND sale_details.deleted_at IS NULL");
    $total_cogs = $cogs_result['status'] ? ($cogs_result['data'][0]->total ?? 0) : 0;


    // -------------------------
    // 4. RETURNED GOODS COST (reduces COGS, since returned items weren't really sold)
    // -------------------------

    $returned_cogs_result = $crud->common_query("SELECT SUM(sales_return_details.quantity * products.purchase_price) as total
        FROM sales_return_details
        JOIN sales_returns ON sales_returns.id = sales_return_details.sale_return_id
        JOIN products ON products.id = sales_return_details.product_id
        WHERE YEAR(sales_returns.return_date) = $year
        AND sales_returns.status = 1
        AND sales_returns.deleted_at IS NULL
        AND sales_return_details.deleted_at IS NULL");
    $total_returned_cogs = $returned_cogs_result['status'] ? ($returned_cogs_result['data'][0]->total ?? 0) : 0;

    $net_cogs = $total_cogs - $total_returned_cogs;


    // -------------------------
    // 5. GROSS PROFIT
    // -------------------------

    $gross_profit = $net_revenue - $net_cogs;


    // -------------------------
    // 6. OPERATING EXPENSES
    // -------------------------

    $expense_result = $crud->common_query("SELECT SUM(amount) as total
        FROM expenses
        WHERE YEAR(expense_date) = $year
        AND deleted_at IS NULL");
    $total_expenses = $expense_result['status'] ? ($expense_result['data'][0]->total ?? 0) : 0;


    // -------------------------
    // 7. NET PROFIT / LOSS
    // -------------------------

    $net_profit = $gross_profit - $total_expenses;

?>

<div class="page-wrapper">
    <div class="content">

        <div class="page-header">
            <div class="page-title">
                <h4>Yearly Profit &amp; Loss Report</h4>
                <h6>See how much the business earned or lost in a year</h6>
            </div>
        </div>

        <div class="card">
            <div class="card-body">

                <form method="GET" class="row mb-4">
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Year</label>
                            <select name="year" class="select form-control" onchange="this.form.submit()">
                                <?php if(empty($years)){ ?>
                                    <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                                <?php } else { ?>
                                    <?php foreach($years as $y){ ?>
                                        <option value="<?php echo $y->yr; ?>" <?php echo ($y->yr == $year) ? 'selected' : ''; ?>>
                                            <?php echo $y->yr; ?>
                                        </option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table datanew">
                        <tbody>
                            <tr>
                                <td><strong>Total Revenue (Sales)</strong></td>
                                <td class="text-end"><?php echo number_format($total_revenue, 2); ?></td>
                            </tr>
                            <tr>
                                <td>Less: Sales Returns</td>
                                <td class="text-end">- <?php echo number_format($total_sales_returns, 2); ?></td>
                            </tr>
                            <tr class="table-light">
                                <td><strong>Net Revenue</strong></td>
                                <td class="text-end"><strong><?php echo number_format($net_revenue, 2); ?></strong></td>
                            </tr>

                            <tr>
                                <td class="pt-4"><strong>Cost of Goods Sold</strong></td>
                                <td class="text-end pt-4">- <?php echo number_format($net_cogs, 2); ?></td>
                            </tr>

                            <tr class="table-light">
                                <td><strong>Gross Profit</strong></td>
                                <td class="text-end"><strong><?php echo number_format($gross_profit, 2); ?></strong></td>
                            </tr>

                            <tr>
                                <td class="pt-4">Less: Operating Expenses</td>
                                <td class="text-end pt-4">- <?php echo number_format($total_expenses, 2); ?></td>
                            </tr>

                            <tr class="<?php echo $net_profit >= 0 ? 'table-success' : 'table-danger'; ?>">
                                <td><strong><?php echo $net_profit >= 0 ? 'Net Profit' : 'Net Loss'; ?> (<?php echo $year; ?>)</strong></td>
                                <td class="text-end"><strong><?php echo number_format(abs($net_profit), 2); ?></strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <small class="text-muted">
                    Note: Cost of Goods Sold is estimated using each product's current purchase price
                    multiplied by quantity sold - not the exact historical purchase cost of each unit.
                </small>

            </div>
        </div>

    </div>
</div>

<?php require_once 'component/footer.php'; ?>
