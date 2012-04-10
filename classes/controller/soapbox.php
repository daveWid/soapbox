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
		$query = $this->request->query('query');

		if ($this->request->query('query') === null)
		{
			$this->request->redirect(Route::get('soapbox')->uri());
		}

		$this->template->title = "Search :: {$query}";
		$this->template->content = View::factory('soapbox/list')->set(array(
			'title' => "Search » {$query}",
			'posts' => Model_Post::search($query),
			'next_page' => false, // No pagination on search
			'previous_page' => false,
		));
	}

	/**
	 * The RSS Feed
	 *
	 * @see   http://feed2.w3.org/docs/rss2.html
	 */
	public function action_feed()
	{
		$this->auto_render = false; // No need for the template

		$this->response->headers('Content-Type', 'text/xml')
			->body(Feed::create(array(
				'title' => $this->_config['title'],
				'link' => Route::get('soapbox')->uri(),
				'description' => $this->_config['description'],
				'generator' => "Soapbox"
			),
			Model_Post::feed(),
			'rss2',
			Kohana::$charset
		));
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
		if ($this->request->method() === "POST")
		{
			$this->do_login();
		}

		// Check for user already
		if (Auth::instance()->get_user())
		{
			$this->request->redirect(Route::get('soapbox/admin')->uri(array('action' => FALSE)));
		}

		$this->template->title = "Login";
		$this->template->content = View::factory('soapbox/login')->set(array(
			'user' => $this->request->post('user'),
			'action' => URL::site($this->request->uri()),
			'error' => Session::instance()->get_once('soapbox-error')
		));
	}

	/**
	 * Do the login processing
	 */
	protected function do_login()
	{
		$post = $this->request->post();

		if (Auth::instance()->login($post['user'], $post['password']))
		{
			$this->request->redirect(Route::get('soapbox/admin')->uri(array('action' => false)));
		}
		else
		{
			Session::instance()->set('soapbox-error', Kohana::message('soapbox', 'login.incorrect'));
		}
	}

	/**
	 * Logs a user in.
	 */
	public function action_logout()
	{
		Auth::instance()->logout();
		$this->request->redirect(Route::get('soapbox/login')->uri(array('action' => "login")));
	}

}
