<article>
	<h2><?php echo $title; ?></h2>

	<div class="date">Posted: <?php echo Date::formatted_time($posted_date, "l F jS, Y"); ?></div>
	<div class="categories"><?php echo Model_Post_Category::link(Model_Post_Category::post_categories($post_id)); ?></div>

	<div class="contents"><?php echo $contents; ?></div>

	<!-- Put in next/previous post navigation -->
</article>