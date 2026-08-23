<?php
 
 
    // Define a list of known local environments
    $local_hosts = ['localhost', '127.0.0.1', '::1'];

    if (in_array($_SERVER['HTTP_HOST'], $local_hosts) || in_array($_SERVER['REMOTE_ADDR'], $local_hosts)) {
        require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/component/connection.php";
    } else {
        require_once $_SERVER['DOCUMENT_ROOT'] . "/component/connection.php";
    }



if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true) {
    header("Location: index.php");
    exit;
}
?>
