<?php
 

require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/component/connection.php";

if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true) {
    header("Location: dashboard.php");
    exit;
}
?>
