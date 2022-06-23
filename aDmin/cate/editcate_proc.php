<?php
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");

$idx = $_REQUEST['idx'];
$cate_brand_kr = $_REQUEST['cate_brand_kr'];

$query = "update SPC_BIG_CATE 
                set 
                cate_brand_kr = '{$cate_brand_kr}'
          where idx = {$idx}";

sql_query($query);

?>
    {
        "isSuc":"success",
        "msg":"성공"
    }
<?php 


