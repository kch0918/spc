<?php
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/admin_header.php");
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/admin_lnb.php");

$query = "select *,DATE_FORMAT(submit_date, '%Y.%m.%d') as submit_date2 from SPC_MAGAZINE where idx = {$_REQUEST['idx']}";
$result = sql_query($query);
$row = sql_fetch($result);

?>
<script>
var lang = "";
lang = "<?php echo $row['language']?>";

$(document).ready(function(){
	
	// 체크박스 체크값 가져오기 
	$("input:checkbox[name='language']:input[value='"+lang+"']").attr("checked", true);

	// 체크박스 중복 막기
	$('input[type="checkbox"]').bind('click',function() {
	    $('input[type="checkbox"]').not(this).prop("checked", false);
	 });
	
	CKEDITOR.replace('contents'); 
	
})

function fncSubmit()
{
 	CKEDITOR.instances.contents.updateElement(); 
 	
	var validationFlag = "Y";
	$(".notEmpty").each(function()
	{ 
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
	});

	var thumb = document.querySelectorAll("span.thumb");
	var file = document.querySelectorAll("span.file");

	console.log(thumb);
	console.log(file);

	// 썸네일
	var thumb_arr = [];
	for(var i = 0; i < thumb.length; i++){
		thumb_arr.push(thumb[i].textContent);
	}
	console.log(thumb_arr);
	var now_thumb = thumb_arr.join("|");
	console.log(now_thumb);	
	
	// 첨부파일
	var file_arr = [];
	for(var i = 0; i < file.length; i++){
		file_arr.push(file[i].textContent);
	}
	console.log(file_arr);
	var now_file = file_arr.join("|");
	console.log(now_file);	
 
	 var chk = "";
		
    $('input[name=language]:checked').each(function() {
		 chk = $(this).val();
  	});

	if(validationFlag == "Y")
	{
		$("#fncForm").ajaxSubmit({
			data : {
				now_thumb	  : now_thumb,
				now_file  	  : now_file,
				language 	  : chk
			},
			success: function(data)
			{
				console.log(data);
				var result = JSON.parse(data);
	    		if(result.isSuc == "success")
	    		{
	    			alert("저장되었습니다.");
	    			location.href="/aDmin/media/magazine.php";
	    		}
	    		else
	    		{
	    			alert(result.msg);
	    		}

			}

		});

	}
}   

//datepicker
$.datepicker.setDefaults({
    dateFormat: 'yy-mm',
    prevText: '이전 달',
    nextText: '다음 달',
    monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
    monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
    dayNames: ['일', '월', '화', '수', '목', '금', '토'],
    dayNamesShort: ['일', '월', '화', '수', '목', '금', '토'],
    dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
    showMonthAfterYear: true,
    yearSuffix: '년'
  });

$(function() {
    $("#start_date").datepicker({
        dateFormat: 'yymmdd'
    });
});
</script>

