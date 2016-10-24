<?php
date_default_timezone_set("Asia/Jakarta");
require '../setting/mail/PHPMailerAutoload.php';	// File fungsi mail
include '../setting/connection.php';
include '../setting/smtp.php';						// File smtp
include '../setting/function.php';					// File fungsi email_sales

session_start();
$username	= $_SESSION['username'];
$sender		= $_SESSION['email'];
$number		= $_REQUEST['PipelineNumber'];
$project	= $_REQUEST['ProjectName'];
$customer	= $_REQUEST['Customer'];
$create_id	= $_REQUEST['CreateId'];
$revision	= $_REQUEST['RevisionNumber'];
$group		= $_REQUEST['SalesGroupId'];
$date		= date('m/d/Y H:i:s a');

// Memanggil fungsi
$sales_email = email_sales($create_id);

// Fungsi kirim email
$subject = 'Sapphire - RFQ Pickup / '.$customer.' / '.$project.' / '.$number.'-'.$revision;
$mail->setFrom($sender, ucwords($username).' - Sapphire');
$mail->addAddress($sales_email);
$mail->Subject = $subject;
$mail->isHTML(true);
$mail->Body = '
<pre style="font-family: courier; font-size: 16px">
Pipeline Number	: '.$number.'
Project Name	: '.$project.'
Customer	: '.$customer.'

has been picked up by <u>'.$username.'</u> and will be scheduled and answered.
</pre>';
$mail->send();

// Memperbarui data
$result = $conn->prepare("UPDATE Pipeline SET PipelineStatus = 'New - RFQ Pick', RFQStatus = 'Pick', Pick = 'Yes', PickDate = :date, PickId = :username WHERE PipelineNumber = :number");
$result->bindParam(':date', $date);
$result->bindParam(':username', $username);
$result->bindParam(':number', $number);
$result->execute();

// Menangani hasil query (assets/js/function.js)
if($result){
	echo json_encode(array('success' => true));
} else {
	echo json_encode(array('errorMsg'=>'Some errors occured.'));
}
?>