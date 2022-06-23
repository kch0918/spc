<?php
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/admin_header.php");
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/admin_lnb.php");

$query = "select *,DATE_FORMAT(submit_date, '%Y.%m.%d') as submit_date2,DATE_FORMAT(re_submit_date, '%Y%m%d') as submit_date3
          from SPC_NAGATION where idx = {$_REQUEST['idx']}";
$result = sql_query($query);
$row = sql_fetch($result);

?>
<script>
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
    $("#start_date, #start_date2").datepicker({
        dateFormat: 'yymmdd'
    });
});

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
	    			location.href="/aDmin/users/nagation.php";
	    		}
	    		else
	    		{
	    			alert(result.msg);
	    		}

			}

		});

	}
}   

function insReply() {

	var idx,reply = "";
	
	idx = $('input[name="idx"]').val();
	reply = $('textarea[name="reply"]').attr("value");

	console.log(idx);
	
	$.ajax({
		type: "get",
		url: "/aDmin/users/insReply.php",
		dataType:"text",
		async: false,
		data:{
			idx : idx,
			reply : reply
		},
		success: function(data)
		{
     		location.reload();
			console.log(data);
			
			var result = JSON.parse(data);
    		if(result.isSuc == "success")
    		{
    			alert("저장되었습니다.");
    		}
    		else
    		{
    			alert(result.msg);
    		}
		}
	});
};

function delReply(idx) {

	reply_idx = idx;

	console.log(reply_idx);
	
	$.ajax({
		type: "get",
		url: "/aDmin/users/delReply.php",
		dataType:"text",
		async: false,
		data:{
			reply_idx : reply_idx
		},
		success: function(data)
		{
     		location.reload();
			console.log(data);
			
			var result = JSON.parse(data);
    		if(result.isSuc == "success")
    		{
    			alert("저장되었습니다.");
    		}
    		else
    		{
    			alert(result.msg);
    		}
		}
	});
};

function downloadFile(file)
{
	location.href="/aDmin/users/downloadFile.php?file="+file;
}

function print(idx)

{  
 window.open("/aDmin/users/nagationprint.php/?idx="+idx,"print_open","width=2000,height=2000,top=0,left=0,noresizable,toolbar=no,status=no,scrollbars=yes,directory=n");
 
}
$(function(){
	$("textarea").each(function(){
		$(this).height(this.scrollHeight+20)
	})
})

</script>

<div id="container" class="review nagation write">
	<div class="search">
		<p>부정제보 상세</p>	
		<a href="javascript:print('<?php echo $row["idx"]?>')" class="print-btn">인쇄하기</a> 	
	</div>
	<form id="fncForm" method="post" action="nagation_anony_proc.php" onSubmit="return false;">
	<input type="hidden" name="idx" value="<?php echo $row["idx"]?>">
	<div class="write_cont_box bg_gray">
		<div class="write_cont">
			<div>
				<div class="write_li_add">
					<p class="write_cont_tit">접수아이디</p>
                    <input type="text" id="" name="" class="info_area" value="<?php echo $row["id"]?>" readonly>
                    <p class="write_cont_tit tit_margin">접수일자</p>
                    <input type="text" id="start_date" name="start_date" class="info_area notempty" data-name="등록일"  placeholder="날짜를 입력해주세요" value="<?php echo $row['submit_date2']?>" readonly>
				</div>
				<div class="write_li_file">
					<p class="write_cont_tit">제보자</p>
					<input type="text" id="" name="" class="info_area" placeholder="익명" readonly>
                     <p class="write_cont_tit tit_margin">이메일</p>
                    <input type="text" id="" name="" class="info_area" placeholder="익명" readonly>
                    <p class="write_cont_tit tit_margin">연락처</p>
                    <input type="text" id="" name="" class="info_area" placeholder="익명" readonly>
				</div>				
                <div class="write_li_file">
                    <p class="write_cont_tit">제목</p>
                    <input type="text" id="" name="" class="tit_area" readonly value="<?php echo $row['title']?>">
                </div>
                <div class="write_li_file">
                    <p class="write_cont_tit">제보 내용</p>
                    <textarea id="" name="" class="cont_area" readonly placeholder=""><?php echo $row['contents']?></textarea>
                </div>
				<div class="write_check">
                    <p class="write_cont_tit">추가 질문</p>
                    <textarea id="" name="" class="cont_area" readonly placeholder=""><?php echo $row['add_answer']?></textarea>
                </div>   
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
			</div>
		</div>
	</div>

	<div class="write_cont_box">
		<div class="write_cont">
			<div>
				<div class="write_li_add">
					<p class="write_cont_tit">등록일</p>
                    <input type="text" id="start_date2" name="start_date2" class="info_area notempty" data-name="등록일" placeholder="날짜를 입력해주세요" value="<?php echo $row['submit_date3']?>">
				</div>
				<div class="write_li_tit">
					<p class="write_cont_tit">답변 제목</p>
					<input type="text" id="re_title" name="re_title" class="tit_area notempty" data-name="답변 제목" value="<?php echo $row['re_title']?>">
				</div>
				<div class="write_li_cont">
					<p class="write_cont_tit">답변 내용</p>
					<textarea id="re_contents" name="re_contents" class="write_area notempty" data-name="답변  내용" value=""><?php echo $row['re_contents']?></textarea>
				</div>
			</div>
		</div>
	</div>

	<div class="write_cont_box reply">
		<div class="write_cont">
			<div>
				<div class="write_li_add">
					<p class="write_cont_tit">댓글</p>				
                    <div class="reply_box">
                  		<!-- 댓글 확인 -->
                    	<?php 
                    	$query2  = "select * from SPC_REPLY where board_no = '{$_REQUEST['idx']}'";
                    	$result2 = sql_query($query2);
                	          for ($i = 0; $i < sql_count($result2); $i++) {
                    	            $row2 = sql_fetch($result2);
                    	       ?>
                    	       <input type="hidden" name="reply_idx" value="">
                            	<div class="reply_view_box line">
                            		<p class="write_cont_tit reply_writer"><input type="text" id="" name="" placeholder="" value="<?php echo $row2['name']?>" readonly></p>
        							<div class="write_area">
        								<div><?php echo $row2['contents']?></div>
        								<div class="reply_info">
        									<input type="text" name="" placeholder="" value="<?php echo $row2['submit_date']?>" readonly>
        									<a href="javascript:delReply('<?php echo $row2['idx']?>');" class="reply_del">삭제</a>
        								</div>
        							</div>							
                            	</div>
                    	<?php 
                    	 }
                    	?>
                    	<!-- //댓글 확인 -->
                    	
                    	<!-- 댓글 쓰기  -->
                    	<div class="reply_view_box reply_wirte">
                    		<p class="write_cont_tit reply_writer"><input type="text" id="" name="" placeholder="" value="<?php echo $_SESSION['name']?>" readonly></p>
                    		<?php echo $_SESSION['name']?>
							<div class="write_area">
								<textarea name="reply" placeholder="관리자 답변"></textarea>
								<a href="javascript:insReply();" class="reply_save">저장</a>
							</div>					
                    	</div>
                    	<!--// 댓글 쓰기  -->
                    </div>                  
				</div>
			</div>
		</div>
	</div>	
	</form>
	
	<div class="write_bt">
		<ul>
			<li><a href="/aDmin/users/nagation.php" class="bt_cont">목록</a></li>
			<li><a href="javascript:fncSubmit();" class="bt_cont">답변 제출</a></li>
		</ul>
	</div>
	
</div>
<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/admin_footer.php");
?>