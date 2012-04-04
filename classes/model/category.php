<?php defined('SYSPATH') or die('No direct script access.');

/**
 * The model that gets data from the `category` table.
 *
 * @package    Soapbox
 * @author     Dave Widmer <dave@davewidmer.net>
 * @copyright  2011-2012 © Dave Widmer
 */
class Model_Category extends \Cactus\Model
{
	/**
	 * Setup for the model
	 */
	public function __construct()
	{
		parent::__construct(array(
			'table' => "post_category",
			'primary_key' => "category_id",
			'columns' => array(
				'category_id' => \Cactus\Field::INT,
				'post_id' => \Cactus\Field::INT,
				'slug' => \Cactus\Field::VARCHAR,
				'display' => \Cactus\Field::VARCHAR,
			),
			'object_class' => "Soapbox_Category",
		));
	}

	/**
	 * Finds records with the given parameters.
	 *
	 * @param  array          $params  The database parameters to search on
	 * @param  \Peyote\Select $query   A Select query.
	 * @return \Cactus\Collection
	 */
	public function find($params = array(), $query = null)
	{
		if ($query === null)
		{
			$query = new \Peyote\Select;
			$query->table($this->table)
				->join("category")->using("category_id");
		}

		return parent::find($params, $query);
	}

}
