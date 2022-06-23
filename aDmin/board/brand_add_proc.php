<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");

$parentidx   = $_REQUEST['brand_type'];
$title       = $_REQUEST['title'];
$contents    = $_REQUEST['contents'];
$youtube_url = $_REQUEST['youtube_url'];
$insta_url   = $_REQUEST['insta_url'];
$face_url    = $_REQUEST['face_url'];
$blog_url    = $_REQUEST['blog_url'];
$home_url    = $_REQUEST['home_url'];
$exposure_yn = $_REQUEST['exposure_yn'];

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
// print_r($_FILES);

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
        
        for($i=0; $i<count($_FILES['top_img']['name']); $i++) {
            
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
} 

$top_img = implode("|", $file_arr);


// 본문이미지 파일첨부
$file_arr = array();
// print_r($_FILES);

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
        for($i=0; $i<count($_FILES['cont_img']['name']); $i++) {
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
} 

$cont_img = implode("|", $file_arr);


$query =                                                                                                                                                                                                                                                                                 "
          insert into SPC_BRAND_BOARD 
            set 
                cate_type = 'brand',
                title = '{$title}', 
                contents = '{$contents}',
                top_img = '{$top_img}',
                cont_img = '{$cont_img}',
                youtube_url = '{$youtube_url}',
                insta_url = '{$insta_url}',
                face_url = '{$face_url}',
                blog_url = '{$blog_url}',
                home_url = '{$home_url}',
                expo_yn  = '{$exposure_yn}',
                submit_date = NOW()+0
          ";

 sql_query($query);
?>
{
	"isSuc":"success"
}
