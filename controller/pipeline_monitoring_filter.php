<?php
date_default_timezone_set('Asia/Jakarta');
include '../setting/connection.php';
include '../setting/function.php'; // File fungsi sales_group_level dan engineer_group

session_start();
$username	= $_SESSION['username'];
$date		= date('Y');

// Memanggil fungsi sales_group_level dan engineer_group
$sales	= sales_group_level($username);
$eng	= engineer_group($username);

$group		= $sales['SalesGroupId'];
$level		= $sales['SalesLevel'];
$eng_group	= $eng['EngineerGroup'];

// Kondisi untuk menambahkan isi di filter value
if($group == 'SA' && $level == 'Staff'){
	$status			= array('PO','SO');
	$kva			= $conn->query("SELECT DISTINCT PipelineDetil.KVA AS KVA FROM PipelineDetil JOIN Pipeline ON PipelineDetil.PipelineNumber = Pipeline.PipelineNumber WHERE Pipeline.Tahun = '$date'");
	$sales 			= $conn->query("SELECT DISTINCT CreateId FROM Pipeline WHERE Tahun = '$date'");
	$market 		= $conn->query("SELECT DISTINCT SalesMarketId FROM Pipeline WHERE Tahun = '$date'");
} elseif($group <> 'SA' && $level == 'Staff'){
	$status			= array('New','PO','SO','Loss');
	$approved		= array('Yes'=>'Yes','No'=>'No');
	$opportunity 	= $conn->query("SELECT DISTINCT ProbabilityId FROM Probability");
	$kva			= $conn->query("SELECT DISTINCT PipelineDetil.KVA AS KVA FROM PipelineDetil JOIN Pipeline ON PipelineDetil.PipelineNumber = Pipeline.PipelineNumber AND PipelineDetil.RevisionNumber = Pipeline.RevisionNumber WHERE Pipeline.CreateId = '$username' AND Pipeline.Tahun = '$date'");
	$sales 			= $conn->query("SELECT DISTINCT CreateId FROM Pipeline WHERE CreateId = '$username' AND Tahun = '$date'");
	$market 		= $conn->query("SELECT DISTINCT SalesMarketId FROM SalesMarket WHERE SalesGroupId = '$group'");
	$business_unit	= $conn->query("SELECT DISTINCT BUGroup FROM BusinessUnit");
	$create_date	= $conn->query("SELECT DISTINCT TOP 10 right(convert(varchar, CreateDate, 106), 8) AS CreateDate, (convert(varchar(7), CreateDate, 126)) AS Date, (convert(varchar(3), CreateDate, 107)) AS Month FROM Pipeline WHERE CreateId = '$username' AND Tahun = '$date'");
} elseif($level == 'Manager'){
	$status			= array('New','PO','SO','Loss');
	$approved		= array('Yes'=>'Yes','No'=>'No');
	$opportunity 	= $conn->query("SELECT DISTINCT ProbabilityId FROM Probability");
	$kva			= $conn->query("SELECT DISTINCT PipelineDetil.KVA AS KVA FROM PipelineDetil JOIN Pipeline ON PipelineDetil.PipelineNumber = Pipeline.PipelineNumber AND PipelineDetil.RevisionNumber = Pipeline.RevisionNumber WHERE Pipeline.SalesGroupId IN (SELECT SalesGroupId FROM SalesDept WHERE SalesId = '$username') AND Tahun = '$date'");
	$sales 			= $conn->query("SELECT Sales.SalesId AS CreateId, SalesDept.SalesGroupId FROM Sales JOIN SalesDept ON Sales.SalesGroupId = SalesDept.SalesGroupId WHERE SalesDept.SalesId = '$username'");
	$market 		= $conn->query("SELECT SalesMarket.SalesMarketId, SalesDept.SalesGroupId FROM SalesMarket JOIN SalesDept ON SalesMarket.SalesGroupId = SalesDept.SalesGroupId WHERE SalesDept.SalesId = '$username'");
	$business_unit	= $conn->query("SELECT DISTINCT BUGroup FROM BusinessUnit");
	$create_date	= $conn->query("SELECT DISTINCT TOP 10 right(convert(varchar, CreateDate, 106), 8) AS CreateDate, (convert(varchar(7), CreateDate, 126)) AS Date, (convert(varchar(3), CreateDate, 107)) AS Month FROM Pipeline WHERE SalesGroupId IN (SELECT SalesGroupId FROM SalesDept WHERE SalesId = '$username')");
} elseif($group == 'MKT' OR $eng_group == 'ENG' OR $eng_group == 'PPIC' OR $eng_group == 'QA' OR $eng_group == 'PC' OR $eng_group == 'SVC') {
	$status			= array('New','PO','SO','Loss');
	$kva			= $conn->query("SELECT DISTINCT PipelineDetil.KVA AS KVA FROM PipelineDetil JOIN Pipeline ON PipelineDetil.PipelineNumber = Pipeline.PipelineNumber WHERE Pipeline.Tahun = '$date'");
	$sales 			= $conn->query("SELECT DISTINCT CreateId FROM Pipeline WHERE Tahun = '$date'");
	$market 		= $conn->query("SELECT DISTINCT SalesMarketId FROM Pipeline WHERE Tahun = '$date'");
	$business_unit	= $conn->query("SELECT DISTINCT BUGroup FROM BusinessUnit");
	$create_date	= $conn->query("SELECT DISTINCT TOP 10 right(convert(varchar, CreateDate, 106), 8) AS CreateDate, (convert(varchar(7), CreateDate, 126)) AS Date, (convert(varchar(3), CreateDate, 107)) AS Month FROM Pipeline WHERE Tahun = '$date' ORDER BY Date DESC");
} else {
	$status			= array('New','PO','SO','Loss');
	$approved		= array('Yes'=>'Yes','No'=>'No');
	$opportunity 	= $conn->query("SELECT DISTINCT ProbabilityId FROM Probability");
	$kva			= $conn->query("SELECT DISTINCT PipelineDetil.KVA AS KVA FROM PipelineDetil JOIN Pipeline ON PipelineDetil.PipelineNumber = Pipeline.PipelineNumber WHERE Pipeline.Tahun = '$date'");
	$sales 			= $conn->query("SELECT DISTINCT CreateId FROM Pipeline WHERE Tahun = '$date'");
	$market 		= $conn->query("SELECT DISTINCT SalesMarketId FROM Pipeline WHERE Tahun = '$date'");
	$business_unit	= $conn->query("SELECT DISTINCT BUGroup FROM BusinessUnit");
	$create_date	= $conn->query("SELECT DISTINCT TOP 10 right(convert(varchar, CreateDate, 106), 8) AS CreateDate, (convert(varchar(7), CreateDate, 126)) AS Date, (convert(varchar(3), CreateDate, 107)) AS Month FROM Pipeline WHERE Tahun = '$date' ORDER BY Date DESC");
}

