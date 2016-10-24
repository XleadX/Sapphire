<?php
include '../setting/connection.php';

$id = $_REQUEST['PipelineNumber'];
$revision = $_REQUEST['RevisionNumber'];

$stmt = $conn->prepare("SELECT TrafoType, KVA, OtherRequest, Qty FROM PipelineDetil WHERE PipelineNumber = :id AND RevisionNumber = :revision");
$stmt->bindParam(':id', $id);
$stmt->bindParam(':revision', $revision);
$stmt->execute();

$items = array();
while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
	array_push($items, $row);
}
$result["rows"] = $items;

echo json_encode($result);
?>