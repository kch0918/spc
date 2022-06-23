<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");

$type        = $_REQUEST['type'];
$title       = $_REQUEST['title'];
$url         = $_REQUEST['url'];
$expo_yn     = $_REQUEST['expo_yn'];
$start_date  = $_REQUEST['start_date'];
$language    = $_REQUEST['language'];

$query =                                                                                                                                                                                                                                                                                 "
          insert into SPC_CF
            set 
                type        = '{$type}',
                title       = '{$title}', 
                url         = '{$url}',
                expo_yn     = '{$expo_yn}',
                lang        = '{$language}',
                submit_date = $start_date
          ";

 sql_query($query);

?>

{
	"isSuc":"success"
}
