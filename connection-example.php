<?php
    session_start();
    $base_url = "http://localhost/supper-shop/";
    require_once  ($_SERVER['DOCUMENT_ROOT'] . "/supper-shop/crud/crud_class.php");
    $crud = new crud_class();
?>
