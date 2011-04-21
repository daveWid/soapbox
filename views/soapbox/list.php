<?php if (isset($title)): ?>
<h1><?php echo $title; ?>
<?php endif; ?>

<?php
foreach ($posts as $post)
{
	echo View::factory('soapbox/single')->set((array) $post);
}
