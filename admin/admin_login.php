<?php
session_start();
extract($_POST);
include '../config.php';
$stmt = $conn->prepare("SELECT * FROM `admin` WHERE admin_email = ? AND admin_pass = ?");
$stmt->bind_param("ss", $emailid, $password);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if($result->num_rows == 1)
{
  session_start();
  $_SESSION["adminid"] = $row['admin_id'];
  $_SESSION["adminname"] = $row['admin_name'];
  
  echo "1";
}
else{
  echo "0";
}


?>