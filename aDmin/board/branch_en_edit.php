<?php
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/admin_header.php");
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/admin_lnb.php");

$query = "SELECT distinct
                a.idx,
                b.*,
                a.cate_name_en,
                DATE_FORMAT(b.submit_date, '%Y.%m.%d') as submit_date2,
                c.cate_brand_en
          from SPC_MID_CATE a
          join SPC_SUB_BOARD b
          on a.idx = b.parentidx
          JOIN SPC_BIG_CATE c
          ON a.parentidx = c.idx
          WHERE b.parentidx = {$_REQUEST['idx']}
          ";

$result = sql_query($query);
$row = sql_fetch($result);
?>
<script>

$(document).ready(function(){
	CKEDITOR.replace('contents'); 
})

function fncSubmit()
{
	CKEDITOR.instances.contents.updateElement(); 
	
	var sub_type = "";
	sub_type = $("#sub_type").val();
	var validationFlag = "Y";
	
	$(".notEmpty").each(function()
	{ 
// 		if($(this).val() == ""){
// 			alert(this.dataset.name+"을(를) 입력해주세요.");
// 			$(this).focus();
// 			validationFlag = "N";
// 			return false;
// 		}
			
		var el = $(this).prop('tagName');
		console.log(el);
		if (el == "INPUT" && $(this).val() == "") 
		{
			alert(this.dataset.name+"을(를) 입력해주세요.");
			$(this).focus();
			validationFlag = "N";
			return false;
			
		}else if(el == "SPAN" && $(this).text() == ""){
			alert(this.dataset.name+"을(를) 입력해주세요.");
			$(this).focus();
			validationFlag = "N";
			return false;
		}

	})
	
	var top_img = document.querySelectorAll("span.top_img");
	var cont_img = document.querySelectorAll("span.cont_img");
	var cont_img2 = document.querySelectorAll("span.cont_img2");

	console.log(top_img);
	console.log(cont_img);
	console.log(cont_img2);

	// 상단 이미지
	var top_img_arr = [];
	for(var i = 0; i < top_img.length; i++){
		top_img_arr.push(top_img[i].textContent);
	}
	console.log(top_img_arr);
	var now_top_img = top_img_arr.join("|");
	console.log(now_top_img);	
	
	// 본문이미지
	var cont_img_arr = [];
	for(var i = 0; i < cont_img.length; i++){
		cont_img_arr.push(cont_img[i].textContent);
	}
	console.log(cont_img_arr);
	var now_cont_img = cont_img_arr.join("|");
	console.log(now_cont_img);	

	// 로고이미지
	var cont_img2_arr = [];
	for(var i = 0; i < cont_img2.length; i++){
		cont_img2_arr.push(cont_img2[i].textContent);
	}
	console.log(cont_img2_arr);
	var now_cont_img2 = cont_img2_arr.join("|");
	console.log(now_cont_img2);	

	if(validationFlag == "Y")
	{
		$("#fncForm").ajaxSubmit({
			data : {
				sub_type : sub_type,
				now_top_img	  : now_top_img,
				now_cont_img  : now_cont_img,
				now_cont_img2 : now_cont_img2
			},
			success: function(data)
			{
				console.log(data);
				var result = JSON.parse(data);
	    		if(result.isSuc == "success")
	    		{
	    			alert("저장되었습니다.");
	    			location.href="/aDmin/board/branch_en.php";
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
						<option><?php echo $row['cate_brand_en']?></option>
    					<?php
    					$query = "select * from SPC_BIG_CATE where cate_type ='subsidiary'";
    					$brand_result = sql_query($query);
    					
                        for ($i = 0; $i < sql_count($brand_result); $i ++) {
                            $brand_row = sql_fetch($brand_result);
                            ?>
                       <option value="<?php echo $brand_row['idx']?>"><?php echo $brand_row['cate_brand_en']?></option>
    					<?php
                            }
                            ?>
    				</select>
				</div>
			</div>			
		</div>
	</div>
	<div class="write_cont_box">
		<form id="fncForm" name="fncForm" method="post" action="branch_en_edit_proc.php" enctype="multipart/form-data" onSubmit="return false;">
		<input type="hidden" name="prev_top_img" value="<?php echo $row["top_img"]?>">
		<input type="hidden" name="prev_cont_img" value="<?php echo $row["cont_img"]?>">
		<input type="hidden" name="prev_cont_img2" value="<?php echo $row["cont_img2"]?>">
		<div class="write_cont">
<!-- 				<div class="write_li_tit "> 
 					<p class="write_cont_tit ver_middle">제목</p> 
					<input type="text" id="" name="title" class="tit_area notempty" placeholder="여기에 제목을 입력하세요" data-name="제목" value='<?php echo $row['title_en']?>'>
 				</div> -->
				<div class="write_li_cont">
					<p class="write_cont_tit">내용</p>
					<textarea id="contents" name="contents" class="notempty" data-name="내용" value=""><?php echo $row['contents_en']?></textarea>
				</div>
				<?php 
        			$insert = explode("|",$row['top_img']);
        			
        			for ($i = 0; $i < count($insert); $i ++) {
        			?>
				<div class="write_li_file">
					<p class="write_cont_tit">상단 이미지</p>
					<div class="write_cont_inline">
						<div class="file_d file_in_add">
							<span id="top_img" class="upload-name file_area notempty top_img" placeholder="500MB 이내로 업로드" data-name="상단 이미지"><?php echo $insert[$i]?></span>
		                    <input type="file" id="upload<?php echo $i?>" name="top_img[]" class="upload-hidden" multiple='multiple' aria-invalid="false">
		                    <label for="upload<?php echo $i?>" class="file_bt bt_up">업로드</label>                    
	                       <?php 
		                    if($i == 0){
		                    ?>
    		                    <a href="#" class="bt_add">추가</a>
							<?php 		                    
		                    } else {
		                    ?>
                                <a href="#" class="bt_del">삭제</a>
							<?php 
		                    }
		                    ?>
						</div>
					</div>
				</div>
				<div class="write_li_file">
					<p class="write_cont_tit">본문 이미지</p>
				<?php 
        				}
        		  ?>	
        		  
        		<?php 
    			$insert1 = explode("|",$row['cont_img']);
    			
    			for ($i = 0; $i < count($insert1); $i ++) {
    			?> 
				
					<div class="write_cont_inline2">
						<div class="file_d file_in_add2">						
							<span class="upload-name file_area notempty cont_img" placeholder="500MB 이내로 업로드" data-name="본문 이미지"><?php echo $insert1[$i]?></span>
		                    <input type="file" id="upload0<?php echo $i?>" name="cont_img[]" class="upload-hidden" multiple='multiple' aria-invalid="false">
		                    <label for="upload0<?php echo $i?>" class="file_bt bt_up">업로드</label>
		                   <?php 
		                    if($i == 0){
		                    ?>
    		                    <a href="#" class="bt_add2">추가</a>
							<?php 		                    
		                    } else {
		                    ?>
                                <a href="#" class="bt_del">삭제</a>
							<?php 
		                    }
		                    ?>
		                    
		                    
	                	</div>
					</div>	
				<?php 
        				}
        		  ?>

				</div>

				<div class="write_li_file">					
				<p class="write_cont_tit">브랜드 로고</p>				
					<div class="write_cont_inline3">
				<?php 
        			$insert = explode("|",$row['cont_img2']);
        			
        			for ($i = 0; $i < count($insert); $i ++) {
        			?>
						<div class="file_d file_in_add3">						
							<span class="upload-name file_area cont_img2" placeholder="500MB 이내로 업로드" data-name="계열사 로고"><?php echo $insert[$i]?></span>
		                    <input type="file" id="upload0<?php echo $i+1?>" name="cont_img2_sub[]" class="upload-hidden" multiple="multiple" aria-invalid="false">
		                    <label for="upload0<?php echo $i+1?>" class="file_bt bt_up">업로드</label>
						
		                    <?php 
		                    if($i == 0){
		                    ?>
    		                    <a href="#" class="bt_add3">추가</a>
    		                    <a href="#" class="bt_del">삭제</a>
							<?php 		                    
		                    } else {
		                    ?>
                                <a href="#" class="bt_del">삭제</a>
							<?php 
		                    }
		                    ?>
	                	</div>
					<?php 
        				}
        			?>	

					</div>	
				</div>
				<div class="write_li_file">
					<p class="write_cont_tit ver_middle">대표이사</p>
					<input type="text" name="ceo" class="file_area notempty" data-name="대표이사"  placeholder="텍스트 입력" value='<?php echo $row['ceo']?>'>
				</div>
				<div class="write_li_file">
					<p class="write_cont_tit ver_middle">회사명</p>
					<input type="text" name="corp" class="file_area notempty" data-name="회사명" placeholder="텍스트 입력" value='<?php echo $row['corp']?>'>
				</div>
				<div class="write_li_file">
					<p class="write_cont_tit ver_middle">연락처</p>
					<input type="text" id="tel" name="tel" class="file_area notempty" data-name="연락처"  placeholder="텍스트 입력" value='<?php echo $row['tel']?>'>
				</div>
				<div class="write_li_file">
				<?php 
        			$insert1 = explode("|",$row['addr']);
        			
        			for ($i = 0; $i < count($insert1); $i ++) {
        			?>
    					<div class="adress_box">
    						<p class="write_cont_tit ver_middle">주소 </p>
    						<input type="text" name="addr[]" class="file_area notempty" data-name="주소 " placeholder="텍스트 입력" value='<?php echo $insert1[$i]?>'>
                       <?php 
	                    if($i == 0){
	                    ?>
    	                    <a href="#" class="bt_add bt_site_add">추가</a>
                      <?php 
	                    } else {
	                    ?>
                            <a href="#" class="bt_del bt_site_del">삭제</a>
						<?php 
	                    }
	                    ?>
                    	</div>
        			<?php 
        				}
        			?>
				</div>
				<?php 
				if($row['home_url'] != null) {
				?>
				<div class="write_li_file">
					<p class="write_cont_tit ver_middle">홈페이지 주소</p>
					<input type="text" name="home_url" class="file_area" data-name="홈페이지 주소 " placeholder="URL 입력" value='<?php echo $row['home_url']?>'>
				</div>
				<?php 
				}
				?>
				<div class="write_check">
					<p class="write_cont_tit">노출 여부</p>
					<ul class="check_wrap">
					<?php 					   
					if($row['expo_yn'] == "Y") {
    					?>			
        					<li><input type="radio" id="show" name="exposure_yn" value="Y" class="regular-radio" checked=""><label for="show"><span>노출</span></label></li>
        					<li><input type="radio" id="noshow" name="exposure_yn" value="N" class="regular-radio"><label for="noshow"><span>미노출</span></label></li>
    					<?php 					
    					} else {
    					?>
    						<li><input type="radio" id="show" name="exposure_yn" value="Y" class="regular-radio" ><label for="show"><span>노출</span></label></li>
        					<li><input type="radio" id="noshow" name="exposure_yn" value="N" class="regular-radio" checked=""><label for="noshow"><span>미노출</span></label></li>
    					<?php 
    					}
					?>
					</ul>
				</div>
				<input type="hidden" id="parentidx" name="parentidx" value="<?php echo $row['parentidx']?>">
			</form>
		</div>
		<div class="write_bt">
			<ul>
				<li><a href="/aDmin/board/branch_en.php" class="bt_cont">목록</a></li>
				<li><a href="" class="bt_cont">임시저장</a></li>
				<li><a href="javascript:fncSubmit();" class="bt_cont">등록</a></li>
			</ul>
		</div>
	</div>

</div>
<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/admin_footer.php");
?>