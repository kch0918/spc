<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");

$parentidx   = $_REQUEST['sub_type'];
$title       = $_REQUEST['title'];
$contents    = $_REQUEST['contents'];
$ceo         = $_REQUEST['ceo'];
$corp        = $_REQUEST['corp'];
$addr        = $_REQUEST['addr'];
// $addr2       = $_REQUEST['addr2'];
// $addr3       = $_REQUEST['addr3'];
// $addr4       = $_REQUEST['addr4'];
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

if($_FILES['top_img_sub']['name'] != null && $_FILES['top_img_sub']['name'] != "")
{
    for( $i=0 ; $i < count($_FILES['top_img_sub']['name']); $i++ ) {
        $name = time()."_".$_FILES['top_img_sub']['name'][$i];
        $fileType = $_FILES['top_img_sub']['type'][$i];
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
        
        for($i=0; $i<count($_FILES['top_img_sub']['name']); $i++) {
            
        if(move_uploaded_file($_FILES['top_img_sub']['tmp_name'][$i], "$uploadBase/$name")){
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

if($_FILES['cont_img_sub']['name'] != null && $_FILES['cont_img_sub']['name'] != "")
{
    for( $i=0 ; $i < count($_FILES['cont_img_sub']['name']); $i++ ) {
        $name = time()."_".$_FILES['cont_img_sub']['name'][$i];
        $fileType = $_FILES['cont_img_sub']['type'][$i];
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
        for($i=0; $i<count($_FILES['cont_img_sub']['name']); $i++) {
        if(move_uploaded_file($_FILES['cont_img_sub']['tmp_name'][$i], "$uploadBase/$name")){
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

// 본문이미지 파일첨부2
$file_arr = array();
// print_r($_FILES);

if($_FILES['cont_img2_sub']['name'] != null && $_FILES['cont_img2_sub']['name'] != "")
{
    for( $i=0 ; $i < count($_FILES['cont_img2_sub']['name']); $i++ ) {
        $name = time()."_".$_FILES['cont_img2_sub']['name'][$i];
        $fileType = $_FILES['cont_img2_sub']['type'][$i];
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
        
        for($i=0; $i<count($_FILES['cont_img2_sub']['name']); $i++) {
        if(move_uploaded_file($_FILES['cont_img2_sub']['tmp_name'][$i], "$uploadBase/$name")){
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

$cont_img2 = implode("|", $file_arr);

$query =                                                                                                                                                                                                                                                                                 "
          insert into SPC_SUB_BOARD 
            set 
                parentidx = '{$parentidx}',
                cate_type = 'subsidiary',
                title = '{$title}', 
                contents = '{$contents}',
                top_img = '{$top_img}',
                cont_img = '{$cont_img}',
                cont_img2 = '{$cont_img2}',
                ceo      = '{$ceo}',
                corp     = '{$corp}',
                addr     = '{$addr}',
                home_url = '{$home_url}',
                expo_yn  = '{$exposure_yn}',
                submit_date = NOW()+0
          ";

 sql_query($query);

?>

{
	"isSuc":"success"
}
