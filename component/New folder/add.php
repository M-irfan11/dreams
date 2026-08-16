<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/component/connection.php"; // gives $crud, $base_url, session
require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/component/auth.php";

require_role(['Super Admin', 'Admin']); // per roles.access, both can manage users

$error = $_SESSION['error'] ?? '';
unset($_SESSION['error']);

$old = $_SESSION['old'] ?? [];
unset($_SESSION['old']);

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

// only a Super Admin should even see "Super Admin" as a role option
// (create.php also blocks this server-side, this just keeps the dropdown honest)
if (($_SESSION['user_role'] ?? '') !== 'Super Admin') {
    $roles = array_filter($roles, function($r) {
        return $r->role_name !== 'Super Admin';
    });
}

require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/component/header.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/component/sidebar.php";
?>

<div class="page-wrapper">
  <div class="content">
    <div class="page-header">
      <div class="page-title">
        <h4>Add User</h4>
        <h6>Create new User</h6>
      </div>
    </div>

    <?php if ($error): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="card">
      <div class="card-body">
        <form method="POST" action="<?= $base_url ?>users/create.php">
          <div class="row">
            <div class="col-lg-6 col-sm-12 col-12">
              <div class="form-group">
                <label>Full Name <span class="text-danger">*</span></label>
                <input type="text" name="full_name" value="<?= htmlspecialchars($old['full_name'] ?? '') ?>" required>
              </div>
            </div>
            <div class="col-lg-6 col-sm-12 col-12">
              <div class="form-group">
                <label>Email <span class="text-danger">*</span></label>
                <input type="email" name="email" value="<?= htmlspecialchars($old['email'] ?? '') ?>" required>
              </div>
            </div>
            <div class="col-lg-6 col-sm-12 col-12">
              <div class="form-group">
                <label>Password <span class="text-danger">*</span></label>
                <input type="password" name="password" required>
              </div>
            </div>
            <div class="col-lg-6 col-sm-12 col-12">
              <div class="form-group">
                <label>Phone</label>
                <input type="text" name="phone" value="<?= htmlspecialchars($old['phone'] ?? '') ?>">
              </div>
            </div>
            <div class="col-lg-6 col-sm-12 col-12">
              <div class="form-group">
                <label>Role <span class="text-danger">*</span></label>
                <select class="select" name="role_id" required>
                  <option value="">Select Role</option>
                  <?php foreach ($roles as $r): ?>
                    <option value="<?= (int)$r->id ?>" <?= (isset($old['role_id']) && $old['role_id'] == $r->id) ? 'selected' : '' ?>>
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
                  <option value="Active" <?= (($old['status'] ?? 'Active') === 'Active') ? 'selected' : '' ?>>Active</option>
                  <option value="Inactive" <?= (($old['status'] ?? '') === 'Inactive') ? 'selected' : '' ?>>Inactive</option>
                </select>
              </div>
            </div>
          </div>
          <div class="col-lg-12">
            <button type="submit" class="btn btn-submit me-2">Submit</button>
            <a href="<?= $base_url ?>users/list.php" class="btn btn-cancel">Cancel</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/component/footer.php"; ?>
