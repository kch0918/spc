<?php
//! WordPress
/*
$wpLoadPath = $_SERVER['DOCUMENT_ROOT']."/wp-load.php";	//wp-load.php 경로
if(file_exists($wpLoadPath)){
	require_once($wpLoadPath);
	$user = new WP_User(get_current_user_id());
	if($user->roles[0]==""){
		echo '<script> alert("로그인을 먼저해 주세요."); location.replace("/wp-login.php"); </script>';
		exit; 
	}
}else{
	exit;
}
*/
?>
<?php 
//! else
/*
if(!isset($_SESSION['login_id'])){
	echo '<script> alert("로그인을 먼저해 주세요."); location.replace("/admin/login.php"); </script>';
	exit;
}
*/
?>
<!-- <a href="logout.php" style="color:red; font-size:16px; height:45px; line-height:45px;" >로그아웃</a></li> -->

<link rel="stylesheet" media="all" href="./css/mu_popup.css">
<div id="header" class="header-wr">
	<div class="table header">
		<div class="logo"><a href="./popup_list.php"><img src="./img/logo.png" alt="로고"/></a></div>
		<div class="gnbwr">
			<ul>
				<li><a href="./popup_list.php">팝업 관리</a></li>
			</ul>
		</div>
	</div>
</div>