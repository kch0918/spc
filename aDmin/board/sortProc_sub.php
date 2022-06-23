<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");

$idx = $_REQUEST['idx'];
$sort = $_REQUEST['sort'];

$query = "update SPC_MID_CATE set
            sort      =  '{$sort}'
            where idx =  '{$idx}'
          ";

sql_query($query);

?>
 