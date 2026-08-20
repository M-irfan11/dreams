<?php require_once '../component/header.php'; ?>
<?php require_once '../component/sidebar.php'; ?>

<?php
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$return_result = $crud->common_query("SELECT sales_returns.*, customers.name as customer_name, sales.sale_date
    FROM sales_returns
    JOIN customers on customers.id = sales_returns.customer_id
    LEFT JOIN sales on sales.id = sales_returns.sale_id
    WHERE sales_returns.id = $id AND sales_returns.deleted_at IS NULL");

if(!$return_result['status']){
    echo '<div class="page-wrapper"><div class="content"><div class="alert alert-danger">Sales return not found.</div></div></div>';
    require_once '../component/footer.php';
    exit;
}

$return = $return_result['data'][0];

$details_result = $crud->common_query("SELECT sales_return_details.*, products.product_name
    FROM sales_return_details
    JOIN products on products.id = sales_return_details.product_id
    WHERE sales_return_details.sale_return_id = $id
    AND sales_return_details.deleted_at IS NULL");

$total_amount = $return->total_amount;
?>

<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Sales Return Invoice</h4>
                <h6>Sales return invoice details</h6>
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
                        <div class="text-end">
                            <h3>SALES RETURN INVOICE</h3>
                            <p><strong>Return No:</strong> SR-<?php echo $return->id; ?></p>
                            <p><strong>Return Date:</strong> <?php echo htmlspecialchars($return->return_date); ?></p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-sm-6 col-12">
                            <h5>Customer Information</h5>
                            <p><strong>Customer:</strong> <?php echo htmlspecialchars($return->customer_name); ?></p>
                        </div>

                        <div class="col-lg-6 col-sm-6 col-12">
                            <h5>Original Sale</h5>
                            <p><strong>Sale ID:</strong> <?php echo $return->sale_id; ?></p>
                            <p><strong>Sale Date:</strong> <?php echo htmlspecialchars($return->sale_date); ?></p>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table invoice-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product Name</th>
                                    <th>Return Qty</th>
                                    <th>Unit Price</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                if($details_result['status']){
                                    foreach($details_result['data'] as $item){
                                ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo htmlspecialchars($item->product_name); ?></td>
                                    <td><?php echo $item->quantity; ?></td>
                                    <td><?php echo number_format($item->unit_price, 2); ?></td>
                                    <td><?php echo number_format($item->subtotal, 2); ?></td>
                                </tr>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-end"><strong>Total Return Amount:</strong></td>
                                    <td><strong><?php echo number_format($total_amount, 2); ?></strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="row mt-4">
                        <div class="col-lg-12">
                            <p><strong>Return Reason:</strong></p>
                            <p><?php echo htmlspecialchars($return->reason); ?></p>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button onclick="window.print()" class="btn btn-submit">Print Invoice</button>
                        <a href="list.php" class="btn btn-cancel">Back</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<style>
.invoice-box{
    background:#fff;
    padding:30px;
    border:1px solid #ddd;
}
.invoice-header{
    display:flex;
    justify-content:space-between;
    margin-bottom:30px;
}
.invoice-table th,
.invoice-table td{
    padding:10px;
    border:1px solid #ddd;
}
@media print{
    .sidebar,
    .header,
    .page-header,
    .btn{
        display:none !important;
    }
    .page-wrapper{
        margin:0 !important;
    }
    .invoice-box{
        border:0;
    }
}
</style>

<?php require_once '../component/footer.php'; ?>