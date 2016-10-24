<?php
try {
	$server		= 'localhost';
	$database	= 'demo';
	$db_user	= 'root';
	$db_pwd		= '';
	$options = array(
		PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
	);
	
	$connection = new PDO("mysql:host=$server;dbname=$database", $db_user, $db_pwd, $options);
	$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
	echo $e->getMessage();
}
?>