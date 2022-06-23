<?php
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");
// error_reporting(E_ALL);
// ini_set('display_errors', '1');

$name      = $_REQUEST['name'];
$id        = $_REQUEST['id'];
$password1 = hash("sha256", $_REQUEST['password1']);
$password2 = hash("sha256", $_REQUEST['password2']);

$query = "select * from SPC_USER where password = '{$password1}' and name = '{$name}'";
$result = sql_query($query);
$row = sql_fetch($result);

if($name != null){
    
    if (sql_count($result) > 0 )
    {
        $_SESSION['user_idx']      = $row['idx'];
        $_SESSION['user_id']       = $row['id'];
        $_SESSION['user_email']    = $row['email'];
        $_SESSION['user_name']     = $row['name'];
        ?>
        {
            "isSuc":"success",
            "msg":"환영합니다."
        }
    <?php 
    } else {
    ?>
        {
        	"isSuc":"fail",
        	"msg":"아이디/비밀번호를 확인해주세요."
        }
        <?php
    }

} else {
    
    $query2 = "select * from SPC_USER where password = '{$password2}' and id = '{$id}'";
    $result2 = sql_query($query2);
    $row = sql_fetch($result2);
    
    if (sql_count($result2) > 0 )
    {
        $_SESSION['user_idx']      = $row['idx'];
        $_SESSION['user_id']       = $id;
        ?>
        {
            "isSuc":"success",
            "msg":"환영합니다."
        }
    <?php 
    } else {
    ?>
        {
        	"isSuc":"fail",
        	"msg":"아이디/비밀번호를 확인해주세요."
        }
        <?php
    }
    
}
