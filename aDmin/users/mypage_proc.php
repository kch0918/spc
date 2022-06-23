<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");
  
$idx            =  $_SESSION['idx'];
$name           =  $_REQUEST['name'];
$tel            =  $_REQUEST['tel'];
$corp_tel       =  $_REQUEST['corp_tel'];
$id             =  $_REQUEST['id'];
$email          =  $_REQUEST['email'];
$pw             =  hash("sha256",$_REQUEST['pw']);

$query =                                                                                                                                                                                                                                                                                 "
          update SPC_ADMIN 
            set 
                name            = '{$name}', 
                tel             = '{$tel}',
                corp_tel        = '{$corp_tel}',
                id              = '{$id}',
                email           = '{$email}',
                pw              = '{$pw}' 
            where idx = '$idx'
          ";

 sql_query($query);

?>

{
	"isSuc":"success"
}
