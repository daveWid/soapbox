<?php defined('SYSPATH') or die('No direct access allowed.');

return array
(
	// The name of your soapbox blog
	'title' => "My Blog",

	// Short description of the blog
	'description' => "A place for my thoughts",

	/**
	 * The name of the section on your site the blog will reside. Include trailing slash!!
	 *
	 * @default	""	This will point to http://yoursite/ and make your whole site a blog
	 *
	 * If you would like your soapbox to reside at http://yoursite/blog, set this to "blog"
	 */
	'section' => "blog",

	// How many posts per page
	'per_page' => 10,

	// The name of the admin route. You can change this to make it harder to
	// guess for curious visitors
	'admin' => "admin",

);