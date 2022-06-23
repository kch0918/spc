<?php
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");

$sub_chk = $_REQUEST['sub_chk'];
$brand_name = $_REQUEST['brand_name'];

$query = "update SPC_MID_CATE 
                set 
                cate_name = '{$brand_name}'
          where idx = {$sub_chk}";

sql_query($query);

?>
    {
        "isSuc":"success",
        "msg":"성공"
    }
<?php 


