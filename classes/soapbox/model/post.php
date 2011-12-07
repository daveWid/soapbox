<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Blog Post Model.
 *
 * @package     Soapbox
 * @author      Dave Widmer <dave@davewidmer.net>
 * @copyright   2011 © Dave Widmer
 */
class Soapbox_Model_Post extends Soapbox_Model
{
	/**
	 * @var   string   Table name
	 */
	public static $table = "post";

	/**
	 * @var   string   The name of the primary key
	 */
	public static $primary = "post_id";

	/**
	 * @var   array    The fields in this table
	 */
	protected $fields = array('post_id','title','slug','contents','posted_date');

	/**
	 * Fetches database rows
	 *
	 * @param   int	      The number of posts to get
	 * @param   int       The page
	 * @return Databse_Result
	 */
	public function fetch($num = null, $offset = 0)
	{
		$result = DB::select()
			->from(static::$table)
			->order_by('posted_date', 'DESC')
			->as_object();

		// Since this is a blog you will be getting a page number
		// we need to convert to an offset MySQL can use
		$offset = ($offset - 1) * $num;

		// Check to see if only a number of posts are requested, or all...
		if ($num !== null)
		{
			$result = $result->limit($num)->offset($offset);
		}

		return $result->execute();
	}

	/**
	 * Get the posts from a category.
	 *
	 * @param	string	The slug of the category to look for
	 * @param	int	The number of posts
	 * @param	int	The offset number
	 * @return	Database_Result	The results
	 */
	public function get_category($slug, $num, $offset)
	{
		$result = $this->get_select()
			->limit($num)
			->offset($offset)
			->where("categories.slug", "=", $slug)
			->as_object()
			->execute();

		return $result;
	}

	/**
	 * Gets a post from a slug.
	 *
	 * @param	string	The post slug
	 * @param	string	The date
	 * @return	Database_Result	The result
	 */
	public function get_post($slug, $date)
	{
		$result = $this->get_select()
			->where(self::$table.".slug", "=", $slug)
			->where(self::$table.".posted_date", "LIKE", "{$date}%")
			->as_object()
			->execute();

		return (count($result) !== 0) ? $result->current() : null;
	}

	/**
	 * Gets the validation rules for a blog post
	 *
	 * @param   Validation  $valid   The current validation object
	 * @return  Validation
	 */
	protected function validation_rules($valid)
	{
		return $valid->rule('title', 'not_empty')
			->rule('slug', 'not_empty')
			->rule('contents', 'not_empty')
			->rule('posted_date', 'not_empty');
	}

	/**
	 * The crazy DB::select object to do all the complex joining and whatnot.
	 *
	 * @return	Database_Query_Builder_Select
	 */
	private function get_select()
	{
		return DB::select()
			->from(static::$table)
			->order_by('posted_date', 'DESC');
	}

}