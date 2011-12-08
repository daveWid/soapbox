<?php if (isset($title)): ?>
<h1><?php echo $title; ?></h1>
<?php endif; ?>

<?php
foreach ($posts as $post):

$link = Model_Post::permalink($post);
list($truncated, $more) = Model_Post::truncate($post->contents, "<p>", "</p>");

?>

<article>
	<h2><a href="<?php echo $link; ?>"><?php echo $post->title; ?></a></h2>

	<div class="date">Posted: <?php echo Date::formatted_time($post->posted_date, "l F jS, Y"); ?></div>
	<div class="categories"><?php echo Model_Post_Category::link(Model_Post_Category::post_categories($post->post_id)); ?></div>

	<div class="contents"><?php echo $truncated; ?></div>
<?php if ($more): ?>
	<div class="read-more"><a href="<?php echo $link; ?>">Read More →</a></div>
<?php endif; ?>
</article>
<?php endforeach; ?>