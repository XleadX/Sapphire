<?php
include '../setting/conn_login.php';
include '../setting/connection.php';

session_start();
$username 	= $_POST['username'];
$password 	= $_POST['password'];
$password	= str_replace("'", "''", $password);

$stmt = $connection->prepare("SELECT username, email FROM login WHERE (username = :username AND password = :password) OR (email = :email AND email_pass = :email_pass)");
$stmt->bindParam(':username', $username);
$stmt->bindParam(':password', $password);
$stmt->bindParam(':email', $username);
$stmt->bindParam(':email_pass', $password);
$stmt->execute();

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

if(count($result) == 1){
	foreach($result as $key){
		$_SESSION['username']	= $key['username'];
		$_SESSION['email']		= $key['email'];
		
		$username_	= $key['username'];
		$email_		= $key['email'];
	}
	
	$admin = $conn->query("SELECT TopLevelId FROM TopLevel WHERE TopLevelId = '$username_' OR TopLevelEmail = '$email_'");
	$sales = $conn->query("SELECT SalesId FROM Sales WHERE SalesId = '$username_'");
	$eng = $conn->query("SELECT EngineerId FROM Engineer WHERE EngineerId = '$username_' OR EngineerEmail = '$email_'");
	
	$admin_result = $admin->fetchAll(PDO::FETCH_ASSOC);
	$sales_result = $sales->fetchAll(PDO::FETCH_ASSOC);
	$eng_result = $eng->fetchAll(PDO::FETCH_ASSOC);
	
	if(count($admin_result) == 1){
		header('location:../view/MENU');
	} elseif(count($sales_result) == 1){
		header('location:../view/MENU');
	} elseif(count($eng_result) == 1){
		header('location:../view/MENU');
	} else {
		echo '<script>alert("Please check username and password !"); </script>';
		echo '<script>document.location="../index.php"; </script>';
	}
	
	$_SESSION['time'] = time();
} else {
	echo '<script>alert("Username and password not registered"); </script>';
	echo '<script>document.location="../index.php"; </script>';
}
?>