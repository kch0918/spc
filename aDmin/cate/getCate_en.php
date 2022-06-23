<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");

$query = "select idx,cate_brand_en,cate_type,cate_sort from SPC_BIG_CATE where cate_type = 'brand'";

$result = sql_query($query);
sql_json($result);
?>