// Menampilkan isi di filter value
if(isset($_POST['field'])) {
	$choose = $_POST['field'];
	if($choose == 'PipelineNumber'){
		echo '<option value="%">All</option>';
	} elseif($choose == 'PipelineStatus'){
		foreach($status as $key){
			echo '<option value="'.$key.'">'.$key.'</option>';
		}
	} elseif($choose == 'Approved'){
		foreach($approved as $key => $value){
			echo '<option value="'.$value.'">'.$key.'</option>';
		}
	} elseif($choose == 'OpportunityLevel'){
		while($data = $opportunity->fetch(PDO::FETCH_ASSOC)){
			echo '<option value="' . $data['ProbabilityId'] . '">' . $data['ProbabilityId'] . '</option>';   
		}
	} elseif($choose == 'KVA'){
		while($data = $kva->fetch(PDO::FETCH_ASSOC)){
			echo '<option value="' . $data['KVA'] . '">' . $data['KVA'] . '</option>';   
		}
	} elseif($choose == 'CreateId'){
		while($data = $sales->fetch(PDO::FETCH_ASSOC)){
			echo '<option value="' . $data['CreateId'] . '">' . $data['CreateId'] . '</option>';   
		}
	} elseif($choose == 'SalesMarketId'){
		while($data = $market->fetch(PDO::FETCH_ASSOC)){
			echo '<option value="' . $data['SalesMarketId'] . '">' . $data['SalesMarketId'] . '</option>';   
		}
	} elseif($choose == 'BUGroup'){
		while($data = $business_unit->fetch(PDO::FETCH_ASSOC)){
			echo '<option value="' . $data['BUGroup'] . '">' . $data['BUGroup'] . '</option>';   
		}
	} elseif($choose == 'CreateDate'){
		while($data = $create_date->fetch(PDO::FETCH_ASSOC)){
			echo '<option value="' . $data['Month'] . '">' . $data['CreateDate'] . '</option>';   
		}
	}
}
?>