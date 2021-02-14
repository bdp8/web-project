<?php

function getdb(){
	$configs = include('config.php');
	$servername = $configs->DB_SERVERNAME;
	$username = $configs->DB_USERNAME;
	$password = $configs->DB_PASSWORD;
	$db = $configs->DB_NAME;
	
	$connection = new PDO("mysql:host=$servername;dbname=$db", $username, $password, 
						[PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
						PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
						]);

	$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$connection->query("CREATE DATABASE IF NOT EXISTS $db");
	$connection->query("use $db");

	return $connection;
}
?>