<div id="container" class="megazine write bt-add">
	<div class="search">
		<p>SPC 매거진 등록 및 수정<strong>생성된 컨텐츠를 수정하고 관리합니다.</strong></p>		
	</div>
	<form id="fncForm"  method="post" action="magazine_edit_proc.php" enctype="multipart/form-data" onSubmit="return false;">	
	<input type="hidden" name="idx" value="<?php echo $row["idx"]?>">
	<input type="hidden" name="prev_thumb" value="<?php echo $row["thumb"]?>">
	<input type="hidden" name="prev_file" value="<?php echo $row["file"]?>">
    	<div class="write_cont_box">
    		<div class="write_cont">
    			<div>
    				<div class="write_li_add">
    					<p class="write_cont_tit">등록일</p>
                        <div class="date_box nomargin"><input type="text" id="start_date" name="start_date" class="search_date notempty" data-name="등록일" placeholder="날짜를 입력해주세요" value="<?php echo $row['submit_date']?>"></div>
						<ul class="check_wrap">
    						<li class="maga_check_tit check_lang">언어</li>
    						<li><input type="checkbox" id="korean" name="language" value="국문" class="regular-radio"><label for="korean"><span>국문</span></label></li>
    						<li><input type="checkbox" id="english" name="language" value="영문" class="regular-radio"><label for="english"><span>영문</span></label></li>
    						<li><input type="checkbox" id="chinese" name="language" value="중문" class="regular-radio"><label for="chinese"><span>중문</span></label></li>
    					</ul>
    				</div>
    				<div class="write_li_tit">
    					<p class="write_cont_tit">제목</p>
    					<input type="text" id="title" name="title" class="tit_area notempty" data-name="제목" placeholder="여기에 제목을 입력하세요" value="<?php echo $row['title']?>">
    				</div>
    				<div class="write_li_cont">
    					<p class="write_cont_tit">내용</p>
    					<textarea id="contents" name="contents" class="notempty" value=""><?php echo $row['contents']?></textarea>
    					
    				</div>
    				<div class="write_li_file file_d">
    					<p class="write_cont_tit">썸네일</p>
    					<span class="upload-name file_area notempty thumb" placeholder="500MB 이내로 업로드" data-name="썸네일" ><?php echo $row['thumb']?></span>
                        <input type="file" id="upload1" name="thumb[]" class="upload-hidden" multiple="multiple" aria-invalid="false">
                        <label for="upload1" class="file_bt bt_up">업로드</label>
                        <a href="#" class="bt_clear">삭제</a>
    				</div>
    				<?php 
        			$insert = explode("|",$row['file']);
        			
        			for ($i = 0; $i < count($insert); $i ++) {
        			?>
                    <div class="write_li_file">
                        <p class="write_cont_tit">첨부파일</p>
                        <div class="write_cont_inline">
						<div class="file_d file_in_add4">
                    	<span class="upload-name file_area file" placeholer="500MB 이내로 업로드 " data-name="첨부파일"><?php echo $row['file']?></span>
                        <input type="file" id="upload0<?php echo $i?>" name="file[]" class="upload-hidden" multiple="multiple" aria-invalid="false">
                        <label for="upload0<?php echo $i?>" class="file_bt bt_up">업로드</label>                    
                     	  <?php 
		                    if($i == 0){
		                    ?>
    		                    <a href="#" class="bt_add4">추가</a>

							<?php 		                    
		                    } else {
		                    ?>
                                <a href="#" class="bt_del">삭제</a>
							<?php 
		                    }
		                    ?>    
            	<?php 
				    }
        		  ?>	         
						</div>
					</div>
                    </div>              
    				<div class="write_check">
    					<p class="write_cont_tit">노출 여부</p>
    					<ul class="check_wrap">
    						<?php 					   
        					if($row['expo_yn'] == "Y") {
        					?>			
            					<li><input type="radio" id="show" name="expo_yn" value="Y" class="regular-radio" checked=""><label for="show"><span>노출</span></label></li>
            					<li><input type="radio" id="noshow" name="expo_yn" value="N" class="regular-radio"><label for="noshow"><span>미노출</span></label></li>
        					<?php 					
        					} else {
        					?>
        						<li><input type="radio" id="show" name="expo_yn" value="Y" class="regular-radio" ><label for="show"><span>노출</span></label></li>
            					<li><input type="radio" id="noshow" name="expo_yn" value="N" class="regular-radio" checked=""><label for="noshow"><span>미노출</span></label></li>
        					<?php 
        					}
        					?>
    					</ul>
    				</div>
    			</div>
    		</div>
		</form>
		<div class="write_bt">
			<ul>
				<li><a href="/aDmin/media/magazine.php" class="bt_cont">목록</a></li>
                <li><a href="" class="bt_cont">임시저장</a></li>
                <li><a href="javascript:fncSubmit();" class="bt_cont">등록</a></li>
			</ul>
		</div>
	</div>
</div>
<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/admin_footer.php");
?>