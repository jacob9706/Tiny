<?php

class ServerErrors_Controller extends Tiny_Controller
{
	private $data = array();

	public function __construct()
	{
		parent::__construct();

		$this->load('helper', 'html');
		$this->data['html'] = $this->html;
	}

	public function error_404()
	{
		$this->load->view("404", $this->data);
	}
}