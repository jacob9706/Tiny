<?php

class Search_Controller extends Tiny_Controller
{
	private $data = array();

	public function __construct()
	{
		parent::__construct();

		$this->load('helper', 'html');
		$this->load('helper', 'users');
		$this->load_as('helper', 'forms', 'login_form');
		$this->load_as('helper', 'forms', 'register_form');

		$this->data['html'] = $this->html;
		$this->data['users'] = $this->users;
		$this->data['login_form'] = $this->login_form;
		$this->data['register_form'] = $this->register_form;
	}
}