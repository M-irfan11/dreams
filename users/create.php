<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/component/connection.php"; // gives $crud, $base_url, session

if (!isset($_SESSION['is_logged_in']) || !$_SESSION['is_logged_in']) {
    header("Location: {$base_url}login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: {$base_url}users/add.php");
    exit;
}

$full_name = trim($_POST['full_name'] ?? '');
$email     = trim($_POST['email'] ?? '');
$password  = trim($_POST['password'] ?? '');
$phone     = trim($_POST['phone'] ?? '');
$role_id   = trim($_POST['role_id'] ?? '');
$status    = trim($_POST['status'] ?? 'Active');

$_SESSION['old'] = $_POST;

/* ---------------- Validation ---------------- */
$errors = [];
if ($full_name === '') $errors[] = 'Full name is required.';
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'A valid email is required.';
if ($password === '' || strlen($password) < 6) $errors[] = 'Password must be at least 6 characters.';
if ($role_id === '' || !is_numeric($role_id)) $errors[] = 'Please select a role.';
if (!in_array($status, ['Active', 'Inactive'], true)) $status = 'Active';

if (empty($errors)) {
    $existing = $crud->common_select('users', 'id', ['email' => $email]);
    if ($existing['status']) {
        $errors[] = 'This email is already registered.';
    }
}

if (!empty($errors)) {
    $_SESSION['error'] = implode(' ', $errors);
    header("Location: {$base_url}users/add.php");
    exit;
}

$data = [
    'role_id'    => (int)$role_id,
    'full_name'  => $full_name,
    'email'      => $email,
    'password'   => password_hash($password, PASSWORD_DEFAULT),
    'phone'      => $phone,
    'status'     => $status,
    'created_by' => $_SESSION['user_id'] ?? null,
];

$result = $crud->common_insert('users', $data);

if ($result['status']) {
    unset($_SESSION['old']);
    $_SESSION['success'] = 'User created successfully.';
    header("Location: {$base_url}users/list.php");
} else {
    $_SESSION['error'] = 'Could not create user: ' . $result['message'];
    header("Location: {$base_url}users/add.php");
}
exit;
