<?php defined('SYSPATH') or die('No direct access allowed.');

/**
 * The Controller handles loading the correct layout as well as rendering the
 * output correctly.
 *
 * @package    Soapbox
 * @author     Dave Widmer <dave@davewidmer.net>
 * @copyright  2011-2012 © Dave Widmer
 */
class Controller extends Kohana_Controller
{
	/**
	 * @var \Owl\Layout  The layout view file
	 */
	protected $layout;

	/**
	 * @var mixed The content to add to the layout
	 */
	protected $content;

	/**
	 * @var User The currently logged in user
	 */
	protected $user = null;

	/**
	 * @var boolean  Is the request from a mobile device?
	 */
	protected $is_mobile = false;

	/**
	 * @var Container  The dependency injection container
	 */
	protected $di = null;

	/**
	 * Gets the logged in user if they are available
	 */
	public function before()
	{
		// Setup the DI container
		$this->di = new Container;

		// Check for a user
		$this->user = Session::instance()->get("soapbox_user");

		// See which request to load
		$layout = "View_Layout_Browser";

		$detect = new Mobile_Detect;

		if ($detect->isMobile())
		{
			$layout = "View_Layout_Mobile";
			$this->is_mobile = true;
		}

		// Create the layout and setup needed variables
		$this->layout = $this->di->view($layout);

		return parent::before();
	}

	/**
	 * Renders the content either in the layout or json encoded, depending on
	 * the request. 
	 */
	public function after()
	{
		if ($this->request->is_ajax())
		{
			$type = "application/json";
			$content = json_encode($this->content);
		}
		else
		{
			$this->layout->set_content($this->content);

			$type = "text/html";
			$content = $this->layout->render();
		}

		// Send the proper response
		$this->response->headers("Content-Type", $type)->body($content);
	}

}
