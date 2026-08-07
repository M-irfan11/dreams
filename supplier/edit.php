<?php
require_once '../component/connection.php';

if($_POST){

    $id = $_POST['id'];

    $data = [
        "supplier_name"   => $_POST['supplier_name'],
        "contact_person"  => $_POST['contact_person'],
        "phone"           => $_POST['phone'],
        "email"           => $_POST['email'],
        "address"         => $_POST['address'],
        "city"            => $_POST['city'],
        "country"         => $_POST['country'],
        "status"          => $_POST['status'],
        "updated_by"      => $_SESSION['user_id']
    ];

    $result = $crud->common_update('suppliers', $data, ["id" => $id]);

    if($result['status']){
        $_SESSION['message'] = array(
            "type" => "success",
            "title" => "Success",
            "message" => "Supplier updated successfully."
        );
    } else {
        $_SESSION['message'] = array(
            "type" => "danger",
            "title" => "Error",
            "message" => $result['message']
        );
    }
}

echo "<script>window.location='list.php'</script>";
