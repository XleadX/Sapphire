<?php
include '../setting/connection.php';

$id = $_REQUEST['PipelineNumber'];

$stmt = $conn->prepare("SELECT * FROM Pipeline WHERE PipelineNumber = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();

$pipeline = $stmt->fetch();
?>
<style type="text/css">
	.dv-table td{
		width: 65px;
		font-size: 12px;
		border: solid 0px;
	}
	.dv-label{
		font-weight: bold;
		color: #15428B;
		width: 65px;
		font-size: 12px;
	}
</style>

<table class="dv-table" border="0" style="width:100%; background-color:#E0ECFF">
	<tr>
		<td class="dv-label">Sales Market</td>
		<td><?php echo $pipeline['SalesMarketId'];?></td>
		<td class="dv-label">Estimate Order Intake</td>
		<td><?php echo $pipeline['EstimateOrderIntake'];?></td>
		<td class="dv-label">Revision date</td>
		<td><?php if($pipeline['RevisionDate'] != null) { echo date('d F Y', strtotime($pipeline['RevisionDate']));} else { echo '-';} ?></td>
		<td class="dv-label">Lost Project Status</td>
		<td><?php echo $pipeline['LostStatus'];?></td>
	</tr>
	<tr>
		<td class="dv-label">Approved by</td>
		<td><?php echo $pipeline['ApprovedId'];?></td>
		<td class="dv-label">Delivery Request Time</td>
		<td><?php echo $pipeline['DeliveryRequestTime'];?></td>
		<td class="dv-label">PO date</td>
		<td><?php if($pipeline['PODate'] != null) { echo date('d F Y', strtotime($pipeline['PODate']));} else { echo '-';} ?></td>
		<td class="dv-label">Lost Project Date</td>
		<td><?php if($pipeline['LostDate'] != null) { echo date('d F Y', strtotime($pipeline['LostDate']));} else { echo '-';} ?></td>
	</tr>
	<tr>
		<td class="dv-label">Approved date</td>
		<td><?php if($pipeline['ApprovedDate'] != null) { echo date('d F Y', strtotime($pipeline['ApprovedDate']));} else { echo '-';} ?></td>
		<td class="dv-label">Opportunity Level</td>
		<td><?php echo $pipeline['OpportunityLevel'];?></td>
		<td class="dv-label">PC Involved</td>
		<td><?php echo $pipeline['PCInvolved'];?></td>
		<td class="dv-label">Lost Project Reason</td>
		<td><?php echo $pipeline['LostReason'];?></td>
	</tr>
	<tr><td colspan="7">&nbsp;<td></tr>
	<tr>
		<td colspan="4" class="dv-label" style="color: green">Request For Quotation (RFQ) :</td>
		<td class="dv-label" style="color: green">Drawing Approval :</td>
		<td colspan="3"><?php echo $pipeline['DrawStatus'];?></td>
	</tr>
	<tr>
		<td class="dv-label">Status</td>
		<td><?php echo $pipeline['RFQ'];?></td>
		<td class="dv-label">Request Date</td>
		<td><?php if($pipeline['RFQDate'] != null) { echo date('d F Y', strtotime($pipeline['RFQDate']));} else { echo '-';} ?></td>
		<td class="dv-label">Request by</td>
		<td><?php echo $pipeline['DrawReqId'];?></td>
		<td class="dv-label">Request Date</td>
		<td><?php if($pipeline['DrawReqDate'] != null) { echo date('d F Y', strtotime($pipeline['DrawReqDate']));} else { echo '-';} ?></td>
	</tr>
	<tr>
		<td class="dv-label">Pick by</td>
		<td><?php echo $pipeline['PickId'];?></td>
		<td class="dv-label">Pick Date</td>
		<td><?php if($pipeline['PickDate'] != null) { echo date('d F Y', strtotime($pipeline['PickDate']));} else { echo '-';} ?></td>
		<td class="dv-label">Answer by</td>
		<td><?php echo $pipeline['DrawAnswerId'];?></td>
		<td class="dv-label">Answer Date</td>
		<td><?php if($pipeline['DrawAnswerDate'] != null) { echo date('d F Y', strtotime($pipeline['DrawAnswerDate']));} else { echo '-';} ?></td>
	</tr>
	<tr>
		<td class="dv-label">Schedule by</td>
		<td><?php echo $pipeline['ScheduleId'];?></td>
		<td class="dv-label">Schedule Date</td>
		<td><?php if($pipeline['ScheduleDate'] != null) { echo date('d F Y', strtotime($pipeline['ScheduleDate']));} else { echo '-';} ?></td>
		<td class="dv-label">Approved by</td>
		<td><?php echo $pipeline['DrawApprovalId'];?></td>
		<td class="dv-label">Approved Date</td>
		<td><?php if($pipeline['DrawApprovalDate'] != null) { echo date('d F Y', strtotime($pipeline['DrawApprovalDate']));} else { echo '-';} ?></td>
	</tr>
	<tr>
		<td class="dv-label">Answer by</td>
		<td><?php echo $pipeline['AnswerId'];?></td>
		<td class="dv-label">Answer Date</td>
		<td><?php if($pipeline['AnswerDate'] != null) { echo date('d F Y', strtotime($pipeline['AnswerDate']));} else { echo '-';} ?></td>
	</tr>
	<tr><td colspan="7">&nbsp;<td></tr>
	<tr>
		<td colspan="4" class="dv-label" style="color: green">New Trafo Code :</td>
		<td colspan="4" class="dv-label" style="color: green">Sales Order (SO) :</td>
	</tr>
	<tr>
		<td class="dv-label">Request by</td>
		<td><?php echo $pipeline['TrfCodeReqId'];?></td>
		<td class="dv-label">Request Date</td>
		<td><?php if($pipeline['TrfCodeReqDate'] != null) { echo date('d F Y', strtotime($pipeline['TrfCodeReqDate']));} else { echo '-';} ?></td>
		<td class="dv-label">Request Date</td>
		<td><?php if($pipeline['SOReqDate'] != null) { echo date('d F Y', strtotime($pipeline['SOReqDate']));} else { echo '-';} ?></td>
		<td class="dv-label">SO Create by</td>
		<td><?php echo $pipeline['SOId'];?></td>
	</tr>
	<tr>
		<td class="dv-label">Answer by</td>
		<td><?php echo $pipeline['TrfCodeAnswerId'];?></td>
		<td class="dv-label">Answer Date</td>
		<td><?php if($pipeline['TrfCodeAnswerDate'] != null) { echo date('d F Y', strtotime($pipeline['TrfCodeAnswerDate']));} else { echo '-';} ?></td>
		<td class="dv-label">SO Reference</td>
		<td><?php echo $pipeline['SORef'];?></td>
		<td class="dv-label">SO Date</td>
		<td><?php if($pipeline['SODate'] != null) { echo date('d F Y', strtotime($pipeline['SODate']));} else { echo '-';} ?></td>
	</tr>
</table>