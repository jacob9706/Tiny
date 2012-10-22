<?php

class Admin_Model extends Tiny_Model
{
	public function __construct()
	{
		parent::__construct();

		$this->load('helper', 'database');
	}

	public function login($username, $password)
	{
		$this->database->select(array('password', 'salt'), 'users');
		$this->database->where('username', '=', $username);

		$results = $this->database->get();
		$result = $results->fetch();

		if (empty($result)) {
			return false;
		}

		$hash = hash('sha256', $result['salt'] . hash('sha256', $password));

		if ($hash != $result['password']) {
			return false;
		}

		return true;
	}

	public function new_user($username, $password)
	{
		$hash = hash('sha256', $password);
		$salt = $this->createSalt();
		$hash = hash('sha256', $salt . $hash);

		return $this->database->insert('users', array('username' => $username, 'password' => $hash, 'salt' => $salt));
	}

	private function createSalt()
	{
	    $string = md5(uniqid(rand(), true));
	    return substr($string, 0, 3);
	}
}