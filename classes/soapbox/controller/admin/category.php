<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Soapbox category administration.
 *
 * @package		Soapbox
 * @author		Dave Widmer <dave@davewidmer.net>
 * @copyright	2011 © Dave Widmer
 */
class Soapbox_Controller_Admin_Category extends Controller_Template
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
	 * View list of categories for administration.
	 */
	public function action_index()
	{
		$this->template->title = $this->_config['title']." :: Administration :: Categories";
		$this->template->content = View::factory('soapbox/admin/category/list')->set(array(
			'categories' => Model::factory('category')->fetch(),
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

		$this->template->title = "Administration :: Add Category";
		$this->template->content = View::factory('soapbox/admin/category/form')->set(array(
			'post' => $this->request->post(),
			'action' => Route::url('soapbox/admin/category', array('action' => "add")),
			'error' => Session::instance()->get_once('soapbox-message', null),
		));
	}

	/**
	 * Processes the add post form.
	 */
	public function do_add()
	{
		$model = new Model_Category;
		$post = $this->request->post();

		if (Valid::not_empty($post['display']))
		{
			list($id, $num) = $model->create($post); // Save the category
			$this->request->redirect(Route::get('soapbox/admin/category')->uri(array('index' => false)));
		}
		else
		{
			Session::instance()->set('soapbox-message', Kohana::message('soapbox', 'category.error'));
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
			$this->request->post((array) Model::factory('category')->read($id));
		}

		$this->template->title = "Administration :: Edit Category";
		$this->template->content = View::factory('soapbox/admin/category/form')->set(array(
			'post' => $this->request->post(),
			'action' => Route::url('soapbox/admin/category', array('action' => "edit", 'id' => $id)),
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
		$model = new Model_Category;
		$post = $this->request->post();

		if (Valid::not_empty($post['display']))
		{
			$model->update($id, $post); // Save the category
			$this->request->redirect(Route::get('soapbox/admin/category')->uri(array('index' => false)));
		}
		else
		{
			Session::instance()->set('soapbox-message', Kohana::message('soapbox', 'category.error'));
		}
	}

	/**
	 * Delete a post
	 */
	public function action_delete()
	{
		$id = $this->request->param('id');
		Model::factory('category')->delete($id);

		$this->request->redirect(Route::get('soapbox/admin/category')->uri(array('action' => false)));
	}

}
