<?php defined('SYSPATH') or die('No direct script access.');

/**
 * The Soapbox controller handles all of the front end interaction that the user
 * has with the site.
 *
 * @package    Soapbox
 * @author     Dave Widmer <dave@davewidmer.net>
 * @copyright  2011-2012 © Dave Widmer
 */
class Controller_Soapbox extends Controller
{
	/**
	 * Views the current posts.
	 */
	public function action_index()
	{
		$model = $this->di->model("Model_Post");
		$posts = $model->latest();

		$this->content = new View_List($posts);
	}

	/**
	 * View a single post
	 */
	public function action_post()
	{
		$model = $this->di->model("Model_Post");
		$post = $model->find_post($this->request->param('slug'));

		if ($post === null)
		{
			$this->request->redirect(Route::get('soapbox')->uri(array('action' => "404")));
		}

		$this->content = new View_Post($post);
	}

	/**
	 * Lists the posts in a given category
	 */
	public function action_category()
	{
		$category = $this->request->param('category');

		$model = $this->di->model("Model_Post");
		$posts = $model->get_category($category);

		$this->content = new View_List($posts, $category);
	}

	/**
	 * Shows all of the posts in an archive format.
	 */
	public function action_archive()
	{
		$model = $this->di->model("Model_Post");
		$posts = $model->all('posted_date', 'DESC');

		$this->content = new View_Archive($posts);
	}

	/**
	 * The search action
	 */
	public function action_search()
	{
		// If there isn't a search query, then just send to homepage
		$query = $this->request->query('q');

		if ($query === null)
		{
			$this->request->redirect(Route::get('soapbox')->uri(array('action' => "404")));
		}

		$model = $this->di->model("Model_Post");
		$posts = $model->search($query);

		$this->content = new View_List($posts, "Search » {$query}");
		$this->content->q = $query;
	}

	/**
	 * The RSS Feed
	 */
	public function action_feed()
	{
		$model = $this->di->model("Model_Post");
		$posts = $model->latest(5);

		$this->layout = new View_Layout_RSS($posts);
	}

	/**
	 * 404
	 */
	public function action_404()
	{
		$this->layout->title .= "Page Not Found";
		$this->content = $this->layout->load("404.mustache");
	}

	/**
	 * Login page
	 */
	public function action_login()
	{
		$post = $this->request->post();

		if ($this->request->method() === Request::POST)
		{
			$user = new Soapbox_User($post);
			$model = $this->di->model("Model_User");

			if ($model->login($user->email, $user->password) !== false)
			{
				Session::instance()->set('soapbox_user', $user->email);
				$this->request->redirect(Route::get('soapbox/admin')->uri(array('action' => false)));
			}
			else
			{
				Session::instance()->set('soapbox_error', Kohana::message("soapbox", 'login.incorrect'));
			}
		}

		// If they are already logged in, just pass them through
		if ($this->user !== null)
		{
			$this->request->redirect(Route::get('soapbox/admin')->uri(array('action' => FALSE)));
		}
		
		$this->content = new View_Login($post);
	}

	/**
	 * Logs a user in.
	 */
	public function action_logout()
	{
		Session::instance()->delete("soapbox_user");
		$this->request->redirect(Route::get('soapbox')->uri(array('action' => "login")));
	}

}
