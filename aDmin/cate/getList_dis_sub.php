<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");
$idx = $_REQUEST['idx_sub'];

$query = "SELECT * FROM SPC_MID_CATE where idx = '$idx' limit 1";

$result = sql_query($query);
sql_json($result);
?>