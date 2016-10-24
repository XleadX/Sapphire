<?php
include '../setting/connection.php';

// Menangkap input field dan value untuk filter data
$field	= isset($_POST['field_order']) ? $_POST['field_order'] : 'PipelineStatus';
$value	= isset($_POST['value_order']) ? $_POST['value_order'] : '%PO%';
$page	= isset($_POST['page']) ? intval($_POST['page']) : 1;
$rows	= isset($_POST['rows']) ? intval($_POST['rows']) : 10;
$offset	= ($page-1)*$rows;
$result	= array();

// Menampilkan jumlah data
$stmt = $conn->query("SELECT COUNT(DISTINCT PipelineNumber) FROM Pipeline WHERE ($field LIKE '%$value%') AND PO = 'Yes' AND PipelineActive = 'Yes'");
$row = $stmt->fetch(); $result["total"] = $row[0];

// Menampilkan isi data
$stmt = $conn->query("SELECT PipelineStatus, PipelineNumber, RevisionNumber, ProjectName, Customer, SalesMarketId, convert(varchar, CreateDate, 106) AS CreateDate, CreateId, convert(varchar, PODate, 106) AS PODate, convert(varchar, SOReqDate, 106) AS SOReqDate, convert(varchar, TrfCodeReqDate, 106) AS TrfCodeReqDate, TrfCodeReqId, convert(varchar, TrfCodeAnswerDate, 106) AS TrfCodeAnswerDate, TrfCodeAnswerId, convert(varchar, DrawReqDate, 106) AS DrawReqDate, DrawReqId, convert(varchar, DrawAnswerDate, 106) AS DrawAnswerDate, DrawAnswerId, convert(varchar, DrawApprovalDate, 106) AS DrawApprovalDate, DrawApprovalId, SO, SalesGroupId, BUGroup FROM (SELECT TOP ($offset + $rows) PipelineStatus, PipelineNumber, RevisionNumber, ProjectName, Customer, SalesMarketId, convert(varchar, CreateDate, 106) AS CreateDate, CreateId, convert(varchar, PODate, 106) AS PODate, convert(varchar, SOReqDate, 106) AS SOReqDate, convert(varchar, TrfCodeReqDate, 106) AS TrfCodeReqDate, TrfCodeReqId, convert(varchar, TrfCodeAnswerDate, 106) AS TrfCodeAnswerDate, TrfCodeAnswerId, convert(varchar, DrawReqDate, 106) AS DrawReqDate, DrawReqId, convert(varchar, DrawAnswerDate, 106) AS DrawAnswerDate, DrawAnswerId, convert(varchar, DrawApprovalDate, 106) AS DrawApprovalDate, DrawApprovalId, SO, SalesGroupId, BUGroup, ROW_NUMBER() OVER (ORDER BY PipelineNumber DESC) AS rnum FROM Pipeline WHERE ($field LIKE '%$value%') AND PO = 'Yes' AND PipelineActive = 'Yes') a WHERE rnum > $offset");

$items = array();
while($row = $stmt->fetch(PDO::FETCH_OBJ)){
	array_push($items, $row);
}
$result["rows"] = $items;

echo json_encode($result);
?>