<?php
/*
 * Simple auth helper functions.
 *
 * Include this AFTER connection.php (needs $_SESSION to already be started
 * and $base_url to already be set).
 *
 * Usage:
 *   require_once '../component/connection.php';
 *   require_once '../component/auth.php';
 *   require_login();                     // any logged-in user
 *   require_role(['Super Admin']);       // only Super Admin
 *   require_role(['Super Admin','Admin']); // Super Admin OR Admin
 */

function require_login() {
    if (!isset($_SESSION['is_logged_in']) || !$_SESSION['is_logged_in']) {
        global $base_url;
        header("Location: {$base_url}login.php");
        exit;
    }
}

function require_role($allowed_roles) {
    // being logged in is a prerequisite for having a role
    require_login();

    $current_role = $_SESSION['user_role'] ?? '';

    if (!in_array($current_role, $allowed_roles, true)) {
        global $base_url;
        $_SESSION['message'] = [
            "type" => "danger",
            "title" => "Access Denied",
            "message" => "You do not have permission to access that page."
        ];
        header("Location: {$base_url}dashboard.php");
        exit;
    }
}
