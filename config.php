<?php
$dbhost = 'bmdi4t1u7guqjyytsjzn-mysql.services.clever-cloud.com';
$dbuser = 'u45x5r7jq7qgtpgt';
$dbpass = 'B8L4uf5s3JfORm4bLyHm';
$dbname = 'bmdi4t1u7guqjyytsjzn';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
         if(! $conn ) {
            die("Could not connect: " . mysqli_error());
         }

         // $dbhost = 'localhost';
         // $dbuser = 'root';
         // $dbpass = '';
         // $dbname = 'bmdi4t1u7guqjyytsjzn';
         // $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
         //          if(! $conn ) {
         //             die("Could not connect: " . mysqli_error());
         //          }

?>