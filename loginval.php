<?php
extract($_POST);
include 'config.php';
$stmt = $conn->prepare("SELECT * FROM `students` WHERE student_email = ? AND student_pass = ?");
$stmt->bind_param("ss", $emailid, $password);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if($result->num_rows == 1)
{
  session_start();
  $_SESSION["userid"] = 1;
  
  echo "1";
}
else{
  echo "0";
}


?>