<?php

class Load
{
	public function view($templates, $variables)
	{
		new View_Model($templates, $variables);
	}

	public function helper($helper, &$context)
	{
		$file = 'system/helpers/' . $helper . '.php';
		if (file_exists($file)) {
			require_once $file;
			$class = ucfirst($helper);
			$context->$helper = new $class;
		}
	}

	public function model($model, &$context)
	{
		$file = 'application/models/' . $model . '.php';
		if (file_exists($file)) {
			require_once $file;
			$class = ucfirst($model) . '_Model';
			$context->model->$model = new $class;
		}
	}
}