<?php
include '../setting/connection.php';

$id = $_POST['SalesId'];

// Menghapus data Sales
$result = $conn->prepare("DELETE FROM Sales WHERE SalesId = :id");
$result->bindParam(':id', $id);
$result->execute();

// Menangani hasil query (assets/js/function.js)
if($result){
	echo json_encode(array('success'=>true));
} else {
	echo json_encode(array('errorMsg'=>'Some errors occured.'));
}
?>