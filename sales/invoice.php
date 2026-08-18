<?php
require_once '../component/header.php';
require_once '../component/sidebar.php';
include_once '../crud/crud_class.php';
include_once '../component/connection.php';

$id = $_GET['id'];

// Sale information
$sale_query = "
    SELECT sales.*, customers.name AS customer_name
    FROM sales
    LEFT JOIN customers ON customers.id = sales.customer_id
    WHERE sales.id = '$id'
";

$sale_result = $crud->common_query($sale_query);

if(!$sale_result['status']){
    echo "Sale not found";
    exit;
}

$sale = $sale_result['data'][0];

// Sale products
$details_query = "
    SELECT sale_details.*, products.product_name
    FROM sale_details
    LEFT JOIN products ON products.id = sale_details.product_id
    WHERE sale_details.sale_id = '$id'
    AND sale_details.deleted_at IS NULL
";

$details_result = $crud->common_query($details_query);

// Payment
$payment_query = "
    SELECT SUM(amount) AS paid
    FROM payments
    WHERE sale_id = '$id'
    AND deleted_at IS NULL
";

$payment_result = $crud->common_query($payment_query);

$paid = 0;

if($payment_result['status']){
    $paid = $payment_result['data'][0]->paid ?? 0;
}

$subtotal = 0;

foreach($details_result['data'] as $item){
    $subtotal += $item->subtotal;
}

$discount = $sale->discount ?? 0;
$tax = $sale->tax ?? 0;

$grand_total = $subtotal - $discount + $tax;

$due = $grand_total - $paid;
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
        <h4>Sales Invoice</h4>
        <h6>View sales invoice</h6>
    </div>
</div>

<div class="card">

<div class="card-body">

<div class="invoice-box">

<div class="invoice-header">

<div>

<h2>SUPER SHOP</h2>

<p>
Supershop Management System
</p>

</div>

<div>

<div class="invoice-title">
SALES INVOICE
</div>

<p>
Invoice No: INV-<?php echo $sale->id; ?>
</p>

<p>
Date: <?php echo $sale->sale_date; ?>
</p>

</div>

</div>


<div class="row">

<div class="col-md-6">

<h5>Customer Information</h5>

<p>
<strong>Name:</strong>
<?php echo htmlspecialchars($sale->customer_name); ?>
</p>

</div>

<div class="col-md-6">

<h5>Invoice Information</h5>

<p>
<strong>Invoice:</strong>
INV-<?php echo $sale->id; ?>
</p>

<p>
<strong>Date:</strong>
<?php echo $sale->sale_date; ?>
</p>

</div>

</div>


<table class="invoice-table">

<thead>

<tr>

<th>#</th>

<th>Product Name</th>

<th>Quantity</th>

<th>Unit Price</th>

<th>Subtotal</th>

</tr>

</thead>

<tbody>

<?php

$i = 1;

foreach($details_result['data'] as $item){

?>

<tr>

<td>
<?php echo $i++; ?>
</td>

<td>
<?php echo htmlspecialchars($item->product_name); ?>
</td>

<td>
<?php echo $item->quantity; ?>
</td>

<td>
<?php echo number_format($item->unit_price,2); ?>
</td>

<td>
<?php echo number_format($item->subtotal,2); ?>
</td>

</tr>

<?php } ?>

</tbody>

</table>


<div class="total-box">

<table>

<tr>
<td>
<strong>Subtotal</strong>
</td>

<td class="text-end">
<?php echo number_format($subtotal,2); ?>
</td>
</tr>


<tr>
<td>
<strong>Discount</strong>
</td>

<td class="text-end">
<?php echo number_format($discount,2); ?>
</td>
</tr>


<tr>
<td>
<strong>Tax</strong>
</td>

<td class="text-end">
<?php echo number_format($tax,2); ?>
</td>
</tr>


<tr>

<td>
<strong>Grand Total</strong>
</td>

<td class="text-end">
<strong>
<?php echo number_format($grand_total,2); ?>
</strong>
</td>

</tr>


<tr>

<td>
<strong>Paid</strong>
</td>

<td class="text-end">
<?php echo number_format($paid,2); ?>
</td>

</tr>


<tr>

<td>
<strong>Due</strong>
</td>

<td class="text-end">

<strong>
<?php echo number_format($due,2); ?>
</strong>

</td>

</tr>

</table>

</div>


<div class="mt-5">

<p>
<strong>Thank you for your purchase!</strong>
</p>

</div>


<div class="print-btn">

<button onclick="window.print()" class="btn btn-primary">
Print Invoice
</button>

<a href="list.php" class="btn btn-secondary">
Back
</a>

</div>

</div>

</div>

</div>

</div>

</div>