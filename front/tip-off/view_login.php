<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");
?>
<script src="/aDmin/js/jquery-1.12.4.js"></script>
<script src="/aDmin/js/jquery-ui.js"></script> 
<link rel="stylesheet" href="/js/jquery-ui.css" type="text/css" />
<script src="/aDmin/js/jquery.form.min.js"></script>
<script type="text/javascript" src="/aDmin/include/ckeditor/ckeditor.js"></script>
<script>

$(function(){
	$('.report-top-btn a').click(function(e){
		var link = $(this).attr('href');
		e.preventDefault();
		$('.report-top-btn a').removeClass('on');
		$(this).addClass('on');
		$('.report-login').hide();
		$(link).show().focus();
	});
});

function enter_check_login()
{
	if(event.keyCode == 13){
		fncSubmit();
		return;
	}
}

function fncSubmit()
{
	if($("#name").val() == "")
	{
		alert("이름을 입력해주세요.");
		$("#name").focus();
		return;
	}

	if($("#name").val() == "익명")
	{
		alert("잘못된 이름형식입니다.");
		$("#name").focus();
		return;
	}
	
	if($("#password").val() == "")
	{
		alert("비밀번호를 입력해주세요.");
		$("#password").focus();
		return;
	}
	
	$("#loginForm").ajaxSubmit({
		success: function(data)
		{
			console.log(data);
    		var result = JSON.parse(data);
    		if(result.isSuc == "success")
    		{
    			alert(result.msg);
    			location.href="/csr/right-mng/view-list/";
    		}
    		else
    		{
    			alert(result.msg);
    		}
		}
	});
}

function fncSubmit2()
{
	if($("#id").val() == "")
	{
		alert("아이디를 입력해주세요.");
		$("#id").focus();
		return;
	}
	if($("#password2").val() == "")
	{
		alert("비밀번호를 입력해주세요.");
		$("#password2").focus();
		return;
	}
	
	$("#loginForm").ajaxSubmit({
		success: function(data)
		{
			console.log(data);
    		var result = JSON.parse(data);
    		if(result.isSuc == "success")
    		{
    			alert(result.msg);
    			location.href="/csr/right-mng/view-list-blind/";
    		}
    		else
    		{
    			alert(result.msg);
    		}
		}
	});
}
</script>
<div class="report-top-btn">
    <a href="#nameLogin" class="btn btn01 on noscroll"><i><img src="/img/csr/icon_report_name.png" alt="실명 제보" width="27" class="non-hov"><img src="/img/csr/icon_report_name_w.png" alt="실명 제보" width="27" class="hov"></i>실명제보</a> <!-- 클릭시 실명제보일때만보이는 영역 노출 -->
    <a href="#blindLogin" class="btn btn01 noscroll"><i><img src="/img/csr/icon_report_blind.png" alt="익명 제보" width="27" class="non-hov"><img src="/img/csr/icon_report_blind_w.png" alt="익명 제보" width="27" class="hov"></i>익명제보</a> <!-- 클릭시 익명제보일때만보이는 영역 노출 -->
</div>

<div class="report-login-wrap">
    <form id="loginForm" name="loginForm" method="post" action="/front/tip-off/view_login_proc.php">
		<!-- 실명 제보일때만 보이는 영역 -->
		<div id="nameLogin" class="report-login" tabindex="0">
        	<fieldset>
        		<legend>처리결과 확인</legend>
        		<div class="table">
        			<div class="pop-th"><label for="name">이름</label></div>
        			<div class="pop-td"><input type="text" id="name" name="name" placeholder="이름을 입력해 주세요."></div>
        		</div>
        		<div class="table">
        			<div class="pop-th"><label for="password1">비밀번호</label></div>
        			<div class="pop-td"><input type="password" id="password1" name="password1" placeholder="비밀번호를 입력해 주세요." onkeydown="javascript:enter_check_login();"></div>
        		</div>
            	<div class="btn-wrap">
            		<input type="button" onclick="fncSubmit()" value="확인" class="btn_login btn btn02"/>
            	</div>
        	</fieldset>
    	</div>
		<!-- //실명 제보일때만 보이는 영역 끝 -->
		<!-- 익명 제보일때만 보이는 영역 -->
		<div id="blindLogin" class="report-login" tabindex="0" style="display:none;">
			<fieldset>
        		<legend>처리결과 확인</legend>
        		<div class="table">
        			<div class="pop-th"><label for="id">접수 아이디</label></div>
        			<div class="pop-td"><input type="text" id="id" name="id" class="input-narrow" placeholder="접수 아이디를 입력해 주세요."></div>
        		</div>
        		<div class="table">
        			<div class="pop-th"><label for="password2">비밀번호</label></div>
        			<div class="pop-td"><input type="password" id="password2" name="password2" class="input-narrow" placeholder="비밀번호를 입력해 주세요." onkeydown="javascript:enter_check_login();"></div>
        		</div>
        		<div class="btn-wrap">
            		<input type="button" onclick="fncSubmit2()" value="확인" class="btn_login btn btn02"/>
        		</div>
			</fieldset>
		</div>
		<!-- //익명 제보일때만 보이는 영역 끝 -->
    </form>
</div>