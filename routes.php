<?php defined('SYSPATH') or die('No direct script access.');

// Admin
Route::set('soapbox/admin', "admin(/<action>(/<id>))", array(
	'action' => "(|add|edit|delete)",
	'id' => "\d+"
))->defaults(array(
	'directory' => "admin",
	'controller' => "soapbox",
	'action' => "index",
	'id' => null
));

// Admin categories
Route::set('soapbox/admin/category', "admin/category(/<action>(/<id>))", array(
	'action' => "(|add|edit|delete)",
	'id' => "\d+"
))->defaults(array(
	'directory' => "admin",
	'controller' => "soapbox_category",
	'action' => "index",
	'id' => null
));

// Login
Route::set('soapbox/login', "<action>", array('action' => "(login|logout)"))
->defaults(array(
	'controller' => "soapbox",
));

// Single Post
Route::set('soapbox/post', "<year>/<month>/<slug>", array(
	'year' => "\d{4}",
	'month' => "\d{2}",
	'slug' => ".*"
))->defaults(array(
	'controller' => "soapbox",
	'action'	=> "post",
	'year'	=> null,
	'month'	=> null,
	'slug'	=> null,
));

// Category
Route::set('soapbox/category', "category/<category>", array('category' => ".*"))
->defaults(array(
	'controller' => "soapbox",
	'action'	=> "category",
));

// One word routes
Route::set('soapbox/action', "<action>", array('action' => "(|search|feed|404)"))
->defaults(array(
	'controller' => "soapbox",
	'action' => "index",
));
