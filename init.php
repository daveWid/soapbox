<?php defined('SYSPATH') or die('No direct script access.');

$section = trim(Kohana::$config->load('soapbox')->section);

// View all posts route
Route::set('soapbox', $section)
	->defaults(array(
		'controller' => "soapbox",
		'action' => "index",
	));

/** Setting default routes for the soapbox */
Route::set('soapbox/post', "{$section}/<year>/<month>/<slug>", array(
		'year' => "\d{4}",
		'month' => "\d{2}",
		'slug' => ".*"
	))
	->defaults(array(
		'controller' => "soapbox",
		'action'	=> "post",
		'year'	=> null,
		'month'	=> null,
		'slug'	=> null,
	));

Route::set('soapbox/category', "{$section}category/<category>", array('category' => ".*"))
	->defaults(array(
		'controller' => "soapbox",
		'action'	=> "category",
	));

unset($section);