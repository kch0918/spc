<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");

?>
<script>
//조회
function goNews(idx)
{
	location.href="/media-hub/news/detail_en/?idx="+idx + "&lang=en";
}
</script>
<div class="news-latest cardtype-list slide-type01">
	<div class="swiper-container">
	<ul class="swiper-wrapper tranDelayList">
	 <?php 
            $query = "select *,DATE_FORMAT(submit_date, '%Y.%m.%d') as submit_date2 from SPC_REPORT where lang = 'en' order by submit_date DESC limit 4";
            $result = sql_query($query);
            for($i = 0; $i < sql_count($result); $i++){
            $row = sql_fetch($result);
                ?>
			<li class="swiper-slide">
				<a href="javascript:goNews(<?php echo $row['idx']?>);">
				<?php 
        			if($row['thumb'] != null) {
        			?>
        				<div class="thumb"><img src="/aDmin/file/<?php echo $row['thumb']?>" alt="SPC그룹 뉴스"/><img class="de-img" src="/img/sub/card-thumb.png" alt="SPC그룹"/></div>
        			<?php 					
        			} else {
        			?>
        				<div class="thumb"><img src="/aDmin/img/youtube-logo01.png" alt="SPC그룹 뉴스"><img class="de-img" src="/img/sub/card-thumb.png" alt="SPC그룹 뉴스"/></div>
        			<?php 
        			}
        			?>
				</a>
				<div class="cont">
					<a href="javascript:goNews(<?php echo $row['idx']?>);"><strong><?php echo $row['title']?></strong></a>
<!-- 					<p class="desc">새 단장을마친 해피포인트의 BI와 해피앱을 소개합니다 </p> -->
					<div class="etc">
						<time class="date"><?php echo $row['submit_date2']?></time>
						<a href="javascript:goNews(<?php echo $row['idx']?>);">VIEW MORE</a>
					</div>
				</div>
			</li>
			
			<?php 
            }
            ?>
		</ul>
	</div>
	<div class="swiper-pagwr"><div class="swiper-button-prev circle-arrow"></div><div class="swiper-button-next circle-arrow"></div><div class="swiper-pagination"></div></div>
</div>