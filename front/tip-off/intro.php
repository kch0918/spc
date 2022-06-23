<?php
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");

?>

<div class="intro-btn">
    <button type="button" class="main-btn" onclick="popOpen('tipOffReport');">부정비리 제보하기</button>
    <button type="button" class="main-btn" onclick="popOpen('customerReport');">고객 불만 접수하기</button>
</div>

<div class="global-popwr">
	<div class="global-bg"></div>
	<!-- 부정제보 팝업 -->
	<div class="global-pop report-pop" id="tipOffReport" tabindex="0" style="display:none">
        <div class="gpop-wr">
            <div id="dishonestReport">
            	<div>
                	<div class="pop-h2">
                    	<h3 class="ft-35">부정제보 하기</h3>
                	</div>
                	<p class="ft-16 color-7d">SPC 임직원의 불공정한 업무처리나 직위를 이용한 부당한 요구 및 비리 사실에 대한 제보를 받습니다.<br>익명 제보의 경우 내용이 구체적이지 않고 사실 근거가 불분명한 경우 조사에 한계가 있습니다.</p>
                	<div class="intro-btn">
                    	<a href="/csr/right-mng/name-report/" class="main-btn"><img src="/img/csr/icon_report_name.png" alt="실명 제보" width="27">실명 제보</a>
                    	<a href="/csr/right-mng/blind-report/" class="main-btn"><img src="/img/csr/icon_report_blind.png" alt="익명 제보" width="27">익명 제보</a>
                        <a href="#close" class="global-cls">닫기</a>
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
                    	<h3 class="ft-35">고객불만</h3>
                	</div>
                	<p class="ft-16 color-7d">궁금하신 점을 빠르고 정확하게 답변 드리겠습니다.<br>아래에서 브랜드를 선택하여 문의하기 버튼을 눌러 주세요.</p>

                	<!-- <div class="intro-btn">
                	    					<div class="select">
                	    						<p><strong>직접입력</strong></p>
                	                            <ul>
                	                             <?php 
                	                                $query = "select * from SPC_MID_CATE where cate_type = 'brand'";
                	                                $result = sql_query($query);
                	                                for($i = 0; $i < sql_count($result); $i++){
                	                                $row = sql_fetch($result);
                	                                    ?>
                	                            	<li><button type="button"><?php echo $row['cate_name']?></button></li>
                	                            <?php 
                	                            }
                	                            ?>
                	                            </ul>
                	                        </div>
                	                        <a href="#" class="main-btn">문의하기</a> 
                	</div> -->

                    <!--  문의하기 클릭시 부정제보 하기 팝업으로 이동 -->

					<h2 class="title">주요 브랜드 고객센터</h2>

						<div class="brand_list_all">
							<div class="brand_list">
								<div class="brand_row">
									<img src="/img/brand1.png" alt="파리바게뜨 로고이미지" class="brand_img">
								</div>
								<div class="brand_row">
									<h3 class="brand_title">파리바게뜨</h3>
								</div>
								<div class="brand_row">
									<p class="brand_num">080-731-2027</p>
								</div>
								<div class="brand_row">
									<a href="https://www.paris.co.kr/cs/inquiry/" target="_blank" class="brand_qna">문의하기</a>
								</div>
							</div>
							<div class="brand_list">
								<div class="brand_row">
									<img src="/img/brand2.png" alt="베스킨라빈스 로고이미지" class="brand_img">
								</div>
								<div class="brand_row">
									<h3 class="brand_title">배스킨라빈스</h3>
								</div>
								<div class="brand_row">
									<p class="brand_num">080-555-3131</p>
								</div>
								<div class="brand_row">
									<a href="http://www.baskinrobbins.co.kr/customer/faq.php#" target="_blank" class="brand_qna">문의하기</a>
								</div>
							</div>
							<div class="brand_list">
								<div class="brand_row">
									<img src="/img/brand3.png" alt="던킨도너츠 로고이미지" class="brand_img">
								</div>
								<div class="brand_row">
									<h3 class="brand_title">던킨도너츠</h3>
								</div>
								<div class="brand_row">
									<p class="brand_num">080-555-3131</p>
								</div>
								<div class="brand_row">
									<a href="https://www.dunkindonuts.co.kr/customer/faq.php" target="_blank" class="brand_qna">문의하기</a>
								</div>
							</div>
							<div class="brand_list">
								<div class="brand_row">
									<img src="/img/brand4.png" alt="해피마켓 로고이미지" class="brand_img">
								</div>
								<div class="brand_row">
									<h3 class="brand_title">해피마켓</h3>
								</div>
								<div class="brand_row">
									<p class="brand_num">1577-8450</p>
								</div>
								<div class="brand_row">
									
								</div>	
							</div>		
						</div>

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