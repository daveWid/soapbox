<article>
<?php if (isset($is_list) AND $is_list === true): ?>
	<h2><a href="<?php echo Route::url('soapbox/post', array(
		'year' => Date::formatted_time($posted_date, "Y"),
		'month' => Date::formatted_time($posted_date, "m"),
		'slug' => $slug
	)); ?>"><?php echo $title; ?></a></h2>
<?php else: ?>
	<h2><?php echo $title; ?></h2>
<?php endif; ?>
	<div class="date">Posted: <?php echo Date::formatted_time($posted_date, "l F jS, Y"); ?></div>
	<div class="categories"><?php echo Model_Post_Category::link(Model_Post_Category::post_categories($post_id)); ?></div>
	
	<div class="contents"><?php echo $contents; ?></div>
</article>