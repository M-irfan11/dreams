<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/component/connection.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/crud/crud_class.php";

$crud = new crud_class();

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // soft delete: row database theke mocha hobe na, deleted_at set hobe
    $crud->common_update(
        "chart_of_accounts",
        ["deleted_at" => date('Y-m-d H:i:s')],
        ["account_id" => $id]
    );
}

header("Location: {$base_url}accounts/list.php");
exit;
