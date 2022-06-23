<?php
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");

?>
<script>
var type2 = "<?php echo $_POST['type2']?>";

//검색
function reSelect(act)
{
	$("#page").val(1);
	$("#fncForm").submit();
}

// function Cate(type){
// 	// input에 value 값 넣어주기
// 	$('input[name="type"]').val(type);
// }

function Cate2(type2) {
	// input에 value 값 넣어주기
	$('input[name="type2"]').val(type2);
}

//페이지 로딩시 
$(document).ready(function(){
	if(type2 != ""){
		$("#type_name2").text(type2);
	}
})

</script>
<div class="contri-wr text-center">
	<div class="contri-sec contri-sec01">
		<h2 class="ft-42 bold color-000 global-tit letter-0 img-ani bottom-top">NEW CF</h2>
		<form id="fncForm" name="fncForm" method="post" action="/media-hub/cf/">
    	    <input type="hidden" id="type" name="type" value="">
    	    <input type="hidden" id="type2" name="type2" value="">
		<div class="contri-box img-ani">
			<div class="cf-slidewr">
				<div class="cf-slide">
					<div class="swiper-container">
						<ul class="insta-wr swiper-wrapper tranDelayList">
    					<?php 
                            $query = "select *,DATE_FORMAT(submit_date, '%Y.%m.%d') as submit_date2 from SPC_CF where expo_yn = 'Y' order by submit_date desc";
                            $result = sql_query($query);
                            for($i = 0; $i < sql_count($result); $i++){
                            $row = sql_fetch($result);
                            
                            $youtube_url = $row['url'];
                            $regExp = '/^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/';
                            preg_match($regExp, $youtube_url, $matches);
                            $thumb = $matches[7];
                        ?>
							<li class="swiper-slide">
								<a class="vdo-img" href="https://www.youtube.com/watch?v=<?php echo $thumb?>" style="background-image:url(http://img.youtube.com/vi/<?php echo $thumb?>/sddefault.jpg">
									<img src="http://img.youtube.com/vi/<?php echo $thumb?>/mqdefault.jpg" alt="cf"/>
									<img src="http://img.youtube.com/vi/<?php echo $thumb?>/maxresdefault.jpg" alt="cf"/>
								</a>
								<div class="vdo-btn"><span>VIDEO PLAY</span><canvas class="vdo-can" width="160" height="160" ></canvas></div>
							</li>
						<?php 
                        }
						?>
						</ul>
					</div>
				</div>
				<div class="mu-swiper-button mu-swiper-button-next"></div>
				<div class="mu-swiper-button mu-swiper-button-prev"></div>
				<div class="swiper-pagination"></div>
			</div>
		</div><!-- //contri-box -->
	</div>
	<div class="contri-sec contri-sec04">
		<div class="board-search table board-search-cf">
			<div class="contri-data">
				<div class="table">
<!-- 					<div class="cf-year"> -->
<!-- 						<div id="search_option" name="search_option" class="select"> -->
<!-- 							<p id="type_name"><strong>2021</strong></p> -->
<!-- 							<ul> -->
							<?php 
// 							for ($i = 1; $i < 10; $i++) {
//                                 ?>
							 <!--   <li><a href="javascript:Cate('<?php echo "200".$i?>');">200<?php echo $i?></a></li> 
							    <?php 
// 							    }
// 							    ?>
					    	<?php 
// 							for ($i = 10; $i < 22; $i++) {
//                                 ?>
							    <li><a href="javascript:Cate('<?php echo "20".$i?>');">20<?php echo $i?></a></li> -->
							    <?php 
