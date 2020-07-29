<?php 
include 'config.php';
extract($_POST);
session_start();

        if($action == "login_mail"){

         $to = "srdeepansr@gmail.com";
         $subject = "Login Help";
         $message = 
         '
        
         
         <div style="text-align:center; color:darkblue; font-size: 1vw;">
          <h1>KDSG Examination System</h1>
          <img src="https://www.freeiconspng.com/uploads/help-icon-26.png" width="200" alt="HELP" padding-bottom:0;/>
        </div>
        <table style="border: 1px solid blue; margin-left: auto; margin-right: auto; font-size: 1vw; background-color: aliceblue;">
            <tr style="border: 1px solid darkblue;">
                <th style="text-align: left;border: 1px solid blue;">Email</th>
                <td style="padding-left: 20px;border: 1px solid blue;">'.$email.'</td>
            </tr>
            <tr style="border: 1px solid blue;">
                <th style="text-align: left;border: 1px solid blue;">Common Issue</th>
                <td style="padding-left: 20px;border: 1px solid blue;">'.$ci.'</td>
            </tr>
            <tr style="border: 1px solid blue;">
                <th style="text-align: left;border: 1px solid blue;">other issue</th>
                <td style="padding-left: 20px;border: 1px solid blue;">'.$oi.'</td>
            </tr>
            <tr style="border: 1px solid blue;">
                <th style="text-align: left;border: 1px solid blue;">problem desc</th>
                <td style="padding-left: 20px;border: 1px solid blue;">'.$pd.'</td>
            </tr>
        </table>
        
         ';
        
         $header = "MIME-Version: 1.0\r\n";
         $header .= "Content-type: text/html\r\n";
         $header  .= 'From:KDSG Examination System'."\r\n";
         if(mail ($to,$subject,$message,$header)) {
            echo "Message sent successfully...";
         }else {
            echo "Message could not be sent...";
         }
        }

    if($action == "main_mail"){


        // $student_name = '';
        // $student_mail = '';
        // $studet_id = '';

        $to = "srdeepansr@gmail.com";
         $subject = "Login Help";
         $message = 
         '
        
         
         <div style="text-align:center; color:darkblue; font-size: 1vw;">
          <h1>KDSG Examination System</h1>
          <img src="https://www.freeiconspng.com/uploads/help-icon-26.png" width="200" alt="HELP" padding-bottom:0;/>
        </div>
        <table style="border: 1px solid blue; margin-left: auto; margin-right: auto; font-size: 1vw; background-color: aliceblue;">
            <tr style="border: 1px solid darkblue;">
                <th style="text-align: left;border: 1px solid blue;">Email</th>
                <td style="padding-left: 20px;border: 1px solid blue;">'.$email.'</td>
            </tr>
            <tr style="border: 1px solid darkblue;">
            <th style="text-align: left;border: 1px solid blue;">Email</th>
            <td style="padding-left: 20px;border: 1px solid blue;">'.$email.'</td>
        </tr>
        <tr style="border: 1px solid darkblue;">
        <th style="text-align: left;border: 1px solid blue;">Email</th>
        <td style="padding-left: 20px;border: 1px solid blue;">'.$email.'</td>
    </tr>
            <tr style="border: 1px solid blue;">
                <th style="text-align: left;border: 1px solid blue;">Common Issue</th>
                <td style="padding-left: 20px;border: 1px solid blue;">'.$ci.'</td>
            </tr>
            <tr style="border: 1px solid blue;">
                <th style="text-align: left;border: 1px solid blue;">other issue</th>
                <td style="padding-left: 20px;border: 1px solid blue;">'.$oi.'</td>
            </tr>
            <tr style="border: 1px solid blue;">
                <th style="text-align: left;border: 1px solid blue;">problem desc</th>
                <td style="padding-left: 20px;border: 1px solid blue;">'.$pd.'</td>
            </tr>
        </table>
        
         ';
        
         $header = "MIME-Version: 1.0\r\n";
         $header .= "Content-type: text/html\r\n";
         $header  .= 'From:KDSG Examination System'."\r\n";
         if(mail ($to,$subject,$message,$header)) {
            echo "Message sent successfully...";
         }else {
            echo "Message could not be sent...";
         }
    }

?>