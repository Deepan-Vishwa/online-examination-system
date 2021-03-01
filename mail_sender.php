<?php

// Mail Configuration

require('PHPMailer/PHPMailerAutoload.php');
 
$mail = new PHPMailer;
$mail->isSMTP();                                    
$mail->Host = 'smtp.gmail.com';  
$mail->SMTPAuth = true;                               
$mail->Username = 'deepantesting2001@gmail.com';                 
$mail->Password = 'kruanytbiwakttdq';                           
$mail->SMTPSecure = 'tls';                            
$mail->Port = 587;                                    
$mail->setFrom('deepantesting2001@gmail.com', 'KDSG Examination System');
$mail->isHTML(true); 
?>