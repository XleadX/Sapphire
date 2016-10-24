<?php
date_default_timezone_set("Asia/Jakarta");
require '../setting/mail/PHPMailerAutoload.php';	// File fungsi mail
include '../setting/connection.php';
include '../setting/smtp.php';						// File smtp
include '../setting/function.php';					// File fungsi email_sales, email_sales_manager, email_engineer_head

session_start();
$username			= $_SESSION['username'];
$sender				= $_SESSION['email'];
$number				= $_REQUEST['PipelineNumber'];
$project			= $_REQUEST['ProjectName'];
$customer			= $_REQUEST['Customer'];
$create_id			= $_REQUEST['CreateId'];
$revision			= $_REQUEST['RevisionNumber'];
$group				= $_REQUEST['SalesGroupId'];
$attachment_name	= $_FILES['filesRFQCost']['name'];
$attachment_type	= $_FILES['filesRFQCost']['type'];
$attachment			= $_FILES['filesRFQCost']['tmp_name'];

// Memanggil fungsi
$sm_email	= email_sales_manager($group);
$eng_email	= email_engineer_head();

// Fungsi kirim email
$subject = 'Sapphire - RFQ Answer Cost / '.$customer.' / '.$project.' / '.$number.'-'.$revision;
$mail->setFrom($sender, ucwords($username).' - Sapphire');
$mail->addAddress($sm_email);
foreach($eng_email as $cc_eng){
	$mail->addCC($cc_eng['EngineerEmail']);
}
$mail->Subject = $subject;
$mail->isHTML(true);
$mail->Body = '
<pre style="font-family:courier; font-size:16px">
Pipeline Number	: '.$number.'
Project Name	: '.$project.'
Customer	: '.$customer.'
</pre>';

// Menambahkan file attachment(s)
foreach($attachment_name as $key => $att){
	$nama_file = $attachment_name[$key];
	$tmp_file = $attachment[$key];

	$mail->addAttachment($tmp_file, $nama_file);
}

if(!$mail->send()) {
	echo '<script>window.close();</script>';
} else {
	echo '<script>window.close();</script>';
}
?>