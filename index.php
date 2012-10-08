<?php

ob_start();

define('DS', DIRECTORY_SEPARATOR);

$url = $_GET['url'];

require_once 'system' . DS . 'core' . DS . 'Router.php';

new Router();