<?php if (!defined('DATATABLES')) exit(); // Ensure being used in DataTables env.

// Enable error reporting for debugging (remove for production)
error_reporting(E_ALL);
ini_set('display_errors', '1');


/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Database user / pass
 */
$sql_details = array(
	"type" => "Mysql",   // Database type: "Mysql", "Postgres", "Sqlserver", "Sqlite" or "Oracle"
	"user" => "forge",        // Database user name
	"pass" => "dTRXnNnQWn0ggRbfHIph",        // Database password
	"host" => "localhost",        // Database host
	"port" => "3306",        // Database connection port (can be left empty for default)
	"db"   => "motaba",        // Database name
	"dsn"  => "charset=utf8",        // PHP DSN extra information. Set as `charset=utf8mb4` if you are using MySQL
	"pdoAttr" => array() // PHP PDO attributes array. See the PHP documentation for all options
);
