<?php
date_default_timezone_set("Asia/Jakarta");
require '../setting/mail/PHPMailerAutoload.php';	// File fungsi mail
include '../setting/connection.php';
include '../setting/smtp.php';						// File smtp
include '../setting/function.php';					// File fungsi email_sales

session_start();
$username		= $_SESSION['username'];
$sender			= $_SESSION['email'];
$number			= $_REQUEST['PipelineNumber'];
$project		= $_REQUEST['ProjectName'];
$customer		= $_REQUEST['Customer'];
$create_id		= $_REQUEST['CreateId'];
$revision		= $_REQUEST['RevisionNumber'];
$scheduled_date	= $_REQUEST['ScheduleDate'];
$date			= date('m/d/Y H:i:s a', strtotime($scheduled_date));

// Memanggil fungsi
$sales_email = email_sales($create_id);

// Fungsi kirim email
$subject = 'Sapphire - RFQ Schedule / '.$customer.' / '.$project.' / '.$number.'-'.$revision;
$mail->setFrom($sender, ucwords($username).' - Sapphire');
$mail->addAddress($sales_email);
$mail->Subject = $subject;
$mail->isHTML(true);
$mail->Body = '
<pre style="font-family: courier; font-size: 16px">
Pipeline Number	: '.$number.'
Project Name	: '.$project.'
Customer	: '.$customer.'
RFQ Schedule	: '.$scheduled_date.'

has been scheduled by <u>'.$username.'</u>.
</pre>';

// Memperbarui data
$stmt = $conn->prepare("UPDATE Pipeline SET PipelineStatus = 'New - RFQ Schedule', RFQStatus = 'Schedule', Schedule = 'Yes', ScheduleDate = :date, ScheduleId = :username WHERE PipelineNumber = :number");
$stmt->bindParam(':date', $date);
$stmt->bindParam(':username', $username);
$stmt->bindParam(':number', $number);
$stmt->execute();

// Menangani hasil pengiriman email
if(!$mail->send()) {
	echo '<script>alert("Email wasn\'t sent to Sales !"); </script>';
	echo '<script>document.location="../view/RFQ"</script>';
} else {
    echo '<script>alert("Email was sent to Sales !"); </script>';
	echo '<script>document.location="../view/RFQ"</script>';
}
?>