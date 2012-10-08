<?php

class Post_Controller extends Tiny_Controller
{
	public function __construct()
	{
		parent::__construct();

		// Load in model(s)
		$this->load('model', 'post');
		// Load in helper(s)
		$this->load('helper', 'html');
		$this->load('helper', 'forms');
		// These loads can be done on construction or individually in each method.
	}

	public function index()
	{
		$data['posts'] = $this->model->post->get_post('all');
		$data['title'] = "Post List";
		// Pass HTML helper to view
		$data['html'] = $this->html;
		// Optionally you could rener the html here and pass a string to echo

		$this->load->view(array('templates/header', 'posts', 'templates/footer'), $data);
	}

	// Add a paramater to show to allow the url variables to be passed to the method
	public function show($getVars)
	{
		$post_data = $this->model->post->get_post($getVars['id']);
		$data = array(
			'html' => $this->html,
			'post' => $post_data,
			'title' => $post_data['title']
		);

		if (!empty($data['post'])) {
			$this->load->view(array('templates/header','post', 'templates/footer'), $data);
		} else {
			$this->load->view('templates/header');
			echo '<h2>Post Does Not Exist</h2>';
			$this->load->view('templates/footer');
		}
	}

	public function new_post()
	{
		// Check if user put in data, and if so redirect to the create_post method
		if (!empty($_POST['title']) && !empty($_POST['post'])) {
			$this->load->redirect('post', 'create_post', $_POST);
		}
		$data = array(
			'form' => $this->forms,
			'html' => $this->html
		);
		$this->load->view('form', $data);
	}

	public function create_post($data)
	{
		if ($this->model->post->create_post($data['title'], $data['post'])) {
			// Redirect to success page
			$this->load->redirect('helpers', 'status', array('message' => 'Post successfully created.'));
		} else {
			// Redirect to a failure page
			$this->load->redirect('helpers', 'status', array('message' => 'Post not created, please try again.'));
		}
	}
}