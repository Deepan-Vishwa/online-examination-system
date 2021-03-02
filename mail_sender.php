<?php

// Mail Configuration

require('PHPMailer/PHPMailerAutoload.php');
 
$mail = new PHPMailer;
$mail->isSMTP();                                    
$mail->Host = 'smtp.mailtrap.io';  
$mail->SMTPAuth = true;                               
$mail->Username = '157b401e40942d';                 
$mail->Password = 'efe13063b9194d';                           
$mail->SMTPSecure = 'tls';                            
$mail->Port = 2525;                                    
$mail->setFrom('3bc6ad5d6a-615ccf@inbox.mailtrap.io', 'KDSG Examination System');
$mail->isHTML(true); 
?>