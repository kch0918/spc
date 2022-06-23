<?php
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");
require_once($_SERVER['DOCUMENT_ROOT']."/mail/send_mail.php");

$title       =  $_REQUEST['title'];
$cont        =  $_REQUEST['contents'];
$re_name     =  $_REQUEST['name'];
$email       =  $_REQUEST['email_result'];
$tel         =  $_REQUEST['tel1']."-".$_REQUEST['tel2']."-".$_REQUEST['tel3'];
$tel_yn      =  $_REQUEST['tel_yn'];
$add_answer  =  $_REQUEST['add_answer'];
$password    =  hash("sha256",$_REQUEST['password']);

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

$query3 = "select count(*) as cnt from SPC_USER where name = '{$re_name}' and password = '{$password}'";
$result3 = sql_query($query3);
$row3 = sql_fetch($result3);

if($row3['cnt'] > 0 )
{
?>
    {
    	"isSuc":"fail",
    	"msg":"이름과 비밀번호가 동일한 고객이 있습니다. 비밀번호를 변경해주세요."
    }
<?php
exit;
} else {
    
    $query =                                                                                                                                                                                                                                                                                 
            "
              insert into SPC_NAGATION
                set 
                    id          = '{$id}',
                    title       = '{$title}', 
                    contents    = '{$cont}',
                    file        = '{$file}',
                    name        = '{$re_name}',
                    tel         = '{$tel}',
                    tel_yn      = '{$tel_yn}',
                    add_answer  = '{$add_answer}', 
                    email       = '{$email}',
                    password    = '{$password}',
                    name_yn     = 'N',
                    lang        = 'en',
                    submit_date = DATE_FORMAT(NOW(), '%Y%m%d')
              ";
    
    $query2 =  "
                insert into SPC_USER
                    set
                    id          = '{$id}',
                    email       = '{$email}',
                    name        = '{$re_name}',
                    password    = '{$password}',
                    submit_date = DATE_FORMAT(NOW(), '%Y%m%d%H%i%s')
                ";
                
    
    $result = sql_query($query);
    $result2 = sql_query($query2);
    if ($result > 0 && $result2 > 0)
    {
        send_mail($email,$re_name);
    }   
}

?>

{
	"isSuc":"success"
}
