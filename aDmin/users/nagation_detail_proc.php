<?php
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");

$idx         = $_REQUEST['idx'];
$title       = $_REQUEST['re_title'];
$contents    = $_REQUEST['re_contents'];
$start_date2  = $_REQUEST['start_date2'];

$query =                                                                                                                                                                                                                                                                                 "
         update SPC_NAGATION
            set
                re_title       = '{$title}',
                re_contents    = '{$contents}',
                re_submit_date = '{$start_date2}',
                status      = 'Y'
            where idx = '$idx'";

sql_query($query);

?>
{
	"isSuc":"success"
}
