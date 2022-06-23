<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/aDmin/include/init.php');
$cate_type = $_REQUEST['cate_type'];

$query = "select * from SPC_MID_CATE where cate_type = '{$cate_type}'";
$result = sql_query($query);
sql_json($result);
?>