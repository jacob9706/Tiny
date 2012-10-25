<?php

session_start();

// Load Config Files
require_once 'system' . DS . 'config' . DS . 'General.php';
require_once 'system' . DS . 'config' . DS . 'Database.php';

// Load Nessesary Classes
require_once 'system' . DS . 'core' . DS . 'Tools.php';
require_once 'system' . DS . 'core' . DS . 'Model.php';
require_once 'system' . DS . 'core' . DS . 'Controller.php';
require_once 'system' . DS . 'core' . DS . 'View.php';

class Router {
	private 
		$getVars = array(),
		$postVars = array();

	public function __construct()
	{
	}

	public function route($pathInfo)
	{
		// Get the passed request
		if (!empty($pathInfo) && $pathInfo != "/") {
			// Trim off last / to avoid empty variable in our created emulaated get variables
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
		$method = urldecode($method);

		$method = empty($method) ? 'index' : $method;

		$GLOBALS['page'] = $method;

		foreach ($parsed as $argument) {
			if (strpos($argument, "&")) {
				// Split GET vars along "=" symbol to separate variable => values
				list($variable, $value) = explode('&', $argument);
				$this->getVars[urldecode($variable)] = urldecode($value);
			} else {
				$this->getVars[] = urldecode($argument);
			}
		}

		$GLOBALS['getVars'] = $this->getVars;

		if (!empty($_POST)) {
			$this->postVars = $_POST;
		}

		// Make path to the file
		$target = 'application' . DS . 'controllers' . DS . $page . '.php';

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
				$controller->$method($this->getVars, $this->postVars);
			} else {
				$this->throw_error();
			}
		} else {
			$controller->index($this->getVars, $this->postVars);
		}
	}

	private function throw_error()
	{
		if (file_exists('application' . DS . 'controllers' . DS . 'serverErrors.php')) {
			include_once 'application' . DS . 'controllers' . DS . 'serverErrors.php';

			if (method_exists('ServerErrors_Controller', 'error_404')) {
				$controller = new ServerErrors_Controller();
				$controller->error_404($this->getVars, $this->postVars);
				exit();
			} else {
				die('Page does not exist.');
			}
		} else {
			die('Page does not exist.');
		}
	}
}