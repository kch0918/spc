<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");

$parentidx   = $_REQUEST['parentidx'];
$title       = $_REQUEST['title'];
$contents    = $_REQUEST['contents'];
$youtube_url = $_REQUEST['youtube_url'];
$insta_url   = $_REQUEST['insta_url'];
$face_url    = $_REQUEST['face_url'];
$blog_url    = $_REQUEST['blog_url'];
$home_url    = $_REQUEST['home_url'];
$exposure_yn = $_REQUEST['exposure_yn'];

$prev_top_img = $_REQUEST['prev_top_img'];
$now_top_img = $_REQUEST['now_top_img'];

$prev_cont_img = $_REQUEST['prev_cont_img'];
$now_cont_img = $_REQUEST['now_cont_img'];

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

if($_FILES['top_img']['name'] != null && $_FILES['top_img']['name'] != "")
{
    for( $i=0 ; $i < count($_FILES['top_img']['name']); $i++ ) {
        $name = time()."_".$_FILES['top_img']['name'][$i];
        $fileType = $_FILES['top_img']['type'][$i];
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
       
        if(move_uploaded_file($_FILES['top_img']['tmp_name'][$i], "$uploadBase/$name")){
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

$prev_top_img_arr = explode("|", $prev_top_img);
$now_top_img_arr = explode("|", $now_top_img);
$n = 0;
$top_cnt = count($now_top_img_arr) - count($prev_top_img_arr);
if($top_cnt > 0){
    for($i = 0; $i < $top_cnt; $i++){
        array_push($prev_top_img_arr, "");
        //         $prev_cont_img2[] = "";
    }
}
for($i = 0; $i < count($prev_top_img_arr); $i++){
    if($prev_top_img_arr[$i] == $now_top_img_arr[$i]){
        
    }else{
        $prev_top_img_arr[$i] = $file_arr[$n];
        $n++;
    }
}
$prev_top_img_arr = array_filter($prev_top_img_arr);
$top_img = implode("|", $prev_top_img_arr);

// 본문이미지 파일첨부
$file_arr = array();

if($_FILES['cont_img']['name'] != null && $_FILES['cont_img']['name'] != "")
{
    for( $i=0 ; $i < count($_FILES['cont_img']['name']); $i++ ) {
        $name = time()."_".$_FILES['cont_img']['name'][$i];
        $fileType = $_FILES['cont_img']['type'][$i];
        
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
        
        if(move_uploaded_file($_FILES['cont_img']['tmp_name'][$i], "$uploadBase/$name")){
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
 
$prev_cont_img_arr = explode("|", $prev_cont_img);
$now_cont_img_arr = explode("|", $now_cont_img);
$n = 0;
$img_cnt = count($now_cont_img_arr) - count($prev_cont_img_arr);
if($img_cnt > 0){
    for($i = 0; $i < $img_cnt; $i++){
        array_push($prev_cont_img_arr, "");
        //         $prev_cont_img2[] = "";
    }
}
for($i = 0; $i < count($prev_cont_img_arr); $i++){
    if($prev_cont_img_arr[$i] == $now_cont_img_arr[$i]){
        
    }else{
        $prev_cont_img_arr[$i] = $file_arr[$n];
        $n++;
    }
}
$prev_cont_img_arr = array_filter($prev_cont_img_arr);
$cont_img = implode("|", $prev_cont_img_arr);

$query =                                                                                                                                                                                                                                                                                 "
          update SPC_BRAND_BOARD 
            set 
                title_en       = '{$title}', 
                contents_en    = '{$contents}',
                top_img        = '{$top_img}',
                cont_img       = '{$cont_img}',
                youtube_url    = '{$youtube_url}',
                insta_url      = '{$insta_url}',
                face_url       = '{$face_url}',
                blog_url       = '{$blog_url}',
                home_url       = '{$home_url}',
                expo_yn        = '{$exposure_yn}',
                submit_date    = NOW()+0
            where parentidx    = '$parentidx'
          ";

 sql_query($query);
 
 $query2 =                                                                                                                                                                                                                                                                                 "
          update SPC_MID_CATE
            set
                expo_yn     = '{$exposure_yn}'
            where idx = '$parentidx'
          ";
 
 sql_query($query2);
 
?>
{
	"isSuc":"success"
}
