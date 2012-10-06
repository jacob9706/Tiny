<?php

class News_Model extends Tiny_Model
{
	private $articles = array
    (
        //article 1
        'new' => array
        (
            'title' => 'New Website' ,
            'content' => 'Welcome to the site! We are glad to have you here.'
        )
        ,
        //2
        'mvc' => array
        (
            'title' => 'PHP MVC Frameworks are Awesome!' ,
            'content' => 'It really is very easy. Take it from us!'
        )
        ,
        //3
        'test' => array
        (
            'title' => 'Testing' ,
            'content' => 'This is just a measly test article.'
        )
    );

	public function __construct()
	{
		parent::__construct();
		$this->load('helper', 'database');
	}

	public function get_article($articleName)
    {
        //fetch article from array
        $article = $this->articles[$articleName];
    	
    	$this->database->query("CREATE TABLE test(name VARCHAR(255))");

    	$this->database->query("INSERT INTO test(name) VALUES('Jacob')");
    	$this->database->query("INSERT INTO test(name) VALUES('Jenna')");
    	$this->database->query("INSERT INTO test(name) VALUES('Erika')");

    	// $results = $this->database->query("SELECT * FROM test");

    	$this->database->select('*', 'test');
    	$columns = array(
    		'name',
    		'name'
    	);
    	$logic = array(
    		'LIKE',
    		'='
    	);
    	$values = array(
    		'J%',
    		'Jacob'
    	);
    	$orOrAnd = array(
    		'AND'
    	);
    	// $this->database->where("name", '=', 'Erika');
    	$this->database->where($columns, $logic, $values, $orOrAnd);
    	$results = $this->database->get(true);

    	foreach ($results as $result) {
    		print_r($result);
    	}

    	$this->database->update("test", 'name', 'Erika2', array('name', 'bday'), '=', array("Erika", 'aug'), "AND");

    	// $this->database->update('test', 'name', 'Erika2', 'name', 'Erika');

    	// print_r($results->fetchAll());

        return $article;
    }
}