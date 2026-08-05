<?php
require_once('../component/header_auth.php');
require_once('../component/connection.php');

$id = $_GET['id'];

$crud->common_delete("customers", ["customer_id"=>$id]);

header("Location: list.php");