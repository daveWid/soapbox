<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Post Categories Model.
 *
 * @package		Soapbox
 * @author		Dave Widmer
 * @copyright	2011 © Dave Widmer
 */
class Soapbox_Model_Post_Categories extends Soapbox_Model
{
	public $primary = "post_id";
	public $table = "post_categories";

	protected $fields = array('post_id', 'category_id');

	/**
	 * Gets all of the categories from the given post.
	 *
	 * @param	int	The post id
	 * @return	array	The categories
	 */
	public function get_post_categories($id)
	{	
		$query = DB::select()
					->from($this->table)
					->join('categories')->using('category_id')
					->where('post_id', '=', $id)
					->as_object()
					->execute();

		if (count($query) === 0)
		{
			return array();
		}
		else
		{
			$result = array();
			
			foreach ($query as $row)
			{
				$result[$row->slug] = $row->display;
			}

			return $result;
		}
	}
	
	/** {@inheritdoc} */
	protected function validation_rules($valid)
	{
		return $valid->rule('post_id', 'not_empty')
			->rule('category_id', 'not_empty');
	}
}