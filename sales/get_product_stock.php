<?php

require_once '../component/connection.php';

$warehouse_id=!empty($_POST['warehouse_id']) ? $_POST['warehouse_id'] : null;

$products=$crud->common_query("SELECT products.id,products.selling_price, products.product_name, SUM(stocks.quantity) AS stock_available FROM `products` JOIN stocks ON stocks.product_id=products.id where products.deleted_at is null and stocks.warehouse_id = $warehouse_id GROUP by products.id");
$option="<option value=''>Select Product</option>";
if($products['status']){
    foreach($products['data'] as $product){
        $option.="<option value='{$product->id}' data-price='{$product->selling_price}' data-stock='{$product->stock_available}'>{$product->product_name} (Available: {$product->stock_available})</option>";
    }
}
echo $option;