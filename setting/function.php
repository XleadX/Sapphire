<?php
function pipeline($number){
	include 'connection.php';
	$active = 'Yes';
	
	$stmt = $conn->prepare("SELECT * FROM Pipeline WHERE PipelineNumber = :number AND PipelineActive = :active");
	$stmt->bindParam(':number', $number);
	$stmt->bindParam(':active', $active);
	$stmt->execute();
	
	$result = $stmt->fetch(PDO::FETCH_ASSOC);
	return $result;
}
function bu_group($username){
	include 'connection.php';
	
	$stmt = $conn->prepare("SELECT BUGroup FROM Engineer WHERE EngineerId = :username");
	$stmt->bindParam(':username', $username);
	$stmt->execute();
	
	$result = $stmt->fetch();
	$bugroup = $result['BUGroup'];
	
	return $bugroup;
}

function email_sales($username){
	include 'connection.php';
	
	$stmt = $conn->prepare("SELECT SalesEmail FROM Sales WHERE SalesId = :username");
	$stmt->bindParam(':username', $username);
	$stmt->execute();

	$result = $stmt->fetch();
	$sales_email = $result['SalesEmail'];
	
	return $sales_email;
}

function email_sales_admin(){
	include 'connection.php';
	
	$stmt = $conn->query("SELECT SalesEmail FROM Sales WHERE SalesGroupId = 'SA'");
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	return $result;
}

function email_sales_manager($group){
	include 'connection.php';
	
	$stmt = $conn->prepare("SELECT Sales.SalesEmail AS SalesEmail FROM Sales JOIN SalesDept ON Sales.SalesId = SalesDept.SalesId WHERE SalesDept.SalesGroupId = :group");
	$stmt->bindParam(':group', $group);
	$stmt->execute();
	
	$result = $stmt->fetch();
	$sm_email = $result['SalesEmail'];
	
	return $sm_email;
}

function email_engineer_head(){
	include 'connection.php';
	
	$stmt = $conn->query("SELECT EngineerEmail FROM Engineer WHERE EngineerGroup = 'ENG' AND EngineerLevel = 'Head'");
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	return $result;
}

function email_engineer_so($bugroup){
	include 'connection.php';
	
	$stmt = $conn->prepare("SELECT EngineerEmail FROM Engineer WHERE ConfirmSO = 'Yes' AND (BUGroup = :bugroup OR BUGroup = '')");
	$stmt->bindParam(':bugroup', $bugroup);
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	return $result;
}

function sales_group_level($username){
	include 'connection.php';
	
	$stmt = $conn->prepare("SELECT SalesGroupId, SalesLevel FROM Sales WHERE SalesId = :username");
	$stmt->bindParam(':username', $username);
	$stmt->execute();
	$result = $stmt->fetch();
	
	return $result;
}

function engineer_group($username){
	include 'connection.php';
	
	$stmt = $conn->prepare("SELECT EngineerGroup FROM Engineer WHERE EngineerId = :username");
	$stmt->bindParam(':username', $username);
	$stmt->execute();
	$result = $stmt->fetch();
	
	return $result;
}

function email_engineer_qa($bugroup){
	include 'connection.php';
	
	$stmt = $conn->prepare("SELECT EngineerEmail FROM Engineer WHERE (EngineerGroup = 'ENG' OR EngineerGroup = 'QA') AND (BUGroup = :bugroup OR BUGroup = '')");
	$stmt->bindParam(':bugroup', $bugroup);
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	return $result;
}

function sales_group($market){
	include 'connection.php';
	
	$stmt = $conn->prepare("SELECT SalesGroupId FROM SalesMarket WHERE SalesMarketId = :market");
	$stmt->bindParam(':market', $market);
	$stmt->execute();
	$result = $stmt->fetch();
	$group = $result['SalesGroupId'];
	
	return $group;
}

function email_engineer($bugroup){
	include 'connection.php';
	
	$stmt = $conn->prepare("SELECT EngineerEmail FROM Engineer WHERE EngineerGroup = 'ENG' AND (BUGroup = :bugroup OR BUGroup = '')");
	$stmt->bindParam(':bugroup', $bugroup);
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	return $result;
}

function email_engineer_ppic_pc($bugroup){
	include 'connection.php';
	
	$stmt = $conn->prepare("SELECT EngineerEmail FROM Engineer WHERE EngineerGroup <> 'QA' AND EngineerGroup <> 'SVC' AND (BUGroup = :bugroup OR BUGroup = '')");
	$stmt->bindParam(':bugroup', $bugroup);
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	return $result;
}

function email_qa($bugroup){
	include 'connection.php';
	
	$stmt = $conn->prepare("SELECT EngineerEmail FROM Engineer WHERE EngineerGroup = 'QA' AND BUGroup = :bugroup");
	$stmt->bindParam(':bugroup', $bugroup);
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	return $result;
}

function email_svc(){
	include 'connection.php';
	
	$stmt = $conn->query("SELECT EngineerEmail FROM Engineer WHERE EngineerGroup = 'SVC'");
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	return $result;
}

function month_year(){
	$start_date = new DateTime();

	$end_date = new DateTime();
	$end_date = $end_date->modify('+2 year');

	$interval = new DateInterval("P1M");
	$dates = new DatePeriod($start_date, $interval, $end_date);

	$date = array();

	if (!empty($dates)) {
		foreach($dates as $dt) {
			$date[] = array(
				'month_year' => $dt->format('M Y')
			);
		}
	}
	return $date;
}

function sm_group_ict($sm_email){
	include 'connection.php';
	
	$stmt = $conn->prepare("SELECT SalesDept.SalesGroupId AS SalesGroupId FROM SalesDept JOIN Sales ON SalesDept.SalesId = Sales.SalesId WHERE Sales.SalesEmail = :sm_email");
	$stmt->bindParam(':sm_email', $sm_email);
	$stmt->execute();
	
	$result = $stmt->fetch();
	$sm_email = $result['SalesGroupId'];
	
	return $sm_email;
}
?>