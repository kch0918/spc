<?php
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");

?>

<div class="intro-btn">
    <button type="button" class="main-btn" onclick="popOpen('tipOffReport');">Report irregularities</button>
    <button type="button" class="main-btn" onclick="popOpen('customerReport');">Submit customer complaints</button>
</div>

<div class="global-popwr">
	<div class="global-bg"></div>
	<!-- 부정제보 팝업 -->
	<div class="global-pop report-pop" id="tipOffReport" tabindex="0" style="display:none">
        <div class="gpop-wr">
            <div id="dishonestReport">
            	<div>
                	<div class="pop-h2">
                    	<h3 class="ft-35">Report irregularities</h3>
                	</div>
                	<p class="ft-16 color-7d">We receive reports on SPC executives and employees' unfair business practices, unreasonable demands using their positions, and corruption.<br>In the case of anonymous reports, investigations are limited if the details are not specific and the factual basis is unclear.</p>
                	<div class="intro-btn">
                    	<a href="/csr/right-mng/name-report/?lang=en" class="main-btn"><img src="/img/csr/icon_report_name.png" alt="Real name report" width="27">Real name report</a>
                    	<a href="/csr/right-mng/blind-report/?lang=en" class="main-btn"><img src="/img/csr/icon_report_blind.png" alt="anonymous report" width="27">anonymous report</a>
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
    						<p><strong>Direct input</strong></p>
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