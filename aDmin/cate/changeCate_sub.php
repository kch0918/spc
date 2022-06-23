<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");

$query = "select * from SPC_BIG_CATE where cate_type = 'subsidiary'";

$result = sql_query($query);
sql_json($result);
?>