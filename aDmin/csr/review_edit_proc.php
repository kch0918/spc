<?php
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");

$idx         = $_REQUEST['idx'];
$expo_yn     = $_REQUEST['expo_yn'];
$popular     = $_REQUEST['popular'];

$query =                                                                                                                                                                                                                                                                                 "
         update SPC_REVIEW
            set
                expo_yn     = '{$expo_yn}',
                top_review  = '{$popular}'    
            where idx = '$idx'";

sql_query($query);

?>
{
	"isSuc":"success"
}
