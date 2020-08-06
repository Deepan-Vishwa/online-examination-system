<?php 
include 'config.php';
include 'mail_sender.php';
extract($_POST);
session_start();

        if($action == "login_mail"){

            $mail->addAddress('srdeepansr@gmail.com', 'Deepan');
            $mail->Subject = "Login Help";
            $mail->Body =
         '
        
         <style>
         .font_res{
            font-size: 1vw;
         }
         @media screen and (max-width: 700px) {
            .font_res{
                font-size: 3vw;
             }
            
         }
         
         </style>
         <div class="font_res" style="text-align:center; color:darkblue;">
          <h1>KDSG Examination System</h1>
          <img src="https://www.freeiconspng.com/uploads/help-icon-26.png" width="200" alt="HELP" padding-bottom:0;/>
        </div>
        <table class="font_res" style="margin-left: auto;border-collapse: collapse; margin-right: auto; background-color: aliceblue; width:90%; height:auto;">
            <tr style="border: 1px solid greeen;">
                <th style="text-align: left;border: 1px solid green;">Email</th>
                <td style="padding-left: 20px;border: 1px solid green;">'.$email.'</td>
            </tr>
            <tr style="border: 1px solid green;">
                <th style="text-align: left;border: 1px solid green;">Common Issue</th>
                <td style="padding-left: 20px;border: 1px solid green;">'.$ci.'</td>
            </tr>
            <tr style="border: 1px solid green;">
                <th style="text-align: left;border: 1px solid green;">Other Issue</th>
                <td style="padding-left: 20px;border: 1px solid green;">'.$oi.'</td>
            </tr>
            <tr style="border: 1px solid green;">
                <th style="text-align: left;border: 1px solid green;">Problem Description</th>
                <td style="padding-left: 20px;border: 1px solid green;">'.$pd.'</td>
            </tr>
        </table>
        
         ';
        
      
         if(!$mail->send()) {
            echo 'Message could not be sent.';
        } else {
            echo 'Message has been sent';
        }
        
        }

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
        

        $mail->addAddress('srdeepansr@gmail.com', 'Deepan');
        $mail->Subject =  "Student Help Request";
        $mail->Body =
         '
        
         <style>
         .font_res{
            font-size: 1vw;
         }
         @media screen and (max-width: 700px) {
            .font_res{
                font-size: 3vw;
             }
            
         }
         
         </style>
         <div class="font_res" style="text-align:center; color:darkblue;">
          <h1>KDSG Examination System</h1>
          <img src="https://www.freeiconspng.com/uploads/help-icon-26.png" width="200" alt="HELP" padding-bottom:0;/>
        </div>
        <table class="font_res" style="margin-left: auto;border-collapse: collapse; margin-right: auto; background-color: aliceblue; width:90%; height:auto;">
            <tr style="border: 2px solid green;">
                <th style="text-align: left;border: 2px solid green;">Name</th>
                <td style="padding-left: 20px;border: 2px solid green;">'.$name.'</td>
            </tr>
            <tr style="border: 2px solid darkblue;">
            <th style="text-align: left;border: 2px solid green;">Reg No</th>
            <td style="padding-left: 20px;border: 2px solid green;">'.$_SESSION["userid"].'</td>
        </tr>
        <tr style="border: 2px solid darkblue;">
        <th style="text-align: left;border: 2px solid green;">Email</th>
        <td style="padding-left: 20px;border: 2px solid green;">'.$email.'</td>
    </tr>
            <tr style="border: 2px solid green;">
                <th style="text-align: left;border: 2px solid green;">Common Issue</th>
                <td style="padding-left: 20px;border: 2px solid green;">'.$coi.'</td>
            </tr>
            <tr style="border: 2px solid green;">
                <th style="text-align: left;border: 2px solid green;">Other Issue</th>
                <td style="padding-left: 20px;border: 2px solid green;">'.$oti.'</td>
            </tr>
            <tr style="border: 2px solid green;">
                <th style="text-align: left;border: 2px solid green;">Problem Description</th>
                <td style="padding-left: 20px;border: 2px solid green;">'.$prd.'</td>
            </tr>
        </table>
        
         ';
         if(!$mail->send()) {
            echo 'Message could not be sent.';
        } else {
            echo 'Message has been sent';
        }
         
    }

?>