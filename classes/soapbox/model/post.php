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
	protected $fields = array('post_id','title','slug','content','posted_date');

	/**
	 * Creates a new recored.
	 *
	 * @param   array    $data    The data to add
	 * @return  array             array [0] insert id, [1] affected rows
	 */
	public function create(array $data)
	{
		$data['posted_date'] = date("Y-m-d H:i:s");
		$data['slug'] = str_replace(" ", "-", strtolower(trim($data['title'])));

		return parent::create($data);
	}

	/**
	 * Updates a blog post.
	 *
	 * @param   int    $key    Post id
	 * @param   array  $data   The update data
	 * @return  int            Affected rows
	 */
	public function update($key, array $data)
	{
		$data['slug'] = str_replace(" ", "-", strtolower(trim($data['title'])));
		return parent::update($key, $data);
	}

	/**
	 * Deletes a post and clears out the categories as well.
	 *
	 * @param   int   $key    The primary key value for the post to delete
	 * @return  int           The number of affected rows
	 */
	public function delete($key)
	{
		// The first step of this function deletes the categories
		Model_Post_Category::set_post($key, array());
		return parent::delete($key);
	}

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
	 * @param	string $slug   The slug of the category to look for
	 * @param   int    $num    The numbner of posts per page
	 * @param   int    $page   The page
	 * @return	Database_Result
	 */
	public static function in_category($slug, $num, $page)
	{
		$offset = ($page - 1) * $num;

		$result = DB::select(static::$table.".*")
			->from(static::$table)
			->join(Model_Post_Category::$table)->using(static::$primary)
			->join(Model_Category::$table)->using(Model_Category::$primary)
			->where(Model_Category::$table.".slug", "=", $slug)
			->order_by('posted_date', 'DESC')
			->order_by('post_id', 'DESC')
			->limit($num)
			->offset($offset)
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
	 * Searches the title/content for the query string.
	 *
	 * @param   string   $query   The seach query
	 * @return  array
	 */
	public static function search($query)
	{
		return DB::select()
			->from(static::$table)
			->or_where('title', 'LIKE', "%{$query}%")
			->or_where('content', 'LIKE', "%{$query}%")
			->order_by('posted_date', 'DESC')
			->order_by(static::$primary, 'DESC')
			->as_object()
			->execute();
	}

	/**
	 * Grabs the latests posts in a format that can be used in a RSS feed.
	 *
	 * @see     http://feed2.w3.org/docs/rss2.html
	 *
	 * @param   int   $num   The number of items to grab
	 * @return  array        The feed items
	 */
	public static function feed($num = 5)
	{
		$posts = DB::select()
			->from(static::$table)
			->order_by('posted_date', 'DESC')
			->order_by(static::$primary, 'DESC')
			->as_object()
			->limit($num)
			->execute();

		$feed = array();
		foreach($posts as $row)
		{
			list($content) = static::truncate($row->content);

			$item = array(
				'title' => $row->title,
				'link' => static::permalink($row, 'http'),
				'description' => htmlentities($content),
				'pubDate' => Date::formatted_time($row->posted_date, 'r'),
			);

			$item['guid'] = $item['link'];
			$feed[] = $item;
		}

		return $feed;
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
			trim($result[0]),
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
	 * Checks to see if there is a previous page.
	 *
	 * @param    int    $page    The page to check if there is a previous
	 * @return   boolean
	 */
	public static function has_previous_page($page = 1)
	{
		return $page > 1;
	}

	/**
	 * Checks to see if there is a next page.
	 *
	 * @param    int     $page    The page to check if there are previous posts
	 * @param    string  $slug    The category slug (if applicable)
	 * @return   boolean
	 */
	public static function has_next_page($page, $slug = null)
	{
		$num = Kohana::$config->load('soapbox')->per_page;

		return (($page * $num) < static::count($slug));
	}

	/**
	 * The number of posts
	 *
	 * @param    string   $slug   The category slug (if applicable)
	 * @return   int
	 */
	public static function count($slug = null)
	{
		$query = DB::select(DB::expr("COUNT(*) AS `count`"))
			->from(static::$table)
			->as_object();

		if ($slug !== null)
		{
			$query->join(Model_Post_Category::$table)->using(static::$primary)
				->join(Model_Category::$table)->using(Model_Category::$primary)
				->where(Model_Category::$table.".slug", "=", $slug);
		}

		return (int) $query->execute()->current()->count;
	}

	/**
	 * Gets the permalink url to a post.
	 *
	 * @param   object   $post       The post object to permalink.
	 * @param   string   $protocol   If a protocol is specified, make a full url
	 * @param   string               The full url to the post
	 */
	public static function permalink($post, $protocol = null)
	{
		$route = Route::get('soapbox/post')->uri(array(
			'year' => Date::formatted_time($post->posted_date, "Y"),
			'month' => Date::formatted_time($post->posted_date, "m"),
			'slug' => $post->slug
		));

		return URL::site($route, $protocol);
	}

	/**
	 * Validates a new post.
	 *
	 * @param   array   $data    The posted data to validate
	 * @return  boolean
	 */
	public function validate_new(array $data)
	{
		// Setup a new validation instance if this one doesn't exist.
		if ($this->validation === null)
		{
			$this->validation = new Validation($data);
			$this->validation->rule('title', 'not_empty')->rule('content', 'not_empty');
		}

		return $this->validation->check();
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
			->rule('content', 'not_empty')
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