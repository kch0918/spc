<?php
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");

$brand_chk = $_REQUEST['brand_chk'];
$brand_name = $_REQUEST['brand_name'];

$query = "update SPC_MID_CATE 
                set 
                cate_name = '{$brand_name}'
          where idx = {$brand_chk}";

sql_query($query);

?>
    {
        "isSuc":"success",
        "msg":"성공"
    }
<?php 


