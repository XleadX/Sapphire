<?php
	$month	= $_POST['createdMonth'];
	$year	= $_POST['createdYear'];
	
	header("Content-type: application/vnd-ms-excel");

	header("Content-Disposition: attachment; filename=Sapphire.xls");
?>
<html>
<head>
	<!--<meta http-equiv="refresh" content="0; url=export_rfq.php">-->
	<title>Export to Excel</title>
	<style type="text/css">
	table.gridtable {
		font-family: verdana,arial,sans-serif;
	}
	table.gridtable th {
		font-size: 13px;
		padding: 8px;
		background-color: #80CCFF;
	}
	table.gridtable td {
		font-size: 10px;
		padding: 8px;
		background-color: #FFFFFF;
		width: auto;
	}
	</style>
</head>
<body>
<!--<a href="export_rfq.php"><button>Export to Excel</button></a><br><br>-->
<center><h4>RFQ Manager Report - <?php echo $month; ?> <?php echo $year; ?></h4></center>
<table border="1" class="gridtable">
	<tr>
		<th>Pipeline Number</th>
		<th>Revision Number</th>
		<th>Project Name</th>
		<th>Customer</th>
		<th>Pipeline Note</th>
		<th>Created Date</th>
		<th>Created By</th>
		<th>Approved Date</th>
		<th>Approved By</th>
		<th>Picked Date</th>
		<th>Picked By</th>
		<th>Scheduled Date</th>
		<th>Scheduled By</th>
		<th>Answered Date</th>
		<th>Answered By</th>
	</tr>
	<?php
	include '../setting/connection.php';
	$month = '%'.$month.'%';
	
	$stmt = $conn->prepare("SELECT PipelineNumber, RevisionNumber, ProjectName, Customer, PipelineNote, convert(varchar, CreateDate, 106) AS CreateDate, CreateId, convert(varchar, ApprovedDate, 106) AS ApprovedDate, ApprovedId, convert(varchar, PickDate, 106) AS PickDate, PickId, convert(varchar, ScheduleDate, 106) AS ScheduleDate, ScheduleId, convert(varchar, AnswerDate, 106) AS AnswerDate, AnswerId FROM Pipeline WHERE RFQ = 'Yes' AND PipelineActive = 'Yes' AND CreateDate LIKE :month AND Tahun = :year");
	$stmt->bindParam(':month', $month);
	$stmt->bindParam(':year', $year);
	$stmt->execute();
	
	while($data = $stmt->fetch(PDO::FETCH_ASSOC)){
		$number = $data['PipelineNumber'];
		echo '
		<tr>
			<td><center>\''.$number.'</center></td>
			<td><center>'.$data['RevisionNumber'].'</center></td>
			<td>'.$data['ProjectName'].'</td>
			<td>'.$data['Customer'].'</td>
			<td>'.$data['PipelineNote'].'</td>
			<td><center>'.$data['CreateDate'].'</center></td>
			<td><center>'.$data['CreateId'].'</center></td>
			<td><center>'.$data['ApprovedDate'].'</center></td>
			<td><center>'.$data['ApprovedId'].'</center></td>
			<td><center>'.$data['PickDate'].'</center></td>
			<td><center>'.$data['PickId'].'</center></td>
			<td><center>'.$data['ScheduleDate'].'</center></td>
			<td><center>'.$data['ScheduleId'].'</center></td>
			<td><center>'.$data['AnswerDate'].'</center></td>
			<td><center>'.$data['AnswerId'].'</center></td>
		</tr>
		';
	}
	?>
</table>
</body>
</html>