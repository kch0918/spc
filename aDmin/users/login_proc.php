<?php
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");
// error_reporting(E_ALL);
// ini_set('display_errors', '1');
$login_pw = hash("sha256", $_POST['login_pw']);
$login_id = $_REQUEST['login_id'];
$query = "select * from SPC_ADMIN where pw = '{$login_pw}' and id = '{$login_id}'";
$result = sql_query($query);
$row = sql_fetch($result);



if (sql_count($result) > 0 )
{
    $_SESSION['idx']      = $row['idx'];
    $_SESSION['id']       = $login_id;
    $_SESSION['name']     = $row['name'];
    $_SESSION['chmod']    = $row['chmod'];
    $_SESSION['tel']      = $row['tel'];
    $_SESSION['email']    = $row['email'];
    $_SESSION['corp_tel'] = $row['corp_tel']; 
    
    if($_POST['remember_pw'] == "on")
    {
        setcookie('remember_id', $_POST['login_id'], time() + 86400 * 30);
        setcookie('remember_pw', $_POST['login_pw'], time() + 86400 * 30);
    }
    else
    {
        setcookie('remember_id', '', time() - 1);
        setcookie('remember_pw', '', time() - 1);
    }
    
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

