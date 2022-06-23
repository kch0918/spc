<?php
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");

$brand_chk = $_REQUEST['brand_chk'];

$query = "delete from SPC_MID_CATE where idx = '{$brand_chk}'";

sql_query($query);

$query2 = "delete from SPC_BRAND_BOARD where parentidx = '{$brand_chk}'";
sql_query($query2);


?>
    {
        "isSuc":"success",
        "msg":"성공"
    }
<?php 


