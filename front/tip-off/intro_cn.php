<?php
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");

?>

<div class="intro-btn">
    <button type="button" class="main-btn" onclick="popOpen('tipOffReport');">举报腐败</button>
    <button type="button" class="main-btn" onclick="popOpen('customerReport');">顾客投诉受理</button>
</div>

<div class="global-popwr">
	<div class="global-bg"></div>
	<!-- 부정제보 팝업 -->
	<div class="global-pop report-pop" id="tipOffReport" tabindex="0" style="display:none">
        <div class="gpop-wr">
            <div id="dishonestReport">
            	<div>
                	<div class="pop-h2">
                    	<h3 class="ft-35">举报腐败</h3>
                	</div>
                	<p class="ft-16 color-7d">SPC接受有关职员不公平处理业务及滥用职位提出不当要求及腐败的举报。<br>如匿名举报，在内容不具体、事实依据不明确时，调查存在局限性。</p>
                	<div class="intro-btn">
                    	<a href="/csr/right-mng/name-report/?lang=zh-hans" class="main-btn"><img src="/img/csr/icon_report_name.png" alt="实名举报" width="27">实名举报</a>
                    	<a href="/csr/right-mng/blind-report/?lang=zh-hans" class="main-btn"><img src="/img/csr/icon_report_blind.png" alt="匿名举报" width="27">匿名举报</a>
                        <a href="#close" class="global-cls">Close</a>
                	</div>
            	</div>
            </div>
        </div>
	</div>
	<!-- //부정제보 팝업 끝 -->
    
    <!-- 고객 불만 팝업 -->
    <div class="global-pop report-pop" id="customerReport" tabindex="0" style="display:none">
        <div class="gpop-wr">
            <div class="csReport">
            	<div>
                	<div class="pop-h2">
                    	<h3 class="ft-35">Customer complaints</h3>
                	</div>
                	<p class="ft-16 color-7d">궁금하신 점을 빠르고 정확하게 답변 드리겠습니다.<br>아래에서 브랜드를 선택하여 문의하기 버튼을 눌러 주세요.</p>
                	<div class="intro-btn">
    					<div class="select">
    						<p><strong>直接输入</strong></p>
                            <ul>
                             <?php 
                                $query = "select * from SPC_MID_CATE where cate_type = 'brand'";
                                $result = sql_query($query);
                                for($i = 0; $i < sql_count($result); $i++){
                                $row = sql_fetch($result);
                                    ?>
                            	<li><button type="button"><?php echo $row['cate_name_en']?></button></li>
                            <?php 
                            }
                            ?>
                            </ul>
                        </div>
                        <a href="#" class="main-btn">문의하기</a> 
                	</div>
                    <!--  문의하기 클릭시 부정제보 하기 팝업으로 이동 -->
                    <a href="#close" class="global-cls">Close</a>
            	</div>
            </div>
        </div>
    </div>
    <!-- //고객 불만 팝업 끝 -->
</div>

<script>
function popOpen(target){
	$('.global-popwr').show();
	$('#' + target).show().focus();
}
$('.global-cls').click(function(e){
	e.preventDefault();
	$(this).closest('.global-pop').hide();
	$('.global-popwr').hide();
});
</script>