<?php 
    session_start();
    include '../config.php';
    if(isset($_POST['form_data'])) :
        $student_name = $conn->real_escape_string($_POST['student_name']);
        $student_email = $conn->real_escape_string($_POST['student_email']);
        $student_pass = $conn->real_escape_string($_POST['student_pass']);
        $student_section = $conn->real_escape_string($_POST['student_section']);
        $student_year = $conn->real_escape_string($_POST['student_year']);
        $father_name = $conn->real_escape_string($_POST['father_name']);
        $parent_number = $conn->real_escape_string($_POST['parent_number']);
        $student_number = $conn->real_escape_string($_POST['student_number']);

        $student_id = ($_POST['student_id']!="") ? $_POST['student_id'] : '';
        if($student_id!="") :
        	$query = " UPDATE `students` SET `student_name`= '$student_name', `student_email`='$student_email',
             `student_pass`='$student_pass', `student_section`='$student_section' , `student_year`='$student_year',
             `father_name`='$father_name',`parent_number`='$parent_number',
             `student_number`='$student_number' WHERE student_id=$student_id";
        	$msg = "Successfully Updated Your Record";
        else: 
        	$query = " INSERT INTO `students` SET `student_name`= '$student_name', `student_email`='$student_email',
            `student_pass`='$student_pass', `student_section`='$student_section' , `student_year`='$student_year',
            `father_name`='$father_name',`parent_number`='$parent_number',
            `student_number`='$student_number'";
            $msg = "Successfully Inserted Your Record";    
            	
        endif;
        $sql = $conn->query($query);
        $_SESSION['flash_msg'] = $msg;
        header("Location:student.php");
    endif;

    if(isset($_POST['ct_id'])) :
        $student_id = ($_POST['ct_id']!="") ? $_POST['ct_id'] : '';
        if($student_id!="") :
            $query = "DELETE FROM students WHERE student_id =$student_id";
            $sql = $conn->query($query);
            echo 1;
        else :
            echo 0;
        endif;
    else :
        echo 0;
    endif;
?>