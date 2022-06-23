<?php
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");

$board_no = $_REQUEST['idx'];
$name     = $_SESSION['user_name'];
$contents = $_REQUEST['reply'];

$query =                                                                                                                                                                                                                                                                                 "
          insert into SPC_REPLY
              set
                 name        = '{$name}',
                 contents    = '{$contents}',
                 submit_date = DATE_FORMAT(NOW()+0, '%Y%m%d'),
                 board_no    = '{$board_no}'
          ";

sql_query($query);

?>
    {
		"isSuc":"success"
	}
<?php
