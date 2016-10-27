<?php
date_default_timezone_set("Asia/Jakarta");
include 'setting/connection.php';
include 'setting/conn_login.php';
session_start();

// Cek session aktif atau tidak
if(!isset($_SESSION['username']) || empty($_SESSION['username'])) {
	header('location:../index.php');
} else {
	$username	= $_SESSION['username'];
	$email		= $_SESSION['email'];
}

$stmt = $connection->prepare("SELECT password FROM login WHERE username = :username");
$stmt->bindParam(':username', $username);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach($result as $key){
	$change_password = $key['password'];
}

// Mengambil data TopLevel
$admin = $conn->prepare("SELECT TOP 1 TopLevelPassword FROM TopLevel WHERE TopLevelId = :TopLevelId");
$admin->bindParam(':TopLevelId', $username);
$admin->execute();
$admin_result = $admin->fetchAll(PDO::FETCH_ASSOC);

// Mengambil data Sales
$sales = $conn->prepare("SELECT TOP 1 SalesPassword, SalesGroupId FROM Sales WHERE SalesId = :SalesId");
$sales->bindParam(':SalesId', $username);
$sales->execute();
$sales_result = $sales->fetchAll(PDO::FETCH_ASSOC);
foreach($sales_result as $key){
	$group = $key['SalesGroupId'];
}

// Mengambil data Engineer
$eng = $conn->prepare("SELECT TOP 1 EngineerPassword, EngineerLevel FROM Engineer WHERE EngineerId = :EngineerId");
$eng->bindParam(':EngineerId', $username);
$eng->execute();
$eng_result = $eng->fetchAll(PDO::FETCH_ASSOC);
foreach($eng_result as $key){
	$group = $key['EngineerLevel'];
}

// Menentukan hak akses untuk menu dan menangkap password
if(count($admin_result) > 0){
	$access	= 'admin';
} elseif(count($sales_result) > 0 AND $group <> 'SA'){
	$access	= 'sales';
} elseif(count($sales_result) > 0 AND $group == 'SA'){
	$access	= 'sales_admin';
} elseif(count($eng_result) > 0 AND $group <> 'Head'){
	$access	= 'eng';
} elseif(count($eng_result) > 0 AND $group == 'Head'){
	$access	= 'eng_head';
}
?>