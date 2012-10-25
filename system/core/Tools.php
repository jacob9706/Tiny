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

	public function load_as($type, $what, $as)
	{
		$type .= '_as';
		$this->load->$type($what, $as, $this);
	}
}