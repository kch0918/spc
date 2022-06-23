<?php
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/admin_header.php");
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/admin_lnb.php");
?>

<script type="text/javascript">
	$(document).ready(function(){
    	$('body').addClass('admin');
	});
	function fncSubmit()
	{
		// 비밀번호 형식 검사
		var pw = $("#pw").val();
		var id = "<?php echo $_SESSION['id']?>";
	    var checkNumber = pw.search(/[0-9]/g);
	    var checkEnglish = pw.search(/[a-z]/ig);

		if($("#id").val() == "" && !id_regExp.test($("#id").val())) {
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
		    
		}else if(/(\w)\1\1\1/.test(pw)){
		    alert('같은 문자를 4번 이상 사용하실 수 없습니다.');
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
		
// 		var sel_chmod = "";
// 		sel_chmod = $("#chmod option:selected").val();
		
		var validationFlag = "Y";
		$(".notEmpty").each(function()
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
// 				data : {
// 					chmod : sel_chmod
// 				},
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
		<p>마이페이지</p>		
	</div>
	<form id="fncForm"  method="post" action="mypage_proc.php" onSubmit="return false;">	
	<div class="write_cont_box">
		<div class="write_cont">
			<div>
				<div class="write_li_add">
					<p class="write_cont_tit">관리자명</p>
                    <input type="text" id="" name="name" class="info_area" placeholder="관리자명" value="<?php echo $_SESSION['name']?>">
				</div>
				<div class="write_li_file">
					<p class="write_cont_tit">휴대폰 번호</p>
					<input type="text" id="" name="tel" class="info_area r_margin" placeholder="휴대폰 번호" value="<?php echo $_SESSION['tel']?>">
                    <p class="write_cont_tit tit_margin">사무실 번호</p>
                    <input type="text" id="" name="corp_tel" class="info_area" placeholder="사무실 번호" value="<?php echo $_SESSION['corp_tel']?>">
				</div>
				<div class="write_li_file">
					<p class="write_cont_tit">아이디</p>
					<input type="text" id="id" name="id" class="info_area r_margin" placeholder="아이디" value="<?php echo $_SESSION['id']?>">
                    <p class="write_cont_tit tit_margin">이메일</p>
                    <input type="text" id="" name="email" class="info_area" placeholder="이메일" value="<?php echo $_SESSION['email']?>">
				</div>   
				<div class="write_li_file">
					<p class="write_cont_tit">비밀번호</p>
					<input type="password" id="pw" name="pw" class="info_area r_margin" placeholder=""><br><br>
					<p class="write_cont_tit mar_top">비밀번호 확인</p>
					<input type="password" id="re_pw" name="re_pw" class="info_area r_margin" placeholder=""><br>
					<span class="pass_desc">* 보안을 위해 아래와 같이 비밀번호를 설정해 주세요.<br>
							영문+숫자 10자~20자로 사용가능하며, 특수문자 !@#$%^&*()_+|[]{}'";:/?.>,<의 사용이 불가능합니다.<br>
							아이디와 3자 이상 중복하거나, 3자 이상 연속 또는 중복되는 문자, 숫자는 사용할 수 없으며, 공백도 사용할 수 없습니다.<br>
							영문(대소문자 구분), 특수기호를 혼합하여 비밀번호를 설정하면, 더욱 안전한 비밀번호를 만드실 수 있습니다.</span>
				</div> 
				<div class="write_li_file">
					<p class="write_cont_tit">사용권한</p>
					<select class="serch_cont_sort" name="chmod" id="chmod">
				        <option><?php echo $_SESSION['chmod']?></option>
				    </select> 
				</div>
			</div>
		</div>
		</form>
		<div class="write_bt">
			<ul>
				<li><a href="/aDmin/users/admin_list.php" class="bt_cont">목록</a></li>
		        <li><a href="javascript:fncSubmit();" class="bt_cont">등록</a></li>
			</ul>
		</div>
	</div>

</div>
<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/admin_footer.php");
?>