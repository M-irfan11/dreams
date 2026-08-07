<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/component/connection.php"; // gives $crud, $base_url, session

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    $_SESSION['error'] = 'Invalid user selected.';
    header("Location: {$base_url}users/list.php");
    exit;
}

$error = $_SESSION['error'] ?? '';
unset($_SESSION['error']);

$result = $crud->common_select('users', '*', ['id' => $id]);
if (!$result['status'] || empty($result['data'])) {
    $_SESSION['error'] = 'User not found.';
    header("Location: {$base_url}users/list.php");
    exit;
}
$user = $result['data'][0];

/*
 * NOTE: roles table has no deleted_at column, but common_select() always
 * appends "AND deleted_at IS NULL", which would error on this table.
 * So we query it directly instead.
 */
$roles = [];
$roles_rs = $crud->conn->query("SELECT * FROM roles WHERE status = 1 ORDER BY role_name ASC");
if ($roles_rs) {
    while ($row = $roles_rs->fetch_object()) {
        $roles[] = $row;
    }
}

require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/component/header.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/component/sidebar.php";
?>

<div class="page-wrapper">
  <div class="content">
    <div class="page-header">
      <div class="page-title">
        <h4>Edit User</h4>
        <h6>Update User details</h6>
      </div>
    </div>

    <?php if ($error): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="card">
      <div class="card-body">
        <form method="POST" action="<?= $base_url ?>users/update.php">
          <input type="hidden" name="id" value="<?= (int)$user->id ?>">
          <div class="row">
            <div class="col-lg-6 col-sm-12 col-12">
              <div class="form-group">
                <label>Full Name <span class="text-danger">*</span></label>
                <input type="text" name="full_name" value="<?= htmlspecialchars($user->full_name) ?>" required>
              </div>
            </div>
            <div class="col-lg-6 col-sm-12 col-12">
              <div class="form-group">
                <label>Email <span class="text-danger">*</span></label>
                <input type="email" name="email" value="<?= htmlspecialchars($user->email) ?>" required>
              </div>
            </div>
            <div class="col-lg-6 col-sm-12 col-12">
              <div class="form-group">
                <label>Password <small>(leave blank to keep current password)</small></label>
                <input type="password" name="password">
              </div>
            </div>
            <div class="col-lg-6 col-sm-12 col-12">
              <div class="form-group">
                <label>Phone</label>
                <input type="text" name="phone" value="<?= htmlspecialchars($user->phone ?? '') ?>">
              </div>
            </div>
            <div class="col-lg-6 col-sm-12 col-12">
              <div class="form-group">
                <label>Role <span class="text-danger">*</span></label>
                <select class="select" name="role_id" required>
                  <option value="">Select Role</option>
                  <?php foreach ($roles as $r): ?>
                    <option value="<?= (int)$r->id ?>" <?= ((int)$user->role_id === (int)$r->id) ? 'selected' : '' ?>>
                      <?= htmlspecialchars($r->role_name) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="col-lg-6 col-sm-12 col-12">
              <div class="form-group">
                <label>Status</label>
                <select class="select" name="status">
                  <option value="Active" <?= $user->status === 'Active' ? 'selected' : '' ?>>Active</option>
                  <option value="Inactive" <?= $user->status === 'Inactive' ? 'selected' : '' ?>>Inactive</option>
                </select>
              </div>
            </div>
          </div>
          <div class="col-lg-12">
            <button type="submit" class="btn btn-submit me-2">Update</button>
            <a href="<?= $base_url ?>users/list.php" class="btn btn-cancel">Cancel</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/component/footer.php"; ?>
