<?php

namespace Owl\Asset;

/**
 * A JavaScript asset for an owl view.
 *
 * @package   Owl
 * @author    Dave Widmer <dwidmer@bgsu.edu>
 */
class JavaScript
{
	/**
	 * @var string  The src for the script tag
	 */
	public $src;

	/**
	 * Creates a new JS view asset.
	 *
	 * @param string $src   The script source
	 */
	public function __construct($src)
	{
		$this->src = $src;
	}

	/**
	 * Renders the asset to html
	 *
	 * @return  string  The html for the <script>
	 */
	public function __toString()
	{
		return '<script src="'.$this->src.'"></script>';
	}

}
