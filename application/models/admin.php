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
		$this->database->select(array('password', 'salt', 'valid'), 'users');
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

		if (!$result['valid']) {
			return 'Please validate user by checking your email.';
		}

		return true;
	}

	public function new_user($username, $email, $password, $require_validation = true)
	{
		$hash = hash('sha256', $password);
		$salt = $this->createSalt();
		$hash = hash('sha256', $salt . $hash);

		if ($require_validation) {
			$this->validate_user($username, $email, $salt);
			
			$result = $this->database->insert('users', array('username' => $username, 'email' => $email, 'password' => $hash, 'salt' => $salt, 'valid' => false));
			echo $this->database->getCurrentQueryString();
			return $result;
		}

		return $this->database->insert('users', array('username' => $username, 'email' => $email, 'password' => $hash, 'salt' => $salt, 'valid' => true));
	}

	public function validate_email($username, $salt)
	{
		$this->database->select('salt', 'users');
		$this->database->where('username', '=', $username);
		$results = $this->database->get(false, false);

		$results = $results->fetch();
		if (!$results) {
			return false;
		}

		if ($results['salt'] == $salt) {
			$this->database->update('users', 'valid', 'true', 'username', '=', $username);
			$this->database->query($this->database->getCurrentQueryString());
			return true;
		}
	}

	private function createSalt()
	{
	    $string = md5(uniqid(rand(), true));
	    return substr($string, 0, 3);
	}

	private function validate_user($username, $email = '', $salt)
	{
		mail($email, "Validate your user", "Click this link to validate your email : " . 'http://' . $_SERVER['HTTP_HOST'] . array_shift(explode("index.php", $_SERVER['REQUEST_URI'])) . 'index.php/admin/validate_email/' . $username . '/' . $salt);
	}
}