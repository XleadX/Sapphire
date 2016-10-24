<?php
include '../setting/connection.php';
include '../setting/function.php';
$number = $_GET['PipelineNumber'];

$data = pipeline($number);
?>

<form id="rfq_schedule" action="../controller/request_for_quotation_schedule.php" method="post" enctype="multipart/form-data">
	<div class="fitem">
		<label>Pipeline Number</label>
		<input style="width:75px" name="PipelineNumber" value="<?php echo $data['PipelineNumber'] ?>" readonly>
	</div>
	<div class="fitem">
		<label>Project Name</label>
		<input style="width:400px" name="ProjectName" value="<?php echo $data['ProjectName'] ?>" readonly>
	</div>
	<div class="fitem">
		<label>Customer</label>
		<input style="width:400px" name="Customer" value="<?php echo $data['Customer'] ?>" readonly>
	</div>
	<div class="fitem">
		<label>Sales</label>
		<input style="width:75px" name="CreateId" value="<?php echo $data['CreateId'] ?>" readonly>
	</div>
	<div class="fitem">
		<label>Schedule Date</label>
		<input id="datepicker" type="text" name="ScheduleDate" style="width:130px; margin-right:100px">
		<script>
			$('#datepicker').datetimepicker({
				timepicker: true,
				format: 'd-m-Y H:i:s'
			});
		</script>
	</div>
	<input type="hidden" name="RevisionNumber" value="<?php echo $data['RevisionNumber'] ?>">
</form>