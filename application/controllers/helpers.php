<?php

class Helpers_Controller extends Tiny_Controller
{
	public function status($vars)
	{
		$this->load('helper', 'html');

		$this->load->view(array('templates/header', 'helpers/status'), $vars);
		echo $link = $this->html->create_link('post', 'new_post', 'Try Again');
		$this->load->view('templates/footer');
	}
}