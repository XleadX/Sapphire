<?php
include '../setting/connection.php';
include '../setting/function.php'; // File fungsi bu_group

session_start();
$username = $_SESSION['username'];

// Menangkap input field dan value untuk filter data
$field = isset($_POST['field_order']) ? $_POST['field_order'] : 'DrawReq';
$value = isset($_POST['value_order']) ? $_POST['value_order'] : 'Yes%';
$year	= isset($_POST['year_value']) ? $_POST['year_value'] : date('Y');
$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
$offset = ($page-1)*$rows;
$result = array();

// Memanggil fungsi bu_group
$bugroup = bu_group($username);

// Menentukan kondisi bugroup
if($bugroup == ''){
	$condition = '';
} else {
	$condition = 'AND BUGroup = \''.$bugroup.'\'';
}

// Menampilkan jumlah data
$stmt = $conn->query("SELECT COUNT(DISTINCT PipelineNumber) FROM Pipeline WHERE ($field LIKE '%$value%') AND PipelineActive = 'Yes' AND Tahun = '$year' $condition");
$row = $stmt->fetch(); $result["total"] = $row[0];

// Menampilkan isi data
$stmt = $conn->query("SELECT PipelineStatus, PipelineNumber, RevisionNumber, ProjectName, Customer, SalesMarketId, convert(varchar, CreateDate, 106) AS CreateDate, CreateId, convert(varchar, DrawReqDate, 106) AS DrawReqDate, DrawReqId, convert(varchar, DrawAnswerDate, 106) AS DrawAnswerDate, DrawAnswerId, convert(varchar, DrawApprovalDate, 106) AS DrawApprovalDate, DrawApprovalId, convert(varchar, AnswerDate, 106) AS AnswerDate, AnswerId, DrawStatus FROM (SELECT TOP ($offset + $rows) PipelineStatus, PipelineNumber, RevisionNumber, ProjectName, Customer, SalesMarketId, convert(varchar, CreateDate, 106) AS CreateDate, CreateId, convert(varchar, DrawReqDate, 106) AS DrawReqDate, DrawReqId, convert(varchar, DrawAnswerDate, 106) AS DrawAnswerDate, DrawAnswerId, convert(varchar, DrawApprovalDate, 106) AS DrawApprovalDate, DrawApprovalId, convert(varchar, AnswerDate, 106) AS AnswerDate, AnswerId, DrawStatus, ROW_NUMBER() OVER (ORDER BY PipelineNumber DESC) AS rnum FROM Pipeline WHERE ($field LIKE '%$value%') AND PipelineActive = 'Yes' AND Tahun = '$year' $condition) a WHERE rnum > $offset");

$items = array();
while($row = $stmt->fetch(PDO::FETCH_OBJ)){
	array_push($items, $row);
}
$result["rows"] = $items;

echo json_encode($result);
?>