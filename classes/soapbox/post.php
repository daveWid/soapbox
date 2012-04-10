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

}