<?php
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");

$agree1   = $_REQUEST['agree1'];
$agree2   = $_REQUEST['agree2'];
$email    = $_REQUEST['email'];
$birth    = $_REQUEST['birth'];

$query =                                                                                                                                                                                                                                                                                 "
         insert into SPC_SUBSCRIBE
            set
                agree1     = '{$agree1}',
                agree2     = '{$agree2}',
                email      = '{$email}',
                birth      = '{$birth}',
               submit_date = DATE_FORMAT(NOW(), '%Y%m%d')";

sql_query($query);

?>
{
	"isSuc":"success"
}
