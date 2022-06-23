<script src="/aDmin/js/jquery-1.12.4.js"></script>
<script src="/aDmin/js/jquery.min.js"></script> 
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
	    			location.href="http://spcweb.musign.co.kr/csr/right-mng/complete/?lang=en";
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
                    	<h3 class="ft-35">Guidelines for Anonymous Reporting</h3>
                	</div>
                	<p class="ft-16 color-7d">For a smooth investigation, the person in charge of reporting may contact you through the bulletin board. We advise you to keep the report confirmation ID and password when entering the report, and then check it by periodically accessing the ‘Report Process Results’.</p>
                    <a href="#close" class="global-cls">Close</a>
            	</div>
            </div>
        </div>
    </div>
</div>
<!-- //사전 고지 팝업 끝 -->
<div class="report-top-btn">
    <a href="/csr/right-mng/name-report/?lang=en" class="btn btn01"><i><img src="/img/csr/icon_report_name.png" alt="Real name report" width="27" class="non-hov"><img src="/img/csr/icon_report_name_w.png" alt="Real name report" width="27" class="hov"></i>Real name report</a>
    <a href="/csr/right-mng/blind-report/?lang=en" class="btn btn02 on"><i><img src="/img/csr/icon_report_blind.png" alt="anonymous report" width="27" class="non-hov"><img src="/img/csr/icon_report_blind_w.png" alt="anonymous report" width="27" class="hov"></i>anonymous report</a>
</div>
<form id="fncForm" method="post" action="/front/tip-off/blind_report_en_proc.php" enctype="multipart/form-data" onSubmit="return false;">
	<?php 
	   $randomNum = mt_rand(100000, 999999);
	?>
	<input type="hidden" name="blind_id" value="<?php echo $randomNum?>">
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
    					<div class="placeholder ft-16">*Please be as specific as possible with the report content based on facts and in accordance with the 5W1H (who, when, where, what, how, why).<br>**If you have related data (photos, documents, evidence, etc.), please attach them. It will be very helpful for the investigation.</div>
        				<textarea id="cont" name="contents" class="notempty" data-name="Content"></textarea>
    				</div>
				</div>
    		</div>
    		<div class="table">
    			<div class="pop-th"><label for="uploadFile">Attachments</label></div>
    			<div class="pop-td">
    				<div class="form-file">
    					<input type="text" class="input-narrow" id="fakeFileName" readonly placholder="Select file(s)">
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
    		<legend>Additional questions related to the report</legend>
    		<div class="table">
    			<div class="pop-th"><label for="addCont">Content</label></div>
    			<div class="pop-td">
    				<div class="placeholder-wrap">
        				<div class="placeholder ft-16">*Please list people who know or are expected to know about this issue.<br>*Please write what you think is the best way to check/investigate this issue.</div>
        				<textarea id="addCont" name="add_answer" class="notempty" data-name="Content"></textarea>
    				</div>
				</div>
    		</div>
    		<div class="table">
    			<div class="pop-th"><label for="password">Password</label></div>
    			<div class="pop-td">
    				<input type="password" id="password" class="input-mid" name="password" placeholder="Enter a password" class="notempty" data-name="비밀번호">
    				<p class="form-notice color-s ft-15">Password rules: more than 10 characters mixing numbers + English letters</p>
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