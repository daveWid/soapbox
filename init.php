<?php defined('SYSPATH') or die('No direct script access.');

$config = Kohana::config('soapbox');

// If there is a section we need to add a slash for routing
$config->slash = ($config->section) ? $config->section."/" : "";

/** Setting default routes for the soapbox */
Route::set('soapbox/post', "{$config->slash}<year>/<month>/<slug>", array(
		'year' => "\d{4}",
		'month' => "\d{2}",
		'slug' => ".*"
	))
	->defaults(array(
		'controller' => $config->controller,
		'action'	=> $config->action['post'],
		'year'	=> null,
		'month'	=> null,
		'slug'	=> null,
	));

Route::set('soapbox/category', "{$config->slash}category/<category>", array('category' => ".*"))
	->defaults(array(
		'controller' => $config->controller,
		'action'	=> $config->action['category'],
	));


Route::set('soapbox', $config->section)
	->defaults(array(
		'controller' => $config->controller,
		'action' => $config->action['home'],
	));

unset($config);