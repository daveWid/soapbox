<?php defined('SYSPATH') or die('No direct access allowed.');

/**
 * A page that has a listing of posts on it.
 *
 * @package    Soapbox
 * @author     Dave Widmer <dave@davewidmer.net>
 * @copyright  2011-2012 © Dave Widmer
 */
class View_List extends Soapbox_View
{
	/**
	 * @var int  The current "page"
	 */
	private $page;

	/**
	 * @var \Cactus\Collection (of Soapbox_Post Objects)
	 */
	private $posts;

	/**
	 * @var Model_Post  The model used to get the posts.
	 */
	private $model = null;

	/**
	 * Setup Partials.
	 *
	 * @param \Cactus\Collestion $posts  The posts to be viewed on this page
	 */
	public function __construct($posts)
	{
		$this->posts = $posts;
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
		$layout->title .= "Latest Posts";
	}

}
