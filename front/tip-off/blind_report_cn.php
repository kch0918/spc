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
	    			location.href="http://spcweb.musign.co.kr/csr/right-mng/complete/?lang=zh-hans";
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
                    	<h3 class="ft-35">匿名举报指南</h3>
                	</div>
                	<p class="ft-16 color-7d">为顺利进行调查，举报负责人可能通过本留言板联系您， <br>所以请记住输入举报内容时的举报确认ID和密码，  <br>并定期链接“举报处理结果”进行确认。</p>
                    <a href="#close" class="global-cls">Close</a>
            	</div>
            </div>
        </div>
    </div>
</div>
<!-- //사전 고지 팝업 끝 -->
<div class="report-top-btn">
    <a href="/csr/right-mng/name-report/?lang=zh-hans" class="btn btn01"><i><img src="/img/csr/icon_report_name.png" alt="实名举报" width="27" class="non-hov"><img src="/img/csr/icon_report_name_w.png" alt="实名举报" width="27" class="hov"></i>实名举报</a>
    <a href="/csr/right-mng/blind-report/?lang=zh-hans" class="btn btn02 on"><i><img src="/img/csr/icon_report_blind.png" alt="匿名举报" width="27" class="non-hov"><img src="/img/csr/icon_report_blind_w.png" alt="匿名举报" width="27" class="hov"></i>匿名举报</a>
</div>
<form id="fncForm" method="post" action="/front/tip-off/blind_report_cn_proc.php" enctype="multipart/form-data" onSubmit="return false;">
	<?php 
	   $randomNum = mt_rand(100000, 999999);
	?>
	<input type="hidden" name="blind_id" value="<?php echo $randomNum?>">
	<div class="report-form">
    	<fieldset>
    		<legend>举报内容</legend>
    		<div class="table">
    			<div class="pop-th"><label for="subject" >标题</label></div>
    			<div class="pop-td"><input type="text" id="subject" name="title" class="notempty" data-name="제목" placeholder="输入标题"></div>
    		</div>
    		<div class="table">
    			<div class="pop-th"><label for="cont">内容 </label></div>
    			<div class="pop-td">
    				<div class="placeholder-wrap">
    					<div class="placeholder ft-16">*请根据事实，按照六何原则（何人、何时、何地、何事、何因、如何发生）尽可能具体说明。 <br>** 如附加相关资料（图片、文件、凭证等），将对举报调查有很大的帮助。</div>
        				<textarea id="cont" name="contents" class="notempty" data-name="内容"></textarea>
    				</div>
				</div>
    		</div>
    		<div class="table">
    			<div class="pop-th"><label for="uploadFile">附件</label></div>
    			<div class="pop-td">
    				<div class="form-file">
    					<input type="text" class="input-narrow" id="fakeFileName" readonly placholder="파일 선택">
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
    		<legend>有关举报的补充问题</legend>
    		<div class="table">
    			<div class="pop-th"><label for="addCont">内容</label></div>
    			<div class="pop-td">
    				<div class="placeholder-wrap">
        				<div class="placeholder ft-16">* 请列出知道或预计知道此事件的人 <br>* 请写下您认为确认/调查此事件最好的方法</div>
        				<textarea id="addCont" name="add_answer" class="notempty" data-name="내용"></textarea>
    				</div>
				</div>
    		</div>
    		<div class="table">
    			<div class="pop-th"><label for="password">密码</label></div>
    			<div class="pop-td">
    				<input type="password" id="password" class="input-mid" name="password" placeholder="输入密码 " class="notempty" data-name="密码">
    				<p class="form-notice color-s ft-15">密码规则:混合数字+英文10位以上</p>
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