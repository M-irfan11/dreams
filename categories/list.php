<?php
require_once('../component/header.php');
require_once('../component/header_auth.php');
require_once('../component/sidebar.php');
require_once('../component/connection.php');

$categories = $crud->common_select("categories");
?>

<div class="page-wrapper">
<div class="content">

<h4>Category List</h4>

<a href="add.php" class="btn btn-primary mb-3">Add Category</a>

<table class="table table-bordered">
<thead>
<tr>
<th>ID</th>
<th>Name</th>
<th>Description</th>
<th>Action</th>
</tr>
</thead>

<tbody>
<?php if($categories['status']): ?>
<?php foreach($categories['data'] as $row): ?>
<tr>
<td><?= $row->categories_id ?></td>
<td><?= $row->name ?></td>
<td><?= $row->description ?></td>
<td>
<a href="edit.php?id=<?= $row->categories_id ?>" class="btn btn-warning btn-sm">Edit</a>
<a href="delete.php?id=<?= $row->categories_id ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
</td>
</tr>
<?php endforeach; ?>
<?php endif; ?>
</tbody>
</table>

</div>
</div>

<?php require_once('../component/footer.php'); ?>
