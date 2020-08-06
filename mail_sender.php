<?php
require('PHPMailer/PHPMailerAutoload.php');
 
$mail = new PHPMailer;
$mail->isSMTP();                                    
$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'deepantesting2001@gmail.com';                 // SMTP username
$mail->Password = 'kruanytbiwakttdq';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to
$mail->setFrom('deepantesting2001@gmail.com', 'KDSG Examination System');
$mail->isHTML(true); 
?>