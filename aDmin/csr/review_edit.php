<?php
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/admin_header.php");
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/admin_lnb.php");

$query = "select *,DATE_FORMAT(submit_date, '%Y.%m.%d') as submit_date2 from SPC_REVIEW where idx = {$_REQUEST['idx']}";
$result = sql_query($query);
$row = sql_fetch($result);

?>

<script>
function fncSubmit()
{
	var validationFlag = "Y";
	$(".notEmpty").each(function()
	{ 
		if($(this).val() == ""){
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
	    			location.href="/aDmin/csr/review.php";
	    		}
	    		else
	    		{
	    			alert(result.msg);
	    		}

			}

		});

	}
}   

function downloadthumb(thumb)
{
	location.href="/aDmin/csr/downloadthumb.php?thumb="+thumb;
}

function downloadFile(file)
{
	location.href="/aDmin/users/downloadFile.php?file="+file;
}
</script>



<div id="container" class="review write">
	<div class="search">
		<p>참여후기</p>		
	</div>
<form id="fncForm" name="fncForm" method="post" action="review_edit_proc.php" enctype="multipart/form-data" onSubmit="return false;">
	<input type="hidden" name="idx" value="<?php echo $row["idx"]?>">
	<div class="write_cont_box">
		<div class="write_cont">
			<div>
				<div class="write_li_add">
					<p class="write_cont_tit">등록자</p>
                    <input type="text" id="" name="" class="info_area" placeholder="등록자명" readonly value="<?php echo $row['reg_name']?>">
                    <p class="write_cont_tit tit_margin">이메일</p>
                    <input type="text" id="" name="" class="info_area" placeholder="이메일" readonly value="<?php echo $row['email']?>">
				</div>
				<div class="write_li_file">
					<p class="write_cont_tit">소속</p>
					<input type="text" id="" name="" class="info_area r_margin" placeholder="회사명" readonly value="<?php echo $row['corp']?>">
                    <input type="text" id="" name="" class="info_area" placeholder="부서명" readonly value="<?php echo $row['corp_dep']?>">
                    <p class="write_cont_tit tit_margin">참석자</p>
                    <input type="text" id="" name="" class="info_area" placeholder="참석자명" readonly value="<?php echo $row['attend']?>">
				</div>
				<div class="write_li_file">
					<p class="write_cont_tit write_ver">참여일시</p>
					<div class="date_box"><input type="text" id="start_date" name="" class="search_date" placeholder="2020-08-20" readonly value="<?php echo $row['start_date']?>"></div>
                    <div class="date_box l_margin"><input type="text" id="finish_date" name="" class="search_date" placeholder="2020-08-26" readonly value="<?php echo $row['end_date']?>"></div>
                    <p class="write_cont_tit tit_margin">활동장소</p>
                    <input type="text" id="" name="" class="info_area" placeholder="활동장소명" readonly value="<?php echo $row['place']?>">
				</div>
                <div class="write_li_file">
                    <p class="write_cont_tit">제목</p>
                    <input type="text" id="" name="" class="tit_area" placeholder="여기에 제목을 입력하세요" readonly value="<?php echo $row['title']?>">
                </div>
                 <div class="write_li_file">
                    <p class="write_cont_tit">내용</p>
                    <textarea id="" name="" class="cont_area" placeholder="" readonly><?php echo $row['contents']?>"</textarea>
                </div>
			  	<?php 
                if($row['thumb'] != null) {
                ?>	
                    <div class="write_li_file">
                        <p class="write_cont_tit">썸네일</p>
                        <input type="text" id="" name="" class="file_area" placeholder="썸네일.jpg" value="<?php echo $row['thumb']?>">
                        <input type="button" class="bt_down" value="다운로드" onclick="downloadthumb('<?php echo $row['thumb']?>')">
                    </div>              
			   <?php 
                } else {
                ?>
                <div class="write_li_file">
					<p class="write_cont_tit">썸네일</p>
					   <input type="text" id="" name="" class="file_area" placeholder="썸네일이 없습니다." value="">
			    </div>  
				<?php                     
                }
                ?>   
                <?php 
                if($row['file'] != null) {
                ?>	
                    <div class="write_li_file">
                        <p class="write_cont_tit">첨부파일</p>
                        <input type="text" id="" name="" class="file_area" placeholder="첨부파일.pdf" value="<?php echo $row['file']?>">
                        <input type="button" class="bt_down" value="다운로드" onclick="downloadFile('<?php echo $row['file']?>')">
                    </div>              
			   <?php 
                } else {
                ?>
                <div class="write_li_file">
					<p class="write_cont_tit">첨부파일</p>
					   <input type="text" id="" name="" class="file_area" placeholder="첨부파일이 없습니다." value="">
			    </div>  
				<?php                     
                }
                ?>   
                        
				<div class="write_li_file write_check">
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
                <div class="write_li_file write_check">
                    <p class="write_cont_tit">인기 후기</p>
                    <ul class="check_wrap cate_check_wrap">
    						<?php 					   
        					if($row['top_review'] == "Y") {
        					?>			
            				    <li><input type="radio" id="add" name="top_review" value="Y" class="cate-radio" checked=""><label for="add"><span>등록</span></label></li>
                      		    <li><input type="radio" id="noadd" name="top_review" value="N" class="cate-radio"><label for="noadd"><span>미등록</span></label></li>
        					<?php 					
        					} else {
        					?>
        	   					<li><input type="radio" id="add" name="top_review" value="Y" class="cate-radio"><label for="add"><span>등록</span></label></li>
                        	    <li><input type="radio" id="noadd" name="top_review" value="N" class="cate-radio" checked=""><label for="noadd"><span>미등록</span></label></li>
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
				<li><a href="/aDmin/csr/review.php" class="bt_cont">목록</a></li>
				<li><a href="javascript:fncSubmit();" class="bt_cont">등록</a></li>
			</ul>
		</div>
	</div>

</div>
<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/admin_footer.php");
?>