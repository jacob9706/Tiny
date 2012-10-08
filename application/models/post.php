<?php

class Post_Model extends Tiny_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load('helper', 'database');
	}

	public function get_post($id = 'all')
	{
		$this->database->select('*', 'posts');

		if ($id == 'all')
		{
			return $this->database->get(true, true);
		}

		$this->database->where('id', '=', $id);

		$results = $this->database->get(false);

		return $results->fetch(PDO::FETCH_ASSOC);
	}

	public function create_post($title, $post)
	{
		return $this->database->insert('posts', array('id' => null, 'title' => $title, 'post' => $post));
	}
}