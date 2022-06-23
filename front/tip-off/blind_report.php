<script src="/aDmin/js/jquery-1.12.4.js"></script>
<script src="/aDmin/js/jquery-ui.js"></script> 
<link rel="stylesheet" href="/js/jquery-ui.css" type="text/css" />
<script src="/aDmin/js/malsup.js"></script>
<script type="text/javascript" src="/aDmin/include/ckeditor/ckeditor.js"></script>
<script>

var maxFileSize = 50 * 1024 * 1024; //바이트 단위

$(document).ready(function(){
	$('.global-popwr, .global-pop').show();

	$('.global-cls').click(function(e){
		e.preventDefault();
		$(this).closest('.global-pop').hide();
		$('.global-popwr').hide();
	});
	
	$(".email-row").each(function(){
		$(".select").find("li").click(function(){
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
	// 비밀번호 형식 검사
	var pw = $("#password").val();
    var checkNumber = pw.search(/[0-9]/g);
    var checkEnglish = pw.search(/[a-z]/ig);
    var title = $("#subject").val();
  
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
			success: function(data)
			{
				console.log(data);
				var result = JSON.parse(data);
	    		if(result.isSuc == "success")
	    		{
	    			alert("저장되었습니다.");
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

<!-- 사전 고지 팝업 -->
<div class="global-popwr">
	<div class="global-bg"></div>
    <div class="global-pop report-pop" tabindex="0">
        <div class="gpop-wr">
            <div>
            	<div class="blind-notice">
                	<div class="pop-h2">
                    	<h3 class="ft-35">익명제보 시 안내사항</h3>
                	</div>
                	<p class="ft-16 color-7d">원활한 조사를 위해 제보 담당자가 해당 게시판을 통해 연락드릴 수 있으니<br>제보 입력시에  제보확인 ID와 비밀번호를 기록하셨다가<br>‘제보처리결과’에 주기적으로 접속하시어  확인하시길 당부 드립니다.</p>
                    <a href="#close" class="global-cls">Close</a>
            	</div>
            </div>
        </div>
    </div>
</div>
<!-- //사전 고지 팝업 끝 -->
<div class="report-top-btn">
    <a href="/csr/right-mng/name-report/" class="btn btn01"><i><img src="/img/csr/icon_report_name.png" alt="실명 제보" width="27" class="non-hov"><img src="/img/csr/icon_report_name_w.png" alt="실명 제보" width="27" class="hov"></i>실명제보</a>
    <a href="/csr/right-mng/blind-report/" class="btn btn02 on"><i><img src="/img/csr/icon_report_blind.png" alt="익명 제보" width="27" class="non-hov"><img src="/img/csr/icon_report_blind_w.png" alt="익명 제보" width="27" class="hov"></i>익명제보</a>
</div>
<form id="fncForm" method="post" action="/front/tip-off/blind_report_proc.php" enctype="multipart/form-data" onSubmit="return false;">
	<?php 
	   $randomNum = mt_rand(100000, 999999);
	?>
	<input type="hidden" name="blind_id" value="<?php echo $randomNum?>">
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
    					<div class="placeholder ft-16">*제보내용은 사실에 근거하여 육하원칙(누가, 언제, 어디서, 무엇을, 어떻게, 왜)에 따라 가급적 구체적으로 작성 부탁드립니다.<br>**관련 자료(사진, 문서, 증빙 등)가 있을 경우 첨부해주시면 제보조사에 많은 도움이 됩니다.</div>
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
    		<legend>제보 관련 추가 질문</legend>
    		<div class="table">
    			<div class="pop-th"><label for="addCont">내용</label></div>
    			<div class="pop-td">
    				<div class="placeholder-wrap">
        				<div class="placeholder ft-16">*이 문제를 알거나, 알 것으로 예상되는 사람들을 적어주십시오<br>*이 문제를 확인/조사하기 위해 가장 좋은 방법으로 생각되는 것을 적어주십시오</div>
        				<textarea id="addCont" name="add_answer" class="notempty" data-name="내용"></textarea>
    				</div>
				</div>
    		</div>
    		<div class="table">
    			<div class="pop-th"><label for="password">비밀번호</label></div>
    			<div class="pop-td">
    				<input type="password" id="password" class="input-mid" name="password" placeholder="비밀번호 입력" class="notempty" data-name="비밀번호">
    				<p class="form-notice color-s ft-15">비밀번호 규칙 : 숫자+영문 혼용 10자 이상</p>
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