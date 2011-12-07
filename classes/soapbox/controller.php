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
		die('This is where you will show a list of posts with the given category');
	}

	/**
	 * View a single post
	 */
	public function action_post()
	{
		die('Here is where you will show a single post');
	}

}
