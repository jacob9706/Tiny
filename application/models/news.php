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

        return $article;
    }

    public function database_example()
    {
    	$this->database->query("CREATE TABLE test(name VARCHAR(255))");

    	$this->database->query("INSERT INTO test(name) VALUES('Jacob')");
    	$this->database->query("INSERT INTO test(name) VALUES('Jenna')");
    	$this->database->query("INSERT INTO test(name) VALUES('Erika')");

    	// You can write your own queries
    	// $results = $this->database->query("SELECT * FROM test");

    	// Or you can generate them
    	$this->database->select('*', 'test');
    	
    	// Use arrays to generate conditioned WHERE clauses
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
    	$this->database->where($columns, $logic, $values, $orOrAnd);

    	// Or individual strings
    	// $this->database->where("name", '=', 'Erika');

    	// Get an PDOQuery Object back or pass true to return an array of information, second paramater is whether to make it just accociative
	   	return	$results = $this->database->get(true, true);

    	$this->database->update("test", 'name', 'Erika2', array('name', 'bday'), '=', array("Erika", 'aug'), "AND");

    	// $this->database->update('test', 'name', 'Erika2', 'name', 'Erika');
    }
}