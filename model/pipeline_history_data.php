<?php
include '../setting/connection.php';

$id = $_REQUEST['PipelineNumber'];

$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
$offset = ($page-1)*$rows;
$result = array();

// Menampilkan jumlah data
$stmt = $conn->query("SELECT COUNT(DISTINCT PipelineNumber) FROM Pipeline WHERE PipelineNumber = '$id'");
$row = $stmt->fetch(); $result["total"] = $row[0];

// Menampilkan isi data
$stmt = $conn->query("SELECT PipelineStatus, PipelineNumber, RevisionNumber, ProjectName, Customer, CreateId, convert(varchar, CreateDate, 106) AS CreateDate FROM Pipeline WHERE PipelineNumber = '$id'");

$items = array();
while($row = $stmt->fetch(PDO::FETCH_OBJ)){
	array_push($items, $row);
}
$result["rows"] = $items;

echo json_encode($result);
?>