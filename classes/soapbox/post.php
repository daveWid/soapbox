<?php defined('SYSPATH') or die('No direct access allowed.');

/**
 * A class representation of a row in the posts table.
 *
 * @package    Soapbox
 * @author     Dave Widmer <dave@davewidmer.net>
 * @copyright  2011-2012 © Dave Widmer
 */
class Soapbox_Post extends \Cactus\Entity
{
	/**
	 * Setup a new post object.
	 *
	 * @param array $data  The data to set.
	 */
	public function __construct(array $data = null)
	{
		if ($data !== null)
		{
			$date = Arr::get($data, 'posted_date', false);
			$data['posted_date'] = ($date !== false) ?
				DateTime::createFromFormat("Y-m-d", $date) :
				new DateTime ;
		}

		parent::__construct($data);
	}

	/**
	 * A human readable date of when the post was posted.
	 *
	 * @param  string $format  The date format
	 * @return string
	 */
	public function date($format = "F jS, Y")
	{
		return $this->posted_date->format($format);
	}

	/**
	 * Are there categories with this post? 
	 *
	 * @return boolean
	 */
	public function has_categories()
	{
		return count($this->categories) > 0;
	}

	/**
	 * @return string  A list of categories in display format.
	 */
	public function display_categories()
	{
		$display = array();

		foreach ($this->categories as $cat)
		{
			$display[] = $cat->display;
		}

		return implode(" ", $display);
	}

	/**
	 * @return string  The publication date of the post
	 */
	public function pubDate()
	{
		return $this->date('r');
	}

	/**
	 * @return string  The permalink for the post
	 */
	public function permalink()
	{
		return Route::url('soapbox/post', array('slug' => $this->slug));
	}

	/**
	 * Lamda function for getting administration routes...
	 *
	 * @return Closure
	 */
	public function admin()
	{
		$id = $this->post_id;

		return function($action) use ($id){
			return Route::url('soapbox/admin', array(
				'action' => $action,
				'id' => $id
			));
		};
	}

	/**
	 * Checks to see if the data is valid.
	 *
	 * @return boolean   Is the data valid?
	 */
	public function is_valid()
	{
		$this->validation = new Validation($this->data());

		$this->validation->rule('title', 'not_empty')
			->rule('source', 'not_empty')
			->rule('posted_date', 'not_empty');

		return $this->validation->check();
	}

	/**
	 * Validation errors.
	 *
	 * @param   type     $file        The path to the message file
	 * @param   boolean  $translate   Translate the errors?
	 * @return  array
	 */
	public function errors($file = null, $translate = true)
	{
		$errors = $this->validation->errors($file, $translate);
		return implode("<br />", $errors);
	}

}