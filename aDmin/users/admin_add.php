<?php
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/admin_header.php");
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/admin_lnb.php");
?>

<script type="text/javascript">
    $(document).ready(function(){
        $('body').addClass('admin');

        $( "#menu01-1" ).click( function() {
            $( "#menu01-2,#menu01-3,#menu01-4,#menu01-5" ).prop( 'checked', this.checked );
          } );

        $( "#menu02-1" ).click( function() {
            $( "#menu02-2,#menu02-3,#menu02-4,#menu02-5,#menu02-6" ).prop( 'checked', this.checked );
          } );

        $( "#menu04-1" ).click( function() {
            $( "#menu04-2,#menu04-3,#menu04-4" ).prop( 'checked', this.checked );
          } );

        $( "#menu05-1" ).click( function() {
            $( "#menu05-2,#menu05-3" ).prop( 'checked', this.checked );
          } );

        $( "#menu06-1" ).click( function() {
            $( "#menu06-2" ).prop( 'checked', this.checked );
          } );
        
    });

function fncSubmit()
{
	// 비밀번호 형식 검사
	var pw = $("#pw").val();
	var id = $("#id").val();
    var checkNumber = pw.search(/[0-9]/g);
    var checkEnglish = pw.search(/[a-z]/ig);

	if($("#id").val() == "") {
		alert('아이디를 입력해주세요.');
		$("#id").focus();
	    return;
	    
	}else if(!/^(?=.*[a-zA-Z])(?=.*[0-9]).{8,25}$/.test(pw)){            
	    alert('비밀번호는 숫자+영문자 조합으로 8자리 이상 사용해야 합니다.');
	    $("#pw").val('');
		$("#pw").focus();
	    return;
	    
	}else if(checkNumber <0 || checkEnglish <0){
	    alert("숫자와 영문자를 혼용하여야 합니다.");
	    $("#pw").val('');
		$("#pw").focus();
	    return;
	    
	}else if(/(\w)\1\1/.test(pw)){
	    alert('같은 문자를 3번 이상 사용하실 수 없습니다.');
	    $("#pw").val('');
		$("#pw").focus();
	    return;
	    
	}else if(pw.search(id) > -1){
	    alert("비밀번호에 아이디가 포함되었습니다.");
	    $("#pw").val('');
		$("#pw").focus();
	    return;
	}

	if($("#pw").val() != $("#re_pw").val()){
		alert("비밀번호를 확인해주세요");
		$("#re_pw").val('');
		$("#re_pw").focus();
		validationFlag = "N";
		return false;
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

	var sel_chmod = "";
	sel_chmod = $("#chmod option:selected").val();
	
	if(validationFlag == "Y")
	{
		$("#fncForm").ajaxSubmit({
			data   : {
				chmod : sel_chmod
			},
			success: function(data)
			{
				console.log(data);
				var result = JSON.parse(data);
	    		if(result.isSuc == "success")
	    		{
	    			alert("저장되었습니다.");
	    			location.href="/aDmin/users/admin_list.php";
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

<div id="container" class="review write">
	<div class="search">
		<p>관리자 등록</p>		
	</div>
	<form id="fncForm"  method="post" action="admin_add_proc.php" enctype="multipart/form-data" onSubmit="return false;">	
	<div class="write_cont_box">
		<div class="write_cont">
			<div>
				<div class="write_li_add">
					<p class="write_cont_tit">관리자명</p>
                    <input type="text" id="name" name="name" class="info_area notempty" data-name="관리자명" placeholder="관리자명">
				</div>
				<div class="write_li_file">
					<p class="write_cont_tit">휴대폰 번호</p>
					<input type="text" id="tel" name="tel" class="info_area r_margin notempty" data-name="휴대폰 번호" placeholder="휴대폰 번호">
                    <p class="write_cont_tit tit_margin">사무실 번호</p>
                    <input type="text" id="corp_tel" name="corp_tel" class="info_area notemtpy" data-name="사무실 번호" placeholder="사무실 번호">
				</div>
				<div class="write_li_file">
					<p class="write_cont_tit">아이디</p>
					<input type="text" id="id" name="id" class="info_area r_margin notemtpy" data-name="아이디" placeholder="아이디">
                    <p class="write_cont_tit tit_margin">이메일</p>
                    <input type="text" id="email" name="email" class="info_area notemtpy" data-name="이메일"  placeholder="이메일">
				</div>   
				<div class="write_li_file">
					<p class="write_cont_tit">비밀번호</p>
					<input type="password" id="pw" name="pw" class="info_area r_margin notemtpy" data-name="비밀번호" placeholder=""><br><br>
					<p class="write_cont_tit mar_top">비밀번호 확인</p>
					<input type="password" id="re_pw" name="re_pw" class="info_area r_margin notemtpy" data-name="비밀번호 확인" placeholder=""><br>
					<span class="pass_desc">* 보안을 위해 아래와 같이 비밀번호를 설정해 주세요.<br>
							영문+숫자 10자~20자로 사용가능하며, 특수문자 !@#$%^&*()_+|[]{}'";:/?.>,< 의 사용이 불가능합니다.<br>
							아이디와 3자 이상 중복하거나, 3자 이상 연속 또는 중복되는 문자, 숫자는 사용할 수 없으며, 공백도 사용할 수 없습니다.<br>
							영문(대소문자 구분), 특수기호를 혼합하여 비밀번호를 설정하면, 더욱 안전한 비밀번호를 만드실 수 있습니다.</span>
				</div>
				<div class="write_li_file">
					<p class="write_cont_tit">사용권한</p>
					<select id="chmod" class="serch_cont_sort" value="chmod" >
				        <option value="마스터">마스터</option>
				        <option value="일반관리자">일반 관리자</option>
				    </select> 
				</div>              
				<div class="write_li_file write_check">
					<p class="write_cont_tit">메뉴 권한</p>
					<div class="menu_check">
						<input type="checkbox" id="menu01-1" name="media_yn" value="Y" class="regular-radio"><label for="menu01-1"><span>MEDIA HUB</span></label><br>
						<input type="checkbox" id="menu01-2" name="news_yn" value="Y" class="regular-radio"><label for="menu01-2"><span>보도자료</span></label><br>
						<input type="checkbox" id="menu01-3" name="magazine_yn" value="Y" class="regular-radio"><label for="menu01-3"><span>SPC매거진</span></label><br>
						<input type="checkbox" id="menu01-4" name="sns_yn" value="Y" class="regular-radio"><label for="menu01-2"><span>SNS</span></label><br>
						<input type="checkbox" id="menu01-5" name="cf_yn" value="Y" class="regular-radio"><label for="menu01-3"><span>CF</span></label>
					</div>		
					<div class="menu_check">
						<input type="checkbox" id="menu02-1" name="csr_yn" value="Y" class="regular-radio"><label for="menu02-1"><span>ESR</span></label><br>
						<input type="checkbox" id="menu02-2" name="notice_yn" value="Y" class="regular-radio"><label for="menu02-2"><span>공지사항</span></label><br>
						<input type="checkbox" id="menu02-3" name="financial_yn" value="Y" class="regular-radio"><label for="menu02-3"><span>재정보고</span></label><br>
						<input type="checkbox" id="menu02-4" name="newsletter_yn" value="Y" class="regular-radio"><label for="menu02-4"><span>뉴스레터</span></label><br>
						<input type="checkbox" id="menu02-5" name="review_yn" value="Y" class="regular-radio"><label for="menu02-5"><span>참여후기</span></label><br>
						<input type="checkbox" id="menu02-6" name="social_yn" value="Y" class="regular-radio"><label for="menu02-6"><span>사회공헌</span></label>
					</div>	
					<div class="menu_check">
						<input type="checkbox" id="menu03" name="nagation_yn" value="Y" class="regular-radio"><label for="menu03"><span>부정제보 관리</span></label>
					</div>	
					<div class="menu_check">
						<input type="checkbox" id="menu04-1" name="type_yn" value="Y" class="regular-radio"><label for="menu04-1"><span>브랜드&계열사 관리</span></label><br>
						<input type="checkbox" id="menu04-2" name="cate_yn" value="Y" class="regular-radio"><label for="menu04-2"><span>카테고리 관리</span></label><br>
						<input type="checkbox" id="menu04-3" name="brand_yn" value="Y" class="regular-radio"><label for="menu04-3"><span>브랜드 등록</span></label><br>
						<input type="checkbox" id="menu04-4" name="sub_yn" value="Y" class="regular-radio"><label for="menu04-4"><span>계열사 등록</span></label>
					</div>	
					<div class="menu_check">
						<input type="checkbox" id="menu05-1" name="manage_yn" value="Y" class="regular-radio"><label for="menu05-1"><span>계정 관리</span></label><br>	
						<input type="checkbox" id="menu05-2" name="adlist_yn" value="Y" class="regular-radio"><label for="menu05-2"><span>관리자 리스트</span></label><br>	
						<input type="checkbox" id="menu05-3" name="iplist_yn" value="Y" class="regular-radio"><label for="menu05-3"><span>IP 관리</span></label>
					</div>
					<div class="menu_check">
						<input type="checkbox" id="menu06-1" name="popup_yn" value="Y" class="regular-radio"><label for="menu06-1"><span>팝업 관리</span></label><br>
						<input type="checkbox" id="menu06-2" name="popup_list" value="Y" class="regular-radio"><label for="menu06-2"><span>팝업 리스트</span></label><br>	
					</div>						
				</div>
			</div>
		</div>
		</form>
		<div class="write_bt">
			<ul>
				 <li><a href="/aDmin/users/admin_list.php" class="bt_cont">취소</a></li>
				 <li><a href="javascript:fncSubmit();" class="bt_cont">등록</a></li>
			</ul>
		</div>
	</div>

</div>
<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/admin_footer.php");
?>