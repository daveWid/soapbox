<?php

namespace Owl\Form;

/**
 * A select option class.
 *
 * @package   Owl
 * @author    Dave Widmer <dwidmer@bgsu.edu>
 */
class Option
{
	/**
	 * @var string  The label for the option
	 */
	public $label;

	/**
	 * @var string  The option value
	 */
	public $value;

	/**
	 * @var boolean  Is this option the selected one?
	 */
	public $selected = false;

	/**
	 * Creates a new CSS view asset.
	 *
	 * @param string $name      The name of the
	 * @param string $label     The option label
	 * @param string $selected  The selected value
	 */
	public function __construct($value, $label, $selected = "")
	{
		$this->value = $value;
		$this->label = $label;
		$this->selected = $selected === $value;
	}

}
