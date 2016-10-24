<?php
	$year = $_POST['answerYear'];
	
	header("Content-type: application/vnd-ms-excel");

	header("Content-Disposition: attachment; filename=Sapphire_-_RFQ_Answer.xls");
?>
<html>
<head>
	<!--<meta http-equiv="refresh" content="0; url=export_rfq_answer.php">-->
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
<center><h4>RFQ Answer Summary <?php echo $year; ?></h4></center>
<table border="1" class="gridtable">
	<tr>
		<th>Pipeline Number</th>
		<th>Revision Number</th>
		<th>Answered By</th>
		<th>Answered Date</th>
	</tr>
	<?php
	include '../setting/connection.php';
	
	$stmt = $conn->prepare("SELECT PipelineNumber, RevisionNumber, convert(varchar, AnswerDate, 106) AS AnswerDate, AnswerId FROM Pipeline WHERE RFQ = 'Yes' AND PipelineActive = 'Yes' AND Tahun = :year AND Answer = 'Yes'");
	$stmt->bindParam(':year', $year);
	$stmt->execute();
	
	while($data = $stmt->fetch(PDO::FETCH_ASSOC)){
		$number = $data['PipelineNumber'];
		echo '
		<tr>
			<td><center>\''.$number.'</center></td>
			<td><center>'.$data['RevisionNumber'].'</center></td>
			<td><center>'.$data['AnswerId'].'</center></td>
			<td><center>'.$data['AnswerDate'].'</center></td>
		</tr>
		';
	}
	?>
</table>
</body>
</html>