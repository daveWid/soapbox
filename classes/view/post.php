<?php defined('SYSPATH') or die('No direct access allowed.');

/**
 * A page that shows a single post.
 *
 * @package    Soapbox
 * @author     Dave Widmer <dave@davewidmer.net>
 * @copyright  2011-2012 © Dave Widmer
 */
class View_Post extends Soapbox_View
{
	/**
	 * @var Soapbox_Post  The current "post"
	 */
	private $post;

	/**
	 * Setup Partials.
	 *
	 * @param Soapbox_Post $post  The current post.
	 */
	public function __construct($post)
	{
		$this->post = $post;

		$this->partials = array(
			'search' => $this->load("partials/search.mustache")
		);
	}

	/**
	 * The title of the post.
	 *
	 * @return string
	 */
	public function post_title()
	{
		return $this->post->title;
	}

	/**
	 * Does this post have categories?
	 *
	 * @return boolean
	 */
	public function has_categories()
	{
		return count($this->post->categories) > 0;
	}

	/**
	 * The following functions allow passthrough to the post property.
	 *
	 * @param  string $name  The property name to get
	 * @return mixed         The value
	 */
	public function __get($name)
	{
		if (method_exists($this->post, $name))
		{
			return $this->post->$name();
		}
		
		return $this->post->$name;
	}
	public function __isset($name)
	{
		return isset($this->post->$name) OR method_exists($this->post, $name);
	}

	/**
	 * Add the post title to the page title.
	 *
	 * @param \Owl\Layout $layout  The layout this post is added to.
	 */
	public function added_to_layout(\Owl\Layout $layout)
	{
		$layout->title .= $this->post->title;
	}
}
