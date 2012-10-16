<?php

class Index_Controller extends Tiny_Controller
{
	public function index()
	{
		$this->load('helper', 'html');

		$data = array(
			'html' => $this->html,
			'title' => 'Hello World'
		);

		$this->load->view(array('templates/header', 'index', 'templates/footer'), $data);
	}
}
