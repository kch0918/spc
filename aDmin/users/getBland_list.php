<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");

$query = "select SPC_BRAND_BOARD.*,SPC_BIG_CATE.cate_brand_kr
          from SPC_BRAND_BOARD
            join SPC_BIG_CATE
            on
          SPC_BRAND_BOARD.parentidx = SPC_BIG_CATE.idx";

$result = sql_query($query);
sql_json($result);
?>