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
	    			location.href="/csr/right-mng/complete/?lang=en";
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
    <a href="/csr/right-mng/name-report/?lang=en" class="btn btn02 on"><i><img src="/img/csr/icon_report_name.png" alt="Real name report" width="27" class="non-hov"><img src="/img/csr/icon_report_name_w.png" alt="Real name report" width="27" class="hov"></i>Real name report</a>
    <a href="/csr/right-mng/blind-report/?lang=en" class="btn btn01"><i><img src="/img/csr/icon_report_blind.png" alt="anonymous report" width="27" class="non-hov"><img src="/img/csr/icon_report_blind_w.png" alt="anonymous report" width="27" class="hov"></i>anonymous report</a>
</div>
<form id="fncForm" method="post" action="/front/tip-off/name_report_en_proc.php" enctype="multipart/form-data" onSubmit="return false;">
	<input type="hidden" id="email" name="email_result"/> 
	<div class="report-form">
    	<fieldset>
    		<legend>Consent to privacy policy (required)</legend>
    		<div class="textbox">
    			<dl>
    				<dt>Scope of personal information collected</dt>
    				<dd class="ft-16 color-7d">“Hot-Line Report” operated by SPC Group collects the following information.<br>Collected items: name, e-mail address, contact information</dd>
    				<dt>How to Collect Personal Information</dt>
    				<dd class="ft-16 color-7d">A procedure that allows a user to choose between 'I agree' or 'I do not agree' is established in 'Privacy Policy'. If you click the 'I agree' checkbox, you are deemed to consent to the collection of personal information.</dd>
    			</dl>
    		</div>
    		<!-- 관리자페이지에서 이 처리방침 저장하는 게 필요할 것 같습니다. 법적인 문제로 수정이 편해야될 것 같아요 -->
    		<div class="form-chkbox">
    			<span class="chkbox-label">
        			<input type="checkbox" id="privacyAgree"/><label for="privacyAgree" class="ft-20">I Agree</label>
    			</span>
    		</div>
    	</fieldset>
	</div>
	<div class="report-form">
    	<fieldset>
    		<legend>Reports Details</legend>
    		<div class="table">
    			<div class="pop-th"><label for="subject" >Subject</label></div>
    			<div class="pop-td"><input type="text" id="subject" name="title" class="notempty" data-name="Subject" placeholder="Enter Subject"></div>
    		</div>
    		<div class="table">
    			<div class="pop-th"><label for="cont">Content</label></div>
    			<div class="pop-td">
    				<div class="placeholder-wrap">
    					<div class="placeholder ft-16">*Please be as specific as possible with the report content based on facts and in accordance with the 5W1H (who, when, where, what, how, why).<br>**제품 및 서비스 불만과 건의사항은 고객센터로 전달되어 처리됩니다.</div>
        				<textarea id="cont" name="contents" class="notempty" data-name="Content"></textarea>
    				</div>
				</div>
    		</div>
    		<div class="table">
    			<div class="pop-th"><label for="uploadFile">Attachments</label></div>
    			<div class="pop-td">
    				<div class="form-file">
    					<input type="text" class="input-narrow" id="fakeFileName" readonly placholder="파일 선택">
    					<span class="file-btn">
    						<span class="btn btn02 on">Select file(s)<img src="/img/csr/icon_plus_w.png" alt="" width="15"></span>
        					<input type="file" id="uploadFile" name="file[]">
    					</span>
					</div>
					<p class="form-notice color-s ft-15">50MB or less</p>
				</div>
    		</div>
    	</fieldset>
	</div>
	<div class="report-form">
    	<fieldset>
    		<legend>Informant</legend>
    		<div class="table">
    			<div class="pop-th"><label for="name">Name</label></div>
    			<div class="pop-td"><input type="text" class="input-narrow" id="name" name="name" class="notempty" data-name="Name" placeholder="Enter your name"></div>
    		</div>
    		<div class="table">
    			<div class="pop-th"><label for="phone01">Contact</label></div>
    			<div class="pop-td">
    				<div class="phone-row">
    					<div class="table">
        					<div>
            					<div class="select">
    								<p><strong>Select</strong></p>
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
                				<input id="phone02" name="tel2" type="text" maxlength="4" class="notempty" data-name="Contact">
        					</div>
        					<div class="data-hi">-</div>
        					<div>
            					<input id="phone03" name="tel3" type="text" maxlength="4" class="notempty" data-name="Contact">
        					</div>
    					</div>
    				</div>
    			</div>
    		</div>
        		<div class="table">
        			<div class="pop-th"><label for="email1">E-mail</label></div>
        			<div class="pop-td">
        				<div class="email-row">
        					<div class="table">
                    			<div><input type="text" placeholder="Enter your email" name="email1" class="notempty" data-name="E-mail"></div>
                    			<div class="data-hi">@</div>
                    			<div><input type="text" id="email-list" placeholder="Direct input" name="email2" class="notempty" data-name="E-mail"></div>
        					</div>
        					<div class="select">
								<p><strong>Direct input</strong></p>
								<ul>
									<li data-id="1"><a>Direct input</a></li>
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
    				<div class="pop-th"><label for="password">Password</label></div>
    				<div class="pop-td"><input type="password" id="password" name="password" placeholder="Enter a password" class="notempty input-mid" data-name="Password">
    					<p class="form-notice color-s ft-15">Password rules: more than 10 characters mixing numbers + English letters</p>
					</div>
    			</div>
    		<div class="form-radio-wrap">
    			<div class="in-bl-th">※ Whether phone consultation is possible regarding the report</div>
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
    		<legend>Additional questions related to the report</legend>
    		<div class="table">
    			<div class="pop-th"><label for="addCont">Content</label></div>
    			<div class="pop-td">
    				<div class="placeholder-wrap">
        				<div class="placeholder ft-16">*Please list people who know or are expected to know about this issue.<br>*Please write what you think is the best way to check/investigate this issue.</div>
        				<textarea id="addCont" name="add_answer"></textarea>
    				</div>
    			</div>
    		</div>
    	</fieldset>
	</div>
	<div class="btn-wrap">
		<a href="http://spcweb.musign.co.kr/csr/right-mng/tip-off-intro/?lang=en" class="btn btn01">Cancel</a>
		<a href="javascript:fncSubmit();" class= "btn btn02" >Register</a>
	</div>
</form>

<!-- id랑 name 값은 임의로 넣었으니 알아서 잘 바꿔주세용 -->