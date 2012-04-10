<?php defined('SYSPATH') or die('No direct script access.');

/**
 * A user based model.
 *
 * @package    Soapbox
 * @author     Dave Widmer <dave@davewidmer.net>
 * @copyright  2011-2012 © Dave Widmer
 */
class Model_User extends \Cactus\Model
{
	/**
	 * Model Setup
	 */
	public function __construct()
	{
		parent::__construct(array(
			'columns' => array(
				'email' => \Cactus\Field::VARCHAR,
				'password' => \Cactus\Field::VARCHAR,
			),
			'object_class' => "Soapbox_User",
		));
	}

	/**
	 * Attempt to log a user in
	 *
	 * @param  string $email  The email address
	 * @param  string $pass   The password
	 * @return boolean 
	 */
	public function login($email, $pass)
	{
		return ($email === "admin" AND $pass === "demo");
	}

}