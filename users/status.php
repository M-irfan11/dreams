<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/component/connection.php"; // gives $crud, $base_url, session

header('Content-Type: application/json');

if (!isset($_SESSION['is_logged_in']) || !$_SESSION['is_logged_in']) {
    echo json_encode(['status' => false, 'message' => 'Not authenticated.']);
    exit;
}

$response = ['status' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['message'] = 'Invalid request method.';
    echo json_encode($response);
    exit;
}

$id = (int)($_POST['id'] ?? 0);
if ($id <= 0) {
    $response['message'] = 'Invalid user id.';
    echo json_encode($response);
    exit;
}

$existing = $crud->common_select('users', 'id, status', ['id' => $id]);
if (!$existing['status'] || empty($existing['data'])) {
    $response['message'] = 'User not found.';
    echo json_encode($response);
    exit;
}

$current_status = $existing['data'][0]->status;
$new_status = ($current_status === 'Active') ? 'Inactive' : 'Active';

$data = [
    'status'     => $new_status,
    'updated_by' => (int)($_SESSION['user_id'] ?? 0),
];

$result = $crud->common_update('users', $data, ['id' => $id]);

if ($result['status']) {
    $response['status']  = true;
    $response['message'] = 'Status updated successfully.';
    $response['new_status'] = $new_status;
} else {
    $response['message'] = 'Could not update status: ' . $result['message'];
}

echo json_encode($response);
exit;
