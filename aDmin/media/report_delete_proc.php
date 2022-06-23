<?php
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");

$seq = $_REQUEST['seq'];

$query = "Delete from SPC_REPORT where seq = '$seq'";

sql_query($query);

?>
 	{
        "isSuc":"success",
        "msg":"성공"
    }
