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
	 * @var \Cactus\Collection (of Soapbox_Post Objects)
	 */
	private $posts;

	/**
	 * @var Model_Post  The model used to get the posts.
	 */
	private $model = null;

	/**
	 * @var string  The page title
	 */
	private $page_title = "";

	/**
	 * @var string  The search query
	 */
	public $q = "";

	/**
	 * Setup Partials.
	 *
	 * @param \Cactus\Collestion $posts  The posts to be viewed on this page
	 * @param string             $title  The page title to set
	 */
	public function __construct($posts, $title = "Latest Posts")
	{
		$this->posts = $posts;
		$this->page_title = $title;

		$this->partials = array(
			'search' => $this->load("partials/search.mustache")
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
		$layout->title .= $this->page_title;
	}

}
