<?php
include '../setting/connection.php';

$id = $_POST['EngineerId'];

// Menghapus data Engineer
$result = $conn->prepare("DELETE FROM Engineer WHERE EngineerId = :id");
$result->bindParam(':id', $id);
$result->execute();

// Menangani hasil query (assets/js/function.js)
if($result){
	echo json_encode(array('success'=>true));
} else {
	echo json_encode(array('errorMsg'=>'Some errors occured.'));
}
?>