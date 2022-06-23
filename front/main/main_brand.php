<?php
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");
?>
<div class="main-brand-wrap tab-wrapper">
	<div class="tab-button-wrap">
		<a href="#tab01" class="active noscroll"><img src="/img/main/main03_icon01.png" alt="">베이커리/디저트</a>
		<a href="#tab02" class="noscroll"><img src="/img/main/main03_icon02.png" alt="">외식/다이닝</a>
		<a href="#tab03" class="noscroll"><img src="/img/main/main03_icon03.png" alt="">카페/음료</a>
		<a href="#tab04" class="noscroll"><img src="/img/main/main03_icon04.png" alt="">유통/서비스</a>
	</div>
	
	<div class="tab-content-wrap">
  	<?php 
    $query = "select * from SPC_BIG_CATE where cate_type = 'brand'";
    $result = sql_query($query);
    for($i = 0; $i < sql_count($result); $i++){
        $row = sql_fetch($result);
    ?>
		<div id="tab0<?php echo $i+1?>" class="tab-content">
			<div class="inner-content">
				<div class="swiper-container">
					<ul class="swiper-wrapper">
					<?php 
                		$query2 = "SELECT distinct a.*, b.home_url from SPC_MID_CATE a join SPC_BRAND_BOARD b on a.idx = b.parentidx WHERE a.parentidx = '{$row['idx']}' order by sort asc";
                		$result2 = sql_query($query2);
                		for($n = 0; $n < sql_count($result2); $n++){
                		    $row2 = sql_fetch($result2);
                		?>
					 	<li class="swiper-slide">
					 		<div class="brand-btn">
								<div class="front"><a href="<?php echo $row2['home_url']?>"><img src="/aDmin/file/<?php echo $row2['cate_logo']?>" alt="" /></a></div>
								<div class="back">
									<a href="<?php echo $row2['home_url']?>">
									<strong><?php echo $row2['cate_name']?></strong>
									<?php echo $row2['cate_dis']?></a>
								</div>
					 		</div>
						</li>
						<?php 
                		}
						?>
					</ul>
				</div>
			</div>
		</div>
		<?php 
         }
		?>
	</div>
</div>


<script>
$(function(){
	$('.tab-content').eq(0).addClass('active-tab');
	
	$(window).scroll(function(){
		if($('#main-sec03').hasClass('img-aniload') && $('active-tab .brand-btn.load').length < 1)
		btnLoad();
	});
	
	$('.tab-button-wrap a').click(function(e){
		e.preventDefault();
		var link = $(this).attr('href');
		$('.brand-btn').removeClass('load');
		$('.tab-button-wrap a').removeClass('active');
		$(this).addClass('active');
		$(this).closest('.tab-wrapper').find('.tab-content').removeClass('active-tab');
		$(this).closest('.tab-wrapper').find(link).addClass('active-tab');
		btnLoad();
	});
	
	function btnLoad(){
		$('.active-tab .brand-btn').each(function(){
			var delayTime = $(this).parent().index() * 200 + 200;
			var $this = $(this);
			setTimeout(function(){
				$this.addClass('load');
			},delayTime);
		});
	}
});
</script>