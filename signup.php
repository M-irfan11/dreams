<?php 
require_once ('component/header_auth.php');

if ($_POST) {

    if ($_POST['password'] !== $_POST['confirm-password']) {
        echo "<script>alert('Password and Confirm Password do not match.');</script>";
    } else {

        $email = $_POST['email'];

        
        $check = $crud->common_select("users", "*", ["email" => $email]);

        if ($check['status'] && count($check['data']) > 0) {
            echo "<script>alert('Email already exists!');</script>";
        } else {

            $data = [
                "full_name" => $_POST['full_name'],
                "email" => $_POST['email'],
                "password" => password_hash($_POST['password'], PASSWORD_DEFAULT),
                "role_id" => 2,
                "status" => "Active"
            ];

            $result = $crud->common_insert('users', $data);

            if ($result['status']) {
                echo "<script>alert('User registered successfully'); window.location='login.php'</script>";
            } else {
                echo "<script>alert('Error: " . $result['message'] . "');</script>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
<title>Sign Up</title>

<link rel="stylesheet" href="assets/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
<link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="account-page">

<div class="main-wrapper">
<div class="account-content">
<div class="login-wrapper">

<div class="login-content">
<div class="login-userset">

<div class="login-logo">
<img src="assets/img/logo.png" alt="">
</div>

<div class="login-userheading">
<h3>Create an Account</h3>
<h4>Continue where you left off</h4>
</div>

<form method="POST">

<div class="form-login">
<label>Full Name</label>
<input type="text" name="full_name" required>
</div>

<div class="form-login">
<label>Email</label>
<input type="email" name="email" required>
</div>

<div class="form-login">
<label>Password</label>
<input type="password" name="password" required>
</div>

<div class="form-login">
<label>Confirm Password</label>
<input type="password" name="confirm-password" required>
</div>

<div class="form-login">
<button type="submit" class="btn btn-primary w-100">Sign Up</button>
</div>

</form>

<div class="text-center mt-3">
Already have an account? <a href="login.php">Login</a>
</div>

</div>
</div>

<div class="login-img">
<img src="assets/img/login.jpg" alt="">
</div>

</div>
</div>
</div>

<script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>