<?php

// Mail Configuration

require('PHPMailer/PHPMailerAutoload.php');
 
$mail = new PHPMailer;
$mail->isSMTP();                                    
$mail->Host = 'smtp.mailtrap.io';  
$mail->SMTPAuth = true;                               
<<<<<<< HEAD
$mail->Username = '6b5e609730b0c8';                 
$mail->Password = '3f1bb6bc129388';                           
=======
$mail->Username = ''; // username                 
$mail->Password = ''; // password                          
>>>>>>> 6c7d1ec1d53c55e529be66ecf6898a4a81bf6bfb
$mail->SMTPSecure = 'tls';                            
$mail->Port = 2525;                                    
$mail->setFrom('3bc6ad5d6a-615ccf@inbox.mailtrap.io', 'KDSG Examination System');
$mail->isHTML(true); 
?>
