<?php
include '../setting/connection.php';

// Menangkap input program
$username 	= htmlspecialchars($_REQUEST['EngineerId']);
$password 	= htmlspecialchars($_REQUEST['EngineerPassword']);
$email 		= htmlspecialchars($_REQUEST['EngineerEmail']);
$group 		= htmlspecialchars($_REQUEST['EngineerGroup']);
$level 		= htmlspecialchars($_REQUEST['EngineerLevel']);
$confirmso	= htmlspecialchars($_REQUEST['ConfirmSO']);
$bugroup	= htmlspecialchars($_REQUEST['BUGroup']);
$receive	= htmlspecialchars($_REQUEST['ReceiveEmail']);

// Menambahkan data ke database
$result = $conn->prepare("INSERT INTO Engineer(EngineerId,EngineerPassword,EngineerEmail,EngineerGroup,EngineerLevel,ConfirmSO,BUGroup,ReceiveEmail) VALUES(:username,:password,:email,:group,:level,:confirmso,:bugroup,:receive)");
$result->bindParam(':username', $username);
$result->bindParam(':password', $password);
$result->bindParam(':email', $email);
$result->bindParam(':group', $group);
$result->bindParam(':level', $level);
$result->bindParam(':confirmso', $confirmso);
$result->bindParam(':bugroup', $bugroup);
$result->bindParam(':receive', $receive);
$result->execute();

// Menangani hasil query (assets/js/function.js)
if($result){
	echo json_encode(array(
		'EngineerId' => $username,
		'EngineerPassword' => $password,
		'EngineerEmail' => $email,
		'EngineerGroup' => $group,
		'EngineerLevel' => $level,
		'ConfirmSO' => $confirmso,
		'BUGroup' => $bugroup,
		'ReceiveEmail' => $receive
	));
} else {
	echo json_encode(array('errorMsg'=>'Some errors occured.'));
}
?>