<?php

class Users
{
	public function require_login($level = 1)
	{
		if (!$_SESSION['user_status'] || $_SESSION['user_level'] < $level) {
			header('Location: http://' . $_SERVER['HTTP_HOST'] . array_shift(explode("index.php", $_SERVER['REQUEST_URI'])) . 'index.php/serverErrors/404');
		}
	}

	public function login($who, $level = 1)
	{
		$_SESSION['user_status'] = true;
		$_SESSION['username'] = $who;
		$_SESSION['user_level'] = $level;
	}

	public function logout()
	{
		$_SESSION['user_status'] = false;
		$_SESSION['username'] = null;
		$_SESSION['user_level'] = null;
	}

	public function get_status()
	{
		return !empty($_SESSION['user_status']) ? $_SESSION['user_status'] : false;
	}

	public function get_username()
	{
		return !empty($_SESSION['username']) ? $_SESSION['username'] : false;
	}

	public function get_level()
	{
		return !empty($_SESSION['user_level']) ? $_SESSION['user_level'] : false;
	}
}