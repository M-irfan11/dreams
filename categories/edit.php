<?php
require_once('../component/header_auth.php');
require_once('../component/connection.php');

$id = $_GET['id'];

$category = $crud->common_select("categories", "*", ["id"=>$id]);

if($_POST){
    $data = [
        "name" => $_POST['name'],
        "description" => $_POST['description']
    ];

    if(!empty($_SESSION['user_id'])){
        $data["updated_by"] = $_SESSION['user_id'];
    }

    $crud->common_update("categories", $data, ["id"=>$id]);

    header("Location: list.php");
    exit;
}
?>

<form method="POST">
<input type="text" name="name" value="<?= $category['data'][0]->name ?>">
<textarea name="description"><?= $category['data'][0]->description ?></textarea>
<button>Update</button>
</form>
