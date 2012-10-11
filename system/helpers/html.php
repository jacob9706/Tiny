<?php

class HTML
{
	/**
	 * Method to help create links to methods in controlelrs
	 * @param  string $controller
	 * @param  string $method
	 * @param  string $text
	 * @param  string $variables  This can be an array or string. The array can be associative or indexed
	 * @return string             A string containing a formated anchor tag
	 */
	public function create_a($controller, $method, $text, $variables = "")
	{
		$vars = array();
		if (is_array($variables)) {
			foreach ($variables as $key => $value) {
				$vars[] = urlencode($key) . '=' . urlencode($value);
			}
			$vars = implode("/", $vars);
		} else {
			$vars = $variables;
		}
		return '<a href="http://' . $_SERVER['HTTP_HOST'] . array_shift(explode("index.php", $_SERVER['REQUEST_URI'])) . 'index.php/' . $controller . '/' . $method . "/" . $vars . '">' . $text . '</a>';
	}

	/**
	 * Method to help create links to stylesheets
	 * @param  string $file Path to file within project directory
	 * @param  string $type Defaults to text/css
	 * @param  string $rel  Defaults to stylesheet
	 * @return string       A string containing a formated link tag
	 */
	public function create_link($file, $type="text/css", $rel="stylesheet")
	{
		return '<link href="http://' . $_SERVER['HTTP_HOST'] . array_shift(explode("index.php", $_SERVER['REQUEST_URI'])) . $file . '" type="' . $type . '" rel="' . $rel .'">';
	}

	public function create_script($file, $type="text/javascript")
	{
		return '<script src="http://' . $_SERVER['HTTP_HOST'] . array_shift(explode("index.php", $_SERVER['REQUEST_URI'])) . $file . '" type="' . $type . '"></script>';
	}

	public function create_img($file, $alt="image", $width="", $height="")
	{
		return '<img src="http://' . $_SERVER['HTTP_HOST'] . array_shift(explode("index.php", $_SERVER['REQUEST_URI'])) . $file . '" alt="' . $alt . '" width="' . $width . '" height="' . $height . '"/>';
	}
}