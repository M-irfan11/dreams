<?php

require_once('component/connection.php');

$id = $_GET['id'];

$customer = $crud->common_select("customers", "*", ["customer_id"=>$id]);

if($_POST){
    $data = [
        "name" => $_POST['name'],
        "phone" => $_POST['phone']
    ];

    $crud->common_update("customers", $data, ["customer_id"=>$id]);

    header("Location: list.php");
}
?>

<form method="POST">
<input type="text" name="name" value="<?= $customer['data'][0]->name ?>">
<input type="text" name="phone" value="<?= $customer['data'][0]->phone ?>">
<button>Update</button>
</form>