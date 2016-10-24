<?php
include '../setting/connection.php';

// Menangkap input program
$username 	= htmlspecialchars($_REQUEST['SalesId']);
$password 	= htmlspecialchars($_REQUEST['SalesPassword']);
$email 		= htmlspecialchars($_REQUEST['SalesEmail']);
$group 		= htmlspecialchars($_REQUEST['SalesGroupId']);
$level 		= htmlspecialchars($_REQUEST['SalesLevel']);
$receive	= htmlspecialchars($_REQUEST['ReceiveEmail']);

// Menambahkan data ke database
$result = $conn->prepare("INSERT INTO Sales(SalesId,SalesPassword,SalesEmail,SalesGroupId,SalesLevel,ReceiveEmail) VALUES(:username,:password,:email,:group,:level,:receive)");
$result->bindParam(':username', $username);
$result->bindParam(':password', $password);
$result->bindParam(':email', $email);
$result->bindParam(':group', $group);
$result->bindParam(':level', $level);
$result->bindParam(':receive', $receive);
$result->execute();

// Menangani hasil query (assets/js/function.js)
if($result){
	echo json_encode(array(
		'SalesId' => $username,
		'SalesPassword' => $password,
		'SalesEmail' => $email,
		'SalesGroupId' => $group,
		'SalesLevel' => $level,
		'ReceiveEmail' => $receive
	));
} else {
	echo json_encode(array('errorMsg'=>'Some errors occured.'));
}
?>