// 							    }
// 							    ?>
<!-- 							</ul> -->
<!-- 						</div> -->
<!-- 					</div> -->
					<div>
						<div class="select" id="search_option2" name="search_option2">
							<p id="type_name2"><strong>구분</strong></p>
								<ul id="Cate2">
									<li><a href="javascript:Cate2();">전체</a></li>
									<li><a href="javascript:Cate2('삼립');">삼립</a></li>
									<li><a href="javascript:Cate2('파리바게뜨');">파리바게뜨</a></li>
									<li><a href="javascript:Cate2('배스킨라빈스');">배스킨라빈스</a></li>
									<li><a href="javascript:Cate2('던킨');">던킨</a></li>
								</ul>
						</div>
					</div>
					<div class="cf-search">
						<input type="button" class="ico_search" value="" onclick="reSelect('search');">
					</div>
				</div>
			</div>
		</div>
		<div class="contri-box img-ani review-slide">
			<div class="contri-list cardtype-list slide-wr">
				<div class="swiper-container">
					<ul class="contri-list cardtype-list">
						<?php 
                            $query = "select *,DATE_FORMAT(submit_date, '%Y.%m.%d') as submit_date2 from SPC_CF where expo_yn = 'Y'";
                            
                            if(isset($_POST['type2']) && $_POST['type2'] != null && $_POST['type2'] != "")
                            {
                                $query .= " and type = '{$_POST['type2']}'";
                            }
                            
                            else
                            {
                                $query .= " order by type desc";
                            } 
                            
                            $result = sql_query($query);
                            for($i = 0; $i < sql_count($result); $i++){
                            $row = sql_fetch($result);
                            
                            $youtube_url = $row['url'];
                            $regExp = '/^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/';
                            preg_match($regExp, $youtube_url, $matches);
                            $thumb = $matches[7];
                        ?>
						<li>
							<a href="https://www.youtube.com/watch?v=<?php echo $thumb?>">
								<div class="thumb vdo-img" style="background-image:url(http://img.youtube.com/vi/<?php echo $thumb?>/sddefault.jpg">
									<img src="http://img.youtube.com/vi/<?php echo $thumb?>/mqdefault.jpg" alt="사회공헌 최근소식" class=""><img class="de-img" src="/img/sub/card-thumb.png" alt="SPC그룹"/>
								</div>
								<div class="cont">
									<h2 class="ft-20"><?php echo $row['title']?></h2>
									<div class="etc">
										<time class="date"><?php echo $row['submit_date2']?></time>
									</div>
								</div>
							</a>
						</li>	
						<?php 
                        }
						?>	
					</ul>
				</div>
			</div>
		</div><!-- //contri-box -->
	</div>
</div>
</form>
<Script>

	
	$(document).on("click",".vdo-btn",function(){
		var li = $(this).parents("li").find(".vdo-img");
		li.trigger("click")
	})
	// 슬라이드 애니메이션
	animateCircle = function(e) {
		var ctx = document.querySelector('.swiper-pagination-bullet-active .play01').getContext('2d');
		var end = Math.PI * 1.5;
		for (var i = 0; i < 1300; i++) {
			draw(i);
		};
		function draw(delay) {
			setTimeout(function() {
			  ctx.clearRect(0, 0, 56, 56);
			  ctx.beginPath();
			  ctx.arc(28, 28, 17, 0, end / 900 * delay);
			  ctx.strokeStyle = "#23afe3"; 
			  ctx.stroke();
			  ctx.lineWidth = 2;
			}, delay * 10);
		}
	};
	animateCircle2 = function(e) {
		var ctx2 = document.querySelector('.swiper-slide-active .vdo-can').getContext('2d');
		var end = Math.PI * 1.5;
		for (var j = 0; j < 100; j++) {
			draw2(j);
		};
		function draw2(delay) {
			setTimeout(function() {
			  ctx2.clearRect(0, 0, 160, 160);
			  ctx2.beginPath();
			  ctx2.arc(80, 80, 45, 0, end / 90 * delay);
			  ctx2.strokeStyle = "#fff"; 
			  ctx2.stroke();
			  ctx2.lineWidth = 6;
			}, delay * 5);
		}
	};

	//유튜브
	$(function(){		
		var snsSlide = new Swiper('.cf-slidewr .swiper-container',{
			slidesPerView:1,
			dots:false,
			navigation:{
				prevEl:'.cf-slidewr .mu-swiper-button-prev',
				nextEl:'.cf-slidewr .mu-swiper-button-next'
			},
			pagination : { // 페이징 설정
				el : '.swiper-pagination',
				clickable : true, // 페이징을 클릭하면 해당 영역으로 이동, 필요시 지정해 줘야 기능 작동
			},
		});
		snsSlide.on('slideChange', function () {
			$(".cf-slidewr .swiper-pagination-bullet canvas").remove();
			$(".cf-slidewr .swiper-pagination-bullet").eq(snsSlide.realIndex).append('<canvas class="play01" width="56" height="56"></canvas>');
			$(".cf-slide .swiper-slide").removeClass("play");
			$(".cf-slide .vdo-btn").remove();
			$(".cf-slide .swiper-slide").eq(snsSlide.realIndex).append('<div class="vdo-btn"><span>VIDEO PLAY</span><canvas class="vdo-can" width="160" height="160" ></canvas></div>');
			animateCircle();
		});
		$(".cf-slide .swiper-slide").hover(function(){
			var chk = $(this).hasClass("play");
			if(!chk) animateCircle2();
			$(this).addClass("play");
			
		})
	});
</script>