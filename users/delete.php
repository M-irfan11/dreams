<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/component/connection.php"; // gives $crud, $base_url, session

if (!isset($_SESSION['is_logged_in']) || !$_SESSION['is_logged_in']) {
    header("Location: {$base_url}login.php");
    exit;
}

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    $_SESSION['error'] = 'Invalid user selected.';
    header("Location: {$base_url}users/list.php");
    exit;
}

/* Prevent a user from deleting their own account */
if (isset($_SESSION['user_id']) && (int)$_SESSION['user_id'] === $id) {
    $_SESSION['error'] = 'You cannot delete your own account.';
    header("Location: {$base_url}users/list.php");
    exit;
}

$check = $crud->common_select('users', 'id', ['id' => $id]);
if (!$check['status']) {
    $_SESSION['error'] = 'User not found or already deleted.';
    header("Location: {$base_url}users/list.php");
    exit;
}

/*
 * Soft delete: users table has a deleted_at column, so we set it instead
 * of running a real DELETE (common_delete() would hard-delete the row).
 */
$data = [
    'deleted_at' => date('Y-m-d H:i:s'),
    'updated_by' => (int)($_SESSION['user_id'] ?? 0),
];

$result = $crud->common_update('users', $data, ['id' => $id]);

if ($result['status']) {
    $_SESSION['success'] = 'User deleted successfully.';
} else {
    $_SESSION['error'] = 'Could not delete user: ' . $result['message'];
}
header("Location: {$base_url}users/list.php");
exit;
