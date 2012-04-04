<?php defined('SYSPATH') or die('No direct access allowed.');

/**
 * A quick and dirty Dependancy Injection Container.
 *
 * @package    Soapbox
 * @author     Dave Widmer <dave@davewidmer.net>
 * @copyright  2011-2012 © Dave Widmer
 */
class Container
{
	/**
	 * @var PDO The pdo object used for database calls.
	 */
	private $pdo = null;

	/**
	 * Gets a model, and makes sure that the adapter is set.
	 *
	 * @param  string $name  The name of the model
	 * @return \Cactus\Model
	 */
	public function model($name)
	{
		$model = new $name;

		if ($model->get_adapter() === null)
		{			
			$adapter = new \Cactus\Adapter\PDO;
			$adapter->set_connection($this->get_pdo());
			$model->set_adapter($adapter);
		}

		return $model;
	}

	/**
	 * The PDO connection object.
	 *
	 * @return PDO 
	 */
	public function get_pdo()
	{
		if ($this->pdo === null)
		{
			$config = Kohana::$config->load('database.default.connection');
			$this->pdo = new PDO($config['dsn'], $config['username'], $config['password']);
		}

		return $this->pdo;
	}
}