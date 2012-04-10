<?php defined('SYSPATH') or die('No direct access allowed.');

/**
 * A full archive page
 *
 * @package    Soapbox
 * @author     Dave Widmer <dave@davewidmer.net>
 * @copyright  2011-2012 © Dave Widmer
 */
class View_Archive extends View_List
{
	/**
	 * @var array  The posts broken up by years.
	 */
	private $by_year = null;
	
	/**
	 * Setup the archive page.
	 *
	 * @param \Cactus\Collestion $posts  The posts to be viewed on this page
	 * @param string             $title  The page title to set
	 */
	public function __construct($posts)
	{
		parent::__construct($posts, "Archive");

		foreach ($posts as $row)
		{
			$this->by_year[$row->date("Y")][] = $row;
		}
	}

	/**
	 * Gets all of the years that have posts.
	 *
	 * @return array  array of years
	 */
	public function get_years()
	{
		$years = array();

		foreach (array_keys($this->by_year) as $y)
		{
			$years[] = array(
				'year' => $y,
				'posts' => $this->by_year[$y]
			);
		}

		return $years;
	}
}
