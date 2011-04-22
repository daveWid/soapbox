<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Core Soapbox functionality.
 *
 * @package		Soapbox
 * @author		Dave Widmer
 * @copyright	2011 © Dave Widmer
 */
class Soapbox_Core
{
	/**
	 * Displays the post categories
	 *
	 * @param	string	The category slugs
	 * @param	string	The display name
	 * @param	string	Seperators
	 * @param	boolean	Make links out of the categories?
	 * @return	string	The categories in HTML form
	 */
	public static function categories($slugs, $display, $seperator = ", ", $link = true)
	{
		$slugs = explode(",", $slugs);
		$display = explode(",", $display);
	
		$categories = array();

		for ($i = 0, $len = count($slugs); $i < $len; $i++)
		{
			$categories[] = ($link) ?
				HTML::anchor(Route::get('soapbox/category')->uri(array('category' => $slugs[$i])), $display[$i]) :
				$display[$i];
		}

		return implode($seperator, $categories);
	}

}
