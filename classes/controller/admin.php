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
		$model = $this->di->model("Model_Post");
		$post = $model->get($id);

		if ($this->request->method() === Request::POST)
		{
			$post->set($this->request->post());

			if ($post->is_valid())
			{
				$model->save($post);
				$this->request->redirect(Route::get('soapbox/admin')->uri(array('index' => false)));
			}
			else
			{
				Session::instance()->set('soapbox_error', $post->errors('soapbox'));
			}
		}

		$this->content = new View_Admin_Post($post, "edit");
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
