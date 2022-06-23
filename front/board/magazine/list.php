<?php
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/excelDown.php");

$query2 = "select *,DATE_FORMAT(submit_date, '%Y.%m.%d') as submit_date2 from SPC_MAGAZINE where language = '국문' ORDER BY submit_date DESC LIMIT 1";
// print_r($_POST);

$result2 = sql_query($query2);
$row2 = sql_fetch($result2);

//이전 글
$query_before_musign = "select * ,DATE_FORMAT(submit_date, '%Y.%m.%d') as submit_date2 from SPC_MAGAZINE where idx < 1 and language = '국문' order BY idx desc limit 1";//쿼리문
$result_before_musign =  sql_query($query_before_musign); //쿼리실행
$row_before_musign = sql_fetch($result_before_musign);

//다음 글
$query_after_musign = "select * ,DATE_FORMAT(submit_date, '%Y.%m.%d') as submit_date2 from SPC_MAGAZINE where idx > 1 and language = '국문' limit 1"; //쿼리문
$result_after_musign =  sql_query($query_after_musign); //쿼리실행
$row_after_musign = sql_fetch($result_after_musign);//반복문 끝
?>
<script src="//code.jquery.com/jquery-1.12.4.js"></script> 
<script src="/js/jquery-ui.js"></script>
<link rel="stylesheet" href="/js/jquery-ui.css" type="text/css" />
<script src="https://malsup.github.io/min/jquery.form.min.js"></script>
<script type="text/javascript" src="/aDmin/include/ckeditor/ckeditor.js"></script>
<script>
//조회
function goDetail(idx)
{
	location.href="/media-hub/magazine/detail/?idx="+idx;
}

function goSubscribe() {

	var agree1,agree2,email,birth = "";

	agree1 = $('input[name="agree1"]:checked').val();
	agree2 = $('input[name="agree2"]:checked').val();
	email  = $('input[name="email"]').val();
	birth  = $('input[name="birth"]').val();

	if(!agree1) {
		alert("개인정보수집이용 동의 항목에 체크를 해주세요.");
		return false;
	}

	if(!agree2){
		alert("개인정보 췩브위탁에 대한 동의 항목에 체크를 해주세요.");
		return false;
	}
	
	var validationFlag = "Y";
	$(".notempty").each(function()
	{ 
		if ($(this).val() == "") 
		{
			alert(this.dataset.name+"을(를) 입력해주세요.");
			$(this).focus();
			validationFlag = "N";
			return false;
		}
	});

	
	if(validationFlag == "Y")
	{
    	$.ajax({
    		type: "get",
    		url: "/front/board/magazine/goSubscribe.php",
    		dataType:"text",
    		async: false,
    		data:{
    			agree1 : agree1,
    			agree2 : agree2,
    			email  : email,
    			birth  : birth
    		},
    		success: function(data)
    		{
         		location.reload();
    			console.log(data);
    			
    			var result = JSON.parse(data);
        		if(result.isSuc == "success")
        		{
        			alert("구독신청 되었습니다.");
        		}
        		else
        		{
        			alert(result.msg);
        		}
    		}
    	});
	}
}

function excelDown()
{
	var filename = "매거진 구독";
	var table = "excelTable";
	
    exportExcel(filename, table);
}
</script>

