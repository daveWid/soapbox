<?php defined('SYSPATH') or die('No direct access allowed.');

/**
 * A class representation of a row in the posts table.
 *
 * @package    Soapbox
 * @author     Dave Widmer <dave@davewidmer.net>
 * @copyright  2011-2012 © Dave Widmer
 */
class Soapbox_Post extends \Cactus\Entity
{
	/**
	 * @var string  The truncated text.
	 */
	private $truncated = null;

	/**
	 * @var boolean  Is there more text to read (a truncated post?)
	 */
	public $has_more = false;

	/**
	 * The link to the full post.
	 *
	 * @return string 
	 */
	public function link()
	{
		return URL::site($this->date("Y/m/").$this->slug);
	}

	/**
	 * A human readable date of when the post was posted.
	 *
	 * @param  string $format  The date format
	 * @return string
	 */
	public function date($format = "F jS, Y")
	{
		return $this->posted_date->format($format);
	}

	/**
	 * Are there categories with this post? 
	 *
	 * @return boolean
	 */
	public function has_categories()
	{
		return count($this->categories) > 0;
	}

	/**
	 * Truncated content using a <!-- more --> tag in the content.
	 *
	 * @param   string   $content   The content to truncate
	 * @return  array               array (text "string", is there more text? "boolean")
	 */
	public function truncated()
	{
		if ($this->truncated === null)
		{
			$result = preg_split("/<!-- more -->/i", $this->content);
			$this->truncated = trim($result[0]);
			$this->has_more = count($result) > 1;
		}

		return $this->truncated;
	}
}