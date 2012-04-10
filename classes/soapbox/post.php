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
	 * The link to the full post.
	 *
	 * @return string 
	 */
	public function link()
	{
		return URL::site($this->slug);
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
	 * @return string  A list of categories in display format.
	 */
	public function display_categories()
	{
		$display = array();

		foreach ($this->categories as $cat)
		{
			$display[] = $cat->display;
		}

		return implode(" ", $display);
	}

	/**
	 * @return string  The publication date of the post
	 */
	public function pubDate()
	{
		return $this->date('r');
	}

	/**
	 * @return string  The permalink for the post
	 */
	public function permalink()
	{
		return URL::site($this->slug, true);
	}

}