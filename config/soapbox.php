<?php defined('SYSPATH') or die('No direct access allowed.');

return array
(
	/**
	 * The controller that houses all of the soapbox logic
	 */
	'controller' => "soapbox",

	/**
	 * The action calls for home, categories and posts
	 */
	'action' => array(
		'home' => "index",
		'category' => "category",
		'post' => "single",
	),

	/**
	 * The name of the section on your site the blog will reside. No trailing slash!!
	 *
	 * @default	""	This will point to http://yoursite/ and make your whole site a blog
	 *
	 * If you would like your soapbox to reside at http://yoursite/blog, set this to "blog"
	 */
	'section' => "",

);