<?php
require_once '../component/header.php';
require_once '../component/sidebar.php';
include_once '../crud/crud_class.php';
include_once '../component/connection.php';

$id = $_GET['id'];

// Purchase information
$purchase_query = "
    SELECT purchases.*, suppliers.supplier_name AS supplier_name
    FROM purchases
    LEFT JOIN suppliers ON suppliers.id = purchases.supplier_id
    WHERE purchases.id = '$id'
";
$purchase_result = $crud->common_query($purchase_query);

if(!$purchase_result['status']){
    echo "Purchase not found";
    exit;
}

$purchase = $purchase_result['data'][0];

// Purchase products
$details_query = "
    SELECT purchase_details.*, products.product_name
    FROM purchase_details
    LEFT JOIN products ON products.id = purchase_details.product_id
    WHERE purchase_details.purchase_id = '$id'
    AND purchase_details.deleted_at IS NULL
";
$details_result = $crud->common_query($details_query);

// purchases table already stores the final discount/vat/grand total
// (calculated on the create form), so we just show them as-is - no
// payments table exists for purchases yet, so there's no Paid/Due here
$subtotal = $purchase->total_amount ?? 0;
$discount = $purchase->discount_amount ?? 0;
$vat = $purchase->vat ?? 0;
$grand_total = $purchase->grand_total ?? 0;
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
        <h4>Purchase Invoice</h4>
        <h6>View purchase invoice</h6>
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
        <div class="invoice-title">PURCHASE INVOICE</div>
        <p>Invoice No: PUR-<?php echo $purchase->id; ?></p>
        <p>Date: <?php echo $purchase->purchase_date; ?></p>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <h5>Supplier Information</h5>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($purchase->supplier_name); ?></p>
    </div>
    <div class="col-md-6">
        <h5>Invoice Information</h5>
        <p><strong>Invoice:</strong> PUR-<?php echo $purchase->id; ?></p>
        <p><strong>Reference:</strong> <?php echo htmlspecialchars($purchase->ref); ?></p>
        <p><strong>Date:</strong> <?php echo $purchase->purchase_date; ?></p>
    </div>
</div>

<table class="invoice-table">
    <thead>
        <tr>
            <th>#</th>
            <th>Product Name</th>
            <th>Quantity</th>
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
            <td><?php echo number_format($item->purchase_price,2); ?></td>
            <td><?php echo number_format($item->subtotal,2); ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<div class="total-box">
    <table>
        <tr>
            <td><strong>Subtotal</strong></td>
            <td class="text-end"><?php echo number_format($subtotal,2); ?></td>
        </tr>
        <tr>
            <td><strong>Discount</strong></td>
            <td class="text-end">
                <?php
                    if($purchase->discount_type == 2){
                        echo number_format($discount,2) . '%';
                    } else {
                        echo number_format($discount,2);
                    }
                ?>
            </td>
        </tr>
        <tr>
            <td><strong>VAT</strong></td>
            <td class="text-end"><?php echo number_format($vat,2); ?></td>
        </tr>
        <tr>
            <td><strong>Grand Total</strong></td>
            <td class="text-end"><strong><?php echo number_format($grand_total,2); ?></strong></td>
        </tr>
    </table>
</div>

<div class="mt-5">
    <p><strong>Thank you for your business!</strong></p>
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
