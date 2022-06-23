<?php
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");

if(isset($_COOKIE['remember_id']) || isset($_COOKIE['remember_id']))
{
    
}
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>SPC</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<link rel="stylesheet" href="/aDmin/css/common.css">
<link rel="stylesheet" href="/aDmin/css/user.css">
<script src="/aDmin/js/jquery-1.11.3.min.js"></script>
<script src="/aDmin/js/jquery.form.min.js"></script>
<script>
function enter_check_login()
{
	if(event.keyCode == 13){
		fncSubmit();
		return;
	}
}

function fncSubmit()
{
	if($("#login_id").val() == "")
	{
		alert("아이디를 입력해주세요.");
		$("#login_id").focus();
		return;
	}
	if($("#login_pw").val() == "")
	{
		alert("비밀번호를 입력해주세요.");
		$("#login_pw").focus();
		return;
	}
	
	// login_id가 spchotline일 경우 부정제보페이지 이동
	if($("#login_id").val() == "spchotline") {
    	$("#loginForm").ajaxSubmit({
    		success: function(data)
    		{
    			console.log(data);
        		var result = JSON.parse(data);
        		if(result.isSuc == "success")
        		{
        			alert(result.msg);
        			location.href="/aDmin/users/nagation.php";
        		}
        		else
        		{
        			alert(result.msg);
        		}
    		}
    	});
	}else if($("#login_id").val() == "spcadmin"){
		$("#loginForm").ajaxSubmit({
    		success: function(data)
    		{
    			console.log(data);
        		var result = JSON.parse(data);
        		if(result.isSuc == "success")
        		{
        			alert(result.msg);
        			location.href="/aDmin/csr/notice.php";
        		}
        		else
        		{
        			alert(result.msg);
        		}
    		}
    	});
	} else {
		$("#loginForm").ajaxSubmit({
    		success: function(data)
    		{
    			console.log(data);
        		var result = JSON.parse(data);
        		if(result.isSuc == "success")
        		{
        			alert(result.msg);
        			location.href="/aDmin/media/report.php";
        		}
        		else
        		{
        			alert(result.msg);
        		}
    		}
    	});
	}
}

$(document).ready(function(){
	
	// 자동 로그인
	var remember_id = '<?php echo $_COOKIE['remember_id'];?>';
	var remember_pw = '<?php echo $_COOKIE['remember_pw'];?>';

	if(remember_id != '' && remember_pw != '')
	{
		$("#remember_pw").prop("checked", true);
		$("#login_id").val(remember_id);
		$("#login_pw").val(remember_pw);
	}
	 
	// 아이디 저장하기
    // 저장된 쿠키값을 가져와서 ID 칸에 넣어준다. 없으면 공백으로 들어감.
    var key = getCookie("key");
    $("#login_id").val(key); 
     
    if($("#login_id").val() != ""){ 					// 그 전에 ID를 저장해서 처음 페이지 로딩 시, 입력 칸에 저장된 ID가 표시된 상태라면,
        $("#remember_id").attr("checked", true); 		// ID 저장하기를 체크 상태로 두기.
    }
     
    $("#remember_id").change(function(){ 				// 체크박스에 변화가 있다면,
        if($("#remember_id").is(":checked")){ 			// ID 저장하기 체크했을 때,
            setCookie("key", $("#login_id").val(), 7);  // 7일 동안 쿠키 보관
        }else{ // ID 저장하기 체크 해제 시,
            deleteCookie("key");
        }
    });
     
    // ID 저장하기를 체크한 상태에서 ID를 입력하는 경우, 이럴 때도 쿠키 저장.
    $("#login_id").keyup(function(){ 					// ID 입력 칸에 ID를 입력할 때,
        if($("#remember_id").is(":checked")){ 			// ID 저장하기를 체크한 상태라면,
            setCookie("key", $("#login_id").val(), 7);  // 7일 동안 쿠키 보관
        }
    });
});
 
function setCookie(cookieName, value, exdays){
    var exdate = new Date();
    exdate.setDate(exdate.getDate() + exdays);
    var cookieValue = escape(value) + ((exdays==null) ? "" : "; expires=" + exdate.toGMTString());
    document.cookie = cookieName + "=" + cookieValue;
}
 
function deleteCookie(cookieName){
    var expireDate = new Date();
    expireDate.setDate(expireDate.getDate() - 1);
    document.cookie = cookieName + "= " + "; expires=" + expireDate.toGMTString();
}
 
function getCookie(cookieName) {
    cookieName = cookieName + '=';
    var cookieData = document.cookie;
    var start = cookieData.indexOf(cookieName);
    var cookieValue = '';
    if(start != -1){
        start += cookieName.length;
        var end = cookieData.indexOf(';', start);
        if(end == -1)end = cookieData.length;
        cookieValue = cookieData.substring(start, end);
    }
    return unescape(cookieValue);
}

</script>
</head>
<body class="log_page">
<div class="login_wrap">
	<div class="page_login">
		<div class="inner">
   			<img alt="로고이미지" src="../img/login_logo.png">
       		<form id="loginForm" name="loginForm" method="post" action="login_proc.php">
				<input type="text" id="login_id" name="login_id" placeholder="아이디">
				<input type="password" id="login_pw" name="login_pw" placeholder="비밀번호" onkeydown="javascript:enter_check_login();">
			<div class="chk-wrap">
				<input type="checkbox" id="remember_id" name="remember_pw"/>        		
				<label for="remember_id"><span></span>아이디 저장</label>
				<input type="checkbox" id="remember_pw" name="remember_pw"/>        		
				<label for="remember_pw"><span></span>로그인 상태 유지</label>
			</div>
			<input type="button" onclick="fncSubmit()" value="로그인" class="btn_login"/>
       		</form>
   		</div>
	 </div>
</div>

<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/admin_footer.php");
?>
