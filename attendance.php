<?php
session_start();
extract($_POST);
include 'config.php';
date_default_timezone_set('Asia/Kolkata');
$time =  date("Y-m-d H:i:s");

$attendance_query = "INSERT INTO `attendance`(`online_exam_id`, `student_id`, `time_stamp`) 
VALUES (".$_SESSION['online_exam_id'].",".$_SESSION['userid'].",'".$time."')";

if($conn->query($attendance_query) === TRUE){
    $_SESSION['attendance'] = 'yes';
}
?>