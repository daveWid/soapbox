<?php $route = Request::current()->route(); ?>
<h1>Administration</h1>

<?php if (isset($message)): ?>
<div id="message" class="success">
	<?php echo $message; ?>
</div>
<?php endif; ?>

<div id="logout">
	<a href="<?php echo Route::url('soapbox/login', array('action' => "logout")); ?>">Logout</a>
</div>

<div id="create">
	<?php echo HTML::anchor($route->uri(array('action' => "add")), "Create New Post"); ?>
</div>

<table id="posts-admin">
	<thead>
		<tr>
			<th>Title</th>
			<th>Posted</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($posts as $post): ?>
		<tr>
			<td><a href="<?php echo Model_Post::permalink($post); ?>"><?php echo $post->title; ?></a></td>
			<td><?php echo Date::formatted_time($post->posted_date, "F jS, Y"); ?></td>
			<td>
			<?php
				echo HTML::anchor($route->uri(array('action' => "edit", 'id' => $post->post_id)), "Edit")." | ".
					HTML::anchor($route->uri(array('action' => "delete", 'id' => $post->post_id)), "Delete");
			?></td>
		</tr>
<?php endforeach; ?>
	</tbody>
</table>