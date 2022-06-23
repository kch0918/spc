<script src="/aDmin/js/jquery-1.12.4.js"></script>
<script src="/aDmin/js/jquery-ui.js"></script> 
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
		
    if($('input:checkbox[id="privacyAgree"]').is(":checked") != true ) 
    {
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

	if (trim(name).length < 1) 
	{
		alert('성명을 입력해주세요.');
	    $("#name").val('');
		$("#name").focus();
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

   var email1  = $("#email1").val();
   var email2  = $("#email-list").val();
   var email3  = email1 + "@" +  email2;

   $("#email").val(email3);

   var email = $("#email").val();
   var regEmail = /^([0-9a-zA-Z_\.-]+)@([0-9a-zA-Z_-]+)(\.[0-9a-zA-Z_-]+){1,2}$/;

   //test 함수 == 문자열이 정규식을 만족하는지 판별하는 함수
   //조건을 만족하면 true를 반환, 만족하지 못하면 false반환
   if(!regEmail.test(email))
   {     
   	 alert("입력한 이메일 형식이 잘못 되었습니다.");
 	 $("#email1").focus();
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
	    			location.href="/csr/right-mng/complete/";
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
    <a href="/csr/right-mng/name-report/" class="btn btn02 on"><i><img src="/img/csr/icon_report_name.png" alt="실명 제보" width="27" class="non-hov"><img src="/img/csr/icon_report_name_w.png" alt="실명 제보" width="27" class="hov"></i>실명제보</a>
    <a href="/csr/right-mng/blind-report/" class="btn btn01"><i><img src="/img/csr/icon_report_blind.png" alt="익명 제보" width="27" class="non-hov"><img src="/img/csr/icon_report_blind_w.png" alt="익명 제보" width="27" class="hov"></i>익명제보</a>
</div>
<form id="fncForm" method="post" action="/front/tip-off/name_report_proc.php" enctype="multipart/form-data" onSubmit="return false;">
	<input type="hidden" id="email" name="email_result"/> 
	<div class="report-form">
    	<fieldset>
    		<legend>개인정보처리방침에 대한 동의(필수)</legend>
    		<div class="textbox">
    			<dl>
    				<dt>개인정보의 수집범위</dt>
    				<dd class="ft-16 color-7d">SPC그룹에서 운영하는 “Hot-Line 제보”에 다음과 같은 정보를 수집하고 있습니다.<br>수집항목 : 이름, 메일 주소, 연락처</dd>
    				<dt>개인정보의 수집방법</dt>
    				<dd class="ft-16 color-7d">개인정보처리방침」내용을 통해 「동의」 또는「동의하지 않음」를 선택할 수 있는 절차를 마련하고,<br>「동의한다」 체크박스를 클릭하면 개인정보 수집에 대해 동의한 것으로 봅니다.</dd>
    			</dl>
    		</div>
    		<!-- 관리자페이지에서 이 처리방침 저장하는 게 필요할 것 같습니다. 법적인 문제로 수정이 편해야될 것 같아요 -->
    		<div class="form-chkbox">
    			<span class="chkbox-label">
        			<input type="checkbox" id="privacyAgree"/><label for="privacyAgree" class="ft-20">동의</label>
    			</span>
    		</div>
    	</fieldset>
	</div>
	<div class="report-form">
    	<fieldset>
    		<legend>제보 내용</legend>
    		<div class="table">
    			<div class="pop-th"><label for="subject" >제목</label></div>
    			<div class="pop-td"><input type="text" id="subject" name="title" class="notempty" data-name="제목" placeholder="제목 입력"></div>
    		</div>
    		<div class="table">
    			<div class="pop-th"><label for="cont">내용</label></div>
    			<div class="pop-td">
    				<div class="placeholder-wrap">
    					<div class="placeholder ft-16">*제보내용은 사실에 근거하여 육하원칙(누가, 언제, 어디서, 무엇을, 어떻게, 왜)에 따라 가급적 구체적으로 작성 부탁드립니다.<br>**제품 및 서비스 불만과 건의사항은 고객센터로 전달되어 처리됩니다.</div>
        				<textarea id="cont" name="contents" class="notempty" data-name="내용"></textarea>
    				</div>
				</div>
    		</div>
    		<div class="table">
    			<div class="pop-th"><label for="uploadFile">첨부파일</label></div>
    			<div class="pop-td">
    				<div class="form-file">
    					<input type="text" class="input-narrow" id="fakeFileName" readonly placholder="파일 선택">
    					<span class="file-btn">
    						<span class="btn btn02 on">파일선택<img src="/img/csr/icon_plus_w.png" alt="" width="15"></span>
        					<input type="file" id="uploadFile" name="file[]">
    					</span>
					</div>
					<p class="form-notice color-s ft-15">50mb 이하만 가능</p>
				</div>
    		</div>
    	</fieldset>
	</div>
	<div class="report-form">
    	<fieldset>
    		<legend>제보자</legend>
    		<div class="table">
    			<div class="pop-th"><label for="name">성명</label></div>
    			<div class="pop-td"><input type="text" class="input-narrow" id="name" name="name" class="notempty" data-name="성명" placeholder="성명 입력"></div>
    		</div>
    		<div class="table">
    			<div class="pop-th"><label for="phone01">연락처</label></div>
    			<div class="pop-td">
    				<div class="phone-row">
    					<div class="table">
        					<div>
            					<div class="select">
    								<p><strong>선택</strong></p>
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
                				<input id="phone02" name="tel2" type="text" maxlength="4" class="notempty" data-name="연락처">
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
        			<div class="pop-th"><label for="email1">이메일</label></div>
        			<div class="pop-td">
        				<div class="email-row table">
							<div>
								<div class="table">
									<div><input type="text" placeholder="이메일 입력" id="email1" name="email1" class="notempty" data-name="이메일"></div>
									<div class="data-hi">@</div>
									<div><input type="text" id="email-list" placeholder="직접입력시" name="email2" class="notempty" data-name="이메일"></div>
								</div>
							</div>
							<div>
								<div class="select">
									<p><strong>직접입력</strong></p>
									<ul>
										<li data-id="1"><a>직접입력</a></li>
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
        		</div>
    			<div class="table">
    				<div class="pop-th"><label for="password">비밀번호</label></div>
    				<div class="pop-td"><input type="password" id="password" name="password" placeholder="비밀번호 입력" class="notempty input-mid" data-name="비밀번호">
    					<p class="form-notice color-s ft-15">비밀번호 규칙 : 숫자+영문 혼용 10자 이상</p>
					</div>
    			</div>
    		<div class="form-radio-wrap">
    			<div class="in-bl-th">※ 제보 관련하여 유선 상담 가능여부</div>
    			<div class="in-bl-td">
        			<div class="form-radio">
        				<span class="radio-label">
                			<input type="radio" id="tel_y" name="tel_yn" value="Y" class="regular-radio" checked=""><label for="tel_y"><span>Yes</span></label>
        				</span>
        				<span class="radio-label">
    	        			<input type="radio" id="tel_n" name="tel_yn" value="N" class="regular-radio"><label for="tel_n"><span>No</span></label>
        				</span>
        			</div>
    			</div>
    		</div>
    	</fieldset>
	</div>
	<div class="report-form">
    	<fieldset>
    		<legend>제보 관련 추가 질문</legend>
    		<div class="table">
    			<div class="pop-th"><label for="addCont">내용</label></div>
    			<div class="pop-td">
    				<div class="placeholder-wrap">
        				<div class="placeholder ft-16">*이 문제를 알거나, 알 것으로 예상되는 사람들을 적어주십시오<br>*이 문제를 확인/조사하기 위해 가장 좋은 방법으로 생각되는 것을 적어주십시오</div>
        				<textarea id="addCont" name="add_answer"></textarea>
    				</div>
    			</div>
    		</div>
    	</fieldset>
	</div>
	<div class="btn-wrap">
		<a href="http://spcweb.musign.co.kr/csr/right-mng/tip-off-intro/" class="btn btn01">취소하기</a>
		<a href="javascript:fncSubmit();" class= "btn btn02" >등록하기</a>
	</div>
</form>

<!-- id랑 name 값은 임의로 넣었으니 알아서 잘 바꿔주세용 -->