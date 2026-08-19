<?php require_once "../component/header.php"; ?>
<!-- Sidebar Start -->
<?php require_once "../component/sidebar.php"; ?>
<!-- Sidebar End -->

<?php
$id = $_GET['id'];
$type = $_GET['type'] ?? 'payment';
$sql = "SELECT * FROM {$type}_vouchers WHERE id = $id AND deleted_at IS NULL";
$voucher = $crud->common_query($sql)['data'][0];

$details = $crud->common_query("SELECT * FROM {$type}_voucher_details WHERE {$type}_voucher_id = $id");
?>
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-12">
                <h3>Voucher Details</h3>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4>Voucher No: <?= $voucher->voucher_no ?></h4>
                <p>Date: <?= $voucher->voucher_date ?></p>
                <p>Narration: <?= $voucher->narration ?></p>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Account</th>
                            <th>Dr</th>
                            <th>Cr</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($details['data'] as $d) { ?>
                        <tr>
                            <td><?= $d->account_head_id ?></td>
                            <td><?= number_format($d->dr, 2) ?></td>
                            <td><?= number_format($d->cr, 2) ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php require_once "../component/footer.php"; ?>