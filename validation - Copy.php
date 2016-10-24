<?php
date_default_timezone_set("Asia/Jakarta");
include 'setting/connection.php';
include 'setting/conn_login.php';
session_start();

// Cek session aktif atau tidak
if(!isset($_SESSION['username']) || empty($_SESSION['username'])) {
	header('location:index.php');
} else {
	$username	= $_SESSION['username'];
	$email		= $_SESSION['email'];
}

$stmt = $connection->prepare("SELECT password FROM login WHERE username = :username");
$stmt->bindParam(':username', $username);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach($result as $key){
	$change_password	= $key['password'];
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
	$disable_admin			= '';
	$disable_sales			= '';
	$disable_engineer_menu	= '';
	$disable_sales_admin	= 'disabled="true"';
	$disable_engineer_head	= '';
	$disable_sales_menu		= '';
	$disable_sales_admin_po	= 'style="display:none"';
	$admin					= 'admin';
} elseif(count($sales_result) > 0 AND $group <> 'SA'){
	$disable_admin			= 'disabled="true"';
	$disable_sales			= '';
	$disable_engineer_menu	= 'disabled="true"';
	$disable_sales_admin	= 'disabled="true"';
	$disable_engineer_head	= 'disabled="true"';
	$disable_sales_menu		= '';
	$disable_sales_admin_po	= 'style="display:none"';
	$admin					= 'user';
} elseif(count($sales_result) > 0 AND $group == 'SA'){
	$disable_admin			= 'disabled="true"';
	$disable_sales			= 'disabled="true" style="display:none"';
	$disable_engineer_menu	= 'disabled="true"';
	$disable_sales_admin	= '';
	$disable_engineer_head	= 'disabled="true"';
	$disable_sales_menu		= '';
	$disable_sales_admin_po	= 'style="display:block"';
	$admin					= 'user';
} elseif(count($eng_result) > 0 AND $group <> 'Head'){
	$disable_admin			= 'disabled="true"';
	$disable_sales			= 'disabled="true"';
	$disable_engineer_menu	= '';
	$disable_sales_admin	= 'disabled="true"';
	$disable_engineer_head	= 'disabled="true"';
	$disable_sales_menu		= 'disabled="true"';
	$disable_sales_admin_po	= 'style="display:none"';
	$admin					= 'user';
} elseif(count($eng_result) > 0 AND $group == 'Head'){
	$disable_admin			= 'disabled="true"';
	$disable_sales			= 'disabled="true"';
	$disable_engineer_menu	= 'disabled="true"';
	$disable_sales_admin	= 'disabled="true"';
	$disable_engineer_head	= '';
	$disable_sales_menu		= 'disabled="true"';
	$disable_sales_admin_po	= 'style="display:none"';
	$admin					= 'user';
}
?>