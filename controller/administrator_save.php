<?php
include '../setting/connection.php';

// Menangkap input program
$username 	= htmlspecialchars($_REQUEST['TopLevelId']);
$password 	= htmlspecialchars($_REQUEST['TopLevelPassword']);
$email 		= htmlspecialchars($_REQUEST['TopLevelEmail']);
$receive	= htmlspecialchars($_REQUEST['ReceiveEmail']);

// Menambahkan data ke database
$result = $conn->prepare("INSERT INTO TopLevel(TopLevelId,TopLevelPassword,TopLevelEmail,ReceiveEmail) VALUES(:username,:password,:email,:receive)");
$result->bindParam(':username', $username);
$result->bindParam(':password', $password);
$result->bindParam(':email', $email);
$result->bindParam(':receive', $receive);
$result->execute();

// Menangani hasil query (assets/js/function.js)
if($result){
	echo json_encode(array(
		'TopLevelId' => $username,
		'TopLevelPassword' => $password,
		'TopLevelEmail' => $email,
		'ReceiveEmail' => $receive
	));
} else {
	echo json_encode(array('errorMsg'=>'Some errors occured.'));
}
?>