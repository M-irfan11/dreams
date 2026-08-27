<?php require_once '../component/header.php'; ?>
<?php require_once '../component/sidebar.php'; ?>
<?php
    $id = $_GET['id'];
    $result = $crud->common_query("
                                SELECT sales.*,
                                customers.name,
                                customers.phone,
                                sum(receive_vouchers.dr) as paid
                                FROM `sales`
                                JOIN customers on customers.id=sales.customer_id
                                left join receive_vouchers on receive_vouchers.source_id=sales.id and receive_vouchers.source_type='sales'
                                WHERE sales.id=$id
                                GROUP BY sales.id
                                ");
    $sale = $result['data'][0] ?? null;

    if (!$sale) {
        echo "<script>window.location.href = '{$base_url}sales/list.php';</script>";
        exit;
    }

    $sdresult = $crud->common_query("SELECT sale_details.*, products.product_name FROM sale_details JOIN products ON products.id = sale_details.product_id WHERE sale_details.sale_id = $id");
    $sale_details = $sdresult['data'] ?? [];

    function getSelectableAccountHeads($crud) {
        $result = $crud->common_query("SELECT id, account_name, parent_id FROM account_heads WHERE account_code in (1110,1120) AND deleted_at IS NULL ORDER BY account_name ASC");
        if (!$result['status'] || empty($result['data'])) {
            return [];
        }

        $heads = $result['data'];
        $headList = [];
        $seen = [];

        foreach ($heads as $head) {
            $childQuery = $crud->common_query("SELECT id FROM account_heads WHERE parent_id = " . (int) $head->id . " AND deleted_at IS NULL");

            if ($childQuery['status'] && !empty($childQuery['data'])) {
                foreach ($childQuery['data'] as $child) {
                    $childHead = $crud->common_query("SELECT id, account_name FROM account_heads WHERE id = " . (int) $child->id . " AND deleted_at IS NULL LIMIT 1");
                    if ($childHead['status'] && !empty($childHead['data'])) {
                        $childRow = $childHead['data'][0];
                        if (!isset($seen[(int) $childRow->id])) {
                            $headList[] = [
                                'id' => (int) $childRow->id,
                                'name' => $childRow->account_name
                            ];
                            $seen[(int) $childRow->id] = true;
                        }
                    }
                }
                continue;
            }

            if (!isset($seen[(int) $head->id])) {
                $headList[] = [
                    'id' => (int) $head->id,
                    'name' => $head->account_name
                ];
                $seen[(int) $head->id] = true;
            }
        }

        return $headList;
    }

    $accountHeads = getSelectableAccountHeads($crud);

    // ---- Due amount calculation ----
    // Some older sale rows may not have grand_total populated (NULL),
    // so fall back to computing it from total_amount, discount and tax.
    if ($sale->grand_total !== null) {
        $grand_total = (float) $sale->grand_total;
    } else {
        $grand_total = (float) $sale->total_amount - (float) $sale->discount + (float) $sale->tax;
    }

    $paid = (float) ($sale->paid ?? 0);

    $due = $grand_total - $paid;
    if ($due < 0) {
        $due = 0; // already fully paid (or overpaid) — don't show a negative amount
    }
?>

<div class="page-wrapper">
    <div class="content">

        <div class="page-header">
            <div class="page-title">
                <h4>Payment</h4>
                <h6>Process payment for sale #<?php echo $sale->id; ?>, Customer: <?= htmlspecialchars($sale->name) ?> - <?= htmlspecialchars($sale->phone) ?></h6>
                <h2>Sales amount: ৳ <?php echo number_format($due, 2); ?></h2>
            </div>
        </div>

        <!-- here form for payment will be added -->
        <div class="card">
            <div class="card-body">
                <form action="process_payment.php" method="POST">
                    <input type="hidden" name="sale_id" value="<?php echo $sale->id; ?>">
                    <input type="hidden" name="received_from" value="<?php echo $sale->name; ?> - <?php echo $sale->phone; ?>">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="payment_date" class="form-label">Payment Date</label>
                            <input type="date" value="<?php echo date('Y-m-d'); ?>" class="form-control" id="payment_date" name="payment_date" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="amount" class="form-label">Payment Amount</label>
                            <input type="number" step="0.01" class="form-control" id="amount" name="amount" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="account_head_id" class="form-label">Payment Method</label>
                            <select class="form-select" id="account_head_id" name="account_head_id" required>
                                <option value="">Select Payment Method</option>
                                <?php if (!empty($accountHeads)): ?>
                                    <?php foreach ($accountHeads as $head): ?>
                                        <option value="<?= (int) $head['id']; ?>"><?= htmlspecialchars($head['name']); ?></option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="">No Payment Method available</option>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Submit Payment</button>
                </form>
            </div>
        </div>

    </div>
</div>

<?php require_once '../component/footer.php'; ?>