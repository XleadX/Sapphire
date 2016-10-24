<?php
include '../setting/connection.php';

$number = $_GET['PipelineNumber'];
$result = $conn->query("SELECT PipelineNumber, ProjectName, Customer, PipelineNote, RevisionNumber, BUGroup, SO FROM Pipeline WHERE PipelineNumber = '$number' AND PipelineActive = 'Yes'");
$data	= $result->fetch(PDO::FETCH_ASSOC);
?>

<form id="draw_approve" action="../controller/order_pipeline_draw.php" method="post" enctype="multipart/form-data">
	<div class="fitem">
		<label>Pipeline Number</label>
		<input style="width:100px" name="PipelineNumber" value="<?php echo $data['PipelineNumber'] ?>" readonly="true">
	</div>
	<div class="fitem">
		<label>Project Name</label>
		<input style="width:325px" name="ProjectName" value="<?php echo $data['ProjectName'] ?>" readonly="true">
	</div>
	<div class="fitem">
		<label>Customer</label>
		<input style="width:325px" name="Customer" value="<?php echo $data['Customer'] ?>" readonly="true">
	</div>
	<div class="fitem" style="float:left; width:138px; margin-top:5px">
		<label>Notes</label>
	</div>
	<div>
		<textarea style="width:325px; height:50px" name="Notes"></textarea>
	</div>
	<div style="margin-top:15px">
		<div class="fitem" style="float:left">
			<label>Draw Approval File(s)</label>
		</div>
	    <div class="uploadFile" style="width:425px; float:left; height:60px; overflow:auto; border:1px solid; margin-bottom:10px; background-color:white">
			<div style="padding:2px">
				<center><p id="placeholderDA" style="color:grey; margin-top:18px"><i>Click + button to add file...</i></p></center>
				<div id="input_field_da"><input style="display: none" type="file" name="filesDA[]"></div>
			</div>
		</div>
		<div id="attachmentDA" class="uploadFile" style="float:left; border:1px solid; width:50px; height:60px; background-color:#EEEEEE">
			<span><img src="../assets/themes/icons/edit_add.png" style="margin: 22px 0px 0px 17px"></span>
		</div>
	</div>
	<input type="hidden" name="RevisionNumber" value="<?php echo $data['RevisionNumber'] ?>">
	<input type="hidden" name="BUGroup" value="<?php echo $data['BUGroup'] ?>">
	<input type="hidden" name="SO" value="<?php echo $data['SO'] ?>">
</form>

<script>
var attachmentsDA = $("#input_field_da");

$('#attachmentDA').click(function(e){
	$('#button_da').removeAttr('id');
	$(attachmentsDA).prepend('<div class="dialog"  style="width:395px"><input id="button_da" type="file" name="filesDA[]"/><a href="javascript:void(0)" id="remove_field_da" style="margin-top: 4px; float: right; color: red">Remove</a></div>');
	$('#button_da').click();
	$('#placeholderDA').hide();
});

$(attachmentsDA).on("click","#remove_field_da", function(e){
	$(this).parent('div').remove();
});
</script>