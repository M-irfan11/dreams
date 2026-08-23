<?php require_once '../component/header.php'; ?>
<?php require_once '../component/sidebar.php'; ?>
<?php
    // Accept either the voucher id directly, or fall back to the latest voucher for a purchase_id
    $voucher_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
    $purchase_id    = isset($_GET['purchase_id']) ? (int) $_GET['purchase_id'] : 0;

    if (!$voucher_id && $purchase_id) {
        $latest = $crud->common_query("SELECT id FROM payment_vouchers WHERE source_type='purchases' AND source_id=$purchase_id ORDER BY id DESC LIMIT 1");
        if ($latest['status']) {
            $voucher_id = (int) $latest['data'][0]->id;
        }
    }

    if (!$voucher_id) {
        echo "<script>window.location.href = '{$base_url}purchases/list.php';</script>";
        exit;
    }

    $voucherResult = $crud->common_query("SELECT * FROM payment_vouchers WHERE id = $voucher_id");
    $voucher = $voucherResult['data'][0] ?? null;

    if (!$voucher) {
        echo "<script>window.location.href = '{$base_url}purchases/list.php';</script>";
        exit;
    }

    // Pull the voucher line items along with their account head names
    $detailsResult = $crud->common_query("
        SELECT payment_voucher_details.*, account_heads.account_name
        FROM payment_voucher_details
        JOIN account_heads ON account_heads.id = payment_voucher_details.account_head_id
        WHERE payment_voucher_details.payment_voucher_id = $voucher_id
    ");
    $details = $detailsResult['data'] ?? [];

    // The "paid via" line is whichever detail row is on the debit side
    // (see process_payment.php: the supplier's chosen payment method is posted as dr)
    $paidVia = null;
    $billpaid = 0;
    foreach ($details as $d) {
        if ((float) $d->dr > 0) {
            $paidVia = $d;
            $billpaid += (float) $d->dr;
        }
    }

    // ---- Due calculation ----
    $purchase_id = (int) $voucher->source_id;

    // purchase এর grand total বের করা
    $grand_total = 0;
    if ($purchase_id) {
        $purchaseResult = $crud->common_query("SELECT grand_total FROM purchases WHERE id = $purchase_id");
        if ($purchaseResult['status']) {
            $grand_total = (float) $purchaseResult['data'][0]->grand_total;
        }
    }

    // এই purchase এর জন্য এ পর্যন্ত মোট কত টাকা receive হয়েছে (সব ভাউচার মিলিয়ে)
    $total_paid = 0;
    if ($purchase_id) {
        $totalPaidResult = $crud->common_query("
            SELECT COALESCE(SUM(cr), 0) as total_paid
            FROM payment_vouchers
            WHERE source_type = 'purchases' AND source_id = $purchase_id
        ");
        if ($totalPaidResult['status']) {
            $total_paid = (float) $totalPaidResult['data'][0]->total_paid;
        }
    }

    $due = $grand_total - $total_paid;
?>

<div class="page-wrapper">
    <div class="content">

        <div class="page-header no-print">
            <div class="page-title">
                <h4>Bil Receipt</h4>
                <h6>Auto-generated receipt for voucher <?= htmlspecialchars($voucher->voucher_no) ?></h6>
            </div>
            <div class="page-btn">
                <button onclick="window.print()" class="btn btn-added">
                    <i class="fa fa-print"></i> Print Receipt
                </button>
                <a href="<?= $base_url ?>purchases/list.php" class="btn btn-primary">Back to purchases List</a>
            </div>
        </div>

        <div class="card receipt-card" id="receipt-print-area">
            <div class="card-body">
                <div class="receipt-letterhead text-center mb-4">
                    <img src="<?= $base_url ?>assets/img/logo.png" alt="Dreams POS" style="max-height:60px;">
                    <p class="mb-0 text-muted" style="font-size:13px;">SuperShop &amp; Inventory Management System</p>
                </div>
 
                <hr>

                <div class="receipt-header text-center mb-4">
                    <h3>Bil Receipt</h3>
                    <p class="mb-0">Voucher No: <strong><?= htmlspecialchars($voucher->voucher_no) ?></strong></p>
                    <p class="mb-0">Date: <?= htmlspecialchars(date('d M, Y', strtotime($voucher->voucher_date))) ?></p>
                </div>

                <hr>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Received From:</strong></p>
                        <p><?= htmlspecialchars($voucher->pay_to) ?></p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <p class="mb-1"><strong>Reference:</strong></p>
                        <p><?= htmlspecialchars($voucher->narration) ?></p>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Description</th>
                                <th class="text-end">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>bill paid (purchase #<?= (int) $voucher->source_id ?>)</td>
                                <td class="text-end">৳<?= number_format((float) $voucher->cr, 2) ?></td>
                            </tr>
                            <?php if ($paidVia): ?>
                            <tr>
                                <td>Payment Method: <?= htmlspecialchars($paidVia->account_name) ?></td>
                                <td class="text-end">৳<?= number_format((float) $paidVia->dr, 2) ?></td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>bill paid</th>
                                <th class="text-end">৳<?= number_format($billpaid ?: (float) $voucher->cr, 2) ?></th>
                            </tr>
                            <tr>
                                <th>Grand Total</th>
                                <th class="text-end">৳<?= number_format($grand_total, 2) ?></th>
                            </tr>
                            <tr>
                                <th>Total Paid (all vouchers)</th>
                                <th class="text-end">৳<?= number_format($total_paid, 2) ?></th>
                            </tr>
                            <tr>
                                <th>Due</th>
                                <th class="text-end" style="<?= $due > 0 ? 'color:#dc3545;' : 'color:#28a745;' ?>">
                                    ৳<?= number_format($due, 2) ?>
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="row mt-5 pt-4">
                    <div class="col-md-6">
                        <p class="mb-0">_____________________</p>
                        <p>Received By</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <p class="mb-0">_____________________</p>
                        <p>Supplier Signature</p>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<style>
    @media print {
        /* Hide absolutely everything on the page first... */
        body * {
            visibility: hidden;
        }

        /* ...then bring back only the receipt card and everything inside it */
        #receipt-print-area,
        #receipt-print-area * {
            visibility: visible;
        }

        /* Pull the receipt out of the page layout (sidebar's reserved space,
           header's fixed height, etc.) and pin it to the top-left of the
           printed page so it doesn't inherit any leftover positioning. */
        #receipt-print-area {
            position: absolute;
            top: 0;
            left: 0;
            width: 100% !important;
            margin: 0 !important;
            border: none !important;
            box-shadow: none !important;
        }

        /* Belt-and-suspenders: if the print dialog still reserves space
           for these, collapse them to zero height. */
        .no-print {
            display: none !important;
        }
    }
</style>

<?php require_once '../component/footer.php'; ?>