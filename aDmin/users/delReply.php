<?php
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");

$reply_no = $_REQUEST['reply_idx'];

$query =                                                                                                                                                                                                                                                                                 "
         Delete from SPC_REPLY where idx = '{$reply_no}'
          ";

sql_query($query);

?>
    {
		"isSuc":"success"
	}
<?php
