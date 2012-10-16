<?php

class Helpers_Controller extends Tiny_Controller
{
	/**
	 * [status description]
	 * @param  [type] $vars [description]
	 * @return [type]
	 */
	public function status($vars)
	{
		$this->load('helper', 'html');
		$vars = array(
			'html' => $this->html,
			'message' => $vars['message']
		);

		$this->load->view(array('templates/header', 'helpers/status'), $vars);
		echo $link = $this->html->create_a('post', 'index', 'View Posts');
		$this->load->view('templates/footer', $vars);
	}
}