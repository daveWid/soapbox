<?php defined('SYSPATH') or die('No direct script access.');

$config = Kohana::$config->load('soapbox');
$section = trim($config->section, "/");
$admin = trim($config->admin, "/");

// Admin
Route::set('soapbox/admin', "{$section}/{$admin}(/<action>(/<id>))", array(
		'action' => "(|add|edit|delete)",
		'id' => "\d+"
	))
	->defaults(array(
		'directory' => "admin",
		'controller' => "soapbox",
		'action' => "index",
		'id' => null
	));

// Admin categories
Route::set('soapbox/admin/category', "{$section}/{$admin}/category(/<action>(/<id>))", array(
		'action' => "(|add|edit|delete)",
		'id' => "\d+"
	))
	->defaults(array(
		'directory' => "admin",
		'controller' => "soapbox_category",
		'action' => "index",
		'id' => null
	));

// Login
Route::set('soapbox/login', "{$section}/<action>", array('action' => "(login|logout)"))
	->defaults(array(
		'controller' => "soapbox",
	));

// Single Post
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

// Category
Route::set('soapbox/category', "{$section}/category/<category>", array('category' => ".*"))
	->defaults(array(
		'controller' => "soapbox",
		'action'	=> "category",
	));

// Homepage
Route::set('soapbox', "{$section}")
	->defaults(array(
		'controller' => "soapbox",
		'action' => "index",
	));

// 404
Route::set('soapbox/404', "{$section}/404")
	->defaults(array(
		'controller' => "soapbox",
		'action' => "404"
	));

unset($config, $section, $admin);