<?php
include '../setting/connection.php';
include '../setting/function.php';
$number = $_GET['PipelineNumber'];

$data = pipeline($number);
?>

<form id="rfq_answer" action="../controller/request_for_quotation_answer.php" method="post" enctype="multipart/form-data">
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
			<label>RFQ Answer Files</label>
		</div>
	    <div class="uploadFile" style="width:445px; float:left; height:60px; overflow:auto; border:1px solid; margin-bottom:10px; background-color:white">
			<div style="padding:2px">
				<center><p id="placeholderRFQ" style="color:grey; margin-top:18px"><i>Click + button to add file...</i></p></center>
				<div id="input_field_rfq"><input style="display:none" type="file" name="filesRFQ[]"></div>
			</div>
		</div>
		<div id="attachmentRFQ" class="uploadFile" style="float:left; border:1px solid; width:50px; height:60px; background-color:#EEEEEE">
			<span><img src="../assets/themes/icons/edit_add.png" style="margin: 22px 0px 0px 17px"></span>
		</div>
	</div>
	<input type="hidden" name="CreateId" value="<?php echo $data['CreateId'] ?>">
	<input type="hidden" name="RevisionNumber" value="<?php echo $data['RevisionNumber'] ?>">
	<input type="hidden" name="SalesGroupId" value="<?php echo $data['SalesGroupId'] ?>">
	<input type="submit" id="submitRFQ" name="submitRFQ" style="display:none">
</form>
<form id="rfq_cost" target="_blank" action="../controller/request_for_quotation_cost.php" method="post" enctype="multipart/form-data">
	<div style="margin-top:15px">
		<div class="fitem" style="float:left">
			<label>RFQ Cost Files</label>
		</div>
	    <div class="uploadFile" style="width:445px; float:left; height:60px; overflow:auto; border:1px solid; margin-bottom:10px; background-color:white">
			<div style="padding:2px">
				<center><p id="placeholderRFQCost" style="color:grey; margin-top:18px"><i>Click + button to add file...</i></p></center>
				<div id="input_field_rfq_cost"><input style="display:none" type="file" name="filesRFQCost[]"></div>
			</div>
		</div>
		<div id="attachmentRFQCost" class="uploadFile" style="float:left; border:1px solid; width:50px; height:60px; background-color:#EEEEEE">
			<span><img src="../assets/themes/icons/edit_add.png" style="margin: 22px 0px 0px 17px"></span>
		</div>
	</div>
	<input type="hidden" name="PipelineNumber" value="<?php echo $data['PipelineNumber'] ?>">
	<input type="hidden" name="RevisionNumber" value="<?php echo $data['RevisionNumber'] ?>">
	<input type="hidden" name="ProjectName" value="<?php echo $data['ProjectName'] ?>">
	<input type="hidden" name="Customer" value="<?php echo $data['Customer'] ?>">
	<input type="hidden" name="CreateId" value="<?php echo $data['CreateId'] ?>">
	<input type="hidden" name="SalesGroupId" value="<?php echo $data['SalesGroupId'] ?>">
	<input type="submit" id="submitCost" name="submitCost" style="display:none">
</form>

<script>
var attachmentsRFQ		= $("#input_field_rfq");
var attachmentsRFQCost	= $("#input_field_rfq_cost");
	
$('#attachmentRFQ').click(function(e){
	$('#button_rfq').removeAttr('id');
	$(attachmentsRFQ).prepend('<div class="dialog"><input id="button_rfq" type="file" name="filesRFQ[]"/><a href="javascript:void(0)" id="remove_field_rfq" style="margin-top:4px; float:right; color:red">Remove</a></div>');
	$('#button_rfq').click();
	$('#placeholderRFQ').hide();
});

$('#attachmentRFQCost').click(function(e){
	$('#button_cost').removeAttr('id');
	$(attachmentsRFQCost).prepend('<div class="dialog"><input id="button_cost" type="file" name="filesRFQCost[]"/><a href="javascript:void(0)" id="remove_field_rfq_cost" style="margin-top:4px; float:right; color:red">Remove</a></div>');
	$('#button_cost').click();
	$('#placeholderRFQCost').hide();
});

$(attachmentsRFQ).on("click","#remove_field_rfq", function(e){
	$(this).parent('div').remove();
});

$(attachmentsRFQCost).on("click","#remove_field_rfq_cost", function(e){
	$(this).parent('div').remove();
});
</script>