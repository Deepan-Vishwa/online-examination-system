<?php

session_start();
date_default_timezone_set('Asia/Kolkata');
$start = strtotime(date("Y-m-d H:i:s"));
$end =   strtotime($_SESSION["end_time"]);

$time = $end - $start; 
echo gmdate("H:i:s",$time) ;
?>

