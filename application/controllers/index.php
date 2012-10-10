<?php

class Index_Controller extends Tiny_Controller
{
	public function index()
	{
		$this->load('helper', 'html');
		$this->load->view('index', array('html' => $this->html));
	}
}