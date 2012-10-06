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

		$article = $this->model->news->get_article($getVars['article']);

		$this->load->view(array($this->template, 'templates/footer'), $article);
	}
}