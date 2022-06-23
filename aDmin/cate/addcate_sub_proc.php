<?php
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");

$query = "insert into SPC_BIG_CATE 
                set 
                    cate_brand_kr = '',                    
                    cate_type = 'subsidiary'";

sql_query($query);

?>
    {
        "isSuc":"success",
        "msg":"성공"
    }
<?php 


