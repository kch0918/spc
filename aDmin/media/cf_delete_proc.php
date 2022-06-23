<?php
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");

$idx = $_REQUEST['idx'];

$query = "Delete from SPC_CF where idx = '$idx'";

sql_query($query);

?>
 	{
        "isSuc":"success",
        "msg":"성공"
    }
