<div class="main-insta slide-type02">
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
			<?php for($i=0; $i<15; $i++){ ?>
				<?php 
					if($result[$i]['media_type'] !== "VIDEO"){
				?>
				<li class="swiper-slide">
					<a href="<?php echo $result[$i]['permalink']; ?>" target="_blank">
					
	<!-- 					<video controls> -->
	<!-- 					  <source src="<?php echo $result[$i]['media_url']; ?>" type="video/mp4"> -->
	<!-- 					</video> -->
						<img src="<?php echo $result[$i]['media_url']; ?>">
					
					<!--
									<div class="insta-txt">
										<div class="insta-cell">
											<?php echo $result[$i]['caption']; ?>
										</div>
									</div>
					-->
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
			'redirect_uri'=>'https://spc.co.kr/',
			'code'=>'AQDPSfBccaA1c4Q5tLKaaRHU8batQLnvDQ_yRM_-rnYNXzmhs5kbOri5xxO3V1iRlxtB1fnv8ZoUyPiaYNmMIKshSVN5_dvADyktFH1_o0ijRGXCHzLb0w5BC_5jOESWp2-CHI0Z_yOUreeB-ytYpKd8F7e2Sjhl4HG54SURu9T06Wug1BZDThuNdiWRmeDfEIYRQJnVoi1aM-EibWxJ4ROU2y3QtFD_oWqNvnH-ruvNIA'
		);
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_POST,true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $post_array);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);  
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		$result = curl_exec($curl);
		curl_close($curl);
		$result = json_decode($result,true);
//		 print_r($result);
//		echo '<script>console.log("'.$result.'")</script>';
		?>
		<!-- 토큰값 
		   "access_token": "IGQVJWS1lWdkM1OW9BYmZAPVUhJdUdrbm9rcDg3SERHUUg4S3ZANR25iSFdzNEVIaEUwZAWVsVkFEcEJZAdFNfNjRZARWZAVM1FzLWJROXd5VmpGZAE1KbmxuMVBHTHpMQzZAGR1hFQlY3Vmd3",
		   "token_type": "bearer",
		   "expires_in": 5184000

		   장기 엑세스 토큰 주소
		   http://graph.instagram.com/refresh_access_token?grant_type=ig_refresh_token&access_token={long-lived-access-token}
		-->
	</div>
	<div class="swiper-pagwr"><div class="swiper-button-prev circle-arrow"></div><div class="swiper-button-next circle-arrow"></div><div class="swiper-pagination"></div></div>
</div>
<script>
	$(function(){
		var snsSlide = new Swiper('.main-insta .swiper-container',{
			slidesPerView:5,
			spaceBetween:38,
			loop:false,
			pagination:{
				el:$(".main-insta .swiper-pagination"),
				type: 'bullets',
			},
			navigation: {
			  nextEl:$(".main-insta .swiper-button-next"),
			  prevEl:$(".main-insta .swiper-button-prev"),
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
					spaceBetween:15,
					loop:true,
				}
			}
		})
	})
</script>