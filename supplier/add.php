<?php
require_once '../component/connection.php';

if($_POST){

    $data = [
        "supplier_name"   => $_POST['supplier_name'],
        "contact_person"  => $_POST['contact_person'],
        "phone"           => $_POST['phone'],
        "email"           => $_POST['email'],
        "address"         => $_POST['address'],
        "city"            => $_POST['city'],
        "country"         => $_POST['country'],
        "status"          => $_POST['status'],
        "created_at"      => date('Y-m-d H:i:s'),
        "created_by"      => $_SESSION['user_id']
    ];

    $result = $crud->common_insert('suppliers', $data);

    if($result['status']){
        $_SESSION['message'] = array(
            "type" => "success",
            "title" => "Success",
            "message" => "Supplier added successfully."
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


