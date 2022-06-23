<?php
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");

$idx = $_REQUEST['idx'];
$ip   = $_REQUEST['edit_ip'];

$query =                                                                                                                                                                                                                                                                                 "
          update SPC_IP
            set
               ip = '{$ip}'
           where idx = '{$idx}'
          ";

sql_query($query);

?>
    {
		"isSuc":"success"
	}
<?php
