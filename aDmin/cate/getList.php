<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");
$idx = $_REQUEST['idx'];

$query = "SELECT * FROM SPC_MID_CATE where parentidx = '$idx' order by sort asc";

$result = sql_query($query);
sql_json($result);
?>