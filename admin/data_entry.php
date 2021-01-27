<?php 
    extract($_POST);
    session_start();
    include '../config.php';
    $student_data = json_decode($data_entry_data, true);
    $query = "INSERT INTO `students`(`student_name`, `student_email`, 
    `student_pass`, `student_section`, `student_year`, `father_name`, `parent_number`, `student_number`) VALUES ";
    foreach ($student_data as $data){

        $query .= " ('".$data['student_name']."','".$data['student_email']."','".$data['student_pass']."',
        '".$data['student_section']."',".$data['student_year'].",'".$data['father_name']."',".$data['parent_number'].",".$data['student_number']."), ";
    }
    $conn->query(rtrim($query, ", "));
    

    ?>