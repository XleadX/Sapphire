<?php
try {
	$server		= 'LUKMAN-PC';
	$database	= 'sapphire';
	$db_user	= 'sa';
	$db_pwd		= 'user';

	$conn = new PDO("sqlsrv:server=$server;database=$database;", $db_user, $db_pwd);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
	echo $e->getMessage();
}
?>