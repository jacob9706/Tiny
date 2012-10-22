<?php

class Post_Controller extends Tiny_Controller
{
	private $data = array();

	public function __construct()
	{
		parent::__construct();

		// Load in model(s)
		$this->load('model', 'post');
		// Load in helper(s)
		$this->load('helper', 'html');
		$this->load('helper', 'forms');

		// Assign helpers to data array to be passed to views
		$this->data['html'] = $this->html;
		$this->data['form'] = $this->forms;
	}

	public function index($vars, $postVars)
	{
		if (isset($_POST['search'])) {
			$this->data['posts'] = $this->model->post->search_posts($_POST['search']);
		}else {
			$this->data['posts'] = $this->model->post->get_post('all');			
		}
		$this->data['title'] = "Post List";
		
		$this->load->view(array('templates/header', 'posts', 'templates/footer'), $this->data);
	}

	// Add a paramater to show to allow the url variables to be passed to the method
	public function show($getVars)
	{
		$post_data = $this->model->post->get_post($getVars['id']);

		$this->data['post'] = $post_data;

		$this->data['title'] = $post_data['title'];

		if (!empty($this->data['post'])) {
			$this->load->view(array('templates/header','post', 'templates/footer'), $this->data);
		} else {
			$this->load->view('templates/header', $this->data);
			echo '<h2>Post Does Not Exist</h2>';
			$this->load->view('templates/footer', $this->data);
		}
	}

	public function new_post($getVars, $postVars)
	{
		// Check if user put in data, and if so redirect to the create_post method
		if (!empty($postVars['title']) && !empty($postVars['post'])) {
			$this->load->redirect('post', 'create_post', $postVars);
		}
		$data = array(
			'form' => $this->forms,
			'html' => $this->html
		);
		$this->load->view(array('templates/header', 'form', 'templates/footer'), $data);
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

	public function remove_post($getData, $data)
	{
		if ($data['id']) {
			$rowsAffected = $this->model->post->remove_post($data['id']);
			echo $rowsAffected;
			if ($rowsAffected >= 1) {
				$this->load->redirect('helpers', 'status', array('message' => 'Post successfully deleted.'));
			} else {
				$this->load->redirect('helpers', 'status', array('message' => 'Post not deleted, something went wrong.'));
			}
		} else {
			$this->load->redirect('helpers', 'status', array('message' => 'Nothing Deleted, Id not set'));
		}
	}
}