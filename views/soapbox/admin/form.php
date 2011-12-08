<?php if (isset($error)): ?>
<div id="message" class="error">
	<?php echo implode("<br />", $error); ?>
</div>
<?php endif; ?>

<form action="<?php echo $action; ?>" method="post" id="post-form">
	<div>
		<label for="title">Title</label>
		<input type="text" name="title" value="<?php echo Arr::get($post, 'title', ""); ?>" id="title" />
	</div>

	<div>
		<label for="content">Content</label>
		<textarea name="content" id="content"><?php echo Arr::get($post, 'content', ""); ?></textarea>
	</div>
<?php if( ! $new): ?>
	<input type="hidden" name="posted_on" value="<?php echo Arr::get($post, 'posted_on', ""); ?>" />
<?php endif; ?>

	<fieldset>
		<legend>Categories</legend>
		<ul id="category-list">
<?php
foreach(Model::factory('category')->fetch() as $c): ?>
			<li>
				<?php echo Form::checkbox(
					"category[]",
					$c->category_id,
					in_array($c->category_id, $categories),
					array('id' => "category{$c->category_id}")
				); ?>
				<label for="category<?php echo $c->category_id; ?>"><?php echo $c->display; ?></label>
			</li>
<?php endforeach; ?>
		</ul>
	</fieldset>

	<input type="submit" value="Submit" />
</form>