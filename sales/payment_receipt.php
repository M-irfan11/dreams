<?php require_once '../component/header.php'; ?>
<?php require_once '../component/sidebar.php'; ?>
<?php
    // Accept either the voucher id directly, or fall back to the latest voucher for a sale_id
    $voucher_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
    $sale_id    = isset($_GET['sale_id']) ? (int) $_GET['sale_id'] : 0;

    if (!$voucher_id && $sale_id) {
        $latest = $crud->common_query("SELECT id FROM receive_vouchers WHERE source_type='Sales' AND source_id=$sale_id ORDER BY id DESC LIMIT 1");
        if ($latest['status']) {
            $voucher_id = (int) $latest['data'][0]->id;
        }
    }

    if (!$voucher_id) {
        echo "<script>window.location.href = '{$base_url}sales/list.php';</script>";
        exit;
    }

    $voucherResult = $crud->common_query("SELECT * FROM receive_vouchers WHERE id = $voucher_id");
    $voucher = $voucherResult['data'][0] ?? null;

    if (!$voucher) {
        echo "<script>window.location.href = '{$base_url}sales/list.php';</script>";
        exit;
    }

    // Pull the voucher line items along with their account head names
    $detailsResult = $crud->common_query("
        SELECT receive_voucher_details.*, account_heads.account_name
        FROM receive_voucher_details
        JOIN account_heads ON account_heads.id = receive_voucher_details.account_head_id
        WHERE receive_voucher_details.receive_voucher_id = $voucher_id
    ");
    $details = $detailsResult['data'] ?? [];

    // The "paid via" line is whichever detail row is on the debit side
    // (see process_payment.php: the customer's chosen payment method is posted as dr)
    $paidVia = null;
    $totalReceived = 0;
    foreach ($details as $d) {
        if ((float) $d->dr > 0) {
            $paidVia = $d;
            $totalReceived += (float) $d->dr;
        }
    }
?>

<div class="page-wrapper">
    <div class="content">

        <div class="page-header no-print">
            <div class="page-title">
                <h4>Payment Receipt</h4>
                <h6>Auto-generated receipt for voucher <?= htmlspecialchars($voucher->voucher_no) ?></h6>
            </div>
            <div class="page-btn">
                <button onclick="window.print()" class="btn btn-added">
                    <i class="fa fa-print"></i> Print Receipt
                </button>
                <a href="<?= $base_url ?>sales/list.php" class="btn btn-primary">Back to Sales List</a>
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
                    <h3>Payment Receipt</h3>
                    <p class="mb-0">Voucher No: <strong><?= htmlspecialchars($voucher->voucher_no) ?></strong></p>
                    <p class="mb-0">Date: <?= htmlspecialchars(date('d M, Y', strtotime($voucher->voucher_date))) ?></p>
                </div>

                <hr>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Received From:</strong></p>
                        <p><?= htmlspecialchars($voucher->received_from) ?></p>
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
                                <td>Amount Received (Sale #<?= (int) $voucher->source_id ?>)</td>
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
                                <th>Total Received</th>
                                <th class="text-end">৳<?= number_format($totalReceived ?: (float) $voucher->cr, 2) ?></th>
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
                        <p>Customer Signature</p>
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