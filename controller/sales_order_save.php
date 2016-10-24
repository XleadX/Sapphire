<?php
date_default_timezone_set("Asia/Jakarta");
require '../setting/mail/PHPMailerAutoload.php';	// File fungsi mail
include '../setting/connection.php';
include '../setting/smtp.php';						// File smtp
include '../setting/function.php';			// File fungsi email_sales dan email_engineer_so

session_start();
$username	= $_SESSION['username'];
$sender		= $_SESSION['email'];
$sonumber	= $_POST['SONumber'];
$number		= $_POST['PipelineNumber'];
$project	= $_POST['ProjectName'];
$customer	= $_POST['Customer'];
$create_id	= $_POST['CreateId'];
$revision	= $_POST['RevisionNumber'];
$group		= $_POST['SalesGroupId'];
$bugroup	= $_POST['BUGroup'];
$date		= date('m/d/Y H:i:s a');

// Memanggil fungsi
$sales_email	= email_sales($create_id);
$eng_email		= email_engineer_so($bugroup);

// Fungsi kirim email
$subject = 'Sapphire - Sales Order / '.$customer.' / '.$project.' / '.$number.'-'.$revision;
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

'.$username.' is creating sales order (<span style="color:blue">'.$sonumber.'</span>)
</pre>';

// Memperbarui data
$stmt = $conn->prepare("UPDATE Pipeline SET PipelineStatus = REPLACE(PipelineStatus, 'PO', 'SO'), SORef = :sonumber, SO = 'Yes', SODate = :date, SOId = :username WHERE PipelineNumber = :number AND RevisionNumber = :revision");
$stmt->bindParam(':sonumber', $sonumber);
$stmt->bindParam(':date', $date);
$stmt->bindParam(':username', $username);
$stmt->bindParam(':number', $number);
$stmt->bindParam(':revision', $revision);
$stmt->execute();

// Menangani hasil pengiriman email
if(!$mail->send()) {
	echo '<script>alert("Email wasn\'t sent to Manager, ENG, PPIC, PC !"); </script>';
	echo '<script>document.location="../view/SALES_ORDER"</script>';
} else {
    echo '<script>alert("Email was sent to Manager, ENG, PPIC, PC !"); </script>';
	echo '<script>document.location="../view/SALES_ORDER"</script>';
}
?>