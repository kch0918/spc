<?php
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");

$sub_chk = $_REQUEST['sub_chk'];

$query = "delete from SPC_MID_CATE where idx = '{$sub_chk}'";

sql_query($query);

$query2 = "delete from SPC_SUB_BOARD where parentidx = '{$sub_chk}'";
sql_query($query2);

?>
    {
        "isSuc":"success",
        "msg":"성공"
    }
<?php 


