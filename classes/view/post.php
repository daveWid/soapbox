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
	 * @var string  The post title
	 */
	public $post_title;

	/**
	 * @var Soapbox_Post  The post that is 1 newer.
	 */
	public $newer;

	/**
	 * @param Soapbox_Post  The post that is older.
	 */
	public $older;

	/**
	 * Setup Partials.
	 *
	 * @param Soapbox_Post $post  The current post.
	 * @param Model_Post   $model The model used to get posts.
	 */
	public function __construct($post, $model)
	{
		$this->post = $post;
		$this->post_title = $post->title;

		list($this->newer, $this->older) = $model->get_neighbors($this->post->post_id);
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
	 * Is there a newer post?
	 *
	 * @return boolean 
	 */
	public function has_newer()
	{
		return $this->newer !== null;
	}

	/**
	 * Are there older posts?
	 *
	 * @return boolean 
	 */
	public function has_older()
	{
		return $this->older !== null;
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
}
