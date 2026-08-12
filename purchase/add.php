<?php
<<<<<<< HEAD
require_once '../component/connection.php';

 $crud->conn->begin_transaction();
    $error=0;
    $data = [
        "supplier_id" => $_POST['supplier_id'],
        "purchase_date" => $_POST['purchase_date'],
        "total_amount" => $_POST['total_amount'],
        "discount_amount" => $_POST['discount_amount'],
        "discount_type" => $_POST['discount_type'],
        "vat" => $_POST['vat'],
        "grand_total" => $_POST['grand_total'],
        "ref" => $_POST['ref'],
        "status" => 1,
        "created_at" => date('Y-m-d H:i:s'),
        "created_by" => $_SESSION['user_id']
    ];

    $result = $crud->common_insert('purchases', $data);

    if($result['status']){
        // set opening balance for the product in stock_transfers table
       // <!-- `id`, `purchase_id`, `product_id`, `quantity`, `purchase_price`, `subtotal`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by` -->
       foreach($_POST['product_id'] as $index => $product_id){
            $stock_data = [
                "purchase_id" => $result['data'],
                "product_id" => $product_id,
                "quantity" => $_POST['quantity'][$index],
                "purchase_price" => $_POST['purchase_price'][$index],
                "subtotal" => $_POST['subtotal'][$index],
                "created_at" => date('Y-m-d H:i:s'),
                "created_by" => $_SESSION['user_id']
            ];
            $pd=$crud->common_insert('purchase_details', $stock_data);
            if(!$pd['status']){
                $error++;
            }
            // add stock in stock_transfers table
            $st=$crud->common_insert('stock_transfers', [
                "product_id" => $product_id,
                "quantity" => $_POST['quantity'][$index],
                "status" => 1,
                "transfer_date" => $_POST['purchase_date'],
                "purchase_id" => $result['data'],
                "created_at" => date('Y-m-d H:i:s'),
                "created_by" => $_SESSION['user_id']
            ]);
            if(!$st['status']){
                $error++;
            }
=======
require_once "../component/connection.php";

/*
|--------------------------------------------------------------------------
| Load Warehouses
|--------------------------------------------------------------------------
*/
$warehouse_result = $crud->common_select(
    "warehouses",
    "*",
    [],
    "AND",
    "warehouse_name",
    "ASC"
);

/*
|--------------------------------------------------------------------------
| Load Suppliers
|--------------------------------------------------------------------------
*/
$supplier_result = $crud->common_select(
    "suppliers",
    "*",
    [],
    "AND",
    "supplier_name",
    "ASC"
);

/*
|--------------------------------------------------------------------------
| Load Products
|--------------------------------------------------------------------------
*/
$product_result = $crud->common_select(
    "products",
    "*",
    [],
    "AND",
    "product_name",
    "ASC"
);

$warehouses = $warehouse_result["data"] ?? [];
$suppliers  = $supplier_result["data"] ?? [];
$products   = $product_result["data"] ?? [];

?>

<?php require_once "../component/header.php"; ?>
<?php require_once "../component/sidebar.php"; ?>


<div class="page-wrapper">

    <div class="content">

        <!-- =====================================================
             PAGE HEADER
        ====================================================== -->

        <div class="page-header">

            <div class="page-title">
                <h4>Add Purchase</h4>
                <h6>Create a new purchase</h6>
            </div>

        </div>


        <!-- =====================================================
             PURCHASE FORM
        ====================================================== -->

       <form action="<?php echo $base_url; ?>purchase/store.php" method="POST">

            <div class="card">

                <div class="card-body">

                    <div class="row">

                        <!-- ==============================
                             WAREHOUSE
                        =============================== -->

                        <div class="col-lg-4 col-sm-6 col-12">

                            <div class="form-group">

                                <label>Warehouse <span class="text-danger">*</span></label>

                                <select
                                    name="warehouse_id"
                                    id="warehouse_id"
                                    class="form-control"
                                    required
                                >

                                    <option value="">
                                        Select Warehouse
                                    </option>

                                    <?php if (!empty($warehouses)) { ?>

                                        <?php foreach ($warehouses as $warehouse) { ?>

                                            <option value="<?= (int)$warehouse->id ?>">
                                                <?= htmlspecialchars($warehouse->warehouse_name) ?>
                                            </option>

                                        <?php } ?>

                                    <?php } ?>

                                </select>

                                <?php if (empty($warehouses)) { ?>

                                    <small class="text-danger">
                                        No warehouses available.
                                    </small>

                                <?php } ?>

                            </div>

                        </div>



                        <div class="col-lg-4 col-sm-6 col-12">

                            <div class="form-group">

                                <label>Supplier <span class="text-danger">*</span></label>

                                <select
                                    name="supplier_id"
                                    id="supplier_id"
                                    class="form-control"
                                    required
                                >

                                    <option value="">
                                        Select Supplier
                                    </option>

                                    <?php if (!empty($suppliers)) { ?>

                                        <?php foreach ($suppliers as $supplier) { ?>

                                            <option value="<?= (int)$supplier->id ?>">
                                                <?= htmlspecialchars($supplier->supplier_name) ?>
                                            </option>

                                        <?php } ?>

                                    <?php } ?>

                                </select>

                                <?php if (empty($suppliers)) { ?>

                                    <small class="text-danger">
                                        No suppliers available.
                                    </small>

                                <?php } ?>

                            </div>

                        </div>


                       

                        <div class="col-lg-4 col-sm-6 col-12">

                            <div class="form-group">

                                <label>
                                    Purchase Date
                                    <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="date"
                                    name="purchase_date"
                                    class="form-control"
                                    value="<?= date('Y-m-d') ?>"
                                    required
                                >

                            </div>

                        </div>


                        

                        <div class="col-lg-4 col-sm-6 col-12">

                            <div class="form-group">

                                <label>Reference</label>

                                <input
                                    type="text"
                                    name="ref"
                                    class="form-control"
                                    placeholder="Reference / Invoice No."
                                >

                            </div>

                        </div>

                    </div>

                </div>

            </div>


         

            <div class="card">

                <div class="card-header">

                    <h5>Purchase Products</h5>

                </div>


                <div class="card-body">

                    <div class="table-responsive">

                        <table
                            class="table table-bordered"
                            id="productTable"
                        >

                            <thead>

                                <tr>

                                    <th style="min-width:220px;">
                                        Product
                                    </th>

                                    <th style="width:120px;">
                                        Quantity
                                    </th>

                                    <th style="width:150px;">
                                        Purchase Price
                                    </th>

                                    <th style="width:150px;">
                                        Subtotal
                                    </th>

                                    <th style="width:80px;">
                                        Action
                                    </th>

                                </tr>

                            </thead>


                            <tbody id="productRows">

                                <!-- First Row -->

                                <tr class="product-row">

                                    <!-- PRODUCT -->

                                    <td>

                                        <select
                                            name="product_id[]"
                                            class="form-control product-select"
                                            required
                                        >

                                            <option value="">
                                                Select Product
                                            </option>

                                            <?php if (!empty($products)) { ?>

                                                <?php foreach ($products as $product) { ?>

                                                    <option
                                                        value="<?= (int)$product->id ?>"
                                                        data-price="<?= htmlspecialchars($product->purchase_price ?? 0) ?>"
                                                    >
                                                        <?= htmlspecialchars($product->product_name) ?>

                                                        <?php if (!empty($product->brand)) { ?>
                                                            - <?= htmlspecialchars($product->brand) ?>
                                                        <?php } ?>

                                                    </option>

                                                <?php } ?>

                                            <?php } ?>

                                        </select>

                                        <?php if (empty($products)) { ?>

                                            <small class="text-danger">
                                                No products available.
                                            </small>

                                        <?php } ?>

                                    </td>


                                

                                    <td>

                                        <input
                                            type="number"
                                            name="quantity[]"
                                            class="form-control quantity"
                                            value="1"
                                            min="1"
                                            step="1"
                                            required
                                        >

                                    </td>


                                   

                                    <td>

                                        <input
                                            type="number"
                                            name="purchase_price[]"
                                            class="form-control purchase-price"
                                            value="0"
                                            min="0"
                                            step="0.01"
                                            required
                                        >

                                    </td>



                                    <td>

                                        <input
                                            type="number"
                                            name="subtotal[]"
                                            class="form-control subtotal"
                                            value="0"
                                            readonly
                                        >

                                    </td>


                                   

                                    <td class="text-center">

                                        <button
                                            type="button"
                                            class="btn btn-danger remove-row"
                                        >
                                            <i class="fa fa-trash"></i>
                                        </button>

                                    </td>

                                </tr>

                            </tbody>

                        </table>

                    </div>



                    <button
                        type="button"
                        id="addProduct"
                        class="btn btn-primary mt-3"
                    >
                        <i class="fa fa-plus"></i>
                        Add Product
                    </button>

                </div>

            </div>


          

            <div class="card">

                <div class="card-body">

                    <div class="row justify-content-end">

                        <div class="col-lg-5 col-md-7 col-sm-12">


                            <!-- TOTAL AMOUNT -->

                            <div class="form-group row">

                                <label class="col-sm-6 col-form-label">
                                    Total Amount
                                </label>

                                <div class="col-sm-6">

                                    <input
                                        type="number"
                                        name="total_amount"
                                        id="total_amount"
                                        class="form-control"
                                        value="0"
                                        step="0.01"
                                        readonly
                                    >

                                </div>

                            </div>


                         

                            <div class="form-group row">

                                <label class="col-sm-6 col-form-label">
                                    Discount Type
                                </label>

                                <div class="col-sm-6">

                                    <select
                                        name="discount_type"
                                        id="discount_type"
                                        class="form-control"
                                    >

                                        <option value="amount">
                                            Fixed Amount
                                        </option>

                                        <option value="percentage">
                                            Percentage (%)
                                        </option>

                                    </select>

                                </div>

                            </div>


                            <!-- DISCOUNT -->

                            <div class="form-group row">

                                <label class="col-sm-6 col-form-label">
                                    Discount
                                </label>

                                <div class="col-sm-6">

                                    <input
                                        type="number"
                                        name="discount_amount"
                                        id="discount_amount"
                                        class="form-control"
                                        value="0"
                                        min="0"
                                        step="0.01"
                                    >

                                </div>

                            </div>


                            <!-- VAT -->

                            <div class="form-group row">

                                <label class="col-sm-6 col-form-label">
                                    VAT / Tax (%)
                                </label>

                                <div class="col-sm-6">

                                    <input
                                        type="number"
                                        name="vat"
                                        id="vat"
                                        class="form-control"
                                        value="5"
                                        min="0"
                                        step="0.01"
                                    >

                                </div>

                            </div>


                            <!-- GRAND TOTAL -->

                            <div class="form-group row">

                                <label class="col-sm-6 col-form-label">
                                    <strong>Grand Total</strong>
                                </label>

                                <div class="col-sm-6">

                                    <input
                                        type="number"
                                        name="grand_total"
                                        id="grand_total"
                                        class="form-control"
                                        value="0"
                                        step="0.01"
                                        readonly
                                    >

                                </div>

                            </div>


                        </div>

                    </div>

                </div>

            </div>


            <!-- =====================================================
                 BUTTONS
            ====================================================== -->

            <div class="card">

                <div class="card-body">

                    <button
                        type="submit"
                        class="btn btn-success"
                    >
                        <i class="fa fa-save"></i>
                        Save Purchase
                    </button>

                    <a
                        href="list.php"
                        class="btn btn-secondary"
                    >
                        Cancel
                    </a>

                </div>

            </div>


        </form>

    </div>

</div>


<!-- =============================================================
     JAVASCRIPT
============================================================== -->

<script>

document.addEventListener("DOMContentLoaded", function () {


    /*
    |--------------------------------------------------------------------------
    | Add Product Row
    |--------------------------------------------------------------------------
    */

    const addProductButton =
        document.getElementById("addProduct");

    const productRows =
        document.getElementById("productRows");


    addProductButton.addEventListener("click", function () {

        const firstRow =
            productRows.querySelector(".product-row");

        const newRow =
            firstRow.cloneNode(true);


        /*
        | Reset values
        */

        newRow.querySelector(".product-select").value = "";

        newRow.querySelector(".quantity").value = 1;

        newRow.querySelector(".purchase-price").value = 0;

        newRow.querySelector(".subtotal").value = 0;


        productRows.appendChild(newRow);

    });


    /*
    |--------------------------------------------------------------------------
    | Remove Product Row
    |--------------------------------------------------------------------------
    */

    productRows.addEventListener("click", function (event) {

        const button =
            event.target.closest(".remove-row");

        if (!button) {
            return;
>>>>>>> b909d02b82be3b4237510179e503cd15ac547ac9
        }
      
        if($result['status'] && $error==0){
            $crud->conn->commit();
             $_SESSION['message'] = array(
                "type" => "success",
                "title" => "Success",
                "message" => "Product added successfully."
            );
        } else {
            $crud->conn->rollback();
                $_SESSION['message'] = array(
                    "type" => "danger",
                    "title" => "Error",
                    "message" => $result['message']
                );
        }

       
    } else {
        $_SESSION['message'] = array(
            "type" => "danger",
            "title" => "Error",
            "message" => $result['message']
        );
    }


<<<<<<< HEAD
echo "<script>window.location='list.php'</script>";
=======
    /*
    |--------------------------------------------------------------------------
    | Initial Calculation
    |--------------------------------------------------------------------------
    */

    calculateTotal();




    document
        .getElementById("purchaseForm")
        .addEventListener("submit", function (event) {


            const warehouse =
                document.getElementById("warehouse_id").value;


            const supplier =
                document.getElementById("supplier_id").value;


            if (!warehouse) {

                event.preventDefault();

                alert("Please select a warehouse.");

                return;
            }


            if (!supplier) {

                event.preventDefault();

                alert("Please select a supplier.");

                return;
            }


            const products =
                document.querySelectorAll(".product-select");


            let validProduct = false;


            products.forEach(function (product) {

                if (product.value !== "") {
                    validProduct = true;
                }

            });


            if (!validProduct) {

                event.preventDefault();

                alert("Please select at least one product.");

                return;
            }


            /*
            | Recalculate before submit
            */

            calculateTotal();

        });

});

</script>


<?php require_once "../component/footer.php"; ?>
>>>>>>> b909d02b82be3b4237510179e503cd15ac547ac9
