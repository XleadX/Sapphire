<?php
date_default_timezone_set("Asia/Jakarta");
require '../setting/mail/PHPMailerAutoload.php';	// File fungsi mail
include '../setting/connection.php';
include '../setting/smtp.php';						// File smtp
include '../setting/function.php';					// File fungsi email_sales dan email_sales_admin

session_start();
$username	= $_SESSION['username'];
$sender		= $_SESSION['email'];
$number		= $_REQUEST['PipelineNumber'];
$project	= $_REQUEST['ProjectName'];
$customer	= $_REQUEST['Customer'];
$create_id	= $_REQUEST['CreateId'];
$revision	= $_REQUEST['RevisionNumber'];
$notes		= $_REQUEST['Notes'];
$date		= date('m/d/Y H:i:s a');

// Memanggil fungsi
$sales_email	= email_sales($create_id);
$sa_email		= email_sales_admin();

// Fungsi kirim email
$subject = 'Sapphire - Transformer Code / '.$customer.' / '.$project.' / '.$number.'-'.$revision;
$mail->setFrom($sender, ucwords($username).' - Sapphire');
$mail->addAddress($sales_email);
foreach($sa_email as $cc_sa){
	$mail->AddCC($cc_sa['SalesEmail']);
}
$mail->Subject = $subject;
$mail->isHTML(true);
$mail->Body = '
<pre style="font-family: courier; font-size: 16px">
Pipeline Number	: '.$number.'
Project Name	: '.$project.'
Customer	: '.$customer.'

<b><i>Notes :</i></b>
<span style="color:blue">'.$notes.'</span>
</pre>';

// Memperbarui data
$stmt = $conn->prepare("UPDATE Pipeline SET PipelineStatus = REPLACE(PipelineStatus,'Code(Req)','Code(Anw)'), TrfCodeAnswer = 'Yes', TrfCodeAnswerDate = :date, TrfCodeAnswerId = :username WHERE PipelineNumber = :number");
$stmt->bindParam(':date', $date);
$stmt->bindParam(':username', $username);
$stmt->bindParam(':number', $number);
$stmt->execute();

// Menangani hasil pengiriman email
if(!$mail->send()) {
	echo '<script>alert("Email was sent to Sales !"); </script>';
	echo '<script>document.location="../view/CODE"</script>';
} else {
    echo '<script>alert("Email was sent to Sales !"); </script>';
	echo '<script>document.location="../view/CODE"</script>';
}
?>