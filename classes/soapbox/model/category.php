<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Blog Categories Model.
 *
 * @package     Soapbox
 * @author      Dave Widmer <dave@davewidmer.net>
 * @copyright   2011 © Dave Widmer
 */
class Soapbox_Model_Category extends Soapbox_Model
{
	public $primary = "category_id";
	public $table = "categories";

	protected $fields = array('category_id','slug','display');

	/** {@inheritdoc} */
	protected function validation_rules($valid)
	{
		return $valid->rule('slug', 'not_empty')
			->rule('display', 'not_empty');
	}
}