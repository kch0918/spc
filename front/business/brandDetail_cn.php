<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");

 $query = "SELECT distinct
            a.idx,
            a.cate_dis_cn,
            a.cate_logo,
            b.*,
            a.cate_name_cn,
            DATE_FORMAT(b.submit_date, '%Y.%m.%d') as submit_date2,
            c.cate_brand_cn
            from SPC_MID_CATE a
            join SPC_BRAND_BOARD b
            on a.idx = b.parentidx
            JOIN SPC_BIG_CATE c
            ON a.parentidx = c.idx
            where b.parentidx = {$_REQUEST['idx']}";
         
$result = sql_query($query);
$row = sql_fetch($result);
?>
<div class="brand-detail brand-detail-<?php echo $row['idx']?>">
	<div class="bdetail-top">
		<div class="bdtop-slide">
			<ul>
    			<?php 
    			$insert1 = explode("|",$row['top_img']);
    			
    			for ($i = 0; $i < count($insert1); $i ++) {
    			?>
    				<li>
    					<img src="/aDmin/file/<?php echo $insert1[$i]?>" alt='파리바게트' value=""/>
    				</li>
    			<?php 
    				}
    			?>
			</ul>
		</div>
		<div class="bdtop-txt">
			<div class="img-ani bottom-top">
				<p class="bd-cata"><?php echo $row['cate_brand_cn']?></p>
				<h2><?php echo $row['cate_name_cn']?></h2>
				<p class="bd-stit ft-25"><?php echo $row['cate_dis_cn']?></p>
			</div>
		</div>
	</div>
	<div class="bdetail-bot">
		<div class="bdetail-sns img-ani bottom-top">
			<ul>
			<?php 
			if($row['youtube_url'] != null)
			  {
			?>
				<li><a href="<?php echo $row['youtube_url']?>" target="_blank"><img src="/img/brand/youtube.png" alt='유튜브'/></a></li>
    			<?php 
    			}
    			?>
			<?php 
			if($row['insta_url'] != null)
			  {
			?>
				<li><a href="<?php echo $row['insta_url']?>" target="_blank"><img src="/img/brand/instagram.png" alt='인스타그램'/></a></li>
				<?php 
    			}
    			?>
			<?php 
			if($row['face_url'] != null)
			  {
			?>
				<li><a href="<?php echo $row['face_url']?>" target="_blank"><img src="/img/brand/facebook.png" alt='페이스북'/></a></li>
				<?php 
    			}
    			?>
			</ul>
		</div>
		<div class="bdet-txt">
			<div class="bdetail-logo img-ani bottom-top"><img src="/aDmin/file/<?php echo $row['cate_logo']?>" alt="파리바게트"/></div>
			<div class="bdet-tit ft-34 img-ani bottom-top"><?php echo $row['title_cn']?></div>
			<div class="bdet-stit ft-22 img-ani bottom-top tran01">
			<?php echo $row['contents_cn']?>
			</div>
		</div>
		<div class="bdet-slide img-ani bottom-top">		
			<ul>
			<?php 
			$insert = explode("|",$row['cont_img']);
			
			for ($i = 0; $i < count($insert); $i ++) {
			?>
				<li>
					<img src="/aDmin/file/<?php echo $insert[$i]?>" alt='파리바게트' value=""/>
				</li>
			<?php 
				}
			?>
			</ul>
		</div>
		<div class="bdet-btnwr img-ani bottom-top">
			<a href="<?php echo $row['home_url']?>" target="_blank" class="main-btn home-href">
				<span class="img-hov">
					<img class="de-img" src="/img/brand/home-icon.png" alt="홈페이지 바로가기" value=""/>
					<img class="ho-img" src="/img/brand/home-icon-w.png" alt="홈페이지 바로가기" value=""/>
				</span>进入主页
			</a>
			<?php 
				if($row['idx'] == 30){ 			
			?>
			<div class="happy-qr">
				<a class="btn btn02">二维码</a>
				<img src="/img/brand/happy-qr.png" alt="해피포인트 큐알코드"/>
			</div>
			<?php
				}
			?>
		</div>
	</div>
</div>


<script>
	$(function(){
		$('.bdet-slide ul').slick({
			infinite: true,
			slidesToShow: 4,
			slidesToScroll: 2,
			responsive: [
				{
				  breakpoint: 1280,
				  settings: {
					slidesToShow: 2,
					slidesToScroll: 2,
					infinite: true,
					dots: true
				  }
				},
				{
				  breakpoint: 767,
				  settings: {
					slidesToShow: 1,
					slidesToScroll: 1
				  }
				}
			]
			
		});
		
		$('.bdtop-slide ul').slick({
			infinite: true,
			slidesToShow: 1,
			slidesToScroll: 1,
			dots:true
			
		});
	});
</script>