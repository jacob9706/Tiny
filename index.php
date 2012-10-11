<?php

error_reporting(E_ALL); 
ini_set('display_errors',1);

ob_start();

define('DS', DIRECTORY_SEPARATOR);

require_once 'system' . DS . 'core' . DS . 'Router.php';

$router = new Router();
$router->route(!empty($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : "");