<script src="/aDmin/js/jquery-1.12.4.js"></script>
<script src="/aDmin/js/jquery.min.js"></script> 
<link rel="stylesheet" href="/js/jquery-ui.css" type="text/css" />
<script src="/aDmin/js/malsup.js"></script>
<script type="text/javascript" src="/aDmin/include/ckeditor/ckeditor.js"></script>
<script>

var maxFileSize = 50 * 1024 * 1024; //바이트 단위

$(document).ready(function(){

    $(".email-row").each(function(){
    	$(".email-row .select").find("li").click(function(){
    		var chk = $(this).attr("data-id"),
    			text = $(this).text();
    		if(chk == "1"){
    			$("#email-list").val("");
    		}else{
    			$("#email-list").val(text);
    		}
    	})
    })
    
    //첨부파일 용량 검증
    $('#uploadFile').change(function(){
        var fileName = $(this).val().split('fakepath\\')[1],
        	fileSize = $(this)[0].files[0].size;
    	if(fileSize >= maxFileSize){
        	alert('첨부파일의 용량은 최대 ' + (maxFileSize / 1024 / 1024) + 'MB까지 가능합니다.');
        	$(this).val('');
        	$('#fakeFileName').val('');
    	}else{
        	$('#fakeFileName').val(fileName);
    	}
    });

	//라디오 버튼 동작
    $('.radio-label label').click(function(){
        var radioBox = $(this).closest('.form-radio');
        radioBox.find('label').removeClass('on');
        $(this).addClass('on');
    });

    //textarea placeholder 동작
    $('.placeholder-wrap textarea').focus(function(){
        var box = $(this).closest('.placeholder-wrap');
        box.addClass('act');
    })
    .blur(function(){
        var v = $(this).val(),
    		box = $(this).closest('.placeholder-wrap');
        if( v.length === 0){
            box.removeClass('act');
        }else{
            box.addClass('act');
        }
    });
});

function fncSubmit()
{
	var tel1 ="";

	tel1 = $("#phone01").text();
	
	// 비밀번호 형식 검사
	var pw = $("#password").val();
    var checkNumber = pw.search(/[0-9]/g);
    var checkEnglish = pw.search(/[a-z]/ig);
	var title = $("#subject").val(); 
	var name = $("#name").val();
	
   if($('input:checkbox[id="privacyAgree"]').is(":checked") != true ) {
		alert("개인정보처리방침에 대한 동의항목에 체크를 해주세요.");
		$('input:checkbox[id="privacyAgree"]').focus(); 
		return;
	   }

    if(checkSpecial(title))
	{
	   alert('제목에 특수문자가 들어가있습니다.');
	    $("#subject").val('');
		$("#subject").focus();
		return;
	} 

    if (trim(title)=='') 
    {
    	alert('제목을 입력해주세요.');
	    $("#subject").val('');
		$("#subject").focus();
		return;
	}

	if (trim($('#cont').val()).length < 1) 
	{
		alert('내용을 입력해주세요.');
	    $("#cont").val('');
		$("#cont").focus();
		return;
	}
	

    if(checkSpecial(name))
	{
	   alert('성명에 특수문자가 들어가있습니다.');
	    $("#name").val('');
		$("#name").focus();
		return;
	} 
    
    if($("#password").val() == "") {
		alert('비밀번호를 입력해주세요.');
		$("#password").focus();
	    return;

	}else if(!/^(?=.*[a-zA-Z])(?=.*[0-9]).{10,25}$/.test(pw)){            
	    alert('비밀번호는 숫자+영문자 조합으로 10자리 이상 사용해야 합니다.');
	    $("#password").val('');
		$("#password").focus();
	    return;
	    
	}else if(checkNumber <0 || checkEnglish <0){
	    alert("숫자와 영문자를 혼용하여야 합니다.");
	    $("#password").val('');
		$("#password").focus();
	    return;
	}  
	
	var validationFlag = "Y";
	$(".notempty").each(function()
	{ 
		if ($(this).val() == "") 
		{
			alert(this.dataset.name+"을(를) 입력해주세요.");
			$(this).focus();
			validationFlag = "N";
			return false;
		}
	});

	if(validationFlag == "Y")
	{
		$("#fncForm").ajaxSubmit({
			data : {
				tel1 : tel1
			},
			success: function(data)
			{
				console.log(data);
				var result = JSON.parse(data);
	    		if(result.isSuc == "success")
	    		{
	    			alert("등록되었습니다.");
	    			location.href="/csr/right-mng/complete/?lang=zh-hans";
	    		}
	    		else
	    		{
	    			alert(result.msg);
	    		}

			}

		});

	}
}   

