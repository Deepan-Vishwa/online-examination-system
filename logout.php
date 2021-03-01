<?php
// Logout
session_start();
session_destroy();
$_SESSION = array();
header("location: index.html"); // Redirects To Index.html

?>