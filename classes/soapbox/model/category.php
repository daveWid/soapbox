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
	 * Creates a new category.
	 *
	 * @param   array   $data   The posted data
	 * @return  array           array [0] insert id [1] number of rows
	 */
	public function create(array $data)
	{
		$data['slug'] = str_replace(" ", "-", strtolower(trim($data['display'])));
		return parent::create($data);
	}

	/**
	 * Creates a new category.
	 *
	 * @param   int     $key    The category id
	 * @param   array   $data   The posted data
	 * @return  array           array [0] insert id [1] number of rows
	 */
	public function update($key, array $data)
	{
		$data['slug'] = str_replace(" ", "-", strtolower(trim($data['display'])));
		return parent::update($key, $data);
	}

	/**
	 * Removes the category id with the given category id
	 *
	 * @param   int   $key    The post id
	 * @return  boolean       the number of affected rows
	 */
	public function delete($key)
	{
		Model_Post_Category::remove_category($key);
		parent::delete($key);
	}

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
