<?php

class Database
{
	private $dbh = null;
	private $query = "";
	private $last_query = "";
	private $values = array();

	public function __construct()
	{
		try {
			if ($GLOBALS['CONFIG_DB']['type'] == 'mssql' || $GLOBALS['CONFIG_DB']['type'] == 'sybase') {
				$this->dbh = new PDO("{$GLOBALS['CONFIG_DB']['type']}:host={$GLOBALS['CONFIG_DB']['host']};dbname={$GLOBALS['CONFIG_DB']['db_name']}, {$GLOBALS['CONFIG_DB']['user_name']}, {$GLOBALS['CONFIG_DB']['password']}");
			} elseif ($GLOBALS['CONFIG_DB']['type'] == 'mysql') {
  			// MySQL with PDO_MYSQL
				$this->dbh = new PDO("mysql:host={$GLOBALS['CONFIG_DB']['host']};dbname={$GLOBALS['CONFIG_DB']['db_name']}", $GLOBALS['CONFIG_DB']['user_name'], $GLOBALS['CONFIG_DB']['password']);  
			} elseif ($GLOBALS['CONFIG_DB']['type'] == 'sqlite') {
  			// SQLite Database
				$this->dbh = new PDO("sqlite:{$GLOBALS['CONFIG_DB']['db_name']}");
			} else {
				echo 'Database Type Not Supported';
			}
		}  
		catch(PDOException $e) {  
			die($e->getMessage());
		}

		if ($GLOBALS['CONFIG_GENERAL']['mode'] == "dev") {
			$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
	}

	/**
	 * Insert into database using PDO prepare
	 * @param  String $table         Table to insert into
	 * @param  Array $arrayOfValues Associative array of column => value
	 * @return boolean                Wether insert succeeded
	 */
	public function insert($table, Array $arrayOfValues)
	{
		$query = 'INSERT INTO ' . $table;
		$columns = '';
		$values = '';
		$executeVar = array();
		if ($this->isAssoc($arrayOfValues)) {
			$delimiter = '';
			foreach ($arrayOfValues as $column =>$value) {
				$columns .= $delimiter . $column;
				$values .= $delimiter . ':' . $column;
				$executeVar[(':' . $column)] = $value;
				$delimiter = ', ';
			}

			$query .= '(' . $columns . ')' . ' VALUES(' . $values . ')';
			// echo $query;
			// print_r($executeVar);
			$query = $this->dbh->prepare($query);
			try {
				return $query->execute($executeVar);
			} catch(PDOException $e) {
				return false;
			}
		} else {
			$debug = debug_backtrace();
			die('Error: Second param of ' . $debug[0]['function'] . '() must be an associative array, ' . $debug[0]['file'] . ": line " . $debug[0]['line']);
		}
	}

	/**
	 * Perform query
	 * @param  string $query  Query String
	 * @param  array  $params Array to pass to pdo prepare
	 * @return [type]         Query results
	 */
	public function query($query, array $params = array())
	{
		$query = $this->dbh->prepare($query);
		$query->execute($params);
		return $query;
	}

	/**
	 * Create SELECT statement
	 * @param  [type] $columns array or string
	 * @param  string $table  string
	 */
	public function select($columns, $table)
	{
		if (is_array($columns)) {
			$this->query = 'SELECT';
			$delimiter = ' ';
			foreach ($columns as $column) {
				$this->query .= $delimiter . $column;
				$delimiter = ', ';
			}
			$this->query .= ' FROM ' . $table;
		} else {
			$this->query = 'SELECT ' . $columns . ' FROM ' . $table;			
		}
	}

	public function delete($fromTable)
	{
		$this->query = 'DELETE FROM ' . $fromTable;
	}

	public function go($count = true)
	{
		$results = $this->dbh->prepare($this->query);
		if (is_array($this->values)) {
			$results->execute($this->values);			
		} else if (!empty($this->values)){
			$results->execute(array($this->values));
		} else {
			$results->execute();
		}

		if ($count) {
			return $results->rowCount();
		} else {
			return $results;
		}
	}

	/**
	 * Add WHERE statement to existing query
	 * @param  [type] $columns a string value or a indexed array
	 * @param  [type] $logic   a string value or a indexed array
	 * @param  [type] $values  a string value or a indexed array
	 * @param  [type] $orOrAnd a string value or a indexed array
	 */
	public function where($columns, $logic, $values, $orOrAnd = 'and')
	{
		if (!empty($this->query)) {
			if (is_array($columns) && is_array($values)) {
				if (sizeof($columns) == sizeof($values)) {
					if (is_array($logic) && sizeof($logic) != sizeof($columns)) {
						$debug = debug_backtrace();
						die('Error: Size of logic array in ' . $debug[0]['function'] . '() must be the same length as columns array, ' . $debug[0]['file'] . ": line " . $debug[0]['line']);
					}
					if (is_array($orOrAnd) && sizeof($orOrAnd) < sizeof($columns) - 1) {
						$debug = debug_backtrace();
						die('Error: Size of orOrAnd array in ' . $debug[0]['function'] . '() must be the same length as columns array, ' . $debug[0]['file'] . ": line " . $debug[0]['line']);
					}
					if (is_array($orOrAnd)) {
						$orOrAnd[] = "and";
					}
					$separator = ' WHERE ';
					for($i = 0; $i < sizeof($columns); $i++) {
						$this->query .= $separator . $columns[$i] . ' ' . (is_array($logic) ? $logic[$i] : $logic) . ' ?';
						$separator = ' ' . (is_array($orOrAnd) ? $orOrAnd[$i] : $orOrAnd) . ' ';
					}
					$this->values = $values;
				} else {
					$debug = debug_backtrace();
					die('Error: Size of arrays in ' . $debug[0]['function'] . '() must be the same length, ' . $debug[0]['file'] . ": line " . $debug[0]['line']);
				}
			} elseif (!is_array($columns) && !is_array($values)) {
				if (!is_array($logic)) {
					$this->query .= ' WHERE ' . $columns . ' ' . $logic . ' ?';
					$this->values = $values;			
				} else {
					$debug = debug_backtrace();
					die('Error: logic must be string when cloumns and values are in ' . $debug[0]['function'] . '(), ' . $debug[0]['file'] . ": line " . $debug[0]['line']);					
				}
			} else {
				$debug = debug_backtrace();
				die('Error: columns and values must be the same var type (string or array) in ' . $debug[0]['function'] . '(), ' . $debug[0]['file'] . ": line " . $debug[0]['line']);
			}
		} else {
			$debug = debug_backtrace();
			die('Error: query is empty in ' . $debug[0]['function'] . '(), ' . $debug[0]['file'] . ": line " . $debug[0]['line']);
		}
	}

	/**
	 * Add limit to query string
	 * @param  integer $start   [description]
	 * @param  integer $ammount [description]
	 */
	public function limit($start = 0, $ammount = 10) {
		if (!empty($this->query)) {
			$this->query .= ' LIMIT ' . $start . ', ' . $ammount;
		} else {
			$debug = debug_backtrace();
			die('Error: query is empty in ' . $debug[0]['function'] . '(), ' . $debug[0]['file'] . ": line " . $debug[0]['line']);
		}
	}

	/**
	 * Query database with generated or set query
	 * @param  boolean $makeResultSet   if true returns a array of results, else returns PDO is_object
	 * @param  boolean $associativeOnly if true will will create only associative array instead of indexed as well
	 * @return [type]                   Array of results or PDO object
	 */
	public function get($makeResultSet = false, $associativeOnly = true)
	{
		$results = $this->dbh->prepare($this->query);
		if (is_array($this->values)) {
			$results->execute($this->values);			
		} else {
			$results->execute(array($this->values));
		}
		
		if ($makeResultSet) {
			$results = $results->fetchAll(($associativeOnly ? PDO::FETCH_ASSOC : PDO::FETCH_BOTH));
		}

		$this->last_query = $this->query;
		$this->query = "";

		return $results;
	}

	// FIXME: Change to PDO
	public function update($table, $columns_to_set, $new_values, $where_columns, $logic, $old_values, $orOrAnd = "AND")
	{
		$this->query = 'UPDATE ' . $table . ' SET ';
		if (is_array($columns_to_set) && is_array($new_values)) {
			if (sizeof($columns_to_set) == sizeof($new_values)) {
				$delimiter = "";
				for ($i = 0; $i < sizeof($columns_to_set); $i++) {
					$this->query .= $delimiter . ' ' . $columns_to_set[$i] . '=' . (is_string($new_values[$i]) ? "'".$new_values[$i]."'" : $new_values[$i]);
					$delimiter = ',';
				}

				if (is_array($where_columns) && is_array($old_values)) {
					if (sizeof($where_columns) == sizeof($old_values)) {
						$this->query .= ' WHERE ';
						$delimiter = "";
						for ($i = 0; $i < sizeof($where_columns); $i++) {
							$this->query .= $delimiter . ' ' . $where_columns[$i] . (is_array($logic) ? $logic[$i] : $logic) . (is_string($old_values[$i]) ? "'".$old_values[$i]."'" : $old_values[$i]);
							$delimiter = ' ' . $orOrAnd . ' ';
						}
					} else {
						$debug = debug_backtrace();
						die('Error: Size of arrays where_columns and old_values in ' . $debug[0]['function'] . '() must be the same length, ' . $debug[0]['file'] . ": line " . $debug[0]['line']);						
					}
				} elseif (!is_array($where_columns) && !is_array($old_values)) {
					$this->query .= ' WHERE ';
					$this->query .= $where_columns . $logic . (is_string($old_values) ? "'".$old_values."'" : $old_values);
				} else {
					$debug = debug_backtrace();
					die('Error: Both where_columns and old_values in ' . $debug[0]['function'] . '() must be both arrays or individual variables, ' . $debug[0]['file'] . ": line " . $debug[0]['line']);
				}
			} else {
				$debug = debug_backtrace();
				die('Error: Size of arrays columns_to_set and new_values in ' . $debug[0]['function'] . '() must be the same length, ' . $debug[0]['file'] . ": line " . $debug[0]['line']);
			}
		} elseif (!is_array($columns_to_set) && !is_array($new_values)) {
			$this->query .= $columns_to_set . '=' . (is_string($new_values) ? "'".$new_values."'" : $new_values);
			if (is_array($where_columns) && is_array($old_values)) {
				if (sizeof($where_columns) == sizeof($old_values)) {
					$this->query .= ' WHERE ';
					$delimiter = "";
					for ($i = 0; $i < sizeof($where_columns); $i++) {
						$this->query .= $delimiter . ' ' . $where_columns[$i] . (is_array($logic) ? $logic[$i] : $logic) . (is_string($old_values[$i]) ? "'".$old_values[$i]."'" : $old_values[$i]);
						$delimiter = ' ' . $orOrAnd . ' ';
					}
				} else {
					$debug = debug_backtrace();
					die('Error: Size of arrays where_columns and old_values in ' . $debug[0]['function'] . '() must be the same length, ' . $debug[0]['file'] . ": line " . $debug[0]['line']);						
				}
			} elseif (!is_array($where_columns) && !is_array($old_values)) {
				$this->query .= ' WHERE ';
				$this->query .= $where_columns . $logic . (is_string($old_values) ? "'".$old_values."'" : $old_values);
			}
		} else {
			$debug = debug_backtrace();
			die('Error: Both columns_to_set and new_values in ' . $debug[0]['function'] . '() must be both arrays or individual variables, ' . $debug[0]['file'] . ": line " . $debug[0]['line']);
		}
	}

	/**
	 * Returns current query string
	 * @return String Current query string
	 */
	public function getCurrentQueryString()
	{
		return $this->query;
	}

    private function isAssoc($arr)
	{
		return array_keys($arr) !== range(0, count($arr) - 1);
	}
}