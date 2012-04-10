<?php defined('SYSPATH') or die('No direct access allowed.');

/**
 * The Layout class that handles the RSS feed
 *
 * @link       http://feed2.w3.org/docs/rss2.html
 *
 * @package    Soapbox
 * @author     Dave Widmer <dave@davewidmer.net>
 * @copyright  2011-2012 © Dave Widmer
 */
class View_Layout_RSS extends \Owl\Layout
{
	/**
	 * @var string  The language.
	 */
	public $lang = "en-us";

	/**
	 * @var string  The title of the feed
	 */
	public $title = "Soapbox Blog";

	/**
	 * @var \Cactus\Collection   The posts to use to build the feed
	 */
	public $posts = null;
	
	/**
	 * Setup the posts
	 *
	 * @param \Cactus\Collection $posts  The posts to use in the feed
	 */
	public function __construct($posts)
	{
		$this->posts = $posts;
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
	 * The link to the main site.
	 *
	 * @return string 
	 */
	public function link()
	{
		return URL::site("", true);
	}

	/**
	 * @return string  The feed description 
	 */
	public function description()
	{
		return "My cool blog";
	}

	/**
	 * @return string  The RFC-8288 date of the latest post 
	 */
	public function lastBuildDate()
	{
		return $this->posts[0]->date('r');
	}

	/**
	 * Gets the path to the template file.
	 *
	 * @return string 
	 */
	public function get_file()
	{
		return "layout/rss.mustache";
	}

}