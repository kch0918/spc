<?php
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");

$ip   = $_REQUEST['reg_ip'];
$name = $_SESSION['name'];

$query =                                                                                                                                                                                                                                                                                 "
          insert into SPC_IP
            set
               ip = '{$ip}',
             name = '{$name}',
            submit_date = DATE_FORMAT(NOW()+0, '%Y%m%d')
          ";

sql_query($query);


?>
    {
		"isSuc":"success"
	}
<?php
