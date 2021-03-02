<?php 
include 'config.php';
include 'mail_sender.php';
extract($_POST);
session_start();


$get_email_query = "SELECT admin_email,admin_name from admin";

$get_email_query_result = mysqli_query($conn,$get_email_query);


        // For Login Mail Requested by help_mailer.js
        if($action == "login_mail"){ 

            while($row = mysqli_fetch_assoc($get_email_query_result)){

                $mail->addCC($row['admin_email'], $row['admin_name']);

            }

            
           
            $mail->Subject = "Login Help";
            $mail->Body =
         '
        
         <!DOCTYPE html>
         <html>
         <head>
             <title></title>
             <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
             <meta name="viewport" content="width=device-width, initial-scale=1">
             <meta http-equiv="X-UA-Compatible" content="IE=edge" />
             <style type="text/css">
                 @media screen {
                     @font-face {
                         font-family: "Lato";
                         font-style: normal;
                         font-weight: 400;
                         src: local("Lato Regular"), local("Lato-Regular"), url(https://fonts.gstatic.com/s/lato/v11/qIIYRU-oROkIk8vfvxw6QvesZW2xOQ-xsNqO47m55DA.woff) format("woff");
                     }
                     @font-face {
                         font-family: "Lato";
                         font-style: normal;
                         font-weight: 700;
                         src: local("Lato Bold"), local("Lato-Bold"), url(https://fonts.gstatic.com/s/lato/v11/qdgUG4U09HnJwhYI-uK18wLUuEpTyoUstqEm5AMlJo4.woff) format("woff");
                     }
                     @font-face {
                         font-family: "Lato";
                         font-style: italic;
                         font-weight: 400;
                         src: local("Lato Italic"), local("Lato-Italic"), url(https://fonts.gstatic.com/s/lato/v11/RYyZNoeFgb0l7W3Vu1aSWOvvDin1pK8aKteLpeZ5c0A.woff) format("woff");
                     }
                     @font-face {
                         font-family: "Lato";
                         font-style: italic;
                         font-weight: 700;
                         src: local("Lato Bold Italic"), local("Lato-BoldItalic"), url(https://fonts.gstatic.com/s/lato/v11/HkF_qI1x_noxlxhrhMQYELO3LdcAZYWl9Si6vvxL-qU.woff) format("woff");
                     }
                 }
                 body,
                 table,
                 td,
                 a {
                     -webkit-text-size-adjust: 100%;
                     -ms-text-size-adjust: 100%;
                 }
                 table,
                 td {
                     mso-table-lspace: 0pt;
                     mso-table-rspace: 0pt;
                 }
                 img {
                     -ms-interpolation-mode: bicubic;
                 }
                 img {
                     border: 0;
                     height: auto;
                     line-height: 100%;
                     outline: none;
                     text-decoration: none;
                 }
                 table {
                     border-collapse: collapse !important;
                 }
                 body {
                     height: 100% !important;
                     margin: 0 !important;
                     padding: 0 !important;
                     width: 100% !important;
                 }
                 a[x-apple-data-detectors] {
                     color: inherit !important;
                     text-decoration: none !important;
                     font-size: inherit !important;
                     font-family: inherit !important;
                     font-weight: inherit !important;
                     line-height: inherit !important;
                 }
                 @media screen and (max-width:600px) {
                     h1 {
                         font-size: 32px !important;
                         line-height: 32px !important;
                     }
                 }
                 div[style*="margin: 16px 0;"] {
                     margin: 0 !important;
                 }
             </style>
         </head>
         <body style="background-color: aliceblue; margin: 0 !important; padding: 0px 0px 30px 0px !important;">
             <!-- HIDDEN PREHEADER TEXT -->
             <div style="display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: "Lato", Helvetica, Arial, sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;"> We"re thrilled to have you here! Get ready to dive into your new account. </div>
             <table border="0" cellpadding="0" cellspacing="0" width="100%">
                 <!-- LOGO -->
                 <tr>
                     <td bgcolor="darkblue" align="center">
                         <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                             <tr>
                                 <td align="center" valign="top" style="padding: 40px 10px 40px 10px;"> </td>
                             </tr>
                         </table>
                     </td>
                 </tr>
                 <tr>
                     <td bgcolor="darkblue" align="center" style="padding: 0px 10px 0px 10px;">
                         <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                             <tr>
                                 <td bgcolor="#ffffff" align="center" valign="top" style="padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111; font-family: "Lato", Helvetica, Arial, sans-serif; font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;">
                                     <h1 style="font-size: 35px; font-weight: 400; margin: 2;">KDSG Examination System</h1> <img src="https://www.pngkey.com/png/full/205-2054169_support-icon-png-for-kids-can-i-help.png" width="170" height="165" style="display: block; border: 0px;" />
                                 </td>
                             </tr>
                         </table>
                     </td>
                 </tr>
                 <tr style="padding-bottom: 10px;">
                     <td bgcolor="aliceblue" align="center" style="padding: 0px 10px 0px 10px;">
                         <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                             <tr>
                                 <td bgcolor="#ffffff" align="left" style="padding: 20px 30px 40px 30px; color: #666666; font-family: "Lato", Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                                     <p style="margin-bottom: 1;">Help Regarding KDSG Examination System Login</p>
                                     <b>My Mail ID:</b>
                                     <p style="margin: 0px 0px 18px 0px;">'.$email.'</p>
                                     <b>Issue:</b>
                                     <p style="margin: 0px 0px 18px 0px;">'.$ci.'</p>
                                     <b>Other issue:</b>
                                     <p style="margin: 0px 0px 18px 0px;">'.$oi.'</p>
                                     <b>Problem Description:</b>
                                     <p style="margin: 0px 0px 18px 0px;">'.$pd.'</p>
                                 </td>
                             </tr>
                         </table>
                     </td>
                 </tr>
             </table>
         </body>
         </html>
        
         ';
        
      
         if(!$mail->send()) {
            echo 'Message could not be sent.';
        } else {
            echo 'Message has been sent';
        }
        
        }

        // For Main Mail Requested by help_mailer.js

    if($action == "main_mail"){

        $query ="
        SELECT student_id,student_name,student_email FROM students where student_id=".$_SESSION['userid']." 
        ";
        $result = mysqli_query($conn, $query); 
        while($row = mysqli_fetch_assoc($result))
        {
            $email = $row["student_email"];
            $name = $row["student_name"];
        }
        

        while($row = mysqli_fetch_assoc($get_email_query_result)){

            $mail->addCC($row['admin_email'], $row['admin_name']);

        }
       
        $mail->Subject =  "Student Help Request";
        $mail->Body =
         '
        
         <!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <style type="text/css">
        @media screen {
            @font-face {
                font-family: "Lato";
                font-style: normal;
                font-weight: 400;
                src: local("Lato Regular"), local("Lato-Regular"), url(https://fonts.gstatic.com/s/lato/v11/qIIYRU-oROkIk8vfvxw6QvesZW2xOQ-xsNqO47m55DA.woff) format("woff");
            }
            @font-face {
                font-family: "Lato";
                font-style: normal;
                font-weight: 700;
                src: local("Lato Bold"), local("Lato-Bold"), url(https://fonts.gstatic.com/s/lato/v11/qdgUG4U09HnJwhYI-uK18wLUuEpTyoUstqEm5AMlJo4.woff) format("woff");
            }
            @font-face {
                font-family: "Lato";
                font-style: italic;
                font-weight: 400;
                src: local("Lato Italic"), local("Lato-Italic"), url(https://fonts.gstatic.com/s/lato/v11/RYyZNoeFgb0l7W3Vu1aSWOvvDin1pK8aKteLpeZ5c0A.woff) format("woff");
            }
            @font-face {
                font-family: "Lato";
                font-style: italic;
                font-weight: 700;
                src: local("Lato Bold Italic"), local("Lato-BoldItalic"), url(https://fonts.gstatic.com/s/lato/v11/HkF_qI1x_noxlxhrhMQYELO3LdcAZYWl9Si6vvxL-qU.woff) format("woff");
            }
        }
        body,
        table,
        td,
        a {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }
        table,
        td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }
        img {
            -ms-interpolation-mode: bicubic;
        }
        img {
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
        }
        table {
            border-collapse: collapse !important;
        }
        body {
            height: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
        }
        a[x-apple-data-detectors] {
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }
        @media screen and (max-width:600px) {
            h1 {
                font-size: 32px !important;
                line-height: 32px !important;
            }
        }
        div[style*="margin: 16px 0;"] {
            margin: 0 !important;
        }
    </style>
</head>
<body style="background-color: aliceblue; margin: 0 !important; padding: 0px 0px 30px 0px !important;">
    <!-- HIDDEN PREHEADER TEXT -->
    <div style="display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: "Lato", Helvetica, Arial, sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;"> We"re thrilled to have you here! Get ready to dive into your new account. </div>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <!-- LOGO -->
        <tr>
            <td bgcolor="darkblue" align="center">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <tr>
                        <td align="center" valign="top" style="padding: 40px 10px 40px 10px;"> </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="darkblue" align="center" style="padding: 0px 10px 0px 10px;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <tr>
                        <td bgcolor="#ffffff" align="center" valign="top" style="padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111; font-family: "Lato", Helvetica, Arial, sans-serif; font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;">
                            <h1 style="font-size: 35px; font-weight: 400; margin: 2;">KDSG Examination System</h1> <img src="https://www.pngkey.com/png/full/205-2054169_support-icon-png-for-kids-can-i-help.png" width="170" height="165" style="display: block; border: 0px;" />
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr style="padding-bottom: 10px;">
            <td bgcolor="aliceblue" align="center" style="padding: 0px 10px 0px 10px;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <tr>
                        <td bgcolor="#ffffff" align="left" style="padding: 20px 30px 40px 30px; color: #666666; font-family: "Lato", Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                            <p style="margin-bottom: 1;">Help Regarding KDSG Examination System Exam</p>
                            <b>Name:</b>
                            <p style="margin: 0px 0px 18px 0px;">'.$name.'</p>
                            <b>Register Number</b>
                            <p style="margin: 0px 0px 18px 0px;">'.$_SESSION["userid"].'</p>
                            <b>My Mail ID:</b>
                            <p style="margin: 0px 0px 18px 0px;">'.$email.'</p>
                            <b>Issue:</b>
                            <p style="margin: 0px 0px 18px 0px;">'.$coi.'</p>
                            <b>Other issue:</b>
                            <p style="margin: 0px 0px 18px 0px;">'.$oti.'</p>
                            <b>Problem Description:</b>
                            <p style="margin: 0px 0px 18px 0px;">'.$prd.'</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
        
         ';
         if(!$mail->send()) {
            echo 'Message could not be sent.';
        } else {
            echo 'Message has been sent';
        }
         
    }

?>