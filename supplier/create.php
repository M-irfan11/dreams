<?php
require_once('../component/connection.php');

if(isset($_POST['submit'])){
    $data = [
        'supplier_name'   => $_POST['supplier_name'],
        'contact_person'  => $_POST['contact_person'],
        'phone'           => $_POST['phone'],
        'email'           => $_POST['email'],
        'address'         => $_POST['address'],
        'city'            => $_POST['city'],
        'country'         => $_POST['country'],
        'status'          => $_POST['status'],
        'created_at'      => date('Y-m-d H:i:s')
    ];

    $result = $crud->common_insert('suppliers', $data);

    if($result['status']){
        header("Location: list.php?msg=added");
        exit;
    }else{
        echo "Error: " . $result['message'];
    }
}
?>

<?php require_once('../component/header.php'); ?>
<?php require_once('../component/sidebar.php'); ?>

<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <h4>Add Supplier</h4>
        </div>

        <form method="POST">
            <div class="row">

                <div class="col-lg-4">
                    <label>Supplier Name *</label>
                    <input type="text" name="supplier_name" class="form-control" required>
                </div>

                <div class="col-lg-4">
                    <label>Contact Person</label>
                    <input type="text" name="contact_person" class="form-control">
                </div>

                <div class="col-lg-4">
                    <label>Phone</label>
                    <input type="text" name="phone" class="form-control">
                </div>

                <div class="col-lg-4 mt-2">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control">
                </div>

                <div class="col-lg-4 mt-2">
                    <label>City</label>
                    <input type="text" name="city" class="form-control">
                </div>

                <div class="col-lg-4 mt-2">
                    <label>Country</label>
                    <input type="text" name="country" class="form-control">
                </div>

                <div class="col-lg-12 mt-2">
                    <label>Address</label>
                    <textarea name="address" class="form-control"></textarea>
                </div>

                <div class="col-lg-4 mt-2">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="1">Active</option>
                        <option value="2">Inactive</option>
                    </select>
                </div>

                <div class="col-lg-12 mt-3">
                    <button type="submit" name="submit" class="btn btn-primary">Save</button>
                    <a href="list.php" class="btn btn-secondary">Back</a>
                </div>

            </div>
        </form>
    </div>
</div>

<?php require_once('../component/footer.php'); ?>