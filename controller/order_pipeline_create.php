<?php
date_default_timezone_set("Asia/Jakarta");
require '../setting/mail/PHPMailerAutoload.php';	// File fungsi mail
include '../setting/connection.php';
include '../setting/smtp.php';						// File smtp
include '../setting/function.php';					// File fungsi group dan email

session_start();
$username		= $_SESSION['username'];
$sender			= $_SESSION['email'];
$bugroup 		= $_REQUEST['BUGroup'];
$project 		= $_REQUEST['ProjectName'];
$customer		= $_REQUEST['Customer'];
$market			= $_REQUEST['SalesMarketId'];
$estimate		= htmlspecialchars($_REQUEST['EstimateOrderIntake']);
$delivery		= htmlspecialchars($_REQUEST['DeliveryRequestTime']);
$opportunity	= htmlspecialchars($_REQUEST['OpportunityLevel']);
$notes			= $_REQUEST['PipelineNote'];
$delivery_terms	= $_REQUEST['DeliveryTerms'];
$destination	= isset($_POST['Destination']) ? $_POST['Destination'] : '';
$rfq_req		= htmlspecialchars($_REQUEST['RFQRequest']);
$fat			= isset($_POST['FAT']) ? $_POST['FAT'] : 'No';
$tescom			= isset($_POST['Tescom']) ? $_POST['Tescom'] : 'No';
$create_date	= date('Y-m-d H:i:s A');
$tahun			= date('Y');
$attachment_name	= $_FILES['files']['name'];
$attachment_type	= $_FILES['files']['type'];
$attachment			= $_FILES['files']['tmp_name'];

// Menangkap input untuk PipelineDetil
$type	= isset($_POST['type']) ? $_POST['type'] : array();
$kva	= isset($_POST['kva']) ? $_POST['kva'] : array();
$desc	= isset($_POST['desc']) ? $_POST['desc'] : array();
$qty	= isset($_POST['qty']) ? $_POST['qty'] : array();

// Memanggil fungsi group dan email
$result	= sales_group_level($username);
$level	= $result['SalesLevel'];
$eng_email = email_engineer($bugroup);

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
	$approval		= '';
	$status			= 'New Pipeline';
	$approved		= 'Yes';
	$approved_date	= '\''.$create_date.'\'';
	$approved_id	= $username;
	$to_manager		= '';
	$sent_manager	= '';
} else {
	$approval		= '[APPROVAL NEEDED] ';
	$status			= 'New Pipeline';
	$approved		= 'No';
	$approved_date	= 'NULL';
	$approved_id	= '';
	$to_manager		= $sm_email;
	$sent_manager	= 'and Manager';
}

// Mengambil PipelineNumber paling akhir
$auto	= $conn->query("SELECT MAX(PipelineNumber) AS PipelineNumber FROM Pipeline");
$data	= $auto->fetch();
$number = $data['PipelineNumber'];
$number = sprintf('%07d', $number + 1);

// Kondisi untuk RFQ
if($rfq_req == 'No'){
	$rfq = 'No';
	$rfq_status = '';
	$pipeline_status = 'New';
	$rfq_date = 'NULL';
	$rfq_id = '';
	
// Menambah data PipelineDetil ke database
	foreach($type as $key => $n){
		$insert_detail = $conn->query("INSERT INTO PipelineDetil (PipelineNumber, ItemNumber, TrafoType, KVA, OtherRequest, Qty, RevisionNumber) VALUES ('$number', '$key', '$n', '$kva[$key]', '$desc[$key]', '$qty[$key]', 0)");
	}
} elseif($rfq_req == 'Yes'){
	$rfq = 'Yes';
	$rfq_status = 'Request';
	$pipeline_status = 'New - RFQ Request';
	$rfq_date = '\''.$create_date.'\'';
	$rfq_id = $username;
	
// Menambah data PipelineDetil ke database
	foreach($type as $key => $n){
		$insert_detail = $conn->query("INSERT INTO PipelineDetil (PipelineNumber, ItemNumber, TrafoType, KVA, OtherRequest, Qty, RevisionNumber) VALUES ('$number', '$key', '$n', '$kva[$key]', '$desc[$key]', '$qty[$key]', 0)");
	}

// Menampilkan tabel pada body email
	$detail = $conn->query("SELECT TrafoType, KVA, OtherRequest, Qty FROM PipelineDetil WHERE PipelineNumber = '$number'");

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
	$body .= "<tr>
		<td>".$table['TrafoType']."</td>
		<td><center>".$table['KVA']."</center></td>
		<td>".$table['OtherRequest']."</td>
		<td><center>".$table['Qty']."</center></td>
	</tr>";
}

// Fungsi kirim email jika RFQ = Yes
	$subject = $approval.'Sapphire - '.$status.' / '.$customer.' / '.$project.' / '.$number.'-0';
	$mail->setFrom($sender, ucwords($username).' - Sapphire');
	$mail->addAddress($sm_email);
	foreach($eng_email as $cc_eng){
		$mail->addCC($cc_eng['EngineerEmail']);
	}
	$mail->Subject = $subject;
	$mail->isHTML(true);
	$mail->Body = $body.'</table>';

	foreach($attachment_name as $key => $att){
		$nama_file = $attachment_name[$key];
		$tmp_file = $attachment[$key];

		$mail->addAttachment($tmp_file, $nama_file);
	}
}

// Menambah data ke database
$stmt = $conn->query("INSERT INTO Pipeline (PipelineNumber,BUGroup,ProjectName,Customer,SalesGroupId,SalesMarketId,EstimateOrderIntake,DeliveryRequestTime,OpportunityLevel,EstimateAmount,CreateDate,CreateId,RFQ,RFQDate,RFQId,PipelineNote,DeliveryTerms,Destination,RevisionNumber,PipelineActive,RFQStatus,PipelineStatus,FAT,Tescom,Tahun,Pick,Answer,DrawReq,DrawAnswer,DrawApproval,TestReq,TestAnswer,TestApproval,PO,SOReq,SO,Revision,TrfCodeReq,TrfCodeAnswer,LostStatus,Schedule,Approved,ApprovedDate,ApprovedId) VALUES ('$number','$bugroup','$project','$customer','$group','$market','$estimate','$delivery','$opportunity','0','$create_date','$username','$rfq',$rfq_date,'$rfq_id','$notes','$delivery_terms','$destination','0','Yes','$rfq_status','$pipeline_status','$fat','$tescom','$tahun','No','No','No','No','No','No','No','No','No','No','No','No','No','No','No','No','$approved',$approved_date,'$approved_id')");

// Menangani hasil pengiriman email
if(!$mail->send()) {
	echo '<script>alert("Email was sent to ENG '.$sent_manager.' !"); </script>';
	echo '<script>document.location="../view/ORDER"</script>';
} else {
    echo '<script>alert("Email was sent to ENG '.$sent_manager.' !"); </script>';
	echo '<script>document.location="../view/ORDER"</script>';
}