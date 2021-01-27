<?php 
    session_start();
    include '../config.php';
    if(isset($_POST['form_data'])) :
        $admin_name = $conn->real_escape_string($_POST['admin_name']);
        $admin_email = $conn->real_escape_string($_POST['admin_email']);
        $admin_pass = $conn->real_escape_string($_POST['admin_pass']);
        

        $admin_id = ($_POST['admin_id']!="") ? $_POST['admin_id'] : '';
        if($admin_id!="") :
        	$query = " UPDATE `admin` SET `admin_name`= '$admin_name', `admin_email`='$admin_email',
             `admin_pass`='$admin_pass'  WHERE admin_id=$admin_id";
        	$msg = "Successfully Updated Your Record";
        else: 
        	$query = " INSERT INTO `admin` SET `admin_name`= '$admin_name', `admin_email`='$admin_email',
            `admin_pass`='$admin_pass'";
            $msg = "Successfully Inserted Your Record";    
            	
        endif;
        $sql = $conn->query($query);
        $_SESSION['flash_msg'] = $msg;
        header("Location:admin.php");
    endif;

    if(isset($_POST['ct_id'])) :
        $admin_id = ($_POST['ct_id']!="") ? $_POST['ct_id'] : '';
        if($admin_id!="") :
            $query = "DELETE FROM admin WHERE admin_id =$admin_id";
            if($conn->query($query)){
                echo 1;
            }
            else{
                echo ($conn ->error);
            }

           
        else :
            echo 0;
        endif;
    else :
        echo 0;
    endif;
?>