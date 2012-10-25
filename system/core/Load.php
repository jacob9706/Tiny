<?php

class Load
{
	public function view($templates, $variables = array())
	{
		new View_Model($templates, $variables);
	}

	public function helper($helper, &$context)
	{
		$file = 'system' . DS . 'helpers' . DS . $helper . '.php';
		if (file_exists($file)) {
			require_once $file;
			$class = ucfirst($helper);
			$context->$helper = new $class;
		}
	}

	public function helper_as($helper, $as, &$context)
	{
		$file = 'system' . DS . 'helpers' . DS . $helper . '.php';
		if (file_exists($file)) {
			require_once $file;
			$class = ucfirst($helper);
			$context->$as = new $class;
		}
	}

	public function model($model, &$context)
	{
		$file = 'application' . DS . 'models' . DS . $model . '.php';
		if (file_exists($file)) {
			require_once $file;
			$class = ucfirst($model) . '_Model';
			$context->model->$model = new $class;
		}
	}

	public function redirect($controller, $method = 'index', $variables = "")
	{
		$vars = array();
		if (is_array($variables)) {
			foreach ($variables as $key => $value) {
				$vars[] = urlencode($key) . '&' . urlencode($value);
			}
			$vars = implode("/", $vars);
		} else {
			$vars = $variables;
		}
		header('Location: http://' . $_SERVER['HTTP_HOST'] . array_shift(explode("index.php", $_SERVER['REQUEST_URI'])) . 'index.php/' . $controller . '/' . $method . '/' . $vars);
	}

	public function previous_page($getVars = '')
	{
		$vars = '';
		if (is_array($getVars)) {
			foreach ($getVars as $key => $value) {
				$vars .= $key . '&' . $value . '/';
			}
		} else {
			$vars = $getVars;
		}
		$server = $_SERVER['HTTP_REFERER'];

		$server = split('index.php/', $server);

		$stuff = split('/', $server[1]);

		$controller = $stuff[0];
		$method = $stuff[1];

		header('Location: ' . $server[0] . 'index.php/' . $controller . '/' . $method . '/' . $vars);
	}
}