<?php 
    session_start();
    include '../config.php';
    if(isset($_POST['form_data'])) :
        $online_exam_id = $conn->real_escape_string($_POST['online_exam_id']);
        $online_exam_title = $conn->real_escape_string($_POST['online_exam_title']);
        $marks_per_right_answer = $conn->real_escape_string($_POST['marks_per_right_answer']);
        $passing_score = $conn->real_escape_string($_POST['passing_score']);
        $online_exam_status = $conn->real_escape_string($_POST['online_exam_status']);
        $online_exam_code = $conn->real_escape_string($_POST['online_exam_code']);
        $admin_id = $conn->real_escape_string($_POST['admin_id']);

        $online_exam_datetime = str_replace("T", " ", $conn->real_escape_string($_POST['online_exam_datetime']));
        $end_time = str_replace("T", " ", $conn->real_escape_string($_POST['end_time']));

      
        $section_year = array('1A','1B','1C','2A','2B','2C','3A','3B','3C');
        $enroll_sections = array();
        foreach($section_year as $val){
            
            if ( isset($_POST[$val]) ){
                $sec = str_split($_POST[$val],1);
                array_push($enroll_sections,array($sec[0],$sec[1]));
            
        }
        }

        $enroll_data = json_decode($enroll, true);
       
        	$query = " UPDATE `online_exam` SET 
            `online_exam_title`= '$online_exam_title',
             `online_exam_datetime`='$online_exam_datetime',
             `end_time`='$end_time', 
             `marks_per_right_answer`='$marks_per_right_answer' , 
             `passing_score`='$passing_score',
             `online_exam_status`='$online_exam_status',
             `online_exam_code`='$online_exam_code',
             `admin_id`='$admin_id'
              WHERE online_exam_id=$online_exam_id";
                 $sql = $conn->query($query);
                $delete_enroll_query = "DELETE FROM exam_enrollment WHERE online_exam_id = $online_exam_id ";
                $sql2 = $conn->query($delete_enroll_query);

                $enroll_insert = "INSERT INTO `exam_enrollment`(`online_exam_id`, `section`, `year`) VALUES ";

                foreach($enroll_sections as $enr){
                    $enroll_insert .= "(".$online_exam_id.",'".$enr[1]."',".$enr[0]."), ";
                }
                $s = rtrim($enroll_insert, ", ");
                $sql3 = $conn->query($s);
    



        	$msg = "Successfully Updated Your Record";
           
            	
            echo "<script>console.log('php running')</script>";
       
        $_SESSION['flash_msg2'] = $msg;
        header("Location:exam_edit.php");
    endif;

    if(isset($_POST['ct_id'])) :
        $online_exam_id = ($_POST['ct_id']!="") ? $_POST['ct_id'] : '';
        if($online_exam_id!="") :
            $query = "DELETE FROM online_exam WHERE online_exam_id =$online_exam_id";
            $sql = $conn->query($query);
            echo 1;
        else :
            echo 0;
        endif;
    else :
        echo 0;
    endif;
?>