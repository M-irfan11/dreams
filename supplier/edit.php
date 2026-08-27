<?php
session_start();
require_once '../component/connection.php';

// ---------- যখন ফর্ম Submit হবে (POST) ----------
if($_POST){

    $id = $_POST['id'];

    $data = [
        "name"   => $_POST['name'],
        "contact_person"  => $_POST['contact_person'],
        "phone"           => $_POST['phone'],
        "email"           => $_POST['email'],
        "address"         => $_POST['address'],
        "city"            => $_POST['city'],
        "country"         => $_POST['country'],
        "status"          => $_POST['status'],
        "updated_by"      => $_SESSION['user_id']
    ];

    $result = $crud->common_update('suppliers', $data, ["id" => $id]);

    if($result['status']){
        $_SESSION['message'] = array(
            "type" => "success",
            "title" => "Success",
            "message" => "Supplier updated successfully."
        );
    } else {
        $_SESSION['message'] = array(
            "type" => "danger",
            "title" => "Error",
            "message" => $result['message']
        );
    }

    echo "<script>window.location='list.php'</script>";
    exit;
}

// ---------- যখন Edit লিংকে ক্লিক করে আসবে (GET) ----------
if(isset($_GET['id'])){

    $id = $_GET['id'];
    $result = $crud->common_select('suppliers', '*', ["id" => $id]);

    if(!empty($result['data'])){
        $supplier = $result['data'][0];
    } else {
        echo "<script>window.location='list.php'</script>";
        exit;
    }

} else {
    echo "<script>window.location='list.php'</script>";
    exit;
}
?>

<?php require_once('../component/header.php'); ?>
<?php require_once('../component/sidebar.php'); ?>

<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <h4>Edit Supplier</h4>
            <a href="list.php" class="btn btn-secondary">Back to List</a>
        </div>

        <form action="edit.php" method="POST">
            <input type="hidden" name="id" value="<?= $supplier->id; ?>">

            <div class="mb-3">
                <label>Supplier Name</label>
                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($supplier->name); ?>" required>
            </div>

            <div class="mb-3">
                <label>Contact Person</label>
                <input type="text" name="contact_person" class="form-control" value="<?= htmlspecialchars($supplier->contact_person); ?>">
            </div>

            <div class="mb-3">
                <label>Phone</label>
                <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($supplier->phone); ?>">
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($supplier->email); ?>">
            </div>

            <div class="mb-3">
                <label>Address</label>
                <input type="text" name="address" class="form-control" value="<?= htmlspecialchars($supplier->address); ?>">
            </div>

            <div class="mb-3">
                <label>City</label>
                <input type="text" name="city" class="form-control" value="<?= htmlspecialchars($supplier->city); ?>">
            </div>

            <div class="mb-3">
                <label>Country</label>
                <input type="text" name="country" class="form-control" value="<?= htmlspecialchars($supplier->country); ?>">
            </div>

            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="1" <?= $supplier->status == 1 ? 'selected' : ''; ?>>Active</option>
                    <option value="0" <?= $supplier->status == 0 ? 'selected' : ''; ?>>Inactive</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update Supplier</button>
        </form>

    </div>
</div>

<?php include('../component/footer.php'); ?>