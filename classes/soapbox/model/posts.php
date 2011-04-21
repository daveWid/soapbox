<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Blog Posts Model.
 *
 * @package		Soapbox
 * @author		Dave Widmer
 * @copyright	2011 © Dave Widmer
 */
class Soapbox_Model_Posts extends Soapbox_Model
{
	public $primary = "post_id";
	public $table = "posts";

	protected $fields = array('post_id','title','slug','contents','posted_date');

	/**
	 * Fetches database rows
	 *
	 * @param	int	The number of posts to get
	 * @param	int	The offset number
	 * @return	Databse_Result	The posts objects
	 */
	public function fetch($num = null, $offset = 0)
	{
		$result = $this->get_select();

		// Check to see if only a number of posts are requested, or all...
		if ($num !== null)
		{
			$result = $result->limit($num)->offset($offset);
		}

		return $result->as_object()->execute();
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
			->where("posts.slug", "=", $slug)
			->where("posts.posted_date", "LIKE", "{$date}%")
			->as_object()
			->execute();

		return (count($result) !== 0) ? $result->current() : null;
	}

	/** {@inheritdoc} */
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
		$expr = DB::expr("`posts`.*,GROUP_CONCAT(`categories`.`slug`) AS 'category_slugs',GROUP_CONCAT(`categories`.`display`) AS 'category_display'");

		return DB::select($expr)
			->from($this->table)
			->join('post_categories', 'left')->using('post_id')
			->join('categories', 'left')->using('category_id')
			->group_by('post_id')
			->order_by('posted_date', 'DESC');
	}

}