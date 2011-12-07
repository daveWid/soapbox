<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Blog Categories Model.
 *
 * @package     Soapbox
 * @author      Dave Widmer <dave@davewidmer.net>
 * @copyright   2011 © Dave Widmer
 */
class Soapbox_Model_Category extends Soapbox_Model
{
	/**
	 * @var   string   The primary key for the table
	 */
	public static $primary = "category_id";

	/**
	 * @var   string   The name of the table
	 */
	public static $table = "category";

	/**
	 * @var   array    The columns in this table
	 */
	protected $fields = array('category_id','slug','display');

	/**
	 * Sets the validation for a category
	 *
	 * @param   Validation   $valid   The current validation object
	 * @return  Validation
	 */
	protected function validation_rules($valid)
	{
		return $valid->rule('slug', 'not_empty')
			->rule('display', 'not_empty');
	}

}
