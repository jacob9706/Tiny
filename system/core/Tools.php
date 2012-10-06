<?php

class Tools
{
	public
	$load;

	public function __construct()
	{
		$this->load = new Load();
	}
	
	public function load($type, $what)
	{
		$this->load->$type($what, $this);
	}
}