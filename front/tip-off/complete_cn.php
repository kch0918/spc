<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");

$query = "SELECT * from SPC_USER order by submit_date desc limit 1 ";
$result = sql_query($query);
$row = sql_fetch($result);
?>

<div class="report-complete-wrap">
	
	<div class="pop-h2">
    	<h2 class="ft-35">受理 完了</h2>
	</div>
	<p class="complete ft-26">
		<img src="/img/csr/icon_report_complete.png" alt="受理 완료" width="72">
		Hot-Line 举报已成功完成。
	</p>
	<?php 
	if($row['id'] != null) {
	?>
	<!-- 익명 제보에서 넘어온 경우에만 보이는 영역 -->
	<div class="report-info">
		<dl>
			<dt class="ft-16">受理 ID</dt>
			<dd class="ft-16"><?php echo $row['id']?></dd><!-- 이거 난수인가? 알아서 잘해주시기 -->
		</dl> 
	</div>
	<!-- //익명 제보에서 넘어온 경우에만 보이는 영역 끝 -->
	<?php 
	}
	?>
	<div class="btn-wrap">
    	<a href="/csr/right-mng/tip-off-login/?lang=zh-hans" class="btn btn02">确认结果</a>
	</div>
</div>