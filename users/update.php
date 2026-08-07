<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/component/connection.php"; // gives $crud, $base_url, session

if (!isset($_SESSION['is_logged_in']) || !$_SESSION['is_logged_in']) {
    header("Location: {$base_url}login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: {$base_url}users/list.php");
    exit;
}

$id        = (int)($_POST['id'] ?? 0);
$full_name = trim($_POST['full_name'] ?? '');
$email     = trim($_POST['email'] ?? '');
$password  = trim($_POST['password'] ?? '');
$phone     = trim($_POST['phone'] ?? '');
$role_id   = trim($_POST['role_id'] ?? '');
$status    = trim($_POST['status'] ?? 'Active');

if ($id <= 0) {
    $_SESSION['error'] = 'Invalid user selected.';
    header("Location: {$base_url}users/list.php");
    exit;
}

/* ---------------- Validation ---------------- */
$errors = [];
if ($full_name === '') $errors[] = 'Full name is required.';
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'A valid email is required.';
if ($role_id === '' || !is_numeric($role_id)) $errors[] = 'Please select a role.';
if ($password !== '' && strlen($password) < 6) $errors[] = 'Password must be at least 6 characters.';
if (!in_array($status, ['Active', 'Inactive'], true)) $status = 'Active';

if (empty($errors)) {
    $existing = $crud->common_select('users', 'id, email', ['email' => $email]);
    if ($existing['status']) {
        foreach ($existing['data'] as $row) {
            if ((int)$row->id !== $id) {
                $errors[] = 'This email is already used by another user.';
                break;
            }
        }
    }
}

if (!empty($errors)) {
    $_SESSION['error'] = implode(' ', $errors);
    header("Location: {$base_url}users/edit.php?id=" . $id);
    exit;
}

/*
 * NOTE: crud_class.php's common_update() builds the SET clause without
 * escaping values, so we escape everything here ourselves before passing
 * it in, to keep this safe from SQL injection.
 */
$data = [
    'role_id'    => (int)$role_id,
    'full_name'  => $crud->conn->real_escape_string($full_name),
    'email'      => $crud->conn->real_escape_string($email),
    'phone'      => $crud->conn->real_escape_string($phone),
    'status'     => $status,
    'updated_by' => (int)($_SESSION['user_id'] ?? 0),
];

if ($password !== '') {
    $data['password'] = $crud->conn->real_escape_string(password_hash($password, PASSWORD_DEFAULT));
}

$result = $crud->common_update('users', $data, ['id' => $id]);

if ($result['status']) {
    $_SESSION['success'] = 'User updated successfully.';
    header("Location: {$base_url}users/list.php");
} else {
    $_SESSION['error'] = 'Could not update user: ' . $result['message'];
    header("Location: {$base_url}users/edit.php?id=" . $id);
}
exit;
