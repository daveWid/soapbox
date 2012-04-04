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
	 * Setup Partials.
	 *
	 * @param int    $page      The current page
	 * @param string $category  The category to fetch
	 */
	public function __construct($page = 1, $category = null)
	{
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
		$di = new Container;
		$model = $di->model("Model_Post");
		return ($category === null) ?
			$model->latest() :
			$model->get_category($category);
	}

}
