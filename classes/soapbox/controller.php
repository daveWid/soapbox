<?php defined('SYSPATH') or die('No direct script access.');
/**
 * The Soapbox Controller handles the displaying of a list of posts, categores
 * and a single post
 *
 * @package		Soapbox
 * @author		Dave Widmer <dave@davewidmer.net>
 * @copyright	2011 © Dave Widmer
 */
class Soapbox_Controller extends Controller_Template
{
	/**
	 * @var   array   An array of configuration values
	 */
	protected $_config;

	/**
	 * Get the configuration
	 */
	public function before()
	{
		$this->_config = Kohana::$config->load('soapbox');
		return parent::before();
	}

	/**
	 * Views the current posts.
	 */
	public function action_index()
	{
		$page = $this->request->param('page', 1);

		$this->template->title = $this->_config['title'];
		$this->template->content = View::factory('soapbox/list')->set(array(
			'posts' => Model::factory('post')->fetch($this->_config['per_page'], $page),
		));
	}

	/**
	 * Lists the posts in a given category
	 */
	public function action_category()
	{
		$slug = $this->request->param('category');

		$this->template->title = $this->_config['title']." :: ".$slug;
		$this->template->content = View::factory('soapbox/list')->set(array(
			'title' => $slug,
			'posts' => Model_Post::in_category($slug),
		));
	}

	/**
	 * View a single post
	 */
	public function action_post()
	{
		$r = $this->request;

		$post = Model_Post::get_post($r->param('slug'), "{$r->param('year')}-{$r->param('month')}");

		if ($post === null)
		{
			$this->request->redirect(Route::get('soapbox/404')->uri()); // 404 if no post
		}

		$this->template->title = $this->_config['title']." :: ".$post->title;
		$this->template->content = View::factory('soapbox/post')->set((array) $post);
	}

	/**
	 * 404
	 */
	public function action_404()
	{
		$this->template->title = "Page Not Found";
		$this->template->content = View::factory('soapbox/404');
	}

}
