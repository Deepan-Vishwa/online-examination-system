<?php
extract($_POST);
$dbhost = 'bmdi4t1u7guqjyytsjzn-mysql.services.clever-cloud.com';
$dbuser = 'u45x5r7jq7qgtpgt';
$dbpass = 'B8L4uf5s3JfORm4bLyHm';
$dbname = 'bmdi4t1u7guqjyytsjzn';
$db = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);


if(! $db ) {
  die('Could not connect: ' . mysqli_error());
}


$stmt = $db->prepare("SELECT * FROM `students` WHERE student_email = ? AND student_pass = ?");
$stmt->bind_param("ss", $emailid, $password);
$stmt->execute();
$stmt->store_result();

if($stmt->num_rows == 1)
{
  echo "1";
}
else{
  echo "0";
}


