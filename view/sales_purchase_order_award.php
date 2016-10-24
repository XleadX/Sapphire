<?php
include '../setting/connection.php';

session_start();
$email	= $_SESSION['email'];
$number = $_GET['PipelineNumber'];
$result = $conn->query("SELECT * FROM Pipeline WHERE PipelineNumber = '$number' AND PipelineActive = 'Yes'");
$data	= $result->fetch(PDO::FETCH_ASSOC);
$sales	= $data['CreateId'];

$sales_result	= $conn->query("SELECT SalesEmail FROM Sales WHERE SalesId = '$sales'");
$sales_data		= $sales_result->fetch(PDO::FETCH_ASSOC);
$sales_email	= $sales_data['SalesEmail'];
?>

<form id="po_award_rso" target="_blank" action="../controller/order_pipeline_send_rso.php" method="post" enctype="multipart/form-data">
	<div class="fitem">
		<label style="width:425px; color:red"><b>PO will process all pipeline, if partially please do revision first</b></label>
	</div>
	<input type="hidden" name="Email" value="<?php echo $email ?>">
	<input type="hidden" name="CreatedEmail" value="<?php echo $sales_email ?>">
	<input type="hidden" name="PipelineNumber" value="<?php echo $data['PipelineNumber'] ?>">
	<input type="hidden" name="RevisionNumber" value="<?php echo $data['RevisionNumber'] ?>">
	<input type="hidden" name="ProjectName" value="<?php echo $data['ProjectName'] ?>">
	<input type="hidden" name="Customer" value="<?php echo $data['Customer'] ?>">
	<input type="hidden" name="SalesGroupId" value="<?php echo $data['SalesGroupId'] ?>">

	<input id="drawForRSO" type="hidden" name="DrawingApproval">
	<input id="testForRSO" type="hidden" name="AdditionalTest">
	<input type="hidden" name="RFQ" value="<?php echo $data['RFQ'] ?>">

	<div style="margin-top:15px">
		<div class="fitem" style="float:left">
			<label style="width:150px">RSO For Sales Admin</label>
		</div>
	    <div class="uploadFile" style="width:445px; float:left; height:60px; overflow:auto; border:1px solid; margin-bottom:10px; background-color:white">
			<div style="padding:2px">
				<center><p id="placeholderRSO" style="color:grey; margin-top:18px"><i>Click + button to add file...</i></p></center>
				<div id="input_field_rso"><input style="display:none" type="file" name="filesRSO[]"></div>
			</div>
		</div>
		<div id="attachmentRSO" class="uploadFile" style="float:left; border:1px solid; width:50px; height:60px; background-color:#EEEEEE">
			<span><img src="../assets/themes/icons/edit_add.png" style="margin: 22px 0px 0px 17px"></span>
		</div>
	</div>
	<input type="submit" id="submitRSO" style="display:none">
