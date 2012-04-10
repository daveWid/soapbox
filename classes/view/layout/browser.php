<?php defined('SYSPATH') or die('No direct access allowed.');

/**
 * The Layout class that handles pages rendered in a browser.
 *
 * @package    Soapbox
 * @author     Dave Widmer <dave@davewidmer.net>
 * @copyright  2011-2012 © Dave Widmer
 */
class View_Layout_Browser extends \Owl\Layout
{
	/**
	 * Setup metadata, js and css 
	 */
	public function __construct()
	{
		$this->title = "Soapbox » ";

		$this->css = array(
			new \Owl\Asset\Css(URL::site("css/normalize.css")),
			new \Owl\Asset\Css(URL::site("css/browser.css")),
		);
	}

	/**
	 * The character set for the page.
	 *
	 * @return string
	 */
	public function charset()
	{
		return Kohana::$charset;
	}

	/**
	 * Is this in production?
	 *
	 * @return boolean 
	 */
	public function in_production()
	{
		return Kohana::$environment === Kohana::PRODUCTION;
	}

	/**
	 * A lambda function to get the url relative to the site.
	 *
	 * @return Closure
	 */
	public function url()
	{
		return function($url){
			return URL::site($url);
		};
	}

	/**
	 * Gets the path to the template file.
	 *
	 * @return string 
	 */
	public function get_file()
	{
		return "layout/browser.mustache";
	}

}