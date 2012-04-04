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
		$page = Arr::get($this->request->query(), 'page', 1);
		$this->content = new View_List($page);
	}

	/**
	 * Lists the posts in a given category
	 */
	public function action_category()
	{
		$slug = $this->request->param('category');
		$page = Arr::get($this->request->query(), 'page', 1);

		$this->template->title = $this->_config['title']." :: ".$slug;
		$this->template->content = View::factory('soapbox/list')->set(array(
			'title' => $slug,
			'posts' => Model_Post::in_category($slug, $this->_config['per_page'], $page),
			'page' => $page,
			'next_page' => Model_Post::has_next_page($page, $slug) ? $page + 1 : false,
			'previous_page' => Model_Post::has_previous_page($page) ? $page - 1 : false,
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
		$this->template->title = "Page Not Found";
		$this->template->content = View::factory('soapbox/404');
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
