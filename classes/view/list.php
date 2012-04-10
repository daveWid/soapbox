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
	public $posts;

	/**
	 * @var Model_Post  The model used to get the posts.
	 */
	private $model = null;

	/**
	 * Setup Partials.
	 *
	 * @param Model_Post $model     The model that gets the posts
	 * @param int        $page      The current page
	 * @param string     $category  The category to fetch
	 */
	public function __construct($model, $page = 1, $category = null)
	{
		$this->model = $model;
		$this->page = (int) $page;
		$this->posts = $this->get_posts($category);

		$this->partials = array(
			'search' => $this->load("partials/search.mustache")
		);
	}

	/**
	 * Gets the posts to be displayed.
	 *
	 * @return \Cactus\Collection
	 */
	protected function get_posts($category = null)
	{
		return ($category === null) ?
			$this->model->latest() :
			$this->model->get_category($category);
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
