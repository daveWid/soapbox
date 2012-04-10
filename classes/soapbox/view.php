<?php defined('SYSPATH') or die('No direct access allowed.');

/**
 * A wrapper for the Owl\View class to automate the template loading.
 *
 * @package    Soapbox
 * @author     Dave Widmer <dave@davewidmer.net>
 * @copyright  2011-2012 © Dave Widmer
 */
class Soapbox_View extends \Owl\View
{
	/**
	 * @var string  The error message
	 */
	public $message = "";

	/**
	 * Gets the name of the file to search for. 
	 *
	 * @return string
	 */
	public function get_file()
	{
		$class = strtolower(get_called_class());
		$parts = explode("_", $class);
		array_shift($parts);

		return implode(DIRECTORY_SEPARATOR, $parts).".mustache";
	}

	/**
	 * Is there is message?
	 *
	 * @return string or boolean false
	 */
	public function has_message()
	{
		$this->message = Session::instance()->get_once("soapbox_error", false);

		return $this->message ? true : false;
	}

}