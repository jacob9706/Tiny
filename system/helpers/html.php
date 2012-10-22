<?php

class HTML
{
	/**
	 * Method to help create links to methods in controlelrs
	 * @param  string $controller
	 * @param  string $method
	 * @param  string $text
	 * @param  string $variables  This can be an array or string. The array can be associative or indexed
	 * @param  string $extras     Put things like 'class="btn"'
	 * @return string             A string containing a formated anchor tag
	 */
	public function create_a($controller, $method, $text, $variables = "", $extras = "")
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
		return '<a ' . $extras .' href="http://' . $_SERVER['HTTP_HOST'] . array_shift(explode("index.php", $_SERVER['REQUEST_URI'])) . 'index.php/' . $controller . '/' . $method . "/" . $vars . '">' . $text . '</a>';
	}

	/**
	 * Method to help create links that submit a form for post data (BEWARE, THIS RELYS ON JAVASCRIPT BEING ENABLED)
	 * @param  string $controller 
	 * @param  string $method     
	 * @param  string $text       
	 * @param  Array  $variables  The array can be associative or indexed
	 * @param  string $extras     Put things like 'class="btn"'
	 * @return string             A string containing formated link to form
	 */
	public function create_post_a($controller, $method, $text, Array $variables, $extras = "")
	{
		$vars = "";
		if (is_array($variables)) {
			foreach ($variables as $key => $value) {
				$vars = '<input type="hidden" name="' . $key . '" value="' . $value . '">';
			}
		}
		$id = $this->randString(6);
		$html = '<script type="text/javascript">function ' . $id . '(){document.forms["' . $id . '"].submit();}</script>';
		$html .= '<form style="display: none; visibility: hidden;" action="http://' . $_SERVER['HTTP_HOST'] . array_shift(explode("index.php", $_SERVER['REQUEST_URI'])) . 'index.php/' . $controller . '/' . $method . '" id="' . $id .'" method="post">';
		$html .= $vars;
		$html .= '</form>';
		$html .= '<a ' . $extras .' href="javascript: ' . $id .'()">' . $text . '</a>';
		return $html;
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

	private function randString($length, $charset='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz')
	{
		$str = '';
		$count = strlen($charset);
		while ($length--) {
			$str .= $charset[mt_rand(0, $count-1)];
		}
		return $str;
	}
}