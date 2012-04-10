<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Soapbox Administration panel.
 *
 * @package    Soapbox
 * @author     Dave Widmer <dave@davewidmer.net>
 * @copyright  2011-2012 © Dave Widmer
 */
class Controller_Admin extends Controller
{
	/**
	 * Get the configuration
	 */
	public function before()
	{
		parent::before();

		// Make sure the user is logged in...
		if ($this->user === null)
		{
			$this->request->redirect(Route::get("soapbox")->uri(array('action' => "login")));
		}
	}

	/**
	 * View list of posts for administration.
	 */
	public function action_index()
	{
		$model = $this->di->model("Model_Post");
		$posts = $model->all();

		$this->content = new View_Admin_List($posts);
	}

	/**
	 * Create a new post
	 */
	public function action_add()
	{
		$post = new Soapbox_Post($this->request->post());

		if ($this->request->method() === Request::POST)
		{
			if ($post->is_valid())
			{
				$model = $this->di->model("Model_Post");
				list($id, $num) = $model->save($post);

				// Save the categories...

				$this->request->redirect(Route::get('soapbox/admin')->uri(array('index' => false)));
			}
			else
			{
				Session::instance()->set('soapbox_error', $post->errors('soapbox'));
			}
		}

		$this->content = new View_Admin_Post($post, "add");
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
		$content = array(
			'success' => false,
			'body' => "There was an error deleting the post."
		);

		$id = $this->request->param('id');

		$model = $this->di->model("Model_Post");
		$post = $model->get($id);

		$num = $model->delete($post);

		if ($num > 0)
		{
			$content['success'] = true;
			$content['body'] = "Success";
			$content['affected'] = $num;
		}

		$this->content = $content;
	}

}
