<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");
session_destroy(); 
echo "<script>location.replace('/aDmin/users/login.php');</script>";
?>