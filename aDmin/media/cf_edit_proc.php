<?php
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");

$idx         = $_REQUEST['idx'];
$type        = $_REQUEST['type'];
$title       = $_REQUEST['title'];
$start_date  = $_REQUEST['start_date'];
$url         = $_REQUEST['url'];
$expo_yn     = $_REQUEST['expo_yn'];
$lang        = $_REQUEST['language'];
    
$query =                                                                                                                                                                                                                                                                                 "
         update SPC_CF
            set
                type        = '{$type}',
                title       = '{$title}',
                url         = '{$url}',
                expo_yn     = '{$expo_yn}',
                submit_date = $start_date,
                lang        = '{$lang}'
            where idx = '$idx'";

sql_query($query);

?>
{
	"isSuc":"success"
}
