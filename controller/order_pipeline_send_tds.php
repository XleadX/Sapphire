<?php
date_default_timezone_set("Asia/Jakarta");
require '../setting/mail/PHPMailerAutoload.php';	// File fungsi mail
include '../setting/connection.php';
include '../setting/smtp.php';						// File smtp
include '../setting/function.php';					// File fungsi email_engineer

session_start();
$username			= $_SESSION['username'];
$sender				= $_SESSION['email'];
$number				= $_POST['PipelineNumber'];
$revision			= $_POST['RevisionNumber'];
$project			= $_POST['ProjectName'];
$customer			= $_POST['Customer'];
$bugroup			= $_POST['BUGroup'];
$rfq				= $_POST['RFQ'];
$tescom				= $_POST['Tescom'];
$fat				= $_POST['FAT'];
$draw_approval		= isset($_POST['DrawingApproval']) ? $_POST['DrawingApproval'] : 'No';
$additional_test	= isset($_POST['AdditionalTest']) ? $_POST['AdditionalTest'] : 'No';
$new_fat_date		= $_POST['newFATDate'];
$fat_schedule_date	= date('Y-m-d H:i:s A', strtotime($new_fat_date));
$attachment_name	= $_FILES['filesTDS']['name'];
$attachment_type	= $_FILES['filesTDS']['type'];
$attachment			= $_FILES['filesTDS']['tmp_name'];
$date				= date('Y-m-d H:i:s A');

// Memanggil fungsi email_engineer_ppic_pc
$eng_email	= email_engineer_ppic_pc($bugroup);
$result		= sales_group_level($username);
$sales_group = $result['SalesGroupId'];

// Kondisi jika DrawingApproval dipilih
if($draw_approval == 'Yes'){
	$draw = 'Yes';
	$draw_date = '\''.$date.'\'';
	$draw_status = 'Require';
	$draw_id = $username;
	$draws = '-Draw(Req)';
} else {
	$draw = 'No';
	$draw_date = 'NULL';
	$draw_status = '';
	$draw_id = '';
	$draws = '';
}

// Kondisi jika FAT dipilih, maka mengirim email ke QA
if($additional_test == 'Yes'){
	$test = 'Yes';
	$test_date = '\''.$date.'\'';
	$test_status = 'Require';
	$test_id = $username;
	$tests = '-Test';
	
	$qa_email = email_qa($bugroup);
	foreach($qa_email as $cc_qa){
		$mail->addCC($cc_qa['EngineerEmail']);
	}
	
	$sent_qa = '/ QA';
} else {
	$test = 'No';
	$test_date = 'NULL';
	$test_id = '';
	$test_status = '';
	$tests = '';
	$sent_qa = '';
}

// Kondisi untuk FATSchedule
if(isset($_POST['FATSchedule'])){
	if($new_fat_date <> ''){
		$fat_date = '\''.$fat_schedule_date.'\'';
		$fat_schedule = date('d F Y', strtotime($fat_schedule_date));
	} else {
		$fat_date = 'NULL';
		$fat_schedule = 'Not scheduled';
	}
} else {
	$fat_date = 'NULL';
	$fat_schedule = 'Not scheduled';
}

// Kondisi jika FAT dipilih, maka mengirim email ke QA
if($fat == 'Yes'){
	$fat_info = 'FAT Date		: '.$fat_schedule.'';
	$qa_email = email_qa($bugroup);
	foreach($qa_email as $cc_qa){
		$mail->addCC($cc_qa['EngineerEmail']);
	}
	
	$sent_qa = '/ QA';
} else {
	$fat_info = '';
	$sent_qa = '';
}

// Kondisi jika ada RFQ
if($rfq == 'Yes'){
	$code = 'Yes';
	$code_date = '\''.$date.'\'';
	$code_id = $username;
	$codes = '-Code(Req)';
} else {
	$code = 'No';
	$code_date = 'NULL';
	$code_id = '';
	$codes = '';
}

// Kondisi jika Tescom dipilih, maka mengirim email ke SVC
if($tescom == 'Yes'){
	$svc_email = email_svc();
	foreach($svc_email as $cc_svc){
		$mail->addCC($cc_svc['EngineerEmail']);
	}
	
	$sent_svc = '/ SVC';
} else {
	$sent_svc = '';
}

// Memperbarui data
$stmt = $conn->query("UPDATE Pipeline SET DrawReq = '$draw', DrawReqDate = $draw_date, DrawReqId = '$draw_id', DrawStatus = '$draw_status', TestReq = '$test', TestReqDate = $test_date, TestReqId = '$test_id', TestStatus = '$test_status', FATDate = $fat_date, TrfCodeReq = '$code', TrfCodeReqDate = $code_date, TrfCodeReqId = '$code_id', PipelineStatus = 'PO$draws$tests$codes', PO = 'Yes', PODate = '$date', POId = '$username', OpportunityLevel = '100', OpportunityDate = '$date', SOReq = 'Yes', SOReqDate = '$date', SOReqId = '$username' WHERE PipelineNumber = '$number' AND RevisionNumber = '$revision'");

// Fungsi kirim email
$subject = 'Sapphire - Purchase Order / '.$customer.' / '.$project.' / '.$number.'-'.$revision.'';
$mail->setFrom($sender, ucwords($username).' - Sapphire');
foreach($eng_email as $to_eng){
	$mail->addAddress($to_eng['EngineerEmail']);
}
$mail->Subject = $subject;
$mail->msgHTML('
<pre style="font-family: courier; font-size: 16px">
Pipeline Number		: '.$number.'
Purchase Order		: Yes
Drawing Approval	: '.$draw.'
Additional Test		: '.$test.'
New Trafo Code		: '.$code.'
'.$fat_info.'
</pre>
');

// Menambahkan file attachment(s)
foreach($attachment_name as $key => $att){
	$nama_file = $attachment_name[$key];
	$tmp_file = $attachment[$key];

	$mail->addAttachment($tmp_file, $nama_file);
}

// Menangani hasil pengiriman email
if(!$mail->send()) {
	echo '<script>alert("Email was sent to SA / ENG / PPIC / PC '.$sent_qa.' '.$sent_svc.' !"); </script>';
	if($sales_group == 'SA'){
		echo '<script>document.location="../view/PURCHASE_ORDER"</script>';
	} else {
		echo '<script>document.location="../view/ORDER"</script>';
	}
} else {
	echo '<script>alert("Email was sent to SA / ENG / PPIC / PC '.$sent_qa.' '.$sent_svc.' !"); </script>';
	if($sales_group == 'SA'){
		echo '<script>document.location="../view/PURCHASE_ORDER"</script>';
	} else {
		echo '<script>document.location="../view/ORDER"</script>';
	}
}
?>