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
		$this->database->select(array('id', 'title'), 'posts');
		// Where title is like $search_string
		$this->database->where(array('title', 'post'), 'LIKE', array("%{$search_string}%", "%{$search_string}%"), array('OR'));
		// Execute query which ends up being "SELECT id, title FROM posts WHERE title LIKE '%{$searchString}%'"
		
		// Limit the ammount of results to 10
		$this->database->limit(0, 10);

		// True is saying fetch my results for me, a second bool determines wheather to get an associative array or both (default true)
		return $this->database->get(true);
	}

	public function create_post($title, $post)
	{
		return $this->database->insert('posts', array('id' => null, 'title' => $title, 'post' => $post));
	}

	public function remove_post($postId)
	{
		$this->database->delete('posts');
		$this->database->where('id', '=', $postId);
		return 	$this->database->go();
	}
}