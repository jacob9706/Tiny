<?php

// Load Config Files
require_once 'system/config/General.php';
require_once 'system/config/Database.php';

// Load Nessesary Classes
require_once 'system/core/Tools.php';
require_once 'system/core/Model.php';
require_once 'system/core/Controller.php';
require_once 'system/core/View.php';

class Router {
	private $getVars;

	public function __construct()
	{
	}

	public function route($pathInfo)
	{
		// Get the passed request
		if (!empty($pathInfo) && $pathInfo != "/") {
			$request = 	rtrim($pathInfo, '/');

			// Explode and get variables
			$parsed = explode('/', $request);

			// Remove empty slot in array caused by leading '/'
			array_shift($parsed);
		} else {
			$parsed = array();
		}

		// The page is first element
		$page = array_shift($parsed);
		urldecode($page);

		$page = empty($page) ? 'index' : $page;

		// The method is second element
		$method = array_shift($parsed);
		urldecode($method);

		$method = empty($method) ? 'index' : $method;

		$this->getVars = array();
		foreach ($parsed as $argument) {
			if (strpos($argument, "=")) {
				// Split GET vars along "=" symbol to separate variable => values
				list($variable, $value) = explode('=', $argument);
				$this->getVars[urldecode($variable)] = urldecode($value);
			} else {
				$this->getVars[] = urldecode($argument);
			}
		}

		// Make path to the file
		$target = 'application/controllers/' . $page . '.php';

		if (file_exists($target)) {
			include_once $target;

			$class = ucfirst($page) . '_Controller';

			if (class_exists($class)) {
				$controller = new $class;
			} else {
				$this->throw_error();
			}
		} else {
			$this->throw_error();
		}

		if (!empty($method)) {
			if(method_exists($controller, $method)) {
				$controller->$method($this->getVars);
			} else {
				$this->throw_error();
			}
		} else {
			$controller->index($this->getVars);	
		}
	}

	private function throw_error()
	{
		if (file_exists('application/controllers/serverErrors.php')) {
			include_once 'application/controllers/serverErrors.php';

			if (method_exists('ServerErrors_Controller', 'error_404')) {
				$controller = new ServerErrors_Controller();
				$controller->error_404($this->getVars);
				exit();
			} else {
				die('Page does not exist.');
			}
		} else {
			die('Page does not exist.');
		}
	}
}