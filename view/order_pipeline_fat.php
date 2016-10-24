<?php
include '../setting/connection.php';
$number = $_GET['PipelineNumber'];
$result = $conn->query("SELECT PipelineNumber, RevisionNumber, FATDate FROM Pipeline WHERE PipelineNumber = '$number' AND PipelineActive = 'Yes'");
$data	= $result->fetch(PDO::FETCH_ASSOC);
?>

<form id="change_fat" method="post" action="../controller/order_pipeline_fat.php" novalidate>
	<div class="fitem">
		<label>Pipeline Number</label>
		<input style="width:80px; text-align:center" name="PipelineNumber" readonly="true" value="<?php echo $number ?>">
	</div>
	<div class="fitem">
		<label>Old FAT Date</label>
		<input style="width: 135px; text-align:center; padding-right:7px" name="FATDate" readonly="true" value="<?php if($data['FATDate'] == ''){ echo ''; } else { echo date('d-m-Y H:i:s', strtotime($data['FATDate'])); } ?>">
	</div>
	<div class="fitem">
		<label>New FAT Date</label>
		<input id="newFATDate" style="width:135px; text-align:center; padding-right:7px" name="newFATDate">
		<script>
			$('#newFATDate').datetimepicker({
				timepicker: true,
				format: 'd-m-Y H:i:s'
			});
		</script>
	</div>
</form>