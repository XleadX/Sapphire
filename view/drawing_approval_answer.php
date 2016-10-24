<?php
include '../setting/connection.php';
include '../setting/function.php';
$number = $_GET['PipelineNumber'];

$data = pipeline($number);
?>

<form id="draw_answer" action="../controller/drawing_approval_answer.php" method="post" enctype="multipart/form-data">
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
		<textarea style="width:395px; height:50px" name="Notes"></textarea>
	</div>
	<div style="margin-top:15px">
		<div class="fitem" style="float:left">
			<label>Draw Answer File</label>
		</div>
	    <div class="uploadFile" style="width:445px; float:left; height:60px; overflow:auto; border:1px solid; margin-bottom:10px; background-color:white">
			<div style="padding:2px">
				<center><p id="placeholderDraw" style="color:grey; margin-top:18px"><i>Click + button to add file...</i></p></center>
				<div id="input_field_draw"><input style="display:none" type="file" name="filesDraw[]"></div>
			</div>
		</div>
		<div id="attachmentDraw" class="uploadFile" style="float:left; border:1px solid; width:50px; height:60px; background-color:#EEEEEE">
			<span><img src="../assets/themes/icons/edit_add.png" style="margin: 22px 0px 0px 17px"></span>
		</div>
	</div>
	<input type="hidden" name="CreateId" value="<?php echo $data['CreateId'] ?>">
	<input type="hidden" name="RevisionNumber" value="<?php echo $data['RevisionNumber'] ?>">
	<input type="hidden" name="SalesGroupId" value="<?php echo $data['SalesGroupId'] ?>">
</form>

<script>
var attachmentsDraw	= $("#input_field_draw");

$('#attachmentDraw').click(function(e){
	$('#button_draw').removeAttr('id');
	$(attachmentsDraw).prepend('<div class="dialog"><input id="button_draw" type="file" name="filesDraw[]"/><a href="javascript:void(0)" id="remove_field_draw" style="margin-top:4px; float:right; color:red">Remove</a></div>');
	$('#button_draw').click();
	$('#placeholderDraw').hide();
});

$(attachmentsDraw).on("click","#remove_field_draw", function(e){
	$(this).parent('div').remove();
});
</script>