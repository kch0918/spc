<?php
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");

if ($_SESSION['user_idx'] == "") {
    
    echo "<script>alert('로그인이 필요한 서비스 입니다.');</script>";
    
    echo "<meta http-equiv='refresh' content='0;url=/csr/right-mng/tip-off-login/?lang=en'>";
    
    exit;
}

$board_idx = $_REQUEST['idx'];

$query  = "SELECT *,DATE_FORMAT(submit_date, '%Y.%m.%d') as submit_date2 from SPC_NAGATION where name = '{$_SESSION['user_name']}' and idx = '{$board_idx}'";
$result = sql_query($query);
$row    = sql_fetch($result);

?>
<script src="/aDmin/js/jquery-1.12.4.js"></script>
<script src="/aDmin/js/jquery-ui.js"></script> 
<link rel="stylesheet" href="/js/jquery-ui.css" type="text/css" />
<script src="/aDmin/js/malsup.js"></script>
<script type="text/javascript" src="/aDmin/include/ckeditor/ckeditor.js"></script>
<script>

function insReply() {

	var idx,reply = "";
	
	idx = $('input[name="idx"]').val();
	reply = $("textarea#reply").val();
	
	$.ajax({
		type: "get",
		url: "/front/tip-off/insReply.php",
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

</script>
<div class="pop-h2">
    <h3 class="ft-35">The result of my report</h3>
</div>
<div class="tip-off-view">
	<div class="title">
        <h4 class="ft-28"><?php echo $row['title']?></h4><!-- 제보 제목 -->
        <div class="view-info">
	        <input type="hidden" name="idx" value="<?php echo $row['idx']?>">
        	<span class="date"><time><?php echo $row['submit_date2']?></time></span><!-- 작성 날짜 -->
        	<span class="report-status">
            	<?php if($row['status'] == "Y") {
            	?>
                	<span>답변완료</span><!-- 상태 -->
            	<?php 
            	}else {
            	?> 
                	<span>접수완료</span><!-- 상태 -->
            	<?php 
            	}
            	?>
        	</span>
        </div>
	</div>
	<div class="view-content">
		<div class="tipOff-cont-box">
			<h5 class="ft-18">공정한 직무와 투명한 경영을 위해 SPC에서 시행하는 윤리경영 위반사항의 내부 제보 제도입니다.</h5>
            <div class="cont ft-16 color-7d">
        		<?php echo $row['contents']?>
            </div>
		</div>
		<div class="tipOff-cont-box">
			<h5 class="ft-18">Additional questions related to the report</h5>
            <div class="addCont ft-16 color-7d">
        		<?php echo $row['add_answer']?>
            </div>
		</div>
	</div>
    <div class="tip-off-answer">
        <h5 class="ft-18"><?php echo $row['re_title']?></h5>
        <div class="answer-cont ft-16 color-7d"><?php echo $row['re_contents']?></div>
    </div><!-- 관리자도 관리자에서 답변을 달 수 있고, 사용자도 추가 댓글을 달 수 있어야 한다고 합니다. 참고 -->
	<div class="tip-off-reply">    
		<h4>댓글</h4>
        <div class="reply_box">
        	<!-- 댓글 확인 -->
        	<?php 
        	$query2  = "select * ,DATE_FORMAT(submit_date, '%Y.%m.%d') as submit_date3 from SPC_REPLY where board_no = '{$row['idx']}'";
        	$result2 = sql_query($query2);
	          for ($i = 0; $i < sql_count($result2); $i++) {
    	            $row2 = sql_fetch($result2);
	        ?>
        	<div class="reply_view_box table">
        		<div class="write_cont_tit reply_writer"><?php echo $row2['name']?></div>
				<div class="write_area"><?php echo $row2['contents']?></div>
				<div class="reply_info"><?php echo $row2['submit_date3']?></div>
        	</div>
        	<?php 
        	 }
        	?>
        	<!-- //댓글 확인 -->
        </div>
    	<!-- 댓글 쓰기  -->
    	<div class="reply_write">
    		<div class="reply_view_box table">
    			<div class="write_cont_tit reply_writer"><?php echo $_SESSION['user_name']?></div>
    			<div class="write_area"><textarea id="reply" name="reply" placeholder="댓글 내용 작성"></textarea></div>		
    			<div class="reply_info"><a href="javascript:insReply();" class="reply_save">댓글 등록</a></div>
			</div>			
    	</div>
    	<!--// 댓글 쓰기  -->
    </div>
    <div class="btn-wrap">
        <a href="/csr/right-mng/view-list/?lang=en" class="btn btn02">List</a>
    </div>  
</div>


