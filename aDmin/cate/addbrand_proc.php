<?php
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");

$parentidx = $_REQUEST['cate_name'];

$query = "insert into SPC_MID_CATE 
                set 
                    cate_name = '',
                    expo_yn = 'Y',
                    parentidx = '{$parentidx}', 
                    cate_type = 'brand'";

sql_query($query);

$idx = sql_fetch(sql_query("select idx from SPC_MID_CATE order by idx desc limit 1"))['idx'];
$query2 = "insert into SPC_BRAND_BOARD
                set 
                  parentidx = '{$idx}',
                  expo_yn = 'Y',
                  submit_date = NOW() + 0,
                  cate_type = 'brand'
          ";
sql_query($query2);

?>
    {
        "isSuc":"success",
        "msg":"성공"
    }
<?php 