</form>
<br>
<form id="po_award_tds" action="../controller/order_pipeline_send_tds.php" method="post" enctype="multipart/form-data">
	<input type="hidden" name="Email" value="<?php echo $email ?>">
	<input type="hidden" name="PipelineNumber" value="<?php echo $data['PipelineNumber'] ?>">
	<input type="hidden" name="RevisionNumber" value="<?php echo $data['RevisionNumber'] ?>">
	<input type="hidden" name="ProjectName" value="<?php echo $data['ProjectName'] ?>">
	<input type="hidden" name="Customer" value="<?php echo $data['Customer'] ?>">
	<input type="hidden" name="SalesGroupId" value="<?php echo $data['SalesGroupId'] ?>">
	
	<input type="hidden" name="RFQ" value="<?php echo $data['RFQ'] ?>">
	<input type="hidden" name="Tescom" value="<?php echo $data['Tescom'] ?>">
	<input type="hidden" name="BUGroup" value="<?php echo $data['BUGroup'] ?>">
	<input id="scheduleFAT" type="hidden" name="FAT" value="<?php echo $data['FAT'] ?>">
	
	<div style="margin-top:15px">
		<div class="fitem" style="float:left">
			<label style="width:150px">TDS For Prodev</label>
		</div>
	    <div class="uploadFile" style="width:445px; float:left; height:60px; overflow:auto; border:1px solid; margin-bottom:10px; background-color:white">
			<div style="padding:2px">
				<center><p id="placeholderTDS" style="color:grey; margin-top:18px"><i>Click + button to add file...</i></p></center>
				<div id="input_field_tds"><input style="display:none" type="file" name="filesTDS[]"></div>
			</div>
		</div>
		<div id="attachmentTDS" class="uploadFile" style="float:left; border:1px solid; width:50px; height:60px; background-color:#EEEEEE">
			<span><img src="../assets/themes/icons/edit_add.png" style="margin: 22px 0px 0px 17px"></span>
		</div>
	</div>
	<div class="fitem">
		<br><br><br><br><br>
		<input id="currentFAT" type="hidden" value="<?php echo $data['FAT'] ?>">
		<div style="margin-bottom:80px"></div>
		<div>
			<input id="DrawingApproval" type="checkbox" name="DrawingApproval" class="input-inline" style="width:10px" value="Yes">Need Drawing Approval
		</div><br>
		<div>
			<input id="AdditionalTest" type="checkbox" name="AdditionalTest" class="input-inline" style="width:10px" value="Yes">Need Additional Test
		</div><br>
		<div style="float:left">
			<input id="FATSchedule" type="checkbox" name="FATSchedule" class="input-inline" style="width:10px" value="Yes">FAT Date Schedule
		</div>
		<div style="float:left; height:25px; margin-left:15px">
			<input id="newFATDate" class="input-inline" style="width:135px; text-align:center; margin-top:0px; padding:2px" name="newFATDate" hidden>
			<script>
				$('#newFATDate').datetimepicker({
					timepicker: true,
					format: 'd-m-Y H:i:s'
				});
			</script>
		</div>
	</div>
	<input type="submit" id="submitTDS" name="submitTDS" style="display:none">
</form>

<script>
var attachmentsRSO	= $("#input_field_rso");
var attachmentsTDS	= $("#input_field_tds");

$('#attachmentRSO').click(function(e){
	$('#button_rso').removeAttr('id');
	$(attachmentsRSO).prepend('<div class="dialog"><input id="button_rso" type="file" name="filesRSO[]"/><a href="javascript:void(0)" id="remove_field_rso" style="margin-top: 4px; float: right; color: red">Remove</a></div>');
	$('#button_rso').click();
	$('#placeholderRSO').hide();
});

$('#attachmentTDS').click(function(e){
	$('#button_tds').removeAttr('id');
	$(attachmentsTDS).prepend('<div class="dialog"><input id="button_tds" type="file" name="filesTDS[]"/><a href="javascript:void(0)" id="remove_field_tds" style="margin-top: 4px; float: right; color: red">Remove</a></div>');
	$('#button_tds').click();
	$('#placeholderTDS').hide();
});

$(attachmentsRSO).on("click","#remove_field_rso", function(e){
	$(this).parent('div').remove();
});

$(attachmentsTDS).on("click","#remove_field_tds", function(e){
	$(this).parent('div').remove();
});

$('#DrawingApproval').change(function(){
	if(this.checked){
		document.getElementById("drawForRSO").value = "Yes";
	} else {
		document.getElementById("drawForRSO").value = "No";
	}
});

$('#AdditionalTest').change(function(){
	if(this.checked){
		document.getElementById("testForRSO").value = "Yes";
	} else {
		document.getElementById("testForRSO").value = "No";
	}
});

$('#FATSchedule').click(function(){
	if(this.checked){
		$('#newFATDate').show();
		$('#newFATDate').prop('disabled', false);
	} else {
		$('#newFATDate').hide();
		$('#newFATDate').prop('disabled', true);
	}
});

var fat = $('#currentFAT').val();
if(fat == 'Yes'){
	$('#FATSchedule').prop('disabled', false);
} else {
	$('#FATSchedule').prop('disabled', true);
}
</script>