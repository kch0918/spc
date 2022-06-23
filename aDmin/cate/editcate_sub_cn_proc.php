<?php
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");

$idx = $_REQUEST['idx'];
$cate_brand_cn = $_REQUEST['cate_brand_cn'];

$query = "update SPC_BIG_CATE 
                set 
                cate_brand_cn = '{$cate_brand_cn}'
          where idx = {$idx}";

sql_query($query);

?>
    {
        "isSuc":"success",
        "msg":"성공"
    }
<?php 


