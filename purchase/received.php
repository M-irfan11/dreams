<?php require_once '../component/header.php'; ?>
<?php require_once '../component/sidebar.php'; ?>
<?php
    $id = $_GET['id'];
    $result = $crud->common_query("SELECT purchases.*,suppliers.name,suppliers.phone,sum(payment_vouchers.dr) as paid
                                    FROM `purchases`
                                    JOIN suppliers on suppliers.id=purchases.supplier_id
                                    LEFT JOIN payment_vouchers on payment_vouchers.source_id=purchases.id and payment_vouchers.source_type='purchases'
                                    WHERE purchases.id=$id
                                    GROUP BY purchases.id");
    $purchase = $result['data'][0] ?? null;

    if (!$purchase) {
        echo "<script>window.location.href = '{$base_url}purchases/list.php';</script>";
        exit;
    }

    $sdresult = $crud->common_query("SELECT purchase_details.*, products.product_name FROM purchase_details JOIN products ON products.id = purchase_details.product_id WHERE purchase_details.purchase_id = $id");
    $purchase_details = $sdresult['data'] ?? [];

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

    print_r($accountHeads);
?>

<div class="page-wrapper">
    <div class="content">

        <div class="page-header">
            <div class="page-title">
                <h4>Received</h4>
                <h6>Process received form purchase #<?php echo $purchase->id; ?>, Supplier: <?= htmlspecialchars($purchase->name) ?> - <?= htmlspecialchars($purchase->phone) ?></h6>
                <h2>purchases amount: ৳<?php echo number_format($purchase->total_amount - $purchase->paid, 2); ?></h2>
            </div>
        </div>

        <!-- here form for received will be added -->
        <div class="card">
            <div class="card-body">
                <form action="process_received.php" method="POST">
                    <input type="hidden" name="purchase_id" value="<?php echo $purchase->id; ?>">
                    <input type="hidden" name="received_from" value="<?php echo $purchase->name; ?> - <?php echo $purchase->phone; ?>">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for=payment_date" class="form-label">payment date</label>
                            <input type="date" value="<?php echo date('Y-m-d'); ?>" class="form-control" id="received_date" name="received_date" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="amount" class="form-label">Bill paid</label>
                            <input type="number" step="0.01" class="form-control" id="amount" name="amount" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="account_head_id" class="form-label">paid method</label>
                            <select class="form-select" id="account_head_id" name="account_head_id" required>
                                <option value="">Select paid method</option>
                                <?php if (!empty($accountHeads)): ?>
                                    <?php foreach ($accountHeads as $head): ?>
                                        <option value="<?= (int) $head['id']; ?>"><?= htmlspecialchars($head['name']); ?></option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="">No paid method available</option>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Submit received</button>
                </form>
            </div>
        </div>

    </div>
</div>

<?php require_once '../component/footer.php'; ?>

