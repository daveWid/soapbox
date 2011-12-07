<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Post Categories Model.
 *
 * @package     Soapbox
 * @author      Dave Widmer <dave@davewidmer.net>
 * @copyright   2011 © Dave Widmer
 */
class Soapbox_Model_Post_Category extends Soapbox_Model
{
	/**
	 * @var   string    The primary key for this table
	 */
	public static $primary = "post_id";

	/**
	 * @var   string    The table name
	 */
	public static $table = "post_category";

	/**
	 * @var   array     The list of columns in this table
	 */
	protected $fields = array('post_id', 'category_id');

	/**
	 * Gets all of the categories from the given post.
	 *
	 * @param    int    The post id
	 * @return   array  The categories
	 */
	public static function post_categories($id)
	{
		$result = DB::select()
			->from(self::$table)
			->join(Model_Category::$table)->using(Model_Category::$primary)
			->where(self::$primary, '=', $id)
			->as_object()
			->execute();

		$categories = array();

		foreach ($result as $row)
		{
			$tmp = array(
				'display' => $row->display,
				'slug' => $row->slug
			);

			$categories[] = (object) $tmp;
		}

		return $categories;
	}

	/**
	 * Makes a category into a clickable link.
	 *
	 * @param   array    $category    A category array you want to make a link out of
	 * @param   string   $delimiter   The category delimiter
	 * @return  string
	 */
	public static function link(array $category, $delimiter = ", ")
	{
		$links = array();
		$route = Route::get('soapbox/category');

		foreach ($category as $row)
		{
			$links[] = HTML::anchor(
				$route->uri(array('category' => $row->slug)),
				$row->display
			);
		}

		return implode($delimiter, $links);
	}

	/**
	 * Gets the validation rules for a post category
	 *
	 * @param   Validation   $valid   The current validation object
	 * @return  Validation
	 */
	protected function validation_rules($valid)
	{
		return $valid->rule('post_id', 'not_empty')
			->rule('category_id', 'not_empty');
	}

}
