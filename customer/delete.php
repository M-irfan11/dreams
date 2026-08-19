<?php

require_once('../component/connection.php');

$id = $_GET['id'];

$crud->common_delete("customers", ["id"=>$id]);

header("Location: list.php");