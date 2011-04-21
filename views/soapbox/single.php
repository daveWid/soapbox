<?php
/*
public 'post_id'
public 'title'
public 'slug'
public 'contents'
public 'posted_date' 
 */
?>

<article>
	<h2><?php echo $title; ?></h2>
	<div class="date">Posted: <?php echo Date::formatted_time($posted_date, "l F jS, Y"); ?></div>

	<div class="contents"><?php echo $contents; ?></div>
</article>