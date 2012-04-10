<?php defined('SYSPATH') or die('No direct access allowed.');

/**
 * The view that deals with creating/editing posts.
 *
 * @package    Soapbox
 * @author     Dave Widmer <dave@davewidmer.net>
 * @copyright  2011-2012 © Dave Widmer
 */
class View_Admin_Post extends Soapbox_View
{
	/**
	 * @var Soapbox_Post  The post
	 */
	private $post;

	/**
	 * @var string  The action for the post (edit|add)
	 */
	private $verb;

	/**
	 * Setup Partials.
	 *
	 * @param Soapbox_post $post  The post
	 * @param string       $verb  Which REST verb are we doing?
	 */
	public function __construct($post, $verb = "edit")
	{
		$this->post = $post;
		$this->verb = $verb;

		$this->partials = array(
			'logout' => $this->load("partials/logout.mustache"),
			'message' => $this->load("partials/message.mustache")
		);
	}

	/**
	 * @return string  The title of the post
	 */
	public function post_title()
	{
		return $this->post->title;
	}

	/**
	 * @return string  The source of the post.
	 */
	public function post_source()
	{
		return $this->post->source;
	}

	/**
	 * @return string  The slug
	 */
	public function post_slug()
	{
		return $this->post->slug;
	}

	/**
	 * @return string  A readable version of the action verb
	 */
	public function verb()
	{
		return ucfirst($this->verb);
	}

	/**
	 * @return string  The uri for the form.
	 */
	public function action()
	{
		return Route::url('soapbox/admin', array(
			'action' => $this->verb,
			'id' => $this->post->post_id
		));
	}

	/**
	 * @return boolean Is this the edit screen?
	 */
	public function is_edit()
	{
		return $this->verb === "edit";
	}

	/**
	 * @return string  The posted date of the post 
	 */
	public function posted_date()
	{
		if ($this->post->posted_date === null)
		{
			$this->post->posted_date = new DateTime('now');
		}

		return $this->post->date("Y-m-d");
	}

	/**
	 * Adds the page title to the layout.
	 *
	 * @param \Owl\Layout $layout   The layout this content is added to
	 */
	public function added_to_layout(\Owl\Layout $layout)
	{
		$layout->title .= "Admin » ".$this->verb();
		$layout->js[] = new \Owl\Asset\Javascript("https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js");
		$layout->js[] = new \Owl\Asset\JavaScript("https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js");
		$layout->css[] = new \Owl\Asset\Css("http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css");
	}

}
