<?php
include '../setting/connection.php';

// Menangkap input program
$group	= htmlspecialchars($_REQUEST['SalesGroupId']);
$market	= htmlspecialchars($_REQUEST['SalesMarketId']);

// Menambahkan data ke database
$result = $conn->prepare("INSERT INTO SalesMarket(SalesMarketId,SalesGroupId) VALUES(:market,:group)");
$result->bindParam(':market', $market);
$result->bindParam(':group', $group);

// Menangani hasil query (assets/js/function.js)
if($result){
	echo json_encode(array(
		'SalesGroupId' => $group,
		'SalesMarketId' => $market
	));
} else {
	echo json_encode(array('errorMsg'=>'Some errors occured.'));
}
?>