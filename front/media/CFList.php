<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");

$type = $_REQUEST['type'];

$query = "select * from SPC_CF where type = '$type' and expo_yn='N'";

$result = sql_query($query);

sql_json($result);

?>