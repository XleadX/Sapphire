<?php
date_default_timezone_set("Asia/Jakarta");
require '../setting/mail/PHPMailerAutoload.php';	// File fungsi mail
include '../setting/connection.php';
include '../setting/smtp.php';						// File smtp
include '../setting/function.php';					// File fungsi group dan email

$type	= array();
$kva	= array();
$desc	= array();
$qty	= array();

session_start();
$username		= $_SESSION['username'];
$sender			= $_SESSION['email'];
$number			= $_REQUEST['PipelineNumber'];
$revision		= $_REQUEST['RevisionNumber'];
$bugroup		= $_REQUEST['BUGroup'];
$project 		= $_REQUEST['ProjectName'];
$customer		= $_REQUEST['Customer'];
$market			= $_REQUEST['SalesMarketId'];
$estimate		= $_REQUEST['EstimateOrderIntake'];
$delivery		= $_REQUEST['DeliveryRequestTime'];
$opportunity	= $_REQUEST['OpportunityLevel'];
$notes			= $_REQUEST['PipelineNote'];
$delivery_terms	= $_REQUEST['DeliveryTerms'];
$group			= $_REQUEST['SalesGroupId'];
$destination	= isset($_POST['Destination']) ? $_POST['Destination'] : '';
$rfq_req		= $_REQUEST['RFQRequestUpdate'];
$fat			= isset($_POST['FATUpdate']) ? $_POST['FATUpdate'] : 'No';
$tescom			= isset($_POST['TescomUpdate']) ? $_POST['TescomUpdate'] : 'No';
$date			= date('Y-m-d H:i:s A');
$tahun			= date('Y');
$create_id		= $_REQUEST['CreateId'];
$attachment_name	= $_FILES['filesNew']['name'];
$attachment_type	= $_FILES['filesNew']['type'];
$attachment			= $_FILES['filesNew']['tmp_name'];
$type			= isset($_POST['type_update']) ? $_POST['type_update'] : array();
$kva			= isset($_POST['kva_update']) ? $_POST['kva_update'] : array();
$desc			= isset($_POST['desc_update']) ? $_POST['desc_update'] : array();
$qty			= isset($_POST['qty_update']) ? $_POST['qty_update'] : array();

// Menambah data PipelineDetil ke database
foreach($type as $key => $n){
	$update_detail = $conn->query("INSERT INTO PipelineDetil (PipelineNumber, ItemNumber, TrafoType, KVA, OtherRequest, Qty, RevisionNumber) VALUES ('$number', '$key'+1, '$n', '$kva[$key]', '$desc[$key]', '$qty[$key]', '$revision'+1)");
}

// Memanggil fungsi group dan email
$sales		= sales_group_level($username);
$level		= $sales['SalesLevel'];
$eng_email	= email_engineer($bugroup);

// Kondisi untuk BU ICT sales andreas dan nyoman
if(($username == 'andreas' OR $username == 'nyoman') AND $bugroup == 'ICT'){
	$sm_email = 'aksari@email.xxx';
	$group = sm_group_ict($sm_email);
} else {
	$group = sales_group($market);
	$sm_email = email_sales_manager($group);
}

// Menentukan level user
if($level == 'Manager'){
	$approval		= '[APPROVED] ';
	$status			= 'Revision Pipeline';
	$approved		= 'Yes';
	$approved_date	= '\''.$date.'\'';
	$approved_id	= $username;
	$to_manager		= '';
	$sent_manager	= '';
} else {
	$approval		= '[APPROVAL NEEDED] ';
	$status			= 'Revision Pipeline';
	$approved		= 'No';
	$approved_date	= 'NULL';
	$approved_id	= '';
	$to_manager		= $sm_email;
	$sent_manager	= 'and Manager';
}

