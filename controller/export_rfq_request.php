<?php
	$year = $_POST['requestYear'];
	
	header("Content-type: application/vnd-ms-excel");

	header("Content-Disposition: attachment; filename=Sapphire_-_RFQ_Request_Pick.xls");
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
		font-size: 10px;
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
<center><h4>Summary Of Pipeline <?php echo $year; ?></h4></center>
<table border="1" class="gridtable">
	<tr>
		<th rowspan="2">Status</th>
		<th rowspan="2">Pipeline<br>Number</th>
		<th rowspan="2">Revision</th>
		<th rowspan="2">Project Name</th>
		<th rowspan="2">Customer</th>
		<th rowspan="2">Created by</th>
		<th rowspan="2">Created Date</th>
		<th rowspan="2">Approved by</th>
		<th rowspan="2">Approved Date</th>		
		
		<th colspan="3">Specification</th>
		<th rowspan="2">Notes</th>
	</tr>
	<tr>
		<th>Type</th>
		<th>Quantity</th>
		<th>KVA / Unit</th>
	</tr>
	<?php
	include '../setting/connection.php';
	
	$stmt = $conn->prepare("SELECT Pipeline.PipelineNumber, ProjectName, Customer, CreateId, Pipeline.EstimateAmount, EstimateOrderIntake, DeliveryRequestTime, OpportunityLevel, OtherRequest, Qty, KVA, PipelineStatus, LostStatus, convert(varchar, CreateDate, 106) AS CreateDate, convert(varchar, PickDate, 106) AS PickDate, convert(varchar, AnswerDate, 106) AS AnswerDate, convert(varchar, PODate, 106) AS PODate, convert(varchar, DrawReqDate, 106) AS DrawReqDate, convert(varchar, DrawAnswerDate, 106) AS DrawAnswerDate, convert(varchar, DrawApprovalDate, 106) AS DrawApprovalDate, convert(varchar, TrfCodeReqDate, 106) AS TrfCodeReqDate, convert(varchar, TrfCodeAnswerDate, 106) AS TrfCodeAnswerDate, convert(varchar, SODate, 106) AS SODate, SORef, PipelineNote, RevisionNumber, ApprovalId, convert(varchar, ApprovalDate, 106) AS ApprovalDate FROM Pipeline JOIN PipelineDetil ON Pipeline.PipelineNumber = PipelineDetil.PipelineNumber AND Pipeline.RevisionNumber = PipelineDetil.RevisionNumber WHERE Tahun = :year AND PipelineActive = 'Yes' AND PipelineStatus LIKE 'New%' AND RFQStatus NOT LIKE 'Answer'");
	$stmt->bindParam(':year', $year);
	$stmt->execute();
	
	$i = 0;
	while($data = $stmt->fetch(PDO::FETCH_ASSOC)){
		// $total_kva = $data['KVA'] * $data['Qty'];
		$row[$i] = $data;
		$i++;
	}
	
	foreach($row as $cell){
		if(isset($total[$cell['PipelineNumber']]['total'])){
			$total[$cell['PipelineNumber']]['total']++;
		} else {
			$total[$cell['PipelineNumber']]['total'] = 1;
		}
	}
	
	$a = COUNT($row);
	$pipeline_no = "";
	for($i = 0; $i < $a; $i++){
		$cell = $row[$i];
		echo '<tr>';
		if($pipeline_no != $cell['PipelineNumber']){
			echo '
			<td'.($total[$cell['PipelineNumber']]['total'] > 1 ?' rowspan="'.($total[$cell['PipelineNumber']]['total']).'"><center>':'><center>').$cell['PipelineStatus'].'</center></td>
			<td'.($total[$cell['PipelineNumber']]['total'] > 1 ?' rowspan="'.($total[$cell['PipelineNumber']]['total']).'"><center>\'':'><center>\'').$cell['PipelineNumber'].'</center></td>
			<td'.($total[$cell['PipelineNumber']]['total'] > 1 ?' rowspan="'.($total[$cell['PipelineNumber']]['total']).'"><center>':'><center>').$cell['RevisionNumber'].'</center></td>
			<td'.($total[$cell['PipelineNumber']]['total'] > 1 ?' rowspan="'.($total[$cell['PipelineNumber']]['total']).'"><center>':'><center>').$cell['ProjectName'].'</center></td>
			<td'.($total[$cell['PipelineNumber']]['total'] > 1 ?' rowspan="'.($total[$cell['PipelineNumber']]['total']).'"><center>':'><center>').$cell['Customer'].'</center></td>
			<td'.($total[$cell['PipelineNumber']]['total'] > 1 ?' rowspan="'.($total[$cell['PipelineNumber']]['total']).'"><center>':'><center>').$cell['CreateId'].'</center></td>
			<td'.($total[$cell['PipelineNumber']]['total'] > 1 ?' rowspan="'.($total[$cell['PipelineNumber']]['total']).'"><center>':'><center>').$cell['CreateDate'].'</center></td>
			<td'.($total[$cell['PipelineNumber']]['total'] > 1 ?' rowspan="'.($total[$cell['PipelineNumber']]['total']).'"><center>':'><center>').$cell['ApprovalId'].'</center></td>
			<td'.($total[$cell['PipelineNumber']]['total'] > 1 ?' rowspan="'.($total[$cell['PipelineNumber']]['total']).'"><center>':'><center>').$cell['ApprovalDate'].'</center></td>';
		}
		
		echo "<td><center>$cell[OtherRequest]</center></td>
			<td><center>$cell[Qty]</center></td>
			<td><center>$cell[KVA]</center></td>";
		
		if($pipeline_no != $cell['PipelineNumber']){
			echo '
			<td'.($total[$cell['PipelineNumber']]['total'] > 1 ?' rowspan="'.($total[$cell['PipelineNumber']]['total']).'"><center>':'><center>').$cell['PipelineNote'].'</center></td>';
			$pipeline_no = $cell['PipelineNumber'];
		}
		echo "</tr>";
	}
	?>
</table>
</body>
</html>