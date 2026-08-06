<?php
require_once('../component/header_auth.php');
require_once('../component/connection.php');

$id = $_GET['id'];

// categories table te deleted_at column ase, tai soft delete kora hocche
$crud->common_update("categories", ["deleted_at" => date('Y-m-d')], ["categories_id" => $id]);

header("Location: list.php");
