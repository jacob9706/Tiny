<?php

class HTML
{
	public function create_link($controller, $method, $text, $variables = "")
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
}