<?php
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");

$query = "select *,DATE_FORMAT(submit_date, '%Y.%m.%d') as submit_date2 from SPC_SOCIAL where idx = {$_REQUEST['idx']}";
// print_r($_POST);

$result = sql_query($query);
$row = sql_fetch($result);

//이전 글
$query_before_musign = "select * ,DATE_FORMAT(submit_date, '%Y.%m.%d') as submit_date2 from SPC_SOCIAL where idx < {$_REQUEST['idx']} and lang = 'cn' order BY idx desc limit 1";//쿼리문
$result_before_musign =  sql_query($query_before_musign); //쿼리실행
$row_before_musign = sql_fetch($result_before_musign);

//다음 글
$query_after_musign = "select * ,DATE_FORMAT(submit_date, '%Y.%m.%d') as submit_date2 from SPC_SOCIAL where idx > {$_REQUEST['idx']} and lang = 'cn'  limit 1";//쿼리문
$result_after_musign =  sql_query($query_after_musign); //쿼리실행
$row_after_musign = sql_fetch($result_after_musign);//반복문 끝


?>
<script>
//조회
function goNotice(idx)
{
    location.href="/share/society/contribution/detail_cn/?idx="+idx + "&lang=zh-hans";
}

</script>
<div class="board-view">
	<div class="bview-top">
		<div class="table">
			<div class="bview-tit">
				<h2><?php echo $row['title']?></h2>
			</div>
			<div>
				<ul class="bview-ul">
					<li><?php echo $row['submit_date2']?></li>
					<li><span class="bd-cata">SPC</span></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="bview-cont">
		<div>
			<?php echo $row['contents']?>
			
			<?php 
				if ($row['file'] !=  '' ) {
					?>
				<?php 
        			$insert = explode("|",$row['file']);
        			
        			for ($i = 0; $i < count($insert); $i ++) {
        			?>
				    <!-- 파일 첨부 -->
				    <div class="bview-attach">
    				    <p>附件 : <?php echo $insert[$i]?></p>
                   		<a href="javascript:downloadFile('<?php echo $insert[$i]?>')" class="main-btn btn attach-btn">文件下载
                   		<img src="/img/csr/attach-icon.png" alt="다운로드"/></a>
                	</div>
                	<?php 
						 }
					?>
            	<?php 
					 }
				?>	
		</div>
	</div>
	<div class="bview-bot">
		<div class="bview-list">
			<?php 
			if ($row_before_musign['idx']!=null) {
				?>
				<div>
    				<div class="table">
    					<div class="bview-aro">
    					<img src="/img/board-prev.png" alt="이전글">上一个</div>
    					<div class="bview-ltit"><a href="javascript:goNotice(<?php echo $row_before_musign['idx']?>);">
    					<?php echo $row_before_musign['title'] ?></a></div>
    					<div class="bview-ldate"><?php echo $row_before_musign['submit_date2']?></div>
    				</div>
			   </div>
			<?php 
				   }
			?>
			<?php 
			if ($row_after_musign['idx']!=null) {
				?>
    			<div>
    				<div class="table">
    					<div class="bview-aro">
    					<img src="/img/board-next.png" alt="다음글">下一个</div>
    					<div class="bview-ltit"><a href="javascript:goNotice(<?php echo $row_after_musign['idx']?>);">
    					<?php echo $row_after_musign['title'] ?></a></div>
    					<div class="bview-ldate"><?php echo $row_after_musign['submit_date2']?></div>
    				</div>
    			</div>
			<?php 
				   }
			?>
		</div>
	</div>
	<div class="btnwr img-ani bottom-top">
		<a href="/csr/society/contribution/?lang=zh-hans" class="main-btn home-href">目录</a>
	</div>
</div>