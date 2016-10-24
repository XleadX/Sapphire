<?php
include '../setting/connection.php';

$id = $_POST['SalesGroupId'];

// Menghapus data SalesGroup
$result = $conn->prepare("DELETE FROM SalesGroup WHERE SalesGroupId = :id");
$result->bindParam(':id', $id);
$result->execute();

// Menghapus data SalesMarket
$result2 = $conn->prepare("DELETE FROM SalesMarket WHERE SalesGroupId = :id");
$result2->bindParam(':id', $id);
$result2->execute();

// Menangani hasil query (assets/js/function.js)
if($result){
	echo json_encode(array('success'=>true));
} else {
	echo json_encode(array('errorMsg'=>'Some errors occured.'));
}
?>