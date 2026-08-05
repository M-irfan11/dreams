<?php


require_once('../component/header_auth.php');
require_once('../component/connection.php');

if($_POST){
    $data = [
        "name" => $_POST['name'],
        "gender" => $_POST['gender'],
        "phone" => $_POST['phone'],
        "email" => $_POST['email'],
        "address" => $_POST['address'],
        "membership_type" => $_POST['membership']
    ];

    $result = $crud->common_insert("customers", $data);

    if($result['status']){
        header("Location: list.php");
        exit;
    }
}
?>

<form method="POST">
<input type="text" name="name" placeholder="Name" required><br>
<select name="gender"><br>
<option>Male</option>
<option>Female</option>
<option>Other</option>
</select>
<input type="text" name="phone" placeholder="Phone"><br>
<input type="email" name="email" placeholder="Email"><br>
<textarea name="address"></textarea><br>
<input type="text" name="membership" placeholder="Membership"><br>

<button type="submit">Save</button>
</form>
<?php require_once('../component/footer.php');?>