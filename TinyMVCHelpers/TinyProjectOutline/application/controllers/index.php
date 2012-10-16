<?php

class Index_Controller extends Tiny_Controller
{
	public function index($getVars)
	{
		// Load the html helper object
		$this->load('helper', 'html');

		// Pass the view the html helper object
		$data['html'] = $this->html;
		// Pass the view the page title (echo'ed in templates/header)
		$data['title'] = 'Welcome';
		// Pass the mocked get array to the view to be displayed
		$data['getVars'] = $getVars;

		$this->load->view('index', $data);
	}
}