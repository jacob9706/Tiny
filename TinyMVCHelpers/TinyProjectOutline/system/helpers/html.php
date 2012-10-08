<?php

class HTML
{
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

	public function create_link($file, $type="text/css", $rel="stylesheet")
	{
		return '<link href="http://' . $_SERVER['HTTP_HOST'] . array_shift(explode("index.php", $_SERVER['REQUEST_URI'])) . $file . '" type="' . $type . '" rel="' . $rel .'">';
	}

	public function create_script($file, $type="text/javascript")
	{
		return '<script src="http://' . $_SERVER['HTTP_HOST'] . array_shift(explode("index.php", $_SERVER['REQUEST_URI'])) . $file . '" type="' . $type . '"></script>';
	}
}