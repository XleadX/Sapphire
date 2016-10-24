<?php
$mail = new PHPMailer;
$mail->isSMTP();
$mail->SMTPDebug = 0;
$mail->Debugoutput = 'html';

$mail->Host = '192.168.0.3';
$mail->Port = '25';
$mail->SMTPAuth = false;
$mail->Username = 'traveller@bambangdjaja.com';
$mail->Password = 'traveller';

//$mail->addReplyTo('no-reply@bambangdjaja.com', 'No Reply');
?>