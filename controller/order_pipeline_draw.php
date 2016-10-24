<?php
date_default_timezone_set("Asia/Jakarta");
require '../setting/mail/PHPMailerAutoload.php';	// File fungsi mail
include '../setting/connection.php';
include '../setting/smtp.php';						// File smtp
include '../setting/function.php';					// File fungsi email_engineer_qa dan email_sales_admin

session_start();
$username			= $_SESSION['username'];
$sender				= $_SESSION['email'];
$number				= $_REQUEST['PipelineNumber'];
$project			= $_REQUEST['ProjectName'];
$customer			= $_REQUEST['Customer'];
$revision			= $_REQUEST['RevisionNumber'];
$bugroup			= $_REQUEST['BUGroup'];
$sales_order		= $_REQUEST['SO'];
$notes				= $_REQUEST['Notes'];
$attachment_name	= $_FILES['filesDA']['name'];
$attachment_type	= $_FILES['filesDA']['type'];
$attachment			= $_FILES['filesDA']['tmp_name'];
$date				= date('m/d/Y H:i:s a');

// Memanggil fungsi email_engineer_qa dan email_sales_admin
$eng_email	= email_engineer_qa($bugroup);
$sa_email	= email_sales_admin();

// Kondisi untuk menambah CC berdasarkan status SO
if($sales_order == 'Yes'){
	foreach($sa_email as $cc_sa){
		$mail->addCC($cc_sa['SalesEmail']);
	}
	$sent_sa = '/ SA';
} else {
	$sent_sa = '';
}

// Fungsi kirim email
$subject = 'Sapphire - Approve Drawing / '.$customer.' / '.$project.' / '.$number.'-'.$revision;
$mail->setFrom($sender, ucwords($username).' - Sapphire');
foreach($eng_email as $to_eng){
	$mail->addAddress($to_eng['EngineerEmail']);
}
$mail->Subject = $subject;
$mail->isHTML(true);
$mail->Body = '
<pre style="font-family: courier; font-size: 16px">
Pipeline Number	: '.$number.'
Project Name	: '.$project.'
Customer	: '.$customer.'

drawing was approved by customer.

<b><i>Notes :</i></b>
<span style="color:blue">'.$notes.'</span>
</pre>';

// Menambahkan file attachment(s)
foreach($attachment_name as $key => $att){
	$nama_file = $attachment_name[$key];
	$tmp_file = $attachment[$key];

	$mail->addAttachment($tmp_file, $nama_file);
}

// Memperbarui data
$stmt = $conn->prepare("UPDATE Pipeline SET PipelineStatus = REPLACE(PipelineStatus,'Draw(Anw)','Draw(App)'), DrawStatus = 'Approve', DrawApproval = 'Yes', DrawApprovalDate = :date, DrawApprovalId = :username WHERE PipelineNumber = :number");
$stmt->bindParam(':date', $date);
$stmt->bindParam(':username', $username);
$stmt->bindParam(':number', $number);
$stmt->execute();

// Menangani hasil pengiriman email
if(!$mail->send()) {
	echo '<script>alert("Email was sent to ENG / QA '.$sent_sa.' !"); </script>';
	echo '<script>document.location="../view/ORDER"</script>';
} else {
    echo '<script>alert("Email was sent to ENG / QA '.$sent_sa.' !"); </script>';
	echo '<script>document.location="../view/ORDER"</script>';
}
?>