<?php defined('SYSPATH') or die('No direct access allowed.');

/**
 * A page that has a listing of posts on it (administration style holmes!)
 *
 * @package    Soapbox
 * @author     Dave Widmer <dave@davewidmer.net>
 * @copyright  2011-2012 © Dave Widmer
 */
class View_Admin_List extends Soapbox_View
{
	/**
	 * @var \Cactus\Collection (of Soapbox_Post Objects)
	 */
	private $posts;

	/**
	 * Setup Partials.
	 *
	 * @param \Cactus\Collestion $posts  The posts to be viewed on this page
	 * @param string             $title  The page title to set
	 */
	public function __construct($posts)
	{
		$this->posts = $posts;

		$this->partials = array(
			'logout' => $this->load("partials/logout.mustache")
		);
	}

	/**
	 * Check to see if there are posts.
	 *
	 * @return boolean
	 */
	public function has_posts()
	{
		return ($this->posts !== null AND count($this->posts) > 0);
	}

	/**
	 * Gets the posts to be displayed.
	 *
	 * @return \Cactus\Collection
	 */
	public function posts()
	{
		return $this->posts;
	}

	/**
	 * Adds the page title to the layout.
	 *
	 * @param \Owl\Layout $layout   The layout this content is added to
	 */
	public function added_to_layout(\Owl\Layout $layout)
	{
		$layout->title .= "Admin";
		$layout->js[] = new \Owl\Asset\Javascript("https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js");
	}

}
