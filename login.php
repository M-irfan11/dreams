<?php 
require_once 'component/header_auth.php'; 

$error = "";

if ($_POST) {
    $email = $crud->conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    // fetch by email only - password is checked separately with password_verify(),
    // since it's a one-way hash and can't be matched inside the SQL query
    $rs = $crud->common_query("
        SELECT users.*, roles.role_name, roles.access
        FROM `users`
        JOIN roles ON roles.id = users.role_id
        WHERE users.email = '$email'
    ");

    if ($rs['status'] && password_verify($password, $rs['data'][0]->password)) {
        $user = $rs['data'][0];
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_name'] = $user->full_name;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_phone'] = $user->phone;
        $_SESSION['user_role'] = $user->role_name;
        $_SESSION['access'] = $user->access;
        $_SESSION['is_logged_in'] = true;

        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid email or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Login - Pos admin template</title>
<link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.jpg">
<link rel="stylesheet" href="assets/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
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
<img src="assets/img/logo.png" alt="img">
</div>
<div class="login-userheading">
    <h3>Sign In</h3>
    <h4>Please login to your account</h4>
</div>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="POST" action="">
<div class="form-login">
    <label>Email</label>
    <div class="form-addons">
        <input type="email" name="email" placeholder="Enter your email address" required>
        <img src="assets/img/icons/mail.svg" alt="img">
    </div>
</div>
<div class="form-login">
    <label>Password</label>
    <div class="pass-group">
        <input type="password" name="password" class="pass-input" placeholder="Enter your password" required>
        <span class="fas toggle-password fa-eye-slash"></span>
    </div>
</div>
<div class="form-login">
    <div class="alreadyuser">
        <h4><a href="forgetpassword.html" class="hover-a">Forgot Password?</a></h4>
    </div>
</div>
<div class="form-login">
    <button type="submit" class="btn btn-login">Sign In</button>
</div>
</form>

<div class="signinform text-center">
<h4>Don't have an account? <a href="signup.php" class="hover-a">Sign Up</a></h4>
</div>
<div class="form-setlogin">
<h4>Or sign up with</h4>
</div>
<div class="form-sociallink">
<ul>
    
<li><a href="javascript:void(0);"><img src="assets/img/icons/google.png" class="me-2" alt="google">Sign Up using Google</a></li>
<li><a href="javascript:void(0);"><img src="assets/img/icons/facebook.png" class="me-2" alt="google">Sign Up using Facebook</a></li>
</ul>
</div>
</div>
</div>
<div class="login-img">
<img src="assets/img/login.jpg" alt="img">
</div>
</div>
</div>
</div>

<script src="assets/js/jquery-3.6.0.min.js"></script>
<script src="assets/js/feather.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/script.js"></script>
</body>
</html>
