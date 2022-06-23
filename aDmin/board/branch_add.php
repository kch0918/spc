<?php
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/admin_header.php");
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/admin_lnb.php");
?>
<script>
function fncSubmit()
{

	var sub_type = "";
	sub_type = $("#sub_type").val();
	
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
			data : {
				sub_type : sub_type,
			},
			success: function(data)
			{
				console.log(data);
				var result = JSON.parse(data);
	    		if(result.isSuc == "success")
	    		{
	    			alert("저장되었습니다.");
	    			location.href="/aDmin/board/branch.php";
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

<div id="container" class="brand write bt-add">
	
	<div class="search">
		<p>계열사 상세페이지 등록</p>
		<div class="seacrh_info">
			<div class="search_top write_search">
				<div class="search_txt">카테고리 연결</div>
				<div class="def">
					<select>
						<option value="">계열사</option>
					</select>
					<select id="sub_type" name="sub_type">
						<option>계열사 선택</option>
    					<?php
    					$query = "select * from SPC_BIG_CATE where cate_type ='subsidiary'";
    					$brand_result = sql_query($query);
    					
                        for ($i = 0; $i < sql_count($brand_result); $i ++) {
                            $brand_row = sql_fetch($brand_result);
                            ?>
                       <option value="<?php echo $brand_row['idx']?>"><?php echo $brand_row['cate_brand_kr']?></option>
    					<?php
                            }
                            ?>
    				</select>
				</div>
			</div>			
		</div>
	</div>
	<div class="write_cont_box">
		<form id="fncForm" name="fncForm" method="post" action="branch_add_proc.php" enctype="multipart/form-data" onSubmit="return false;">
		<div class="write_cont">
				<div class="write_li_tit ">
					<p class="write_cont_tit ver_middle">제목</p>
					<input type="text" id="" name="title" class="tit_area notempty" data-name="제목" placeholder="여기에 제목을 입력하세요">
				</div>
				<div class="write_li_cont">
					<p class="write_cont_tit">내용</p>
					<input type="text" class="write_area notempty" name="contents" data-name="내용" value=''></div>
				</div>
				<div class="write_li_file">
					<p class="write_cont_tit">상단 이미지</p>
					<div class="write_cont_inline">
						<div class="file_in_add">
							<span class="upload-name file_area" placeholder="500MB 이내로 업로드" ></span>
		                    <input type="file" id="upload" name="top_img_sub[]" class="upload-hidden notempty" data-name="상단 이미지" ><label for="upload" class="file_bt bt_up" multiple="multiple" aria-invalid="false">업로드</label>                    
		                    <a href="#" class="bt_add">추가</a>
						</div>
					</div>
				</div>
				<div class="write_li_file">
					<p class="write_cont_tit">본문 이미지</p>
					<div class="write_cont_inline2">
						<div class="file_in_add2">						
							<span class="upload-name file_area" placeholder="500MB 이내로 업로드"></span>
		                    <input type="file" id="upload00" name="cont_img_sub[]" class="upload-hidden notempty" data-name="본문 이미지"><label for="upload00" class="file_bt bt_up" multiple="multiple" aria-invalid="false">업로드</label>
		                    <a href="#" class="bt_add2">추가</a>
	                	</div>
					</div>					
				</div>
					<div class="write_li_file">
					<p class="write_cont_tit">본문 이미지</p>
					<div class="write_cont_inline3">
						<div class="file_in_add3">						
							<span class="upload-name file_area" placeholder="500MB 이내로 업로드"></span>
		                    <input type="file" id="upload01" name="cont_img2_sub[]" class="upload-hidden notempty" data-name="본문 이미지2"><label for="upload01" class="file_bt bt_up" multiple="multiple" aria-invalid="false">업로드</label>
		                    <a href="#" class="bt_add3">추가</a>
	                	</div>
					</div>					
				</div>
				<div class="write_li_file">
					<p class="write_cont_tit ver_middle">대표이사</p>
					<input type="text" name="ceo" class="file_area notempty" data-name="대표이사" placeholder="텍스트 입력">
				</div>
				<div class="write_li_file">
					<p class="write_cont_tit ver_middle">회사명</p>
					<input type="text" name="corp" class="file_area notempty" data-name="회사명" placeholder="텍스트 입력">
				</div>
				<div class="write_li_file">
					<div class="adress_box">
						<p class="write_cont_tit ver_middle">주소 1</p>
						<input type="text" name="addr" class="file_area notempty" data-name="주소 " placeholder="텍스트 입력">
	                    <a href="#" class="bt_add bt_site_add">추가</a>
                	</div>
				</div>
				<div class="write_li_file">
					<p class="write_cont_tit ver_middle">홈페이지 주소</p>
					<input type="text" name="home_url" class="file_area notempty" data-name="홈페이지 주소 " placeholder="URL 입력">
				</div>
				<div class="write_check">
					<p class="write_cont_tit">노출 여부</p>
					<ul class="check_wrap">
    					<li><input type="radio" id="show" name="exposure_yn" value="Y" class="regular-radio" checked=""><label for="show"><span>노출</span></label></li>
    					<li><input type="radio" id="noshow" name="exposure_yn" value="N" class="regular-radio"><label for="noshow"><span>미노출</span></label></li>
					</ul>
				</div>
			</form>
		</div>
		<div class="write_bt">
			<ul>
				<li><a href="/aDmin/board/branch.php" class="bt_cont">목록</a></li>
				<li><a href="" class="bt_cont">임시저장</a></li>
				<li><a href="javascript:fncSubmit();" class="bt_cont">등록</a></li>
			</ul>
		</div>
	</div>

</div>
<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/admin_footer.php");
?>