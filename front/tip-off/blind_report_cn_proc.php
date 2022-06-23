<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");

$title       =  $_REQUEST['title'];
$cont        =  $_REQUEST['contents'];
$add_answer  =  $_REQUEST['add_answer'];
$password    =  $_REQUEST['password'];

$randomNum = mt_rand(1000000000, 9999999999);

$id = "S".$randomNum;

$uploadBase = $_SERVER['DOCUMENT_ROOT']."/aDmin/file/";

if (!is_dir($uploadBase)){
    if(@mkdir($uploadBase, 0777)) {
        if(is_dir($uploadBase)) {
        }
    }
    else {
        
    }
}

$file_arr2 = array();

if($_FILES['file']['name'] != null && $_FILES['file']['name'] != "")
{
    for( $i=0 ; $i < count($_FILES['file']['name']); $i++ ) {
        $name = time()."_".$_FILES['file']['name'][$i];
        $fileType = $_FILES['file']['type'][$i];
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
        
            
        if(move_uploaded_file($_FILES['file']['tmp_name'][$i], "$uploadBase/$name")){
            $file_arr2[] = $name;
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

$file = implode("|", $file_arr2);

$query =                                                                                                                                                                                                                                                                                 "
          insert into SPC_NAGATION
            set 
                id          = '{$id}',
                title       = '{$title}', 
                contents    = '{$cont}',
                file        = '{$file}',
                add_answer  = '{$add_answer}', 
                password    = '{$password}',
                name_yn     = 'Y',
                lang        = 'cn',
                submit_date = DATE_FORMAT(NOW(), '%Y%m%d')
          ";

$query2 =  "insert into SPC_USER
                set
                id          = '{$id}',
                password    = '{$password}',
                submit_date = DATE_FORMAT(NOW(), '%Y%m%d%H%i%s')
            ";
            
$result = sql_query($query);
$result2 = sql_query($query2);
if ($result > 0 && $result2 > 0)
{
    blind_send_mail($id);
}
 
?>

{
	"isSuc":"success"
}
