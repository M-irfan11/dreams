<?php
session_start();
require_once "component/connection.php";

session_destroy();

header("Location: login.php");
exit;
?>