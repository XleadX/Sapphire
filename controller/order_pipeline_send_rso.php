<?php
date_default_timezone_set("Asia/Jakarta");
require '../setting/mail/PHPMailerAutoload.php';	// File fungsi mail
include '../setting/connection.php';
include '../setting/smtp.php';						// File smtp
include '../setting/function.php';					// File fungsi email_sales_manager dan email_sales_admin

session_start();
$username			= $_SESSION['username'];
$sender				= $_SESSION['email'];
$number				= $_POST['PipelineNumber'];
$revision			= $_POST['RevisionNumber'];
$project			= $_POST['ProjectName'];
$customer			= $_POST['Customer'];
$group				= $_POST['SalesGroupId'];
$code				= isset($_POST['RFQ']) ? $_POST['RFQ'] : 'No';
$created_email		= $_POST['CreatedEmail'];
$attachment_name	= $_FILES['filesRSO']['name'];
$attachment_type	= $_FILES['filesRSO']['type'];
$attachment			= $_FILES['filesRSO']['tmp_name'];

if($_POST['DrawingApproval'] == 'Yes'){
	$draw = 'Yes';
} else {
	$draw = 'No';
}

if($_POST['AdditionalTest'] == 'Yes'){
	$test = 'Yes';
} else {
	$test = 'No';
}

// Memanggil fungsi email_sales_manager dan email_sales_admin
$sa_email = email_sales_admin();
$sm_email = email_sales_manager($group);

// Fungsi kirim email
$subject = 'Sapphire - Purchase Order / '.$customer.' / '.$project.' / '.$number.'-'.$revision.'';
$mail->setFrom($sender, ucwords($username).' - Sapphire');
foreach($sa_email as $to_sa){
	$mail->AddAddress($to_sa['SalesEmail']);
}
$mail->AddCC($created_email);
$mail->AddCC($sm_email);
$mail->Subject = $subject;
$mail->msgHTML('
<pre style="font-family: courier; font-size: 16px">
Pipeline Number		: '.$number.'
Purchase Order		: Yes
Drawing Approval	: '.$draw.'
Additional Test		: '.$test.'
New Trafo Code		: '.$code.'
</pre>
');

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