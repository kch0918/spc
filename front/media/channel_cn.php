<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");
?>
<div class="contri-sec sns-sec01 text-center">
	<h2 class="ft-42 bold color-000 global-tit img-ani bottom-top">品牌官方频道</h2>
	<p class="ft-20 color-7d img-ani bottom-top">请一目了然地确认各品牌的官方频道</p>
	<div class="channel-list">
		<?php 
		$query = "SELECT distinct a.idx, a.cate_logo, a.cate_name_en,a.sort,b.face_url, b.insta_url,b.home_url, b.youtube_url from SPC_MID_CATE a join SPC_BRAND_BOARD b on a.idx = b.parentidx ORDER BY b.sort2*1 asc";
		$result = sql_query($query);
		for($i = 0; $i < sql_count($result); $i++){
		    $row = sql_fetch($result);
		?>
		<?php 
		if($row['youtube_url'] != null || $row['insta_url'] != null || $row['youtube_url'] != null ) {
		?>
		<div class="channel-row">
			<div class="table">
				<div class="chn-img"><img src="/aDmin/file/<?php echo $row['cate_logo']?>" alt="로고"/></div>
				<div class="channel-tit"><?php echo $row['cate_name_en']?></div>
				<?php 
				if($row['home_url'] != null) {
				?>
				<div class="channel-iwr"><a target="_blank" href="<?php echo $row['home_url']?>" class="channel-i"><img src="/img/sub/channel-i03.png" alt="로고"/></a></div>
				<?php 
				}
				?>
				<?php 
				if($row['insta_url'] != null) {
				?>
				<div class="channel-iwr"><a target="_blank" href="<?php echo $row['insta_url']?>" class="channel-i"><img src="/img/sub/channel-i01.png" alt="로고"/></a></div>
				<?php 
				}
				?>
				<?php 
				if($row['face_url'] != null) {
				?>
				<div class="channel-iwr"><a target="_blank" href="<?php echo $row['face_url']?>" class="channel-i"><img src="/img/sub/channel-i02.png" alt="로고"/></a></div>
				<?php 
				}
				?>
				<?php 
				if($row['youtube_url'] != null) {
				?>
				<div class="channel-iwr"><a target="_blank" href="<?php echo $row['youtube_url']?>" class="channel-i"><img src="/img/brand/youtube.png" alt="로고"/></a></div>
				<?php 
				}
				?>
			</div>
		</div>
		<?php 
		}
		?>
		<?php 
		}
		?>
	</div>
</div>
<div class="contri-sec sns-sec01 text-center">
	<h2 class="ft-42 bold color-000 global-tit img-ani bottom-top">进入旗下公司主页</h2>
	<div class="channel-list">
	<?php 
	$query = "SELECT * from SPC_MID_CATE a join SPC_SUB_BOARD b on a.idx = b.parentidx order by b.idx asc";
	$result = sql_query($query);
	for($i = 0; $i < sql_count($result); $i++){
	    $row = sql_fetch($result);
	    ?>
		<div class="channel-row">
			<div class="table">
				<div class="chn-img"><img src="/aDmin/file/<?php echo $row['cate_logo']?>" alt="로고"/></div>
				<div class="channel-tit"><?php echo $row['cate_name_cn']?></div>
				<div class="channel-iwr"><a href="<?php echo $row['home_url']?>" class="channel-i"><img src="/img/sub/channel-i03.png" alt="로고"/></a></div>
			</div>
		</div>
		<?php 
    	}
	   ?>
	</div>
</div>

<script>
	$(function(){
		var newsSlide = new Swiper('.point-latest .swiper-container',{
			slidesPerView:5,
			spaceBetween:12,
			breakpoints:{
				989:{
					spaceBetween:12,
					slidesPerView:3
				},
				767:{
					spaceBetween:10,
					slidesPerView:1.2,
					
				}
			},
			navigation:{
				prevEl:'.point-latest .swiper-button-prev',
				nextEl:'.point-latest .swiper-button-next'
			}
		});
	})
</script>