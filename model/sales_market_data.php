<?php
include '../setting/connection.php';

$id = $_REQUEST['SalesGroupId'];

$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
$offset = ($page-1)*$rows;
$result = array();

// Menampilkan jumlah data
$stmt = $conn->query("SELECT COUNT(*) FROM SalesMarket WHERE SalesGroupId = '$id'");
$row = $stmt->fetch(); $result["total"] = $row[0];

// Menampilkan isi data
$stmt = $conn->query("SELECT SalesMarketId FROM SalesMarket WHERE SalesGroupId = '$id'");

$items = array();
while($row = $stmt->fetch(PDO::FETCH_OBJ)){
	array_push($items, $row);
}
$result["rows"] = $items;

echo json_encode($result);
?>