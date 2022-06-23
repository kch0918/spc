<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");


 $query = "SELECT distinct
            a.idx,
            a.cate_dis_en,
            a.cate_logo,
            b.*,
            a.cate_name_en,
            DATE_FORMAT(b.submit_date, '%Y.%m.%d') as submit_date2,
            c.cate_brand_en
            from SPC_MID_CATE a
            join SPC_SUB_BOARD b
            on a.idx = b.parentidx
            JOIN SPC_BIG_CATE c
            ON a.parentidx = c.idx
            where b.parentidx = {$_REQUEST['idx']}";
         

$result = sql_query($query);
$row = sql_fetch($result);

?>

<div class="subs-detail">
	<div class="sdetail-bg" style="background-image:url(/aDmin/file/<?php echo $row['top_img']?>)"></div>
	<div class="sdetail-left">
		<p><?php echo $row['cate_brand_en']?></p>
		<a href="/subsidiary-list/?lang=en" class="back-btn">뒤로가기</a>
		<a class="cls-btn">뒤로가기</a>
	</div>
	<div class="sdetail-top">
		<div class="table">
			<div>
				<div class="sdetail-grid">
					<div class="sdetail-txt">
						<p class="img-ani bottom-top tran01 ft-18"><?php echo $row['cate_dis_en']?></p>
						<h2 class="img-ani bottom-top tran02"><?php echo $row['cate_name_en']?></h2>
						<a class="scroll-i main-btn img-ani"><span class="scroll-ani"><img src="/img/subsidiary/subs-scroll.png" alt="spc삼립"/></span>SCROLL</a>
						<div class="sdetop-logo img-ani">
							<img src="/aDmin/file/<?php echo $row['cate_logo']?>" alt="spc삼립" />
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="sdetail-bot" animation-value="0">
		<div class="sdetail-grid">		
			<div class="sdetail-dot img-ani"></div>
			<div class="sde-infowr">
				<div class="sde-maxw img-ani bottom-top">
					<a href="<?php echo $row['home_url']?>" class="home-go"><span class="home-iwr"><img src="/img/subsidiary/home-i.png" alt="홈페이지바로가기"/></span>Homepage</a>
					<h2 class="ft-41"><span class="ft-18"><?php echo $row['cate_brand_en']?></span><?php echo $row['cate_name_en']?></h2>
				</div>
				<div class="sde-img round-box img-ani bottom-top"><img src="/aDmin/file/<?php echo $row['cont_img']?>" alt="<?php echo $row['cate_name_en']?>"/></div>
				<div class="sde-maxw">
					<div class="sde-infotxt img-ani bottom-top">
						<?php echo $row['contents_en']?>
					</div>
					
			<?php 
			if($row['cont_img2'] != null)
			{
			?>		
					<div class="bd-catawr">
						<p class="bd-cata">Brand introduction</p>
					</div>
				</div>
			</div>
			<div class="sde-slide">		
				<ul>
					<?php 
        			$insert1 = explode("|",$row['cont_img2']);
        			
        			for ($i = 0; $i < count($insert1); $i ++) {
        			?>
    					<li>
    						<div><a><img src="/aDmin/file/<?php echo $insert1[$i]?>" alt='파리바게트'/></a></div>
    					</li>
        			<?php 
        				}
        			?>
				</ul>
			<?php 
			}
			?>	
			</div>
			<div class="sde-ul">
				<ul>
					<li class="round-box">
						<div class="sde-icon"><img src="/img/subsidiary/subs-i01.png" alt="브랜드정보"/></div>
						<p class="sdeli-tit">CEO</p>
						<?php echo $row['ceo_en']?>
					</li>
					<li class="round-box">
						<div class="sde-icon"><img src="/img/subsidiary/subs-i02.png" alt="브랜드정보"/></div>
						<p class="sdeli-tit">Company Name</p>
						<?php echo $row['corp_en']?>
					</li>
					<?php 
					if($row['tel'] != null) {
					?> 
					<li class="round-box">
						<div class="sde-icon"><img src="/img/subsidiary/subs-i05.png" alt="브랜드정보"/></div>
						<p class="sdeli-tit">Contact</p>
						<?php echo $row['tel']?>
					</li>
					<?php 
					}
					?>
					<?php 
        			$insert2 = explode("|",$row['addr_en']);
        			
        			for ($i = 0; $i < count($insert2); $i ++) {
        			?>
					<li class="round-box">
						<div class="sde-icon"><img src="/img/subsidiary/subs-i03.png" alt="브랜드정보"/></div>
						<p class="sdeli-tit">Address<?php echo $i+1?></p>
						<?php echo $insert2[$i]?>
					</li>
					<?php 
    				}
        			?>
				</ul>
			</div>
		</div>
	</div><!-- //sdetail-bot -->
</div>

<script>
	$(function(){
		$("html").addClass("subsidiary-html");
		height();
	
		$(".scroll-i").on("click",function(){
			open();
		});
		$(".sdetail-bg,.cls-btn").on("click",function(){
			close();
		});
			
		$(".sdetail-top").bind("touchmove",function(e){
			e.preventDefault();
			open();
		});
	
		$(".sdetail-bot").on('wheel touchmove', function (e) {
			var s = $(this).scrollTop(),
				val = $(".sdetail-bot").attr("animation-value");
			
			if (e.originalEvent.deltaY < 0) {
				if(s == 0 && val == "1"){
					close();
				}
			} else {
				if(s>50){
					scr_event();
					
				}
			}
		});
		$(".sdetail-top").on('wheel', function (e) {
			var val = $(".sdetail-bot").attr("animation-value");
			if (e.originalEvent.deltaY > 0 && val == "0") {
				open();
			}
		});

		$('.sde-slide ul').slick({
			variableWidth:true,
			autoplay:true,
			autoplaySpeed:0,
			arrows:false,
			touchMove:false,
			swipe:false,
			pauseOnHover:false,
			pauseOnFocus:false,
			draggable:false,
			accessibility:false,
			cssEase:'linear',
			speed:6000,
			centerMode:true,
			edgeFriction:0
		})
	});
	
	$(window).resize(function(){
		height()
	})
	function height(){
		var H = $(window).height();
		$(".subs-detail").css("height",H);
	}
	function close(){
		$(".sdetail-bot").addClass("remove");
		$(".sdetail-left").removeClass("on");
		setTimeout(function(){
			$(".sdetail-bot").removeClass("on");
			$("html").removeClass("black-html");
		},200);
		setTimeout(function(){
			$(".sdetail-bot").removeClass("remove");
			$(".sdetail-bot").attr("animation-value","0");
		},1000);
	}
	function open(){
		$("html").addClass("black-html");
		$(".sdetail-left").addClass("on");
		$(".sdetail-bot").addClass("on");
		setTimeout(function(){
			$(".sdetail-bot").attr("animation-value","1");
		},1000);
	}
	function scr_event(){
		$(".sdetail-bot .img-ani").each(function(){
			var w_t = $(".sdetail-bot").scrollTop() + $(window).height();
			var i_t = $(this).offset().top;
			if(w_t > i_t + 200){
				$(this).addClass("img-aniload");
			}
		})
	}
</script>