<div class="contri-wr text-center">
	<div class="basic-grid">
		<div class="contri-sec contri-sec05">
			<h2 class="ft-42 bold color-000 global-tit img-ani bottom-top">SPC 매거진 NOW</h2>
				<input type="hidden" id="idx" name="idx" value="<?php echo $row2['idx']?>">
				<div class="magazine-slide">
					<div class="slide-wr">
						<div class="magazine-latest swiper-container">
							<ul class="tranDelayList swiper-wrapper">
								<?php 
								$query = "select *,DATE_FORMAT(submit_date, '%Y.%m.%d') as submit_date2 from SPC_MAGAZINE where expo_yn='Y' and language = '국문' order by submit_date DESC LIMIT 5";
								$result = sql_query($query);
								for($i = 0; $i < sql_count($result); $i++){
								$row = sql_fetch($result);
								?>
									<li class="swiper-slide">
										<div class="img">
											<div class="img-hov"><a href="javascript:goDetail(<?php echo $row['idx']?>);"><img src="/aDmin/file/<?php echo $row['thumb']?>" alt=""></a></div> 
										</div>
										<div class="cont">
											<h3 class="ft-18"><?php echo $row['title']?></h3>
											<time class="date"><?php echo $row['submit_date2']?></time>
										</div>
									</li>
    							<?php 
    								}
    							 ?>
							</ul>
						</div>			
					</div>
					<div class="mu-swiper-button mu-swiper-button-next"></div>
					<div class="mu-swiper-button mu-swiper-button-prev"></div>
				</div>
		</div>
	</div>
	<div class="maga-applywr">
		<div class="maga-apply ">
			<p class="ft-18 color-s letter-0">SPC MAGAZINE</p>
			<p class="ft-26">건강한 소식이 가득한 <span class="color-s">SPC 매거진 뉴스레터</span>를 매일 이메일로 받아보세요.</p>
			<a class="maga-btn"><img src="/img/sub/apply-btn.png" alt="구독신청"/>구독신청</a>
		</div>
	</div>
	<div class="maga-detail">
		<div class="md-bg md-bg01"></div>
		<div class="md-bg md-bg02"></div>
		<div class="md-bg md-bg03"></div>
		<div class="md-bg md-bg04"></div>
		<div class="maga-detop">
			<div class="select">
				<p><strong><?php echo $row2['title']?></strong></p>
				<ul>
				<?php 
					$query = "select *,DATE_FORMAT(submit_date, '%Y.%m.%d') as submit_date2 from SPC_MAGAZINE where expo_yn='Y' and language = '국문' order by submit_date DESC";
					$result = sql_query($query);
					for($i = 0; $i < sql_count($result); $i++){
					$row = sql_fetch($result);
				?>
					<li><a href="javascript:goDetail(<?php echo $row['idx']?>);"><?php echo $row['title']?></a></li>
				<?php 
					}
				?>
				</ul>
			</div>
		</div>
    		<div class="maga-demid">
<!--     			<img src="/img/sub/maga-detail.jpg" alt="매거진" value=""/> -->
			<?php echo $row2['contents']?>
    		</div>
		<div class="maga-debot">
			<div class="table">
			<?php 
			if ($row_before_musign['idx']!=null) {
				?>
				<div class="mega-arr mega-prev" onclick="javascript:goDetail(<?php echo $row_before_musign['idx']?>);"><span><img src="/img/sub/apply-prev.png" alt="이전"/></span><b>이전 호 보러가기</b></div>
			<?php 
			    }
				else{
			?>
				<div></div>
			<?php
				}
			?>
				
			<?php 
			if ($row_after_musign['idx']!=null) {
				?>
				<div class="mega-arr mega-next" onclick="javascript:goDetail(<?php echo $row_after_musign['idx']?>);"><b>다음 호 보러가기</b><span><img src="/img/sub/apply-next.png" alt="다음"/></span></div>
			<?php 
		    }
		     ?>
			</div>
			<a href="https://www.spcmagazine.com/" target="_blank" class="main-btn home-href">spcmagazine.com 바로가기</a>
		</div>
	</div>
</div>