// Kondisi untuk RFQ
if($rfq_req == 'No'){
	$rfq = 'No';
	$rfq_date = 'NULL';
	$rfq_id = '';
	$rfq_status = '';
	$pipeline_status = 'New';
	$stmt = $conn->query("INSERT INTO Pipeline (PipelineNumber,BUGroup,ProjectName,Customer,SalesGroupId,SalesMarketId,EstimateOrderIntake,DeliveryRequestTime,OpportunityLevel,EstimateAmount,CreateDate,CreateId,RFQ,RFQDate,RFQId,Pick,PickDate,PickId,Answer,AnswerDate,AnswerId,Schedule,ScheduleDate,ScheduleId,PipelineNote,DeliveryTerms,Destination,RFQStatus,PipelineStatus,FAT,FATDate,Tescom,Tahun,DrawReq,DrawAnswer,DrawApproval,TestReq,TestAnswer,TestApproval,PO,SOReq,SO,TrfCodeReq,TrfCodeAnswer,Approved,ApprovedDate,ApprovedId,LostStatus,PipelineActive,Revision,RevisionDate,RevisionId,RevisionNumber) SELECT PipelineNumber,'$bugroup','$project','$customer','$group','$market','$estimate','$delivery',OpportunityLevel,EstimateAmount,CreateDate,CreateId,'$rfq',$rfq_date,'$rfq_id',Pick,PickDate,PickId,Answer,AnswerDate,AnswerId,Schedule,ScheduleDate,ScheduleId,'$notes','$delivery_terms','$destination','$rfq_status','$pipeline_status','$fat',FATDate,'$tescom',Tahun,DrawReq,DrawAnswer,DrawApproval,TestReq,TestAnswer,TestApproval,PO,SOReq,SO,TrfCodeReq,TrfCodeAnswer,Approved,ApprovedDate,ApprovedId,LostStatus,'Yes','Yes','$date','$username',RevisionNumber+1 FROM Pipeline WHERE PipelineNumber = '$number' AND RevisionNumber = '$revision'");
} elseif($rfq_req == 'Yes'){
	$stmt = $conn->query("INSERT INTO Pipeline (PipelineNumber,BUGroup,ProjectName,Customer,SalesGroupId,SalesMarketId,EstimateOrderIntake,DeliveryRequestTime,OpportunityLevel,EstimateAmount,CreateDate,CreateId,RFQ,RFQDate,RFQId,Pick,PickDate,PickId,Answer,AnswerDate,AnswerId,Schedule,ScheduleDate,ScheduleId,PipelineNote,DeliveryTerms,Destination,RFQStatus,PipelineStatus,FAT,FATDate,Tescom,Tahun,DrawReq,DrawAnswer,DrawApproval,TestReq,TestAnswer,TestApproval,PO,SOReq,SO,TrfCodeReq,TrfCodeAnswer,Approved,ApprovedDate,ApprovedId,LostStatus,PipelineActive,Revision,RevisionDate,RevisionId,RevisionNumber) SELECT PipelineNumber,'$bugroup','$project','$customer','$group','$market','$estimate','$delivery',OpportunityLevel,EstimateAmount,CreateDate,CreateId,RFQ,RFQDate,RFQId,Pick,PickDate,PickId,Answer,AnswerDate,AnswerId,Schedule,ScheduleDate,ScheduleId,'$notes','$delivery_terms','$destination',RFQStatus,PipelineStatus,'$fat',FATDate,'$tescom',Tahun,DrawReq,DrawAnswer,DrawApproval,TestReq,TestAnswer,TestApproval,PO,SOReq,SO,TrfCodeReq,TrfCodeAnswer,Approved,ApprovedDate,ApprovedId,LostStatus,'Yes','Yes','$date','$username',RevisionNumber+1 FROM Pipeline WHERE PipelineNumber = '$number' AND RevisionNumber = '$revision'");
} elseif($rfq_req == 'New'){
	$rfq = 'Yes';
	$rfq_status = 'Request';
	$pipeline_status = 'New - RFQ Request';
	$rfq_date = '\''.$date.'\'';
	$rfq_id = $username;
	
	$stmt = $conn->query("INSERT INTO Pipeline (PipelineNumber,BUGroup,ProjectName,Customer,SalesGroupId,SalesMarketId,EstimateOrderIntake,DeliveryRequestTime,OpportunityLevel,EstimateAmount,CreateDate,CreateId,RFQ,RFQDate,RFQId,Pick,PickDate,PickId,Answer,AnswerDate,AnswerId,Schedule,ScheduleDate,ScheduleId,PipelineNote,DeliveryTerms,Destination,RFQStatus,PipelineStatus,FAT,FATDate,Tescom,Tahun,DrawReq,DrawAnswer,DrawApproval,TestReq,TestAnswer,TestApproval,PO,SOReq,SO,TrfCodeReq,TrfCodeAnswer,Approved,ApprovedDate,ApprovedId,LostStatus,PipelineActive,Revision,RevisionDate,RevisionId,RevisionNumber) SELECT PipelineNumber,'$bugroup','$project','$customer','$group','$market','$estimate','$delivery',OpportunityLevel,EstimateAmount,CreateDate,CreateId,'$rfq',$rfq_date,'$rfq_id',Pick,PickDate,PickId,Answer,AnswerDate,AnswerId,Schedule,ScheduleDate,ScheduleId,'$notes','$delivery_terms','$destination','$rfq_status','$pipeline_status','$fat',FATDate,'$tescom',Tahun,DrawReq,DrawAnswer,DrawApproval,TestReq,TestAnswer,TestApproval,PO,SOReq,SO,TrfCodeReq,TrfCodeAnswer,Approved,ApprovedDate,ApprovedId,LostStatus,'Yes','Yes','$date','$username',RevisionNumber+1 FROM Pipeline WHERE PipelineNumber = '$number' AND RevisionNumber = '$revision'");
	
	$detail = $conn->query("SELECT * FROM PipelineDetil WHERE PipelineNumber = '$number' AND RevisionNumber IN (SELECT MAX(RevisionNumber) FROM Pipeline WHERE PipelineNumber = '$number')");

$body = '<style type="text/css">
table.gridtable {
	font-family: verdana,arial,sans-serif;
	font-size:11px;
	border-width: 1px;
	border-collapse: collapse;
}
table.gridtable th {
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	background-color: #dedede;
}
table.gridtable td {
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	background-color: #ffffff;
}
</style>

<pre style="font-family: courier; font-size: 16px">
Pipeline Number		: '.$number.'
Business Unit		: '.$bugroup.'
Project Name		: '.$project.'
Customer		: '.$customer.'
Market / Sales		: '.$market.' / '.ucwords($username).'
Notes			: '.$notes.'
Delivery Terms		: '.$delivery_terms.' / '.$destination.'
FAT			: '.$fat.'
Tescom			: '.$tescom.'
</pre>
<table class="gridtable">
<tr>
	<th width="150px"><center>Trafo Type</center></th>
	<th width="50px"><center>KVA</center></th>
	<th width="350px"><center>Description</center></th>
	<th width="50px"><center>QTY</center></th>
</tr>';
	while($table = $detail->fetch(PDO::FETCH_ASSOC)){
	$revision_update = $revision + 1;
	$body .= "<tr>
				<td>".$table['TrafoType']."</td>
				<td><center>".$table['KVA']."</center></td>
				<td>".$table['OtherRequest']."</td>
				<td><center>".$table['Qty']."</center></td>
			</tr>";
}

// Fungsi kirim email
	$subject = $approval.'Sapphire - '.$status.' / '.$customer.' / '.$project.' / '.$number.'-'.$revision_update.'';
	$mail->setFrom($sender, ucwords($username).' - Sapphire');
	foreach($eng_email as $to_eng){
		$mail->AddAddress($to_eng['EngineerEmail']);
	}
	$mail->AddCC($sm_email);
	$mail->Subject = $subject;
	$mail->isHTML(true);
	$mail->Body = $body.'</table>';

	foreach($attachment_name as $key => $att){
		$nama_file = $attachment_name[$key];
		$tmp_file = $attachment[$key];

		$mail->addAttachment($tmp_file, $nama_file);
	}
}

$result = $conn->query("UPDATE Pipeline SET PipelineActive = 'No' WHERE PipelineNumber = '$number' AND RevisionNumber = '$revision'");

// Menangani hasil pengiriman email
if(!$mail->send()){
	echo '<script>alert("Pipeline has been updated !"); </script>';
	echo '<script>document.location="../view/ORDER"</script>';
} else {
    echo '<script>alert("Email was sent to ENG '.$sent_manager.' !"); </script>';
	echo '<script>document.location="../view/ORDER"</script>';
}
?>