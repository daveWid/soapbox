<?php $route = Request::current()->route(); ?>
<h1>Administration :: Categories</h1>

<?php if (isset($message)): ?>
<div id="message" class="success">
	<?php echo $message; ?>
</div>
<?php endif; ?>

<div id="logout">
	<a href="<?php echo Route::url('soapbox/login', array('action' => "logout")); ?>">Logout</a>
</div>

<div id="create">
	<?php echo HTML::anchor($route->uri(array('action' => "add")), "Create New Category"); ?>
</div>

<table id="category-admin">
	<thead>
		<tr>
			<th>Name</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($categories as $category): ?>
		<tr>
			<td><?php echo $category->display; ?></td>
			<td>
			<?php
				echo HTML::anchor($route->uri(array('action' => "edit", 'id' => $category->category_id)), "Edit")." | ".
					HTML::anchor($route->uri(array('action' => "delete", 'id' => $category->category_id)), "Delete");
			?></td>
		</tr>
<?php endforeach; ?>
	</tbody>
</table>
