<?php
date_default_timezone_set("Asia/Jakarta");
require '../setting/mail/PHPMailerAutoload.php';	// File fungsi mail
include '../setting/connection.php';
include '../setting/smtp.php';						// File smtp
include '../setting/function.php';					// File fungsi email_sales

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
$attachment_name	= $_FILES['filesDraw']['name'];
$attachment_type	= $_FILES['filesDraw']['type'];
$attachment			= $_FILES['filesDraw']['tmp_name'];
$date				= date('m/d/Y H:i:s a');

// Memanggil fungsi
$sales_email = email_sales($create_id);

// Fungsi kirim email
$subject = 'Sapphire - Drawing Approval / '.$customer.' / '.$project.' / '.$number.'-'.$revision;
$mail->setFrom($sender, ucwords($username).' - Sapphire');
$mail->addAddress($sales_email);
$mail->Subject = $subject;
$mail->isHTML(true);
$mail->Body = '
<pre style="font-family: courier; font-size: 16px">
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
$stmt = $conn->prepare("UPDATE Pipeline SET PipelineStatus = REPLACE(PipelineStatus,'Draw(Req)','Draw(Anw)'), DrawStatus = 'Answer', DrawAnswer = 'Yes', DrawAnswerDate = :date, DrawAnswerId = :username WHERE PipelineNumber = :number");
$stmt->bindParam(':date', $date);
$stmt->bindParam(':username', $username);
$stmt->bindParam(':number', $number);
$stmt->execute();

// Menangani hasil pengiriman email
if(!$mail->send()) {
	echo '<script>alert("Email was sent to Sales !"); </script>';
	echo '<script>document.location="../view/DRAW"</script>';
} else {
    echo '<script>alert("Email was sent to Sales !"); </script>';
	echo '<script>document.location="../view/DRAW"</script>';
}
?>