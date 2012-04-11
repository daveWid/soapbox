<?php defined('SYSPATH') or die('No direct access allowed.');

/**
 * Categories!
 *
 * @package    Soapbox
 * @author     Dave Widmer <dave@davewidmer.net>
 * @copyright  2011-2012 © Dave Widmer
 */
class Soapbox_Category extends \Cactus\Entity
{
	/**
	 * A Relative link to the category page. 
	 */
	public function permalink()
	{
		return Route::url('soapbox/category', array('category' => $this->slug));
	}
}