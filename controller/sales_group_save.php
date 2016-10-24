<?php
include '../setting/connection.php';

// Menangkap input program
$group = htmlspecialchars($_REQUEST['SalesGroupId']);

// Menambahkan data ke database
$result = $conn->prepare("INSERT INTO SalesGroup(SalesGroupId) VALUES(:group)");
$result->bindParam(':group', $group);

// Menangani hasil query (assets/js/function.js)
if($result){
	echo json_encode(array(
		'SalesGroupId' => $group
	));
} else {
	echo json_encode(array('errorMsg'=>'Some errors occured.'));
}
?>