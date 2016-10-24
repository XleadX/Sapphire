<?php
include '../setting/connection.php';
include '../setting/function.php'; // File fungsi sales_group dan sales_level

session_start();
$username = $_SESSION['username'];

// Memanggil fungsi sales_group_level
$data	= sales_group_level($username);
$group	= $data['SalesGroupId'];
$level	= $data['SalesLevel'];

// Menangkap input field dan value untuk filter data
$field	= isset($_POST['field']) ? $_POST['field'] : 'PipelineNumber';
$value	= isset($_POST['value']) ? $_POST['value'] : '%';
$active	= isset($_POST['active']) ? $_POST['active'] : 'Yes';
$year	= isset($_POST['year']) ? $_POST['year'] : date('Y');
$page	= isset($_POST['page']) ? intval($_POST['page']) : 1;
$rows	= isset($_POST['rows']) ? intval($_POST['rows']) : 10;
$offset = ($page-1)*$rows;
$result = array();
$condition = $field .' LIKE \'%'.$value.'%\'';

// Kondisi berdasarkan user login
If($level == 'Staff' AND $group != 'SA'){
	$user		= 'AND CreateId = \''.$username.'\'';
	$rfq		= '';
	$po			= '';
	$approved	= '';
} elseIf($level == 'Manager'){
	$user		= 'AND SalesGroupId IN (SELECT SalesGroupId FROM SalesDept WHERE SalesId = \''.$username.'\')';
	$rfq		= '';
	$po			= '';
	$approved	= '';
} elseIf($level == 'Staff' AND $group == 'SA'){
	$user		= "AND PO = 'Yes'";
	$rfq		= '';
	$po			= '';
	$approved	= '';
} else {
	$user		= '';
	$rfq		= '';
	$po			= '';
	$approved	= '';
}

// Kondisi ketika filter berdasarkan status approved
if($field == 'Approved' AND $value == 'No'){
	$condition	= $field .' LIKE \'%'.$value.'%\'';
	$approved	= 'OR Approved IS NULL';
	$rfq		= 'AND RFQ = "Yes"';
	$po			= 'AND PO = "No"';
} elseif($field == 'Approved' AND $value == 'Yes'){
	$condition	= $field .' LIKE \'%'.$value.'%\'';
	$approved	= '';
	$rfq		= 'AND RFQ = "Yes"';
	$po			= 'AND PO = "No"';
} else {
	$condition	= $field .' LIKE \'%'.$value.'%\'';
	$approved	= '';
	$rfq		= 'AND RFQ LIKE "%"';
	$po			= 'AND PO LIKE "%"';
}

// Kondisi ketika filter berdasarkan status project loss
if($field == 'PipelineStatus' AND $value == 'Loss'){
	$active = 'No';
}

// Kondisi ketika filter berdasarkan KVA
if($field == 'KVA'){
	$condition = "PipelineNumber IN (SELECT PipelineNumber FROM PipelineDetil WHERE KVA = '$value')";
}

// Menampilkan jumlah data
$stmt = $conn->query("SELECT COUNT(DISTINCT PipelineNumber) FROM Pipeline WHERE ($condition $approved) AND Tahun = '$year' AND PipelineActive LIKE '$active' $user");
$row = $stmt->fetch(); $result["total"] = $row[0];

// Menampilkan isi data
$stmt = $conn->query("SELECT *, convert(varchar, CreateDate, 106) AS CreateDate FROM (SELECT TOP ($offset + $rows) *, ROW_NUMBER() OVER (ORDER BY PipelineNumber DESC) AS rnum FROM Pipeline WHERE ($condition $approved) AND Tahun = '$year' AND PipelineActive LIKE '$active' $user) a WHERE rnum > $offset");

$items = array();
while($row = $stmt->fetch(PDO::FETCH_OBJ)){
	array_push($items, $row);
}
$result["rows"] = $items;

echo json_encode($result);
?>