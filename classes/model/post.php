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
				'content' => \Cactus\Field::VARCHAR,
				'posted_date' => \Cactus\Field::DATETIME
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
	 * @param  int    $year   The post year
	 * @param  int    $month  The post month
	 * @return Soapbox_Post OR null
	 */
	public function find_post($slug, $year, $month)
	{
		$result = $this->find(array(
			'slug' => $slug,
			'posted_date' => array("{$year}-{$month}%", "LIKE")
		));

		if (count($result) == 0)
		{
			return null;
		}

		return $result->current();
	}

	/**
	 * Get the neighboring posts of the given post.
	 *
	 * @param  int $id  The post id to check
	 * @return array     array($newer, $older)
	 */
	public function get_neighbors($id)
	{
		return array(
			$this->get_newer($id),
			$this->get_older($id),
		);
	}

	/**
	 * Gets a post that is "newer".
	 *
	 * @param  int $id  The id
	 * @return $this->object_class
	 */
	public function get_newer($id)
	{
		$result = $this->find(array(
			$this->primary_key => array($id, ">"),
			'order_by' => array("post_id", "ASC"),
			'limit' => 1
		));

		return (count($result) == 0) ? null : $result->current();
	}

	/**
	 * Gets a post that is "older".
	 *
	 * @param  int $id  The id
	 * @return $this->object_class
	 */
	public function get_older($id)
	{
		$result = $this->find(array(
			$this->primary_key => array($id, "<"),
			'order_by' => array("post_id", "DESC"),
			'limit' => 1
		));

		return (count($result) == 0) ? null : $result->current();
	}

}