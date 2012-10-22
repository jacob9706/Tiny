<?php

class Admin_Controller extends Tiny_Controller
{
	private $data = array();

	public function __construct()
	{
		parent::__construct();

		// Load in model(s)
		$this->load('model', 'admin');
		// Load in helper(s)
		$this->load('helper', 'html');
		$this->load('helper', 'forms');
		$this->load('helper', 'users');

		// Assign helpers to data array to be passed to views
		$this->data['html'] = $this->html;
		$this->data['form'] = $this->forms;
	}

	public function index()
	{
		$this->users->require_login();
		echo 'you have been authenticated<br>';
		echo $this->html->create_a('admin', 'logout', 'Logout');
	}

	public function logout()
	{
		$this->users->logout();
	}

	public function login($getVars, $postVars)
	{
		if (!empty($postVars)) {
			$this->login_process($postVars);
		}

		$this->data['error'] = !empty($getVars['error']) ? $getVars['error'] : '';

		$this->load->view(array('templates/header', 'login', 'templates/footer'), $this->data);
	}

	public function login_process($info)
	{
		if ($this->model->admin->login($info['username'], $info['password'])) {
			$this->users->login($info['username']);
			$this->data['message'] = 'Login Successful';
			$this->load->view(array('templates/header', 'helpers/status', 'templates/footer'), $this->data);
		} else {
			$this->load->redirect('admin', 'login', array('error' => 'Username or Password is incorrect'));
		}
		exit;
	}

	public function register($getVars, $postVars)
	{
		if (!empty($postVars)) {
			$this->registration_process($postVars);
		}

		$this->data['error'] = !empty($getVars['error']) ? $getVars['error'] : '';

		$this->load->view(array('templates/header', 'register', 'templates/footer'), $this->data);
	}

	private function registration_process($info)
	{
		$valid = true;
		$error = '';

		if ($info['pass1'] != $info['pass2']) {
			$valid = false;
			$error .= 'Passwords Do Not Match <br>';
		}
		if (empty($info['username']) || strlen($info['username']) > 30) {
			$valid = false;
			$error .= 'Username Must Be Less Than 30';
		}

		if ($valid) {
			$success = $this->model->admin->new_user($info['username'], $info['pass1']);

			$this->data['message'] = $success ? 'User Created Successfully' : 'User Not Created';

			$this->load->view(array('templates/header', 'helpers/status', 'templates/footer'), $this->data);
		} else {
			$this->load->redirect('admin', 'register', array('error' => $error));
		}
		exit;
	}
}