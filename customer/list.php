<?php
require_once('../component/header.php');

require_once('../component/sidebar.php');

$customers = $crud->common_select("customers");
?>

<div class="page-wrapper">
<div class="content">

<h4>Customer List</h4>

<a href="add.php" class="btn btn-primary mb-3">Add Customer</a>

<table class="table table-bordered">
<thead>
<tr>
<th>ID</th>
<th>Name</th>
<th>Phone</th>
<th>Email</th>
<th>Action</th>
</tr>
</thead>

<tbody>
<?php if($customers['status']): ?>
<?php foreach($customers['data'] as $row): ?>
<tr>
<td><?= $row->customer_id ?></td>
<td><?= $row->name ?></td>
<td><?= $row->phone ?></td>
<td><?= $row->email ?></td>
<td>
<a href="edit.php?id=<?= $row->customer_id ?>" class="btn btn-warning btn-sm">Edit</a>
<a href="delete.php?id=<?= $row->customer_id ?>" class="btn btn-danger btn-sm">Delete</a>
</td>
</tr>
<?php endforeach; ?>
<?php endif; ?>
</tbody>
</table>

</div>
</div>

<?php require_once('../component/footer.php'); ?>