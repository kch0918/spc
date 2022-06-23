<?php
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");
?>

<div class="contri-wr text-center">
	<div class="contri-sec contri-sec02">
		<h2 class="ft-42 bold color-000 global-tit letter-0 img-ani bottom-top">SPC集团官方SNS频道</h2>
		<div class="btnwr img-ani bottom-top">
			<a href="https://www.instagram.com/spc_group/" target="_blank" class="main-btn sns-btn sns-btn01">
				<img src="/img/insta-i02.png" alt="spc.happyphoto 바로가기">Instagram
			</a>
		</div>
		<div class="contri-box img-ani">
			<div class="magazine-slide">
				<div class="main-insta slide-wr sns-show">
					<div class="swiper-container">
						<!-- 인스타그램 api 로 내 인스타 글 가져오기 -->
						<?php
						$url = "https://graph.instagram.com/17841403101639180/media?fields=id,media_type,media_url,permalink,thumbnail_url,username,caption&access_token=IGQVJWaU9BTG11a0tKTV9qVHJxLTBsQTBrZAVBLdXpVR1ByTmF1MFNlMkc1UWhuTTg5NFpDMGFJb3N5YjFPamlnbzd6TGd5cVZAyZADdFc2JNMHZARWElLZAnJqcG5UbGpsbFFnNFJzekxn";
						$curl = curl_init($url);
						curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);  
						curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
						$result = curl_exec($curl);
						curl_close($curl);
						 
						$result = json_decode($result, true);
						$result = $result['data'];
						?>
						<ul class="insta-wr swiper-wrapper tranDelayList">
							<?php for($i=0; $i<20; $i++){ ?>
								<?php 
									if($result[$i]['media_type'] !== "VIDEO"){
								?>
								<li class="swiper-slide">
									<a href="<?php echo $result[$i]['permalink']; ?>" class="insta-btn" target="_blank">
									
					<!-- 					<video controls> -->
					<!-- 					  <source src="<?php echo $result[$i]['media_url']; ?>" type="video/mp4"> -->
					<!-- 					</video> -->
										<img src="<?php echo $result[$i]['media_url']; ?>">
									
									
					<!-- 								<div class="insta-txt"> -->
					<!-- 									<div class="insta-cell"> -->
					<!-- 										<?php echo $result[$i]['caption']; ?> -->
					<!-- 									</div> -->
					<!-- 								</div> -->
									</a>
								</li>
								<?PHP
									}
								?>
							<?php } ?>
						</ul>
						<?php
						//액세스 토큰 발급
						$url = "https://api.instagram.com/oauth/access_token";
						$post_array = array(
							'client_id'=>'470839550865513',
							'client_secret'=>'44d2ccc0b2d7de7ee7309a90a3bfeaeb',
							'grant_type'=>'authorization_code',
							'redirect_uri'=>'https://musign.net/',
							'code'=>'AQCSVyGrFwPXmQuirqABnM5_V3_mrLALysesj5JbRIznyBQUX_l5m8W9BHrx9aNY6HrwCwl_cToIcMTePGamswYcDGlDkWzD7QDPkS3bGMuEdB0YXOrYYCAsrN3ZD3pxgY-wQQdF00uSvxPFlWSj7S4e2-MFMMqqELxHliMwlSHiDRSecQxMI1lYeJA7FhjVR0nXUDe0rymsPy-xxL0wjwhH_wDP7I3_HCrXPdRQBd7jFA'
						);
						$curl = curl_init($url);
						curl_setopt($curl, CURLOPT_POST,true);
						curl_setopt($curl, CURLOPT_POSTFIELDS, $post_array);
						curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);  
						curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
						$result = curl_exec($curl);
						curl_close($curl);
						$result = json_decode($result,true);
						//print_r($result);
						?>
						<!-- 토큰값 
						   "access_token": "IGQVJXdWRwOWp3QU9MQWhoQ3hTVlo0ZA3FvZA2JhNjNBYkZAkZAlBQaWloeFhDQzQxSW9kb1o5RzFVUlFMdGE2ZAlU5bFE4a1dSd0VBTW9rS1FmbHdZAa2pwT3FTWnJPNDVicUpFM1o1Mmdn",
						   "token_type": "bearer",
						   "expires_in": 5183086

						   장기 엑세스 토큰 주소
						   http://graph.instagram.com/refresh_access_token?grant_type=ig_refresh_token&access_token={long-lived-access-token}
						-->
					</div>
				</div>
				<div class="mu-swiper-button mu-swiper-button-next"></div>
				<div class="mu-swiper-button mu-swiper-button-prev"></div>
			</div>
		</div><!-- //contri-box -->
		<div class="btnwr img-ani bottom-top">
			<a href="https://www.facebook.com/happySPC" target="_blank" class="main-btn sns-btn sns-btn02">
				<img src="/img/facebook-i01.png" alt="spc.happyphoto 바로가기">Facebook
			</a>
		</div>
		<div class="contri-box img-ani review-slide facebook-slide">
			<div class="contri-list cardtype-list slide-wr face-list">
				<div class="swiper-container">
					<ul class="swiper-wrapper tranDelayList">
					<?php 
                        $query = "select *,DATE_FORMAT(submit_date, '%Y.%m.%d') as submit_date2 from SPC_SNS where expo_yn = 'Y' order by submit_date desc";
                        $result = sql_query($query);
                        for($i = 0; $i < sql_count($result); $i++){
                        $row = sql_fetch($result);
                            ?>
						<li class="swiper-slide">
							<a target="_blank" href="<?php echo $row['url']?>">
							<?php 
    								if($row['thumb'] != null) {
    								?>
        								<div class="thumb"><img src="/aDmin/file/<?php echo $row['thumb']?>" alt="spc그룹"><img class="de-img" src="/img/sub/card-thumb.png" alt="SPC그룹"/></div>
            						<?php 
    								} else {
    								?>
    									<div class="thumb"><img src="/aDmin/img/youtube-logo01.png" alt="spc그룹"><img class="de-img" src="/img/sub/card-thumb.png" alt="SPC그룹"/></div>
    								<?php 
    								}
    								?>
<!-- 								<div class="cont"> -->
<!-- 									<h2 class="ft-20"></h2> -->
<!-- 									<div class="etc"> -->
<!-- 										<time class="date"></time> -->
<!-- 									</div> -->
<!-- 								</div> -->
							</a>
						</li>
						<?php 
                        }
						?>
					</ul>
				</div>
			</div>
			<div class="mu-swiper-button mu-swiper-button-next"></div>
			<div class="mu-swiper-button mu-swiper-button-prev"></div>
		</div><!-- //contri-box -->
	</div>
	<div class="contri-sec sns-sec01 text-center">
		<h2 class="ft-42 bold color-000 global-tit img-ani bottom-top">Official social media channels of our affiliate brands</h2>
		<p class="ft-20 color-7d img-ani bottom-top">请一目了然地确认各品牌的官方频道。</p>
		<div class="channel-list">
		<?php 
		$query = "SELECT distinct a.idx, a.cate_logo, a.cate_name_cn,a.sort,b.face_url, b.insta_url,b.home_url, b.youtube_url from SPC_MID_CATE a join SPC_BRAND_BOARD b on a.idx = b.parentidx ORDER BY b.sort2*1 asc";
		$result = sql_query($query);
		for($i = 0; $i < sql_count($result); $i++){
		    $row = sql_fetch($result);
		?>
    		<?php 
    		if($row['home_url'] != null || $row['youtube_url'] != null || $row['insta_url'] != null || $row['youtube_url'] != null ) {
    		?>
		<div class="channel-row">
			<div class="table">
				<div class="chn-img"><img src="/aDmin/file/<?php echo $row['cate_logo']?>" alt="로고"/></div>
				<div class="channel-tit"><?php echo $row['cate_name_cn']?></div>
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
</div>

<script>
	$(window).ready(function(){
		var snsSlide = new Swiper('.main-insta .swiper-container',{
			slidesPerView:5,
			spaceBetween:38,
			navigation:{
				prevEl:'.magazine-slide .mu-swiper-button-prev',
				nextEl:'.magazine-slide .mu-swiper-button-next'
			},
			/*autoplay:{
				enable:true,
				delay:2000,
				disableOnInteraction: false
			},*/
			breakpoints:{
				1365:{
					spaceBetween:25,
				},
				989:{
					slidesPerView:4,
					spaceBetween:25
				},
				767:{
					slidesPerView:2,
					spaceBetween:15
				}
			}
		});
		
	});
	//sns 로드 후 노출
	$(window).load(function(){
		setTimeout(function(){
			$(".sns-show").css("opacity","1");
		},200)
	});
	$(function(){
		var newsSlide = new Swiper('.contri-list .swiper-container',{
			slidesPerView:3,
			spaceBetween:30,
			breakpoints:{
				989:{
					spaceBetween:28,
					slidesPerView:2
				},
				767:{
					spaceBetween:15,
					slidesPerView:1
				}
			},
			navigation:{
				prevEl:'.review-slide .mu-swiper-button-prev',
				nextEl:'.review-slide .mu-swiper-button-next'
			}
		});
	});

</script>
