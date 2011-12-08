<?php if (isset($error)): ?>
<div id="message" class="error">
	<?php echo $error; ?>
</div>
<?php endif; ?>

<form action="<?php echo $action; ?>" method="post" id="category-form">
	<div>
		<label for="display">Category</label>
		<input type="text" name="display" value="<?php echo Arr::get($post, 'display', ""); ?>" id="display" />
	</div>

	<input type="submit" value="Submit" />
</form>