</script>
<div class="report-top-btn">
    <a href="/csr/right-mng/name-report/?lang=zh-hans" class="btn btn02 on"><i><img src="/img/csr/icon_report_name.png" alt="实名举报 " width="27" class="non-hov"><img src="/img/csr/icon_report_name_w.png" alt="实名举报 " width="27" class="hov"></i>实名举报</a>
    <a href="/csr/right-mng/blind-report/?lang=zh-hans" class="btn btn01"><i><img src="/img/csr/icon_report_blind.png" alt="匿名举报" width="27" class="non-hov"><img src="/img/csr/icon_report_blind_w.png" alt="匿名举报" width="27" class="hov"></i>匿名举报</a>
</div>
<form id="fncForm" method="post" action="/front/tip-off/name_report_cn_proc.php" enctype="multipart/form-data" onSubmit="return false;">
	<div class="report-form">
    	<fieldset>
    		<legend>同意隐私政策（必选）</legend>
    		<div class="textbox">
    			<dl>
    				<dt>个人信息的收集范围</dt>
    				<dd class="ft-16 color-7d">SPC集团运营的“Hot-Line举报”收集以下信息。<br>收集项目:姓名、电子邮箱地址、联系方式</dd>
    				<dt>个人信息收集方法</dt>
    				<dd class="ft-16 color-7d">通过“隐私政策”的内容，准备可以选择“同意”或“不同意”的步骤，如果选择同意，<br>即可视为同意收集个人信息。</dd>
    			</dl>
    		</div>
    		<!-- 관리자페이지에서 이 처리방침 저장하는 게 필요할 것 같습니다. 법적인 문제로 수정이 편해야될 것 같아요 -->
    		<div class="form-chkbox">
    			<span class="chkbox-label">
        			<input type="checkbox" id="privacyAgree"/><label for="privacyAgree" class="ft-20">同意</label>
    			</span>
    		</div>
    	</fieldset>
	</div>
	<div class="report-form">
    	<fieldset>
    		<legend>举报内容</legend>
    		<div class="table">
    			<div class="pop-th"><label for="subject" >标题</label></div>
    			<div class="pop-td"><input type="text" id="subject" name="title" class="notempty" data-name="标题" placeholder="输入标题"></div>
    		</div>
    		<div class="table">
    			<div class="pop-th"><label for="cont">内容 </label></div>
    			<div class="pop-td">
    				<div class="placeholder-wrap">
    					<div class="placeholder ft-16">*请根据事实，按照六何原则（何人、何时、何地、何事、何因、如何发生）尽可能具体说明。<br>** 如附加相关资料（图片、文件、凭证等），将对举报调查有很大的帮助。</div>
        				<textarea id="cont" name="contents" class="notempty" data-name="内容 "></textarea>
    				</div>
				</div>
    		</div>
    		<div class="table">
    			<div class="pop-th"><label for="uploadFile">附件</label></div>
    			<div class="pop-td">
    				<div class="form-file">
    					<input type="text" class="input-narrow" id="fakeFileName" readonly placholder="选择文件">
    					<span class="file-btn">
    						<span class="btn btn02 on">选择文件<img src="/img/csr/icon_plus_w.png" alt="" width="15"></span>
        					<input type="file" id="uploadFile" name="file[]">
    					</span>
					</div>
					<p class="form-notice color-s ft-15">只允许上传50mb以下</p>
				</div>
    		</div>
    	</fieldset>
	</div>
	<div class="report-form">
    	<fieldset>
    		<legend>举报人</legend>
    		<div class="table">
    			<div class="pop-th"><label for="name">姓名</label></div>
    			<div class="pop-td"><input type="text" class="input-narrow" id="name" name="name" class="notempty" data-name="姓名" placeholder="输入姓名"></div>
    		</div>
    		<div class="table">
    			<div class="pop-th"><label for="phone01">联系方式</label></div>
    			<div class="pop-td">
    				<div class="phone-row">
    					<div class="table">
        					<div>
            					<div class="select">
    								<p><strong>選擇</strong></p>
    								<ul>
    									<li id="phone01" name="tel1" value="010"><a>010</a></li>
    									<li id="phone01" name="tel1" value="011"><a>011</a></li>
    									<li id="phone01" name="tel1" value="017"><a>017</a></li>
    									<li id="phone01" name="tel1" value="019"><a>019</a></li>
    								</ul>
    							</div>
        					</div>
        					<div class="data-hi">-</div>
        					<div>
                				<input id="phone02" name="tel2" type="text" maxlength="4" class="notempty" data-name="联系方式">
        					</div>
        					<div class="data-hi">-</div>
        					<div>
            					<input id="phone03" name="tel3" type="text" maxlength="4" class="notempty" data-name="연락처">
        					</div>
    					</div>
    				</div>
    			</div>
    		</div>
        		<div class="table">
        			<div class="pop-th"><label for="email1">电子邮箱</label></div>
        			<div class="pop-td">
        				<div class="email-row">
        					<div class="table">
                    			<div><input type="text" placeholder="输入电子邮箱" name="email1" class="notempty" data-name="电子邮箱"></div>
                    			<div class="data-hi">@</div>
                    			<div><input type="text" id="email-list" placeholder="直接输入时" name="email2" class="notempty" data-name="电子邮箱"></div>
        					</div>
        					<div class="select">
								<p><strong>直接输入</strong></p>
								<ul>
									<li data-id="1"><a>直接输入</a></li>
									<li><a>naver.com</a></li>
									<li><a>gmail.com</a></li>
									<li><a>nate.com</a></li>
									<li><a>hanmail.net</a></li>
									<li><a>daum.net</a></li>
								</ul>
							</div>
        				</div>
            		</div>
        		</div>
    			<div class="table">
    				<div class="pop-th"><label for="password">密码</label></div>
    				<div class="pop-td"><input type="password" id="password" name="password" placeholder="输入密码" class="notempty input-mid" data-name="密码">
    					<p class="form-notice color-s ft-15">密码规则:混合数字+英文10位以上</p>
					</div>
    			</div>
    		<div class="form-radio-wrap">
    			<div class="in-bl-th">※ 关于举报，可否进行电话咨询</div>
    			<div class="in-bl-td">
        			<div class="form-radio">
        				<span class="radio-label">
                			<input type="radio" id="tel_y" name="tel_yn" value="Y" class="regular-radio" checked=""><label for="tel_y"><span>是</span></label>
        				</span>
        				<span class="radio-label">
    	        			<input type="radio" id="tel_n" name="tel_yn" value="N" class="regular-radio"><label for="tel_n"><span>否</span></label>
        				</span>
        			</div>
    			</div>
    		</div>
    	</fieldset>
	</div>
	<div class="report-form">
    	<fieldset>
    		<legend>有关举报的补充问题</legend>
    		<div class="table">
    			<div class="pop-th"><label for="addCont">内容</label></div>
    			<div class="pop-td">
    				<div class="placeholder-wrap">
        				<div class="placeholder ft-16">* 请列出知道或预计知道此事件的人 <br>* 请写下您认为确认/调查此事件最好的方法</div>
        				<textarea id="addCont" name="add_answer"></textarea>
    				</div>
    			</div>
    		</div>
    	</fieldset>
	</div>
	<div class="btn-wrap">
		<a href="http://spcweb.musign.co.kr/csr/right-mng/tip-off-intro/?lang=zh-hans" class="btn btn01">取消</a>
		<a href="javascript:fncSubmit();" class= "btn btn02" >受理</a>
	</div>
</form>

<!-- id랑 name 값은 임의로 넣었으니 알아서 잘 바꿔주세용 -->