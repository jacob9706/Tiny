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
		$this->load_as('helper', 'forms', 'login_form');
		$this->load_as('helper', 'forms', 'register_form');

		// Assign helpers to data array to be passed to views
		$this->data['html'] = $this->html;
		$this->data['form'] = $this->forms;
		$this->data['users'] = $this->users;
		$this->data['login_form'] = $this->login_form;
		$this->data['register_form'] = $this->register_form;
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
		$this->load->previous_page();
	}

	public function login($getVars, $postVars)
	{
		if (!empty($postVars)) {
			$this->login_process($postVars);
		}

		$this->data['error'] = !empty($getVars['error']) ? $getVars['error'] : '';

		$this->load->previous_page(array('login_error' => $this->data['error']));
	}

	public function login_process($info)
	{
		$good_to_go = $this->model->admin->login($info['username'], $info['password']);
		if ($good_to_go && is_bool($good_to_go)) {
			$this->users->login($info['username']);
			$this->load->previous_page();		
			// $this->data['message'] = 'Login Successful';
			// $this->load->view(array('templates/header', 'helpers/status', 'templates/footer'), $this->data);
		} elseif($good_to_go && is_string($good_to_go)) {
			$this->load->previous_page(array('login_error' => $good_to_go));
		} else {
			// $this->load->redirect('admin', 'login', array('error' => 'Username or Password is incorrect'));
			$this->load->previous_page(array('login_error' => 'Username or Password is incorrect'));
		}
		exit;
	}

	public function register($getVars, $postVars)
	{
		if (!empty($postVars)) {
			$this->registration_process($postVars);
		}

		$this->data['error'] = !empty($getVars['error']) ? $getVars['error'] : '';

		$this->load->previous_page(array('register_error' => $this->data['error']));
		// $this->load->view(array('templates/header', 'register', 'templates/footer'), $this->data);
	}

	public function validate_email($getVars)
	{
		if (isset($getVars[0]))
		{
			if($this->model->admin->validate_email($getVars[0], $getVars[1])) {
				echo 'valid';
			} else {
				echo 'not valid';
			}
		} else {
			$this->load->redirect('helpers', '404');
		}
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
			$error .= 'Username Must Be Less Than 30 <br>';
		}
		if (empty($info['email']) || !strpos($info['email'], '@')) {
			$valid = false;
			$error .= 'Not a valid email <br>';
		}

		if ($valid) {
			$success = $this->model->admin->new_user($info['username'], $info['email'], $info['pass1']);

			$this->data['message'] = $success ? 'User Created Successfully' : 'User Not Created';

			$this->load->view(array('templates/header', 'helpers/status', 'templates/footer'), $this->data);
		} else {
			$this->load->redirect('admin', 'register', array('error' => $error));
		}
		exit;
	}
}