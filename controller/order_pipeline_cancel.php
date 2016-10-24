<?php
date_default_timezone_set("Asia/Jakarta");
require '../setting/mail/PHPMailerAutoload.php';	// File fungsi mail
include '../setting/connection.php';
include '../setting/smtp.php';						// File smtp
include '../setting/function.php';					// File fungsi email

session_start();
$username	= $_SESSION['username'];
$sender		= $_SESSION['email'];
$number		= $_POST['PipelineNumber'];
$revision	= $_POST['RevisionNumber'];
$project	= $_POST['ProjectName'];
$customer	= $_POST['Customer'];
$group		= $_POST['SalesGroupId'];
$bugroup	= $_POST['BUGroup'];
$fat		= $_POST['FAT'];
$tescom		= $_POST['Tescom'];
$test		= $_POST['TestReq'];
$reason		= $_POST['ReasonCancelled'];
$date		= date('Y-m-d H:i:s A');

// Memanggil fungsi
$sm_email	= email_sales_manager($group);
$sa_email	= email_sales_admin();
$eng_email	= email_engineer($bugroup);

// Kondisi jika ada FAT atau TestReq, maka mengirim email ke QA
if($fat == 'Yes' OR $test = 'Yes'){
	$qa_email = email_qa($bugroup);
	foreach($qa_email as $cc_qa){
		$mail->addCC($cc_qa['EngineerEmail']);
	}

	$sent_qa = '/ QA';
} else {
	$sent_qa = '';
}

// Kondisi jika ada Tescom, maka mengirim email ke SVC
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
$stmt = $conn->prepare("UPDATE Pipeline SET PipelineStatus = 'Project Loss', LostStatus = 'Yes', LostDate = :date, LostReason = :reason, PipelineActive = 'No', OpportunityLevel = '0' WHERE PipelineNumber = :number");
$stmt->bindParam(':date', $date);
$stmt->bindParam(':reason', $reason);
$stmt->bindParam(':number', $number);
$stmt->execute();

// Fungsi kirim email
$subject = 'Sapphire - Cancel Pipeline / '.$customer.' / '.$project.' / '.$number.'-'.$revision.'';
$mail->setFrom($sender, 'Sapphire - '.ucwords($username).'');
$mail->AddAddress($sm_email);
foreach($sa_email as $cc_sa){
	$mail->AddCC($cc_sa['SalesEmail']);
}
foreach($eng_email as $cc_eng){
	$mail->AddCC($cc_eng['EngineerEmail']);
}
$mail->Subject = $subject;
$mail->msgHTML('
<pre style="font-family: courier; font-size: 16px">
Pipeline Number		: '.$number.'
Project Name		: '.$project.'
Customer		: '.$customer.'
Reason Cancelled	: '.$reason.'
</pre>
');

// Menangani hasil pengiriman email
if(!$mail->send()) {
	echo '<script>alert("Email was sent to SA / ENG / PPIC / PC '.$sent_qa.' '.$sent_svc.' !"); </script>';
	echo '<script>document.location="../view/ORDER"</script>';
} else {
    echo '<script>alert("Email was sent to SA / ENG / PPIC / PC '.$sent_qa.' '.$sent_svc.' !"); </script>';
	echo '<script>document.location="../view/ORDER"</script>';
}
?>