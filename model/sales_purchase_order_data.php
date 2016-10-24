<?php
include '../setting/connection.php';

session_start();
$username = $_SESSION['username'];

// Menangkap input field dan value untuk filter data
$field	= isset($_POST['field_order']) ? $_POST['field_order'] : 'PipelineNumber';
$value	= isset($_POST['value_order']) ? $_POST['value_order'] : '%';
$active	= isset($_POST['active_order']) ? $_POST['active_order'] : 'Yes';
$year	= isset($_POST['value_year']) ? $_POST['value_year'] : date('Y');
$page	= isset($_POST['page']) ? intval($_POST['page']) : 1;
$rows	= isset($_POST['rows']) ? intval($_POST['rows']) : 10;
$offset	= ($page-1)*$rows;
$result	= array();

if($field == 'RFQStatus'){
	$rfq = '';
} else {
	$rfq = '';
}

// Menampilkan jumlah data
$stmt = $conn->query("SELECT COUNT(DISTINCT PipelineNumber) FROM Pipeline WHERE ($field LIKE '%$value%') AND PipelineActive LIKE '$active' AND Tahun = '$year' AND PO = 'No' $rfq");
$row = $stmt->fetch(); $result["total"] = $row[0];

// Menampilkan isi data
$stmt = $conn->query("SELECT * FROM (SELECT TOP ($offset + $rows) PipelineStatus, PipelineNumber, RevisionNumber, ProjectName, Customer, SalesGroupId, SalesMarketId, CreateId, convert(varchar, CreateDate, 106) AS CreateDate, EstimateOrderIntake, DeliveryRequestTime, OpportunityLevel, RFQStatus, RFQ, convert(varchar, RFQDate, 106) AS RFQDate, convert(varchar, PickDate, 106) AS PickDate, PickId, convert(varchar, ScheduleDate, 106) AS ScheduleDate, ScheduleId, convert(varchar, AnswerDate, 106) AS AnswerDate, AnswerId, DrawStatus, convert(varchar, DrawReqDate, 106) AS DrawReqDate, DrawAnswer, convert(varchar, DrawAnswerDate, 106) AS DrawAnswerDate, DrawAnswerId, DrawApproval, convert(varchar, DrawApprovalDate, 106) AS DrawApprovalDate, DrawApprovalId, TestStatus, convert(varchar, TestReqDate, 106) AS TestDate, FAT, Tescom, convert(varchar, FATDate, 106) AS FATDate, PO, SO, Approved, BUGroup, PipelineNote, ROW_NUMBER() OVER (ORDER BY PipelineNumber DESC) AS rnum FROM Pipeline WHERE ($field LIKE '%$value%') AND PipelineActive LIKE '$active' AND Tahun = '$year' AND PO = 'No' $rfq) a WHERE rnum > $offset");

$items = array();
while($row = $stmt->fetch(PDO::FETCH_OBJ)){
	array_push($items, $row);
}
$result["rows"] = $items;

echo json_encode($result);
?>