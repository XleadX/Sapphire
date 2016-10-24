<?php
include '../setting/connection.php';
$number = $_GET['PipelineNumber'];
$result = $conn->query("SELECT PipelineNumber, RevisionNumber, ProjectName, Customer, OpportunityLevel FROM Pipeline WHERE PipelineNumber = '$number' AND PipelineActive = 'Yes'");
$data	= $result->fetch(PDO::FETCH_ASSOC);
?>

<form id="change_opportunity" method="post" action="../controller/order_pipeline_opportunity.php" novalidate>
	<div class="fitem">
		<label>Pipeline Number</label>
		<input style="width:100px" name="PipelineNumber" readonly="true" value="<?php echo $number; ?>">
		<input type="hidden" name="RevisionNumber" value="<?php echo $data['RevisionNumber'] ?>">
	</div>
	<div class="fitem">
		<label>Project Name</label>
		<input style="width:350px" name="ProjectName" readonly="true" value="<?php echo $data['ProjectName'] ?>">
	</div>
	<div class="fitem">
		<label>Customer</label>
		<input style="width:350px" name="Customer" readonly="true" value="<?php echo $data['Customer'] ?>">
	</div>
	<div class="fitem">
		<label>Current Opportunity</label>
		<input id="opportunityLevel" name="OpportunityLevel" style="width:40px" readonly="true" value="<?php echo $data['OpportunityLevel'] ?>">
		<input id="descriptionOpportunity" name="DescriptionOpportunity" class="easyui-textbox" style="width:406px" readonly="true">
	</div>
	<div class="fitem">
		<label>New Opportunity (%)</label>
		<select id="newOpportunityLevel" name="NewOpportunityLevel" style="width:450px" required="true">
			<option>&nbsp;</option>
			<?php
				$stmt = $conn->query("SELECT * FROM probability");
				while($data = $stmt->fetch(PDO::FETCH_ASSOC)){
					echo '<option value="' . $data['ProbabilityId'] . '">' . $data['ProbabilityId'] . ' - ' . $data['ProbabilityDesc'] .'</option>';
				}
			?>
		</select>
	</div>
</form>

<script>
var text = $('#opportunityLevel').val();
if(text == 10){
	$('#descriptionOpportunity').val('Project Detected');
} else if(text == 20){
	$('#descriptionOpportunity').val('Understand Customer Bussiness & Good Relation With DMU');
} else if(text == 30){
	$('#descriptionOpportunity').val('Uncover Opportunity');
} else if(text == 40){
	$('#descriptionOpportunity').val('Able To Demonstrate Bussiness Value');
} else if(text == 50){
	$('#descriptionOpportunity').val('Influence Specification');
} else if(text == 60){
	$('#descriptionOpportunity').val('Prequalification');
} else if(text == 70){
	$('#descriptionOpportunity').val('Bidding');
} else if(text == 80){
	$('#descriptionOpportunity').val('Bid Evaluation');
} else if(text == 90){
	$('#descriptionOpportunity').val('Negotiation');
}
</script>