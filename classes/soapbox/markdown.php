<?php defined('SYSPATH') or die('No direct access allowed.');

include_once APPPATH."vendor".DIRECTORY_SEPARATOR."Markdown.php";

/**
 * The Markdown parser to handle code highlighting
 *
 * @package    Soapbox
 * @author     Dave Widmer <dave@davewidmer.net>
 * @copyright  2011-2012 © Dave Widmer
 */
class Soapbox_Markdown extends MarkdownExtra_Parser
{
	/**
	 * @var boolean  Does the server have pygments installed?
	 */
	private $has_pygments = false;

	/**
	 * Creates a new markdown parser.
	 */
	public function __construct()
	{
		$path = exec("which pygmentize");
		$this->has_pygments = empty($path) === false;

		parent::MarkdownExtra_Parser();
	}

	/**
	 * Adding fenced code block syntax to regular Markdown.
	 *
	 * @param  string $text  The raw text to search
	 * @return string        Transformed text
	 */
	public function doFencedCodeBlocks($text)
	{
		$text = preg_replace_callback('{
				(?:\n|\A)
				# 1: Opening marker
				(
					[~|`]{3,} # Marker: three tilde or more.
				)
				([ ]*\w*[ ]*\n) # Optionally specifying the language.

				# 2: Content
				(
					(?>
						(?!\1 [ ]* \n)	# Not a closing marker.
						.*\n+
					)+
				)

				# Closing marker.
				\1 [ ]* \n
			}xm',
			array(&$this, '_doFencedCodeBlocks_callback'), $text);

		return $text;
	}

	/**
	 * Highlights the syntax, server-side of course!
	 *
	 * @param  array  $matches  The matches of the codeblocks
	 * @return string           Syntax highlighted text
	 */
	public function _doFencedCodeBlocks_callback($matches)
	{
		if ($this->has_pygments)
		{
			$ext = trim($matches[2]);

			// Pygments needs a temporary file....
			$temp = tempnam("/tmp", "soapbox");
			if ($ext !== "")
			{
				$temp .= ".{$ext}";
			}
			file_put_contents($temp, $matches[3]); // [3] is the code block
			
			// Run Pygmentize
			$call = "pygmentize -f html {$temp}";

			$output = array();
			exec($call, $output);

			// unlink the file
			unlink($temp);

			$code = implode("\n", $output);
			return $this->hashBlock($code);
		}
		else
		{
			return parent::_doFencedCodeBlocks_callback($matches);
		}
	}

}
