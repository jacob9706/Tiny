<?php

class View_Model
{
	private 
	$variables,
	$render = false;

	public function __construct($templates, $variables)
	{
		$this->variables = $variables;
		if (is_array($templates)) {
			$this->render = array();
			$i = 0;
			foreach ($templates as $template) {
				$file = 'application/views/' . strtolower($template) . '.php';

				if (file_exists($file))
				{
					$this->render[$i] = $file;
				} else {
					$this->render[$i] = false;
				}
				$i++;
			}
		} else {
			$file = 'application/views/' . strtolower($templates) . '.php';

			if (file_exists($file))
			{
				$this->render = $file;
			}
		}
	}

	public function __destruct()
	{
		if (is_array($this->variables)) {
			foreach ($this->variables as $var => $value) {
				$$var = $value;
			}
		}
		if (is_array($this->render)) {
			foreach ($this->render as $render) {
				if ($render)
					include($render);
			}
		} else {
			if ($this->render)
				include($this->render);
		}
	}
}