<?php
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");

$idx = $_REQUEST['idx'];

$query = "delete from SPC_BIG_CATE where idx = '{$idx}'";

sql_query($query);

?>
    {
        "isSuc":"success",
        "msg":"성공"
    }
<?php 


