<?php defined('SYSPATH') or die('No direct access allowed.');

/**
 * The login form.
 *
 * @package    Soapbox
 * @author     Dave Widmer <dave@davewidmer.net>
 * @copyright  2011-2012 © Dave Widmer
 */
class View_Login extends Soapbox_View
{
	/**
	 * @var string  The submitted email
	 */
	public $email;

	/**
	 * @var string  The submitted password
	 */
	public $password;

	/**
	 * @var string  The url to post the form to.
	 */
	public $action;

	/**
	 * Setup Partials.
	 *
	 * @param array $post  Any posted data
	 */
	public function __construct($data)
	{
		$this->email = Arr::get($data, 'email', "");
		$this->password = Arr::get($data, 'password', "");
		$this->action = URL::site(Route::get('soapbox')->uri(array('action' => "login")));

		$this->partials = array(
			'message' => $this->load("partials/message.mustache")
		);
	}

	/**
	 * Add the post title to the page title.
	 *
	 * @param \Owl\Layout $layout  The layout this post is added to.
	 */
	public function added_to_layout(\Owl\Layout $layout)
	{
		$layout->title .= "Login";
	}
}
