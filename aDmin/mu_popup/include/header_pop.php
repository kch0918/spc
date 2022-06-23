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