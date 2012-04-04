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
			'order_by' => 'posted_date',
			'limit' => $num
		));
	}

}