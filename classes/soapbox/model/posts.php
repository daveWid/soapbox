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

	/** {@inheritdoc} */
	public function insert(array $data)
	{
		// Add in the posted date
		$data['posted_date'] = date('Y-m-d');

		return parent::insert($data);
	}

	/**
	 * Gets a number of recent posts
	 *
	 * @throws	Database_Exception
	 *
	 * @param	int	The number of posts to get
	 * @param	int	The offset number
	 * @return	Databse_Result	The posts objects
	 */
	public function get_posts($num, $offset = 0)
	{
		$result = $this->get_select()
			->limit($num)
			->offset($offset)
			->as_object()
			->execute();

		if (count($result) === 0)
		{
			throw new Database_Exception(204, "No Content");
		}

		return $result;
	}

	/**
	 * Get the posts from a category.
	 *
	 * @throws	Database_Exception
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

		if (count($result) === 0)
		{
			throw new Database_Exception(204, "No Content");
		}

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

		if (count($result) === 0)
		{
			throw new Database_Exception(204, "No Content");
		}

		return $result->current();
	}

	/** {@inheritdoc} */
	protected function validation_rules($valid)
	{
		return $valid->rule('title', 'not_empty')
			->rule('slug', 'not_empty')
			->rule('contents', 'not_empty');
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
			->join('post_categories')->using('post_id')
			->join('categories')->using('category_id')
			->group_by('post_id')
			->order_by('posted_date', 'DESC');
	}

}