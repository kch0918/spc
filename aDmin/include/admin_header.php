<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");

if ($_SESSION['idx'] == "") {
    
	 echo "<script>alert('로그인이 필요한 서비스 입니다.');</script>";
	 
	 echo "<meta http-equiv='refresh' content='0;url=/aDmin/users/login.php'>";
	 
	 exit;
}

// 특정 ip 차단
//function ipBlock($ip, $iplist) {
    
//    foreach ($iplist as $value) {
//        if (strpos($ip, $value) === 0) return true;
//        else continue;
        
//    }
//    return false;
//}

//$ip = $_SERVER['REMOTE_ADDR'];

//$query = "select * from SPC_IP where ip = '$ip'";
//$result = sql_query($query);


//if (sql_count($result) > 0 ) {
    
    
//}else{
    
//    echo "ip: ".$ip." 는 접근금지 아이피입니다.<br/> 관리자에게 문의바랍니다.";
//    exit();
//}

?>

<html>
<head>
<title>SPC</title>
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script src="/aDmin/js/jquery-1.11.3.min.js"></script>
<script src="/aDmin/js/jquery-1.12.4.js"></script>
<script src="/aDmin/js/jquery.min.js"></script> 
<script src="/aDmin/js/jquery-ui.min.js"></script>
<link rel="stylesheet" href="/aDmin/css/jquery-ui.css" type="text/css" />
<script type="text/javascript" src="/aDmin/js/admin.js"></script>
<script type="text/javascript" src="/aDmin/js/function.js"></script>
<script src="/aDmin/js/malsup.js"></script>
<script type="text/javascript" src="/aDmin/include/ckeditor/ckeditor.js"></script>
<link rel="stylesheet" href="/aDmin/css/common.css">

</head>
<body>
<script>
    $(document).ready(function(){
        $(".menu").click(function(){
            var $this = $(this);
            var submenu = $(this).next(".hide");
            
            if( submenu.is(":visible") ){
                submenu.slideUp();
                $this.removeClass("on");
            }else{
                submenu.slideDown();
                $this.addClass("on");
            }
        });
    });
</script>
<div id="header" class="header_wrap">
    <a href="/aDmin/media/report.php" class="logo"><img src="/img/h_logo.png"></a>
    <div class="t_menu">        
        <a href="/aDmin/users/mypage.php" class="mypage_bt"><span>마이페이지</span></a>
        <div class="menu">
            <img src="/img/ico_admin.png" class="ico_admin">
            <span>Admin</span>
            <img src="/img/h_down_arrow.png" class="ico_arrow">
        </div>
        <div class="hide">
            <a href="/aDmin/users/logout.php">LOGOUT</a>
        </div>
    </div>
</div>
