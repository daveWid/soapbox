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

// Category
Route::set('soapbox/category', "category/<category>", array('category' => ".*"))
->defaults(array(
	'controller' => "soapbox",
	'action'	=> "category",
));

// One word routes
Route::set('soapbox', "<action>", array('action' => "(|archive|search|feed|404|login|logout)"))
->defaults(array(
	'controller' => "soapbox",
	'action' => "index",
));

// Single Post
Route::set('soapbox/post', "<slug>", array('slug' => ".*")
)->defaults(array(
	'controller' => "soapbox",
	'action'	=> "post",
));
