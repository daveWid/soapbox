<?php defined('SYSPATH') or die('No direct script access.');
/**
 * This is a very basic Soapbox controller.
 *
 * It is for demonstration purposes only. Please move this logic into
 * real controllers on your site.
 * 
 * (note) Update your Soapbox config when you move this logic!!
 *
 * @package		Soapbox
 * @author		Dave Widmer
 * @copyright	2011 © Dave Widmer
 */
class Controller_Soapbox extends Controller
{
	/**
	 * The home page
	 */
	public function action_index()
	{
		die('This is where your homepage will go (more than likely a list of posts');
	}

	/**
	 * The categories listing
	 */
	public function action_category()
	{
		die('This is where you will show a list of posts with the given category');
	}

	/**
	 * A single post
	 */
	public function action_single()
	{
		die('Here is where you will show a single post');
	}

}
