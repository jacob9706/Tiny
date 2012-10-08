<?php

/*function __autoload($className)
{
	// Parse out filename where class should be
	list($filename, $suffix) = split('_', $className);

	// Make filename
	$file = 'application/models/' . strtolower($filename) . '.php';

	if (file_exists($file)) {
		include_once $file;
	} else {
		$file = 'system/core/View.php';
		if (file_exists($file)) {
			include_once $file;
		} else {
			die('File' . $file . ' containing class ' . $className . ' not found');
		}
	}
}*/

require_once 'system/config/General.php';
require_once 'system/config/Database.php';

require_once 'system/core/Tools.php';
require_once 'system/core/Model.php';
require_once 'system/core/Controller.php';
require_once 'system/core/View.php';

class Router {
	public function __construct()
	{
		// Get the passed request
		$request = 	$_SERVER['PATH_INFO'];

		// Explode and get variables
		$parsed = explode('/', $request);

		// Remove empty slot in array caused by leading '/'
		array_shift($parsed);

		// The page is first element
		$page = array_shift($parsed);
		urldecode($page);

		$page = empty($page) ? 'index' : $page;

		// The method is second element
		$method = array_shift($parsed);
		urldecode($method);

		$method = empty($method) ? 'index' : $method;

		$getVars = array();
		foreach ($parsed as $argument) {
			if (strpos($argument, "=")) {
				// Split GET vars along "=" symbol to separate variable => values
				list($variable, $value) = split('=', $argument);
				$getVars[urldecode($variable)] = urldecode($value);
			} else {
				$getVars[] = urldecode($argument);
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
				die('class does not exist.');
			}
		} else {
			die('page does not exist.');
		}

		if (!empty($method)) {
			if(method_exists($controller, $method)) {
				$controller->$method($getVars);
			} else {
				die('method does not exist.');
			}
		} else {
			$controller->index($getVars);	
		}
	}
}