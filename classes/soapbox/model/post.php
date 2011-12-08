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
			->order_by('posted_date','DESC')
			->order_by('post_id', 'DESC')
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
	 * @param	string     The slug of the category to look for
	 * @return	Database_Result
	 */
	public static function in_category($slug)
	{
		$result = DB::select(static::$table.".*")
			->from(static::$table)
			->join(Model_Post_Category::$table)->using(static::$primary)
			->join(Model_Category::$table)->using(Model_Category::$primary)
			->where(Model_Category::$table.".slug", "=", $slug)
			->order_by('posted_date', 'DESC')
			->order_by('post_id', 'DESC')
			->as_object()
			->execute();

		return $result;
	}

	/**
	 * Gets a post from a slug and date
	 *
	 * @param	string	The post slug
	 * @param	string	The date
	 * @return	Database_Result	The result
	 */
	public static function get_post($slug, $date)
	{
		$result = DB::select()
			->from(static::$table)
			->where(static::$table.".slug", "=", $slug)
			->where(static::$table.".posted_date", "LIKE", "{$date}%")
			->as_object()
			->execute();

		return (count($result) !== 0) ? $result->current() : null;
	}

	/**
	 * Truncates the content using a <!-- more --> tag in the content.
	 *
	 * @param   string   $content   The content to truncate
	 * @return  array               array (text "string", is there more text? "boolean")
	 */
	public static function truncate($content)
	{
		$result = preg_split("/<!-- more -->/i", $content);

		return array(
			$result[0],
			count($result) > 1
		);
	}

	/**
	 * Get the previous post.
	 *
	 * @param   int   $id   The id of the post
	 * @return  mixed       The stdClass of the row OR false if not found
	 */
	public static function get_previous($id)
	{
		$result = DB::select()
			->from(static::$table)
			->where(static::$primary, "<", $id)
			->limit(1)
			->as_object()
			->execute();

		return (count($result) === 1) ? $result->current() : false;
	}

	/**
	 * Get the next post.
	 *
	 * @param   int   $id   The id of the post
	 * @return  mixed       The stdClass of the row OR null if not found
	 */
	public static function get_next($id)
	{
		$result = DB::select()
			->from(static::$table)
			->where(static::$primary, ">", $id)
			->limit(1)
			->as_object()
			->execute();

		return (count($result) === 1) ? $result->current() : false;
	}

	/**
	 * Gets the permalink url to a post.
	 *
	 * @param   object   $post    The post object to permalink.
	 * @param   string            The full url to the post
	 */
	public static function permalink($post)
	{
		return Route::url('soapbox/post', array(
			'year' => Date::formatted_time($post->posted_date, "Y"),
			'month' => Date::formatted_time($post->posted_date, "m"),
			'slug' => $post->slug
		));
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