<!-- 팝업 -->
<div class="global-popwr">
	<div class="global-bg"></div>
	<div class="global-pop newslatter-pop">
		<div class="gpop-wr">
			<div>
				<div class="table">
					<div>
						<div class="pop-h2">
							<div class="global-cls">x</div>
							<h2>뉴스레터 구독신청</h2>
							<p>건강하고 행복한 소식이 가득한 SPC 매거진의 뉴스레터를 매월 이메일로 받아보세요.</p>
						</div>
						<div class="pop-cont">
							<div class="scrollbar-inner">
								<div class="poprow">
									<h4>개인정보수집이용 동의</h4>
									<table>
										<tbody>
											<tr>
												<th>목적</th>
												<th>항목</th>
												<th>보유기간</th>
											</tr>
											<tr>
												<td>SPC MAGAZINE 뉴스레터 수신</td>
												<td>이메일</td>
												<td>구독수신거부 전까지</td>
											</tr>
										</tbody>
									</table>
									<ul class="rdo-ul">
										<li><input type="radio" id="agree-n1" name="agree1" value="N"><label for="agree-n1">동의안함</label></li>
										<li><input type="radio" id="agree-y1" name="agree1" value="Y"><label for="agree-y1">동의</label></li>
									</ul>
								</div>
								<div class="poprow">
									<h4>개인정보 취급위탁에 대한 동의</h4>
									<table>
										<tbody>
											<tr>
												<th>수탁자</th>
												<th>목적</th>
												<th>보유기간</th>
											</tr>
											<tr>
												<td>㈜콜레오마케팅그룹</td>
												<td>SPC MAGAZINE 뉴스레터 수신자 관리</td>
												<td>구독수신거부 전까지</td>
											</tr>
										</tbody>
									</table>
									<ul class="rdo-ul">
										<li><input type="radio" id="agree-n2" name="agree2" value="N"><label for="agree-n2">동의안함</label></li>
										<li><input type="radio" id="agree-y2" name="agree2" value="Y"><label for="agree-y2">동의</label></li>
									</ul>
								</div>
								<div class="pop-form">
									<div class="table">
										<div class="pop-th">구독신청 이메일</div>
										<div class="pop-td"><input type="eamil" name="email" class="notempty" placeholder="이메일을 입력해 주세요." data-name="이메일"></div>
									</div>
									<div class="table">
										<div class="pop-th">구독자 생년월일</div>
										<div class="pop-td"><input type="birth" name="birth" class="notempty" placeholder="예) 19800101" data-name="생년월일">
										
											<ul class="pop-cap">
												<li>수집이용에 관한 동의 및 취급위탁에 대해 동의를 거부하실 수 있으며, 동의하지 않으신 경우 구독신청이 제한됩니다. 
												   (If you decline the collection and consignment of your data, your subscription may be limited.)</li>
												<li>만 14세 이상만 구독 가능합니다. 생년월일은 별도로 저장하지 않습니다.<br>
												   (Subscription is limited to those over 13 years of age. Date of birth is not recorded separately.)</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<div class="btn-wr">
							<a href="http://spcweb.musign.co.kr/media-hub/magazine/" class="btn btn01">취소하기</a>
							<a href="javascript:goSubscribe()"class="btn btn02">구독신청</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div><!-- //global-pop -->
</div>
<script src="//code.jquery.com/jquery-1.12.4.js"></script> 
<script src="/js/jquery-ui.js"></script>
<link rel="stylesheet" href="/js/jquery-ui.css" type="text/css" />
<script>
(function($) { 
	$(window).ready(function(){		
		
	})
	$(function(){
		var newsSlide = new Swiper('.magazine-slide .swiper-container',{
			slidesPerView:4,
			breakpoints:{
				989:{
					slidesPerView:2
				},
				500:{
					slidesPerView:1			
				}
			},
			navigation:{
				prevEl:'.magazine-slide .mu-swiper-button-prev',
				nextEl:'.magazine-slide .mu-swiper-button-next'
			}
		});
	});
	$(function() {
        $(".search_date").each(function(){
			$(this).datepicker({
				// altField: "#datepicker-input",
				// altFormat: "yy-mm-dd",
				showButtonPanel: true,
				dateFormat: "yy-mm-dd",
				changeMonth: true,
				changeYear: true,
				yearRange: "c-100:c+10",
				dayNamesMin : [ "S", "M", "T", "W", "T", "F", "S" ],
				// defaultDate: +1,
				buttonImageOnly: true,
				buttonImage: "/img/calendar-i01.png",
				buttonText: "Pick Date",
				showOn: "button",
				dateFormat: "yymmdd",
			});   
		})
    });
	$(window).load(function(){
		$(".maga-btn").click(function(){
			$(".global-popwr").show();
			$(".global-pop").show();

		});
		$(".global-bg, .global-cls").click(function(){
			$(".global-popwr").hide();
			$(".global-pop").hide();
			
		});
	})
} ) ( jQuery);
</script>