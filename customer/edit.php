<?php

require_once('../component/connection.php');

$id = $_GET['id'];

$customer = $crud->common_select("customers", "*", ["id"=>$id]);

if($_POST){
    $data = [
        "name"  => $_POST['name'],
        "phone" => $_POST['phone'],
        "email" => $_POST['email']
    ];

    $crud->common_update("customers", $data, ["id"=>$id]);

    header("Location: list.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Customer</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<?php require_once('../component/header.php'); ?>
<?php require_once('../component/sidebar.php'); ?>

<div class="content" style="margin-left:220px; padding:30px;">
    <h4 class="mb-4">Edit Customer</h4>

    <div class="card" style="max-width:500px;">
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control"
                           value="<?= htmlspecialchars($customer['data'][0]->name) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control"
                           value="<?= htmlspecialchars($customer['data'][0]->phone) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control"
                           value="<?= htmlspecialchars($customer['data'][0]->email ?? '') ?>">
                </div>

                <button type="submit" class="btn btn-warning">Update</button>
                <a href="list.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>

</body>
</html>
<?php require_once('../component/footer.php'); ?>