<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Soapbox blog administration.
 *
 * @package		Soapbox
 * @author		Dave Widmer <dave@davewidmer.net>
 * @copyright	2011 © Dave Widmer
 */
class Soapbox_Controller_Admin extends Controller_Template
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
		// Do a quick check for a user
		if ( ! Auth::instance()->get_user())
		{
			$this->request->redirect(Route::get('soapbox/login')->uri(array('action' => "login")));
		}

		$this->_config = Kohana::$config->load('soapbox');
		return parent::before();
	}

	/**
	 * View list of posts for administration.
	 */
	public function action_index()
	{
		$this->template->title = $this->_config['title']." :: Administration";
		$this->template->content = View::factory('soapbox/admin/list')->set(array(
			'posts' => Model::factory('post')->fetch(),
			'message' => Session::instance()->get_once('soapbox-message', null)
		));
	}

	/**
	 * Create a new post
	 */
	public function action_add()
	{
		if ($this->request->method() === "POST")
		{
			$this->do_add();
		}

		$this->template->title = "Administration :: Add Post";
		$this->template->content = View::factory('soapbox/admin/form')->set(array(
			'post' => $this->request->post(),
			'action' => Route::url('soapbox/admin', array('action' => "add")),
			'new' => true,
			'categories' => Arr::get($this->request->post(), 'categories', array()),
			'error' => Session::instance()->get_once('soapbox-message', null),
		));
	}

	/**
	 * Processes the add post form.
	 */
	public function do_add()
	{
		$model = new Model_Post;
		$post = $this->request->post();

		if ($model->validate_new($post))
		{
			list($id, $num) = $model->create($post); // Save the post
			Model_Post_Category::set_post($id, Arr::get($post, 'category', array()));

			$this->request->redirect(Route::get('soapbox/admin')->uri(array('index' => false)));
		}
		else
		{
			Session::instance()->set('soapbox-message', $model->errors('soapbox'));
		}
	}

	/**
	 * Edit a post
	 */
	public function action_edit()
	{
		$id = $this->request->param('id');

		if ($this->request->method() === "POST")
		{
			$this->do_edit($id);
		}
		else
		{
			// Get the post data
			$this->request->post((array) Model::factory('post')->read($id));
			$this->request->post('categories', Model_Post_Category::post_category_ids($id));
		}

		$this->template->title = "Administration :: Edit Post";
		$this->template->content = View::factory('soapbox/admin/form')->set(array(
			'post' => $this->request->post(),
			'action' => Route::url('soapbox/admin', array('action' => "edit", 'id' => $id)),
			'new' => false,
			'categories' => Arr::get($this->request->post(), 'categories', array()),
			'error' => Session::instance()->get_once('soapbox-message', null),
		));
	}

	/**
	 * Does the editing of a post
	 *
	 * @param   int   The post id to edit
	 */
	protected function do_edit($id)
	{
		$model = new Model_Post;
		$post = $this->request->post();

		if ($model->validate_new($post))
		{
			$model->update($id, $post);
			Model_Post_Category::set_post($id, Arr::get($post, 'category', array()));

			Session::instance()->set('soapbox-message', Kohana::message('soapbox', 'edit.success'));
			$this->request->redirect(Route::get('soapbox/admin')->uri(array('index' => false)));
		}
		else
		{
			Session::instance()->set('soapbox-message', $model->errors('soapbox'));
		}
	}

	/**
	 * Delete a post
	 */
	public function action_delete()
	{
		Model::factory('post')->delete($this->request->param('id'));
		$this->request->redirect(Route::get('soapbox/admin')->uri(array('action' => false)));
	}

}
