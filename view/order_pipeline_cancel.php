<?php
include '../setting/connection.php';

$number = $_GET['PipelineNumber'];
$result = $conn->query("SELECT PipelineNumber, ProjectName, Customer, RevisionNumber, BUGroup, SalesGroupId, FAT, Tescom, TestReq FROM Pipeline WHERE PipelineNumber = '$number' AND PipelineActive = 'Yes'");
$data	= $result->fetch(PDO::FETCH_ASSOC);
?>

<form id="cancel_project" action="../controller/order_pipeline_cancel.php" method="post">
	<input type="hidden" name="PipelineNumber" value="<?php echo $data['PipelineNumber'] ?>">
	<input type="hidden" name="RevisionNumber" value="<?php echo $data['RevisionNumber'] ?>">
	<input type="hidden" name="ProjectName" value="<?php echo $data['ProjectName'] ?>">
	<input type="hidden" name="Customer" value="<?php echo $data['Customer'] ?>">
	<input type="hidden" name="BUGroup" value="<?php echo $data['BUGroup'] ?>">
	<input type="hidden" name="SalesGroupId" value="<?php echo $data['SalesGroupId'] ?>">
	<input type="hidden" name="FAT" value="<?php echo $data['FAT'] ?>">
	<input type="hidden" name="Tescom" value="<?php echo $data['Tescom'] ?>">
	<input type="hidden" name="TestReq" value="<?php echo $data['TestReq'] ?>">
	<div class="fitem">
		<label>Reason</label>
	</div>
	<div class="fitem">
		<textarea style="width:315px; height:75px" name="ReasonCancelled" required></textarea>
	</div>
</form>