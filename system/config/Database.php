<?php
$CONFIG_DB = array();

/**
 * Defines type of database to use, You can use any of the database types supported by your current PDO instilation.
 * To check what type your current system supports, use the function php_info();
 */
$CONFIG_DB['type'] = 'sqlite';

/**
 * Defines your username used for accessing the database. If you are using sqlite leave this blank.
 */
$CONFIG_DB['user_name'] = 'root';

/**
 * Defines your password used for accessing the database. If you are using sqlite leave this blank.
 */
$CONFIG_DB['password'] = 'root';

/**
 * Defines your host used for accessin the database. If you are using sqlite leave this blank.
 */
$CONFIG_DB['host'] = 'localhost';

/**
 * Defines the name of the database you want to access. If you are using sqlite this will be the path to the database file.
 */
$CONFIG_DB['db_name'] = 'application/databases/blog.sqlite';




// // ==================================================================
// $CONFIG_DB['type'] = 'mysql';

// /**
//  * Defines your username used for accessing the database. If you are using sqlite leave this blank.
//  */
// $CONFIG_DB['user_name'] = 'root';


//  * Defines your password used for accessing the database. If you are using sqlite leave this blank.
  
// $CONFIG_DB['password'] = 'root';

// /**
//  * Defines your host used for accessin the database. If you are using sqlite leave this blank.
//  */
// $CONFIG_DB['host'] = 'localhost';

// /**
//  * Defines the name of the database you want to access. If you are using sqlite this will be the path to the database file.
//  */
// $CONFIG_DB['db_name'] = 'tiny';