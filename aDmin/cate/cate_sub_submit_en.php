<?php
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");

$idx         = $_REQUEST['sub_chk'];
$brand_name2 = $_REQUEST['sub_name2'];
$brand_dis   = $_REQUEST['sub_dis'];
$sud_name    = $_REQUEST['sub_sud_name'];
$parentidx   = $_REQUEST['sub_cate_type'];

$uploadBase = $_SERVER['DOCUMENT_ROOT']."/aDmin/file/";

if (!is_dir($uploadBase)){
    if(@mkdir($uploadBase, 0777)) {
        if(is_dir($uploadBase)) {
        }
    }
    else {
        
    }
}
$file_arr = array();

if($_FILES['cate_logo_sub']['name'] != null && $_FILES['cate_logo_sub']['name'] != "")
{
    for( $i=0 ; $i < count($_FILES['cate_logo_sub']['name']); $i++ ) {
        $name = time()."_".$_FILES['cate_logo_sub']['name'][$i];
        $fileType = $_FILES['cate_logo_sub']['type'][$i];
        if($fileType != "image/jpeg" && $fileType != "image/png")
        {
            ?>
            {
            	"isSuc":"fail",
            	"msg":"이미지 파일만 가능합니다."
            }
            <?php
            exit;
        }
        if(move_uploaded_file($_FILES['cate_logo_sub']['tmp_name'][$i], "$uploadBase/$name")){
            $file_arr[] = $name;
        }else{
            ?>
            {
            	"isSuc":"fail",
            	"msg":"파일 업로드에 실패하였습니다."
            }
            <?php

            exit;
        }
    }
} 

$files_name = implode("|", $file_arr);

$query = "update SPC_MID_CATE
                set
                parentidx     = '{$parentidx}',
                cate_name_en  = '{$brand_name2}',
                cate_dis_en   = '{$brand_dis}',
                sud_name      = '{$sud_name}',
                cate_logo     = '{$files_name}'
          where idx = '{$idx}'";

sql_query($query);

?>
    {
        "isSuc":"success",
        "msg":"저장"
    }
<?php 


