<?php
include '../setting/conn_login.php';
session_start();
$username	= $_SESSION['username'];
$password	= str_replace("'", "''", $_POST['password']);

$stmt = $connection->prepare("UPDATE login SET password = :password WHERE username = :username");
$stmt->bindParam(':password', $password);
$stmt->bindParam(':username', $username);
$stmt->execute();

if($stmt){
	echo '<script>alert("Password has been change !")</script>';
	echo '<script>document.location="../view/MENU"</script>';
}
?>