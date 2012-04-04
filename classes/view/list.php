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
	 * @param int $page  The current page
	 */
	public function __construct($page = 1)
	{
		$this->page = (int) $page;

		$di = new Container;
		$model = $di->model("Model_Post");
		$this->posts = $model->latest();

		$this->partials = array(
			'search' => $this->load("partials/search.mustache")
		);
	}
}

/*
$this->template->title = $this->_config['title'];
		$this->template->content = View::factory('soapbox/list')->set(array(
			'posts' => Model::factory('post')->fetch($this->_config['per_page'], $page),
			'page' => $page,
			'next_page' => Model_Post::has_next_page($page) ? $page + 1 : false,
			'previous_page' => Model_Post::has_previous_page($page) ? $page - 1 : false,
		));
 * 
 */
