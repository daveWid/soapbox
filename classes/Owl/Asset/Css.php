<?php

namespace Owl\Asset;

/**
 * A CSS asset for an Owl view
 *
 * @package   Owl
 * @author    Dave Widmer <dwidmer@bgsu.edu>
 */
class Css
{
	/**
	 * @var string  The href for the link
	 */
	public $href;

	/**
	 * @var string   The media type
	 */
	public $media;

	/**
	 * Creates a new CSS view asset.
	 *
	 * @param string $href   The link href
	 * @param string $media  The media type
	 */
	public function __construct($href, $media = null)
	{
		$this->href = $href;
		$this->media = $media ?: "all";
	}

	/**
	 * Renders the asset to html
	 *
	 * @return  string  The html for the <link>
	 */
	public function __toString()
	{
		return '<link href="'.$this->href.'" media="'.$this->media.'" rel="stylesheet" type="text/css">';
	}

}
