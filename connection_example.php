<?php
    session_start();
    $base_url = "http://localhost/dreams/";
    require_once  ($_SERVER['DOCUMENT_ROOT'] . "/dreams/crud/crud_class.php");
    $crud = new crud_class();
?>