<?php
date_default_timezone_set("Asia/Jakarta");
require '../setting/mail/PHPMailerAutoload.php';	// File fungsi mail
include '../setting/connection.php';
include '../setting/smtp.php';						// File smtp
include '../setting/function.php';					// File fungsi email_sales dan email_engineer

session_start();
$username	= $_SESSION['username'];
$sender		= $_SESSION['email'];
$number		= $_REQUEST['PipelineNumber'];
$project	= $_REQUEST['ProjectName'];
$customer	= $_REQUEST['Customer'];
$create_id	= $_REQUEST['CreateId'];
$bugroup	= $_REQUEST['BUGroup'];
$fat		= $_REQUEST['FAT'];
$tescom		= $_REQUEST['Tescom'];
$revision	= $_REQUEST['RevisionNumber'];
$date		= date('m/d/Y H:i:s a');

// Memanggil fungsi email_sales dan email_engineer
$sales_email	= email_sales($create_id);
$eng_email		= email_engineer($bugroup);

// Fungsi kirim email
$subject = '[APPROVED] Sapphire - New Pipeline / '.$customer.' / '.$project.' / '.$number.'-'.$revision;
$mail->setFrom($sender, ucwords($username).' - Sapphire');
$mail->addAddress($sales_email);
foreach($eng_email as $cc_eng){
	$mail->AddCC($cc_eng['EngineerEmail']);
}
$mail->Subject = $subject;
$mail->isHTML(true);
$mail->Body = '
<pre style="font-family: courier; font-size: 16px">
Pipeline Number	: '.$number.'
Project Name	: '.$project.'
Customer	: '.$customer.'

has been approved by '.$username.'.
</pre>';
$mail->send();

// Memperbarui data
$result = $conn->prepare("UPDATE Pipeline SET Approved = 'Yes', ApprovedDate = :date, ApprovedId = :username WHERE PipelineNumber = :number AND RevisionNumber = :revision");
$result->bindParam(':date', $date);
$result->bindParam(':username', $username);
$result->bindParam(':number', $number);
$result->bindParam(':revision', $revision);
$result->execute();

if($result){
	echo json_encode(array('success' => true));
} else {
	echo json_encode(array('errorMsg'=>'Some errors occured.'));
}

// ======================================================================================================================== //
/*
if($fat == 'Yes'){
	$qa_sql	= mssql_query("SELECT EngineerEmail FROM Engineer WHERE EngineerGroup = 'QA' AND (BUGroup = '$bugroup' OR BUGroup = '')");
	$qa_mail = array();
	while($user_qa = mssql_fetch_array($qa_sql)){
		$qa_mail[] = $user_qa['EngineerEmail'];
	}
	$cc_qa = implode(',', $qa_mail);
	$mail->addCC($cc_qa);
}

if($tescom == 'Yes'){
	$svc_sql	= mssql_query("SELECT EngineerEmail FROM Engineer WHERE EngineerGroup = 'SVC'");
	$svc_mail	= array();
	while($user_svc = mssql_fetch_array($svc_sql)){
		$svc_mail[] = $user_svc['EngineerEmail'];
	}
	$cc_svc = implode(',', $svc_mail);
	$mail->addCC($cc_svc);
}
*/
?>