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
$notes				= $_REQUEST['Notes'];
$attachment_name	= $_FILES['filesRFQ']['name'];
$attachment_type	= $_FILES['filesRFQ']['type'];
$attachment			= $_FILES['filesRFQ']['tmp_name'];
$date				= date('m/d/Y H:i:s a');

// Memanggil fungsi
$sales_email	= email_sales($create_id);
$sm_email		= email_sales_manager($group);
$eng_email		= email_engineer_head();

// Fungsi kirim email
$subject = 'Sapphire - RFQ Answer / '.$customer.' / '.$project.' / '.$number.'-'.$revision;
$mail->setFrom($sender, ucwords($username).' - Sapphire');
$mail->addAddress($sales_email);
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

has been answered by <u>'.$username.'</u>.

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
$stmt = $conn->prepare("UPDATE Pipeline SET PipelineStatus = 'New - RFQ Answer', RFQStatus = 'Answer', Answer = 'Yes', AnswerDate = :date, AnswerId = :username WHERE PipelineNumber = :number");
$stmt->bindParam(':date', $date);
$stmt->bindParam(':username', $username);
$stmt->bindParam(':number', $number);
$stmt->execute();

// Menangani hasil pengiriman email
if(!$mail->send()) {
	echo '<script>alert("Email was sent to Sales and Manager !"); </script>';
	echo '<script>document.location="../view/RFQ"</script>';
} else {
    echo '<script>alert("Email was sent to Sales and Manager !"); </script>';
	echo '<script>document.location="../view/RFQ"</script>';
}
?>