<?php

class ServerErrors_Controller extends Tiny_Controller
{
	public function error_404()
	{
		$this->load->view("404");
	}
}