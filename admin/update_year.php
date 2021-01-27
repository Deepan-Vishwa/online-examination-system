<?php 
    session_start();
    include '../config.php';


    $query_del = "
    DELETE FROM `students` where `student_year` = 3
    ";
    $query_update = "
    UPDATE `students` set `student_year` = `student_year` + 1 WHERE `student_year` = 1 OR `student_year` = 2 
    ";

    if ($conn->query($query_del) === TRUE) {
        if($conn->query($query_update)){
            echo "0";
        }
        
      } else {
        echo "Error deleting record: " . $conn->error;
      }
      
    ?>

