<?php
include '../setting/connection.php';

// Menangkap input program
$percent	= htmlspecialchars($_REQUEST['ProbabilityId']);
$desc		= htmlspecialchars($_REQUEST['ProbabilityDesc']);

$result = $conn->prepare("INSERT INTO probability(ProbabilityId,ProbabilityDesc) VALUES(:percent,:desc)");
$result->bindParam(':percent', $percent);
$result->bindParam(':desc', $desc);
$result->execute();

// Menangani hasil query (assets/js/function.js)
if($result){
	echo json_encode(array(
		'ProbabilityId' => $percent,
		'ProbabilityDesc' => $desc
	));
} else {
	echo json_encode(array('errorMsg'=>'Some errors occured.'));
}
?>