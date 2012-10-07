<?php

class News_Controller extends Tiny_Controller
{
	public $template = 'news';

	public function index(array $getVars)
	{
		echo "in news controller, index";
		echo '<br>';
		echo 'get vars are <pre>';
		print_r($getVars);
		echo '</pre>';
	}

	public function test(array $getVars)
	{
		$this->load('model', 'news');
		$this->load('helper', 'forms');

		$this->forms->add('TextElement', array("name", "id", "class", "lable"));
		$this->forms->add('SubmitElement', array("submit_button", "id2", "class2", "Submit"));

		$data['article'] = $this->model->news->get_article($getVars['article']);
		$data['form'] = $this->forms;
		$data['database_data'] = $this->model->news->database_example();

		$this->load->view(array($this->template, 'templates/footer'), $data);
	}
}