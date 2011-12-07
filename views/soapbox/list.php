<?php if (isset($title)): ?>
<h1><?php echo $title; ?></h1>
<?php endif; ?>

<?php
foreach ($posts as $post)
{
	echo View::factory('soapbox/post')->set((array) $post)->set('is_list', true);
}
