<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");

$start_date  = $_REQUEST['start_date'];
$title       = $_REQUEST['title'];
$url         = $_REQUEST['url'];
$expo_yn     = $_REQUEST['expo_yn'];
$language    = $_REQUEST['language'];

$uploadBase = $_SERVER['DOCUMENT_ROOT']."/aDmin/file/";

if (!is_dir($uploadBase)){
    if(@mkdir($uploadBase, 0777)) {
        if(is_dir($uploadBase)) {
        }
    }
    else {
        
    }
}

// 썸네일
$file_arr1 = array();
// print_r($_FILES);

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
            $file_arr1[] = $name;
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

$thumb = implode("|", $file_arr1);

$query =                                                                                                                                                                                                                                                                                 "
          insert into SPC_SNS
            set 
                title       = '{$title}', 
                url         = '{$url}',
                thumb       = '{$thumb}',
                expo_yn     = '{$expo_yn}',
                lang        = '{$language}',
                submit_date = '{$start_date}'
          ";

 sql_query($query);

?>

{
	"isSuc":"success"
}
