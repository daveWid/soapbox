<?php defined('SYSPATH') or die('No direct script access.');

/**
 * The model that gets data from the `posts` table.
 *
 * @package    Soapbox
 * @author     Dave Widmer <dave@davewidmer.net>
 * @copyright  2011-2012 © Dave Widmer
 */
class Model_Post extends \Cactus\Model
{
	/**
	 * Setup for the model
	 */
	public function __construct()
	{
		parent::__construct(array(
			'table' => "post",
			'primary_key' => "post_id",
			'columns' => array(
				'post_id' => \Cactus\Field::INT,
				'title' => \Cactus\Field::VARCHAR,
				'slug' => \Cactus\Field::VARCHAR,
				'source' => \Cactus\Field::VARCHAR,
				'html' => \Cactus\Field::VARCHAR,
				'excerpt' => \Cactus\Field::VARCHAR,
				'posted_date' => \Cactus\Field::DATE,
				'last_modified' => \Cactus\Field::DATETIME
			),
			'object_class' => "Soapbox_Post",
			'relationships' => array(
				'categories' => array(
					'type' => \Cactus\Relationship::HAS_MANY,
					'driver' => "Model_Category",
					'column' => 'post_id'
				)
			)
		));
	}

	/**
	 * Normalize the data before it is added.
	 *
	 * @param  \Cactus\Entity $object    The object to save
	 * @param  boolean        $validate  Validate the object?
	 * @return array
	 */
	public function create(\Cactus\Entity &$object, $validate = true)
	{
		$slug = str_replace(" ", "-", strtolower($object->title));
		$slug = preg_replace("/[^a-z|\-]+/", "", $slug);
		$object->slug = $object->posted_date->format("Y/m/").$slug;

		$object->posted_date = $object->posted_date->format("Y-m-d");
		$object->last_modified = date("Y-m-d H:i:s");

		// Now render the content.
		include APPPATH."vendor".DIRECTORY_SEPARATOR."Markdown.php";
		$md = new MarkdownExtra_Parser;
		$object->html = $md->transform($object->source);

		list($exerpt) = explode(PHP_EOL, $object->source);
		$object->excerpt = $md->transform($exerpt);

		return parent::create($object, $validate);
	}

	/**
	 * Get the latest posts.
	 *
	 * @param  int $num  The number of posts to try and find
	 * @return \Cactus\Collection
	 */
	public function latest($num = 10)
	{
		return $this->find(array(
			'order_by' => array('posted_date', 'DESC'),
			'limit' => $num
		));
	}

	/**
	 * Locates a post with the given slug and year-month combo.
	 *
	 * @param  string $slug   The post slug
	 * @return Soapbox_Post OR null
	 */
	public function find_post($slug)
	{
		$result = $this->find(array(
			'slug' => $slug
		));

		if (count($result) == 0)
		{
			return null;
		}

		return $result->current();
	}

	/**
	 * Gets all of the posts that have the given category.
	 *
	 * @param string $category  The category slug
	 * @return \Cactus\Collection
	 */
	public function get_category($category)
	{
		$query = new \Peyote\Select;
		$query->table($this->table)
			->columns("post.*")
			->join('post_category')->using('post_id')
			->join('category')->using('category_id')
			->order_by("posted_date", "DESC")
			->where('category.slug', '=', $category);

		return $this->find(array(), $query);
	}

	/**
	 * Searches the site for a given query.
	 *
	 * @param  string $query   The query to search for.
	 * @return \Cactus\Collection
	 */
	public function search($term)
	{
		$select = new \Peyote\Select($this->table);
		$select->where("title,source", "AGAINST", $term);

		return $this->find(array(), $select);
	}

}