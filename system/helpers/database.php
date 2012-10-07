<?php

class Database
{
	private $dbh = null;
	private $query = "";
	private $last_query = "";

	public function __construct()
	{
		try {
			if ($GLOBALS['CONFIG_DB']['type'] == 'mssql' || $GLOBALS['CONFIG_DB']['type'] == 'sybase') {
				$this->dbh = new PDO("{$GLOBALS['CONFIG_DB']['type']}:host={$GLOBALS['CONFIG_DB']['host']};dbname={$GLOBALS['CONFIG_DB']['db_name']}, {$GLOBALS['CONFIG_DB']['user']}, {$GLOBALS['CONFIG_DB']['password']}");
			} elseif ($GLOBALS['CONFIG_DB']['type'] == 'mysql') {
  			// MySQL with PDO_MYSQL
				$this->dbh = new PDO("mysql:host={$GLOBALS['CONFIG_DB']['host']};dbname={$GLOBALS['CONFIG_DB']['db_name']}", $GLOBALS['CONFIG_DB']['user'], $GLOBALS['CONFIG_DB']['password']);  
			} elseif ($GLOBALS['CONFIG_DB']['type'] == 'sqlite') {
  			// SQLite Database
				$this->dbh = new PDO("sqlite:{$GLOBALS['CONFIG_DB']['db_name']}");
			} else {
				echo 'Database Type Not Supported';
			}
		}  
		catch(PDOException $e) {  
			echo $e->getMessage();
		}
	}

	public function query($query)
	{
		return $this->dbh->query($query);
	}

	public function select($column, $table)
	{
		$this->query = 'SELECT ' . $column . ' FROM ' . $table; 
	}

	public function where($columns, $logic, $values, $orOrAnd = 'and')
	{
		if (!empty($this->query)) {
			if (is_array($columns) && is_array($values)) {
				if (sizeof($columns) == sizeof($values)) {
					$separator = ' WHERE ';
					for ($i = 0; $i < sizeof($columns); $i++) {
						$this->query .= $separator . $columns[$i] . ' ' . (is_array($logic) ? $logic[$i] : $logic) . ' ' . (is_string($values[$i]) ? "'".$values[$i]."'": $values[$i]);
						$separator = ' ' . (is_array($orOrAnd) ? ($i >= sizeof($orOrAnd) ? "" : $orOrAnd[$i]) : $orOrAnd) . ' ';
					}
				} else {
					$debug = debug_backtrace();
					die('Error: Size of arrays in ' . $debug[0]['function'] . '() must be the same length, ' . $debug[0]['file'] . ": line " . $debug[0]['line']);
				}
			} else if (!is_array($columns) && !is_array($values)) {
				$this->query .= ' WHERE ' . $columns . ' ' . $logic . ' ' . ($logic == "LIKE" || $logic == 'like' ? ("'" . $values . "'") : (is_string($values) ? "'".$values."'": $values));
			}
		} else {
			echo 'The query is empty';
		}
	}

	public function get($makeResultSet = false, $associativeOnly = true)
	{
		$results = $this->dbh->query($this->query);
		
		if ($makeResultSet) {
			$results = $results->fetchAll(($associativeOnly ? PDO::FETCH_ASSOC : PDO::FETCH_BOTH));
		}

		$this->last_query = $this->query;
		$this->query = "";

		return $results;
	}

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

	public function getCurrentQueryString()
	{
		return $this->query;
	}
}