<?php
include '../setting/connection.php';
include '../setting/function.php'; // File fungsi bu_group

session_start();
$username = $_SESSION['username'];

// Menangkap input field dan value untuk filter data
$field	= isset($_POST['field_order']) ? $_POST['field_order'] : 'RFQ';
$value	= isset($_POST['value_order']) ? $_POST['value_order'] : 'Yes%';
$year	= isset($_POST['year_value']) ? $_POST['year_value'] : date('Y');
$group	= isset($_POST['bugroup']) ? $_POST['bugroup'] : '%';
$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
$offset = ($page-1)*$rows;
$result = array();

// Memanggil fungsi bu_group
$bugroup = bu_group($username);

// Menentukan kondisi bugroup
if($bugroup == ''){
	$bu_group = '';
} else {
	$bu_group = $bugroup;
}

// Menampilkan jumlah data
$stmt = $conn->query("SELECT COUNT(DISTINCT PipelineNumber) FROM Pipeline WHERE ($field LIKE '%$value%') AND PipelineActive = 'Yes' AND Tahun = '$year' AND BUGroup LIKE '%$bu_group$group'");
$row = $stmt->fetch(); $result["total"] = $row[0];

// Menampilkan isi data
$stmt = $conn->query("SELECT RFQStatus, PipelineNumber, RevisionNumber, ProjectName, Customer, PipelineNote, convert(varchar, CreateDate, 106) AS CreateDate, CreateId, convert(varchar, ApprovedDate, 106) AS ApprovedDate, ApprovedId, convert(varchar, PickDate, 106) AS PickDate, PickId, convert(varchar, ScheduleDate, 106) AS ScheduleDate, ScheduleId, convert(varchar, AnswerDate, 106) AS AnswerDate, AnswerId, SalesGroupId, RFQ, Approved FROM (SELECT TOP ($offset + $rows) RFQStatus, PipelineNumber, RevisionNumber, ProjectName, Customer, PipelineNote, convert(varchar, CreateDate, 106) AS CreateDate, CreateId, convert(varchar, ApprovedDate, 106) AS ApprovedDate, ApprovedId, convert(varchar, PickDate, 106) AS PickDate, PickId, convert(varchar, ScheduleDate, 106) AS ScheduleDate, ScheduleId, convert(varchar, AnswerDate, 106) AS AnswerDate, AnswerId, SalesGroupId, RFQ, Approved, ROW_NUMBER() OVER (ORDER BY PipelineNumber DESC) AS rnum FROM Pipeline WHERE ($field LIKE '%$value%') AND PipelineActive = 'Yes' AND Tahun = '$year' AND BUGroup LIKE '%$bu_group$group') a WHERE rnum > $offset");

$items = array();
while($row = $stmt->fetch(PDO::FETCH_OBJ)){
	array_push($items, $row);
}
$result["rows"] = $items;

echo json_encode($result);
?>