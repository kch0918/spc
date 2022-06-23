<?php

session_start();

require('../../wp-load.php' );

$user = new WP_User(get_current_user_id());

if($user->roles[0]==""){?>

	<script>
// 		alert("로그인을 먼저해 주세요.");
// 		location.href="/wp-login.php";
	</script>

	
<?exit;}
?>

<link rel="stylesheet" media="all" href="../css/admin.css">
<?php 
// if(!isset($_SESSION['login_id']))
// {
//     echo "<script>location.replace('/aDmin/login.php');</script>";
//     exit;
// }
?>
<!-- 
<a href="/aDmin/logout.php" style="color:red; font-size:16px; height:45px; line-height:45px;" >로그아웃</a></li>
 -->

<div id="header" class="header-wr">
	<div class="table header">
		<div class="logo"><a href="/aDmin/popup/popup_list.php"><img src="/aDmin/img/logo.png" alt="로고"/></a></div>
		<div class="gnbwr">
			<ul>
				<li><a href="/aDmin/popup/popup_list.php">팝업 관리</a></li>
			</ul>
		</div>
	</div>
</div>