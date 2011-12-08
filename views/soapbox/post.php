<article>
	<h2><?php echo $title; ?></h2>

	<div class="date">Posted: <?php echo Date::formatted_time($posted_date, "l F jS, Y"); ?></div>
	<div class="categories"><?php echo Model_Post_Category::link(Model_Post_Category::post_categories($post_id)); ?></div>

	<div class="content"><?php echo $content; ?></div>

	<!-- Put in next/previous post navigation -->
	<ul id="next-previous">
<?php if($previous = Model_Post::get_previous($post_id)): ?>
		<li id="previous-post"><a href="<?php echo Model_Post::permalink($previous); ?>">← <?php echo $previous->title; ?></a></li>
<?php endif; ?>
<?php if ($next = Model_Post::get_next($post_id)): ?>
		<li id="next-post"><a href="<?php echo Model_Post::permalink($next); ?>"><?php echo $next->title; ?> →</a></li>
<?php endif; ?>
	</ul>
</article>