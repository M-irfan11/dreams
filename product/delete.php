<?php
require_once "../component/connection.php";

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $delete = $crud->common_delete("products", ["id" => $id]);

    if ($delete['status']) {
        header("Location: list.php");
        exit;
    } else {
        echo "Delete Failed: " . $delete['message'];
    }

} else {
    echo "Invalid ID";
}