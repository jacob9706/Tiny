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

	public function search_posts($search_string)
	{	
		// Select id and title from posts
		$this->database->select('id, title', 'posts');
		// Where title is like $search_string
		$this->database->where('title', 'LIKE', "%{$search_string}%");
		// Execute query which ends up being "SELECT id, title FROM posts WHERE title LIKE '%{$searchString}%'"
		// True is saying fetch my results for me, a second bool determines wheather to get an associative array or both (default true)
		return $this->database->get(true);
	}

	public function create_post($title, $post)
	{
		return $this->database->insert('posts', array('id' => null, 'title' => $title, 'post' => $post));
	}
}