<?php
include '../setting/connection.php';
include '../setting/function.php';
$number = $_GET['PipelineNumber'];

$data = pipeline($number);
?>

<form id="code_answer" action="../controller/transformer_code_answer.php" method="post">
	<div class="fitem">
		<label>Pipeline Number</label>
		<input style="width:75px" name="PipelineNumber" value="<?php echo $data['PipelineNumber'] ?>" readonly>
	</div>
	<div class="fitem">
		<label>Project Name</label>
		<input style="width:395px" name="ProjectName" value="<?php echo $data['ProjectName'] ?>" readonly>
	</div>
	<div class="fitem">
		<label>Customer</label>
		<input style="width:395px" name="Customer" value="<?php echo $data['Customer'] ?>" readonly>
	</div>
	<div class="fitem" style="float:left; width:103px; margin-top:5px">
		<label>Notes</label>
	</div>
	<div>
		<textarea style="width:395px; height:50px" name="Notes" required></textarea>
	</div>
	<input type="hidden" name="CreateId" value="<?php echo $data['CreateId'] ?>">
	<input type="hidden" name="RevisionNumber" value="<?php echo $data['RevisionNumber'] ?>">
</form>