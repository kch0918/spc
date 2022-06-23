<?php
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");

$idx         = $_REQUEST['idx'];
$start_date  = $_REQUEST['start_date'];
$title       = $_REQUEST['title'];
$url         = $_REQUEST['url'];
$expo_yn     = $_REQUEST['expo_yn'];
$lang        = $_REQUEST['language'];

$prev_thumb = $_REQUEST['prev_thumb'];
$now_thumb = $_REQUEST['now_thumb'];

$uploadBase = $_SERVER['DOCUMENT_ROOT']."/aDmin/file/";

if (!is_dir($uploadBase)){
    if(@mkdir($uploadBase, 0777)) {
        if(is_dir($uploadBase)) {
        }
    }
    else {
        
    }
}

// 상단이미지 파일첨부
$file_arr = array();

if($_FILES['thumb']['name'] != null && $_FILES['thumb']['name'] != "")
{
    for( $i=0 ; $i < count($_FILES['thumb']['name']); $i++ ) {
        $name = time()."_".$_FILES['thumb']['name'][$i];
        $fileType = $_FILES['thumb']['type'][$i];
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
       
        if(move_uploaded_file($_FILES['thumb']['tmp_name'][$i], "$uploadBase/$name")){
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

$prev_thumb_arr = explode("|", $prev_thumb);
$now_thumb_arr = explode("|", $now_thumb);
$n = 0;
$thumb_cnt = count($now_thumb_arr) - count($prev_thumb_arr);
if($thumb_cnt > 0){
    for($i = 0; $i < $thumb_cnt; $i++){
        array_push($prev_thumb_arr, "");
        //         $prev_cont_img2[] = "";
    }
}

for($i = 0; $i < count($prev_thumb_arr); $i++){
    if($prev_thumb_arr[$i] == $now_thumb_arr[$i]){
        
    }else{
        $prev_thumb_arr[$i] = $file_arr[$n];
        $n++;
    }
}
array_filter($prev_thumb_arr);

$thumb = implode("|", $prev_thumb_arr);

$query =                                                                                                                                                                                                                                                                                 "
         update SPC_SNS
            set
                title       = '{$title}',
                url         = '{$url}',
                thumb       = '{$thumb}',
                expo_yn     = '{$expo_yn}',
                submit_date = '{$start_date}',
                lang        = '{$lang}'
            where idx = '$idx'";

sql_query($query);

?>
{
	"isSuc":"success"
}
