<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/component/connection.php"; // gives $crud, $base_url, session

$success = $_SESSION['success'] ?? '';
$error   = $_SESSION['error'] ?? '';
unset($_SESSION['success'], $_SESSION['error']);

/* ---------------- Filters (GET) ---------------- */
$f_name   = trim($_GET['name'] ?? '');
$f_phone  = trim($_GET['phone'] ?? '');
$f_email  = trim($_GET['email'] ?? '');
$f_status = trim($_GET['status'] ?? '');

$sql = "SELECT users.*, roles.role_name AS role_name
        FROM users
        LEFT JOIN roles ON users.role_id = roles.id";

/*
 * NOTE: built and run directly (instead of common_query()) because
 * common_query() appends "WHERE deleted_at IS NULL" at the very end of
 * the SQL string, which breaks once ORDER BY is already present.
 */
$conditions = ["users.deleted_at IS NULL"];
if ($f_name !== '') {
    $conditions[] = "users.full_name LIKE '%" . $crud->conn->real_escape_string($f_name) . "%'";
}
if ($f_phone !== '') {
    $conditions[] = "users.phone LIKE '%" . $crud->conn->real_escape_string($f_phone) . "%'";
}
if ($f_email !== '') {
    $conditions[] = "users.email LIKE '%" . $crud->conn->real_escape_string($f_email) . "%'";
}
if ($f_status !== '' && in_array($f_status, ['Active', 'Inactive'], true)) {
    $conditions[] = "users.status = '" . $crud->conn->real_escape_string($f_status) . "'";
}
$sql .= " WHERE " . implode(" AND ", $conditions);
$sql .= " ORDER BY users.id DESC";

$users = [];
$rs = $crud->conn->query($sql);
if ($rs) {
    while ($row = $rs->fetch_object()) {
        $users[] = $row;
    }
}

require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/component/header.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/component/sidebar.php";
?>

<div class="page-wrapper">
  <div class="content">
    <div class="page-header">
      <div class="page-title">
        <h4>User List</h4>
        <h6>Manage your User</h6>
      </div>
      <div class="page-btn">
        <a href="<?= $base_url ?>users/add.php" class="btn btn-added"><img src="<?= $base_url ?>assets/img/icons/plus.svg" alt="img" class="me-2">Add User</a>
      </div>
    </div>

    <?php if ($success): ?>
      <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="card">
      <div class="card-body">
        <div class="table-top">
          <div class="search-set">
            <div class="search-path">
              <a class="btn btn-filter" id="filter_search">
                <img src="<?= $base_url ?>assets/img/icons/filter.svg" alt="img">
                <span><img src="<?= $base_url ?>assets/img/icons/closes.svg" alt="img"></span>
              </a>
            </div>
          </div>
        </div>

        <div class="card" id="filter_inputs">
          <div class="card-body pb-0">
            <form method="GET" action="<?= $base_url ?>users/list.php" class="row">
              <div class="col-lg-2 col-sm-6 col-12">
                <div class="form-group">
                  <input type="text" name="name" value="<?= htmlspecialchars($f_name) ?>" placeholder="Enter User Name">
                </div>
              </div>
              <div class="col-lg-2 col-sm-6 col-12">
                <div class="form-group">
                  <input type="text" name="phone" value="<?= htmlspecialchars($f_phone) ?>" placeholder="Enter Phone">
                </div>
              </div>
              <div class="col-lg-2 col-sm-6 col-12">
                <div class="form-group">
                  <input type="text" name="email" value="<?= htmlspecialchars($f_email) ?>" placeholder="Enter Email">
                </div>
              </div>
              <div class="col-lg-2 col-sm-6 col-12">
                <div class="form-group">
                  <select class="select" name="status">
                    <option value="">All</option>
                    <option value="Active" <?= $f_status === 'Active' ? 'selected' : '' ?>>Active</option>
                    <option value="Inactive" <?= $f_status === 'Inactive' ? 'selected' : '' ?>>Inactive</option>
                  </select>
                </div>
              </div>
              <div class="col-lg-1 col-sm-6 col-12 ms-auto">
                <div class="form-group">
                  <button type="submit" class="btn btn-filters ms-auto">
                    <img src="<?= $base_url ?>assets/img/icons/search-whites.svg" alt="img">
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>

        <div class="table-responsive">
          <table class="table datanew">
            <thead>
              <tr>
                <th>
                  <label class="checkboxs">
                    <input type="checkbox">
                    <span class="checkmarks"></span>
                  </label>
                </th>
                <th>Full name</th>
                <th>Role</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($users)): ?>
                <tr><td colspan="7" class="text-center">No records found</td></tr>
              <?php else: ?>
                <?php foreach ($users as $u): ?>
                  <tr>
                    <td>
                      <label class="checkboxs">
                        <input type="checkbox">
                        <span class="checkmarks"></span>
                      </label>
                    </td>
                    <td class="productimgname">
                      <a href="javascript:void(0);" class="product-img">
                        <img src="<?= $base_url ?>assets/img/profiles/avator1.jpg" alt="user">
                      </a>
                      <?= htmlspecialchars($u->full_name) ?>
                    </td>
                    <td><?= htmlspecialchars($u->role_name ?? '-') ?></td>
                    <td><?= htmlspecialchars($u->phone ?? '-') ?></td>
                    <td><?= htmlspecialchars($u->email) ?></td>
                    <td>
                      <div class="status-toggle d-flex justify-content-between align-items-center">
                        <input type="checkbox"
                               id="user<?= (int)$u->id ?>"
                               class="check user-status-toggle"
                               data-id="<?= (int)$u->id ?>"
                               <?= $u->status === 'Active' ? 'checked' : '' ?>>
                        <label for="user<?= (int)$u->id ?>" class="checktoggle">checkbox</label>
                      </div>
                    </td>
                    <td>
                      <a class="me-3" href="<?= $base_url ?>users/edit.php?id=<?= (int)$u->id ?>">
                        <img src="<?= $base_url ?>assets/img/icons/edit.svg" alt="img">
                      </a>
                      <a class="me-3 confirm-text" href="<?= $base_url ?>users/delete.php?id=<?= (int)$u->id ?>">
                        <img src="<?= $base_url ?>assets/img/icons/delete.svg" alt="img">
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.querySelectorAll('.user-status-toggle').forEach(function (el) {
  el.addEventListener('change', function () {
    var id = this.getAttribute('data-id');
    fetch('<?= $base_url ?>users/status.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: 'id=' + encodeURIComponent(id)
    })
    .then(res => res.json())
    .then(data => {
      if (!data.status) {
        alert(data.message || 'Failed to update status');
        location.reload();
      }
    })
    .catch(() => {
      alert('Something went wrong while updating status.');
      location.reload();
    });
  });
});
</script>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/dreams/component/footer.php"; ?>
