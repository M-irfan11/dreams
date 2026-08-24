<?php
require_once '../component/header.php';
require_once '../component/sidebar.php';

$id = (int)$_GET['id'];

// Purchase return information
$return_query = "
    SELECT purchase_returns.*, suppliers.name AS name
    FROM purchase_returns
    LEFT JOIN suppliers ON suppliers.id = purchase_returns.supplier_id
    WHERE purchase_returns.id = '$id'
    AND purchase_returns.deleted_at IS NULL
";
$return_result = $crud->common_query($return_query);

if(!$return_result['status']){
    echo "Purchase return not found";
    exit;
}

$purchase_return = $return_result['data'][0];

// Returned products
$details_query = "
    SELECT purchase_return_details.*, products.product_name
    FROM purchase_return_details
    LEFT JOIN products ON products.id = purchase_return_details.product_id
    WHERE purchase_return_details.purchase_return_id = '$id'
    AND purchase_return_details.deleted_at IS NULL
";
$details_result = $crud->common_query($details_query);

$subtotal = 0;
foreach($details_result['data'] as $item){
    $subtotal += $item->subtotal;
}

$grand_total = $purchase_return->total_amount ?? 0;
?>

<style>
.invoice-box{
    background:white;
    padding:30px;
    margin-top:20px;
    border:1px solid #ddd;
}
.invoice-header{
    display:flex;
    justify-content:space-between;
    margin-bottom:30px;
}
.invoice-title{
    font-size:28px;
    font-weight:bold;
}
.invoice-table{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
}
.invoice-table th,
.invoice-table td{
    border:1px solid #ddd;
    padding:10px;
}
.invoice-table th{
    background:#f5f5f5;
}
.total-box{
    width:350px;
    margin-left:auto;
    margin-top:20px;
}
.total-box table{
    width:100%;
}
.total-box td{
    padding:8px;
}
.print-btn{
    margin-top:20px;
}
@media print{
    .sidebar,
    .header,
    .page-header,
    .print-btn{
        display:none !important;
    }
    .page-wrapper{
        margin:0 !important;
    }
    .invoice-box{
        border:none;
    }
}
</style>

<div class="page-wrapper">
<div class="content">

<div class="page-header">
    <div class="page-title">
        <h4>Purchase Return Invoice</h4>
        <h6>View purchase return invoice</h6>
    </div>
</div>

<div class="card">
<div class="card-body">
<div class="invoice-box">

<div class="invoice-header">
    <div>
        <h2>SUPER SHOP</h2>
        <p>Supershop Management System</p>
    </div>
    <div>
        <div class="invoice-title">PURCHASE RETURN</div>
        <p>Return No: PR-<?php echo $purchase_return->id; ?></p>
        <p>Against Purchase: PUR-<?php echo $purchase_return->purchase_id; ?></p>
        <p>Date: <?php echo $purchase_return->return_date; ?></p>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <h5>Supplier Information</h5>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($purchase_return->name); ?></p>
    </div>
    <div class="col-md-6">
        <h5>Return Information</h5>
        <p><strong>Return No:</strong> PR-<?php echo $purchase_return->id; ?></p>
        <p><strong>Date:</strong> <?php echo $purchase_return->return_date; ?></p>
        <p>
            <strong>Status:</strong>
            <?php echo $purchase_return->status == 1 ? '<span class="badges bg-lightgreen">Active</span>' : '<span class="badges bg-lightred">Cancelled</span>'; ?>
        </p>
    </div>
</div>

<table class="invoice-table">
    <thead>
        <tr>
            <th>#</th>
            <th>Product Name</th>
            <th>Return Qty</th>
            <th>Purchase Price</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1; foreach($details_result['data'] as $item){ ?>
        <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo htmlspecialchars($item->product_name); ?></td>
            <td><?php echo $item->quantity; ?></td>
            <td><?php echo number_format($item->unit_price,2); ?></td>
            <td><?php echo number_format($item->subtotal,2); ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<?php if(!empty($purchase_return->reason)){ ?>
<p class="mt-3"><strong>Return Reason:</strong> <?php echo htmlspecialchars($purchase_return->reason); ?></p>
<?php } ?>

<div class="total-box">
    <table>
        <tr>
            <td><strong>Subtotal</strong></td>
            <td class="text-end"><?php echo number_format($subtotal,2); ?></td>
        </tr>
        <tr>
            <td><strong>Total Return Amount</strong></td>
            <td class="text-end"><strong><?php echo number_format($grand_total,2); ?></strong></td>
        </tr>
    </table>
</div>

<div class="mt-5">
    <p><strong>This is a record of returned goods.</strong></p>
</div>

<div class="print-btn">
    <button onclick="window.print()" class="btn btn-primary">Print Invoice</button>
    <a href="list.php" class="btn btn-secondary">Back</a>
</div>

</div>
</div>
</div>

</div>
</div>
