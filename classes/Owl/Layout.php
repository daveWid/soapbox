<?php

namespace Owl;

/**
 * A Layout (template) View class.
 *
 * @package   Owl
 * @author    Dave Widmer <dwidmer@bgsu.edu>
 */
abstract class Layout extends \Owl\View
{
	/**
	 * @var mixed  The content to inject into the view.
	 */
	private $content = null;

	/**
	 * @var string The character set for the page
	 */
	public $charset = "utf-8";

	/**
	 * @var array  An array of css files in a href => , media => format
	 */
	public $css = array();

	/**
	 * @var array  An array of js files in a src => format
	 */
	public $js = array();

	/**
	 * @var array An array of metadata in a name => , content => format
	 */
	public $meta = array();

	/**
	 * @var string The page title.
	 */
	public $title = "";

	/**
	 * @var boolean  Does this layout have an \Owl\View?
	 */
	private $has_view = false;

	/**
	 * The content that will replace {{> content}} in the layout template.
	 *
	 * @return mixed
	 */
	public function get_content()
	{
		return $this->content;
	}

	/**
	 * Sets the content that will replace {{> content}} in the template. This
	 * can be anything that can be echo'ed out, but if it is an \Owl\View class
	 * then the added_to_layout function will be called.
	 *
	 * @param  mixed $content  The content.
	 * @return \Owl\Layout     $this
	 */
	public function set_content($content)
	{
		$this->content = $content;

		if ($content instanceof \Owl\View)
		{
			$content->added_to_layout($this);
			$this->partials['content'] = $this->load($content->get_file());
			$this->has_view = true;
		}
		else
		{
			$this->partials['content'] = $content;
			$this->has_view = false;
		}

		return $this;
	}

	/**
	 * Pass in the content partials to the rendering function.
	 *
	 * @param  array $partials  An array of partials
	 * @return string           The rendered template
	 */
	public function render(array $partials = array())
	{
		if ($this->has_view)
		{
			$partials = array_merge($this->content->get_partials(), $partials);
		}

		return parent::render($partials);
	}

	/**
	 * Allowing access to content properties (if a \Owl\View instance)
	 *
	 * @param  string $name  The name of the property to get
	 * @return mixed
	 */
	public function __get($name)
	{
		if (method_exists($this->content, $name))
		{
			return $this->content->{$name}();
		}
		else
		{
			return $this->content->{$name};
		}
	}

	/**
	 * Checks to see if a variable is available in the content.
	 *
	 * @param  string $name  The name of the property to check
	 * @return boolean
	 */
	public function __isset($name)
	{
		$set = false;

		if ($this->has_view)
		{
			if (isset($this->content->{$name}) OR method_exists($this->content, $name))
			{
				$set = true;
			}
		}

		return $set;
	}

}
