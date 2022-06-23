<?php
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/admin_header.php");
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/admin_lnb.php");

$query = "select *,DATE_FORMAT(submit_date, '%Y%m%d') as submit_date2 from SPC_REPORT where seq = {$_REQUEST['seq']}";
$result = sql_query($query);
$row = sql_fetch($result);

?>
<script>
var lang = "";
lang = "<?php echo $row['lang']?>";

$(document).ready(function(){

	// 체크박스 중복 막기
	$('input[type="checkbox"]').bind('click',function() {
	    $('input[type="checkbox"]').not(this).prop("checked", false);
	 });

	// 체크박스 체크값 가져오기 
	$("input:checkbox[name='language']:input[value='"+lang+"']").attr("checked", true);
	
	var subMenuA = $('.mainmenu li:nth-child(1) .submenu');
    var subMenu = $('.mainmenu li:nth-child(1) .submenu > li');
   	var localPath = window.location.pathname; 
	
	subMenu.parents('.submenu').addClass('on');
	subMenu.parents('li').addClass('on');
	subMenu.parents('li').addClass('active');
	subMenuA.find('li:nth-child(1)').addClass('on');
});

$(document).ready(function(){
	CKEDITOR.replace('contents'); 
	
})

function fncSubmit()
{
 	CKEDITOR.instances.contents.updateElement(); 

   var chk = "";
	
    $('input[name=language]:checked').each(function() {
		 chk = $(this).val();
  	});
  	
	var validationFlag = "Y";
	$(".notempty").each(function()
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


	var cate1 = "";
	var cate2 = "";
	
	cate1 = $("#search_option option:selected").val();
	cate2 = $("#seacrh_sel2 option:selected").val();

	alert(cate1);
	alert(cate2);
	
   var lang = "";

   lang = $('input[name="language"]:checked').val();

   if(!lang) {
    	alert("언어 항목에 체크를 해주세요.");
		return false;		
    }

	if(validationFlag == "Y")
	{
		$("#fncForm").ajaxSubmit({
			data : {
				now_thumb	   : now_thumb,
				now_file  	   : now_file,
				search_option  : cate1,
				seacrh_sel2    : cate2,
				language 	   : chk
			},
			success: function(data)
			{
				console.log(data);
				var result = JSON.parse(data);
	    		if(result.isSuc == "success")
	    		{
	    			alert("저장되었습니다.");
	    			location.href="/aDmin/media/report.php";
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
    $("#start_date,#start_date2").datepicker({
        dateFormat: 'yymmdd'
    });
});


function cate2(val){
	$.ajax({
		url: "./getCate2.php",
		type: "POST",
		data: {
			cate_type: val
		},
		success: function(data){
			var result = JSON.parse(data);
			var inner = "";
			var inner2 = "";
			for(var i = 0; i < result.length; i++) {
	   			inner +=   '<option value="'+result[i].cate_name+'">'+result[i].cate_name+'</option>';
	   			inner2 += 	'<li>'+result[i].cate_name+'</li>';
	  /*  			inner2 += 	'<li>'+result[i].cate_name_en+'</li>'; */
			}

			$(".seacrh_sel2").empty();
			$(".seacrh_sel2").siblings('.select-ul').empty();

			$(".seacrh_sel2").append(inner);
			$('.seacrh_sel2').parent(".select-box").find('ul').append(inner2);		
// 			$(".select-ul.undefined_ul").append(inner2);			
			   
			   $('.seacrh_sel2').each(function(index, element) {
			    var this_id = $(this).attr("id");
			    var title = $(this).children('option:first-child').text();
		        var selBox =  $(this).parent(".select-box");
		       
// 		        $(element).each(function(seq, elm) {
// 		            $('option', elm).each(function(id, el) {
// 		                selBox.find('ul').append('<li>' + el.text + '</li>');
// 		                console.log($('.select-box ul:last'));
// 		            });
		            
// 		            $('.select-box ul').hide();
// 		           	// $(this).parent('.makeMeUl .selectedOption').text(defTxt);
// 		        });
		        
		        $(this).parent(".select-box").children('div.selectedOption').text(title);
		        $(this).parent(".notit").children('div.selectedOption').text();
		        $(this).addClass('novis');
		    });

		}
	});	
}
</script>

<div id="container" class="report write bt-add">
	<form id="fncForm"  method="post" action="report_edit_proc.php" enctype="multipart/form-data" onSubmit="return false;">
		<div class="search">
			<p>보도자료 등록 및 수정<strong>생성된 컨텐츠를 수정하고 관리합니다.</strong></p>
			<input type="hidden" name="seq" value="<?php echo $row["seq"]?>">
			<input type="hidden" name="prev_thumb" value="<?php echo $row["thumb"]?>">
			<input type="hidden" name="prev_file" value="<?php echo $row["file"]?>">
			<div class="seacrh_info">
				<div class="search_top write_search">
					<div class="search_txt">카테고리 연결</div>
					<div class="def">
						<select id="search_option" name="search_option" class="search_select" onchange="cate2(this.value);">
								<?php 
								if($row['type'] == "brand"){
								?>
		    						<option value="brand" selected>브랜드</option>
		    						<option value="brand">브랜드</option>
		    						<option value="subsidiary">계열사</option>
	    							<option value="spc_group">SPC 그룹</option>
								<?php 
								} else {
								?>
									<option value="subsidiary" selected>계열사</option>
									<option value="subsidiary">계열사</option>
									<option value="brand">브랜드</option>
									<option value="spc_group">SPC 그룹</option>
								<?php 						    
								}
								?>
						</select>
						<select id="seacrh_sel2" class="seacrh_sel2" name="seacrh_sel2">
							<option value="<?php echo $row['type2']?>"><?php echo $row['type2']?></option>
						</select>
					</div>
				</div>
				<div class="search_bot">
					<div class="search_txt write_search_txt">등록일</div>
		    			<div class="write_date">
		    				<div class="date_box">
		    					<input type="text" id="start_date" name="start_date" class="search_date notempty" data-name="등록일" placeholder="날짜를 입력해주세요" value="<?php echo $row['submit_date2']?>">
		    				</div>
		    			</div>
					</div>
					
					<ul class="check_wrap">
					<li class="maga_check_tit check_lang">언어</li>
					<li><input type="checkbox" id="korean" name="language" value="ko" class="regular-radio"><label for="korean"><span>국문</span></label></li>
					<li><input type="checkbox" id="english" name="language" value="en" class="regular-radio"><label for="english"><span>영문</span></label></li>
					<li><input type="checkbox" id="chinese" name="language" value="cn" class="regular-radio"><label for="chinese"><span>중문</span></label></li>
    			</ul>
				</div>
		</div>
		<div class="write_cont_box">
			<div class="write_cont">
				<div>
    				<div class="write_li_tit">
    					<p class="write_cont_tit">제목</p>
    					<input type="text" id="title" name="title" class="tit_area notempty" data-name="제목" placeholder="여기에 제목을 입력하세요" value="<?php echo $row['title']?>">
    				</div>
    				<div class="write_li_cont">
    					<p class="write_cont_tit">내용</p>
    					<textarea id="contents" name="contents" class="notempty" data-name="내용" value=""><?php echo $row['contents']?></textarea>
    				</div>
    				<div class="write_li_file file_d">
    					<p class="write_cont_tit">썸네일</p>
    					<span class="upload-name file_area thumb"  data-name="썸네일" ><?php echo $row['thumb']?></span>
                        <input type="file" id="upload1" name="thumb[]" class="upload-hidden" aria-invalid="false">
                        <label for="upload1" class="file_bt bt_up">업로드</label>
                        <a href="#" class="bt_clear">삭제</a>
    				</div>
    				<div class="write_li_file">
                        <p class="write_cont_tit">첨부파일</p>
                       	<div class="write_cont_inline">

		    				<?php 
		        			$insert = explode("|",$row['file']);
		        			
		        			for ($i = 0; $i < count($insert); $i ++) {
		        			?>
                    
								<div class="file_d file_in_add4">
									<span class="upload-name file_area file" placeholer="500MB 이내로 업로드 "><?php echo $insert[$i]?></span>
				                    <input type="file" id="upload0<?php echo $i?>" name="file[]" class="upload-hidden" data-name="상단 이미지"  aria-invalid="false">
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

				                </div>  
			            	
			            	<?php 
							    }
			        		  ?>	         
							 
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
			<div class="write_bt">
				<ul>
					<li><a href="/aDmin/media/report.php" class="bt_cont">목록</a></li>
					<li><a href="" class="bt_cont">임시저장</a></li>
					<li><a href="javascript:fncSubmit();" class="bt_cont">등록</a></li>
				</ul>
			</div>
		</div>
	</form>
</div>
<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/admin_footer.php");
?>