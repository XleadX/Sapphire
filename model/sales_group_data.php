<?php
include '../setting/connection.php';

$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 20;
$offset = ($page-1)*$rows;
$result = array();

// Menampilkan jumlah data
$stmt = $conn->query("SELECT COUNT(*) FROM SalesGroup");
$row = $stmt->fetch(); $result["total"] = $row[0];

// Menampilkan isi data
$stmt = $conn->query("SELECT SalesGroupId FROM (SELECT TOP ($offset + $rows) SalesGroupId, ROW_NUMBER() OVER (ORDER BY SalesGroupId) AS rnum FROM SalesGroup) a WHERE rnum > $offset");

$items = array();
while($row = $stmt->fetch(PDO::FETCH_OBJ)){
	array_push($items, $row);
}
$result["rows"] = $items;

echo json_encode($result);
?>