<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");
$idx = $_REQUEST['idx'];

$query = "SELECT * FROM SPC_MID_CATE a where idx = '$idx'";

$result = sql_query($query);
sql_json($result);
?>