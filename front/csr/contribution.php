<?php
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");

$query2 = "select *,DATE_FORMAT(submit_date, '%Y.%m.%d') as submit_date2 from SPC_SOCIAL where lang = 'ko' and expo_yn='Y'";
// print_r($_POST);

$time_stamp = strtotime("-9 year");
$start_date = date("Ymd", $time_stamp);
$end_date = date("Ymd");
$date_picker1 = (isset($_REQUEST['datepicker1'])) ? $_REQUEST['datepicker1'] : $start_date;
$date_picker2 = (isset($_REQUEST['datepicker2'])) ? $_REQUEST['datepicker2'] : $end_date;

// 조회기간 검색
if($date_picker1 != "" && $date_picker2 != "")
{
    $query2 .= " and submit_date BETWEEN '{$date_picker1}' and '{$date_picker2}'";
}

if(isset($_POST['search_name']) && $_POST['search_name'] != null && $_POST['search_name'] != "")
{
    $query2 .= " and title like '%{$_POST['search_name']}%' or contents like '%{$_POST['search_name']}%'";
}

else
{
    $query2 .= " order by submit_date desc";
}

$result2 = sql_query($query2);
$row2 = sql_fetch($result2);


// 현재 페이지
$page = ($_REQUEST['page'])?$_REQUEST['page']:1;

if(!isset($_REQUEST['listSize']))
{
    $listSize = 12;
}
else
{
    $listSize = $_REQUEST['listSize'];
}

$list = $listSize;
$block = 5;
$pageNum = ceil(sql_count($result2)/$list); // 총 페이지
$blockNum = ceil($pageNum/$block);             // 총 블록
$nowBlock = ceil($page/$block);

$s_page = ($nowBlock * $block) - ($block-1);
if ($s_page <= 1) {
    $s_page = 1;
}
$e_page = $nowBlock*$block;
if ($pageNum <= $e_page) {
    $e_page = $pageNum;
}

$n = sql_count($result2);
?>
<script>
var listSize = "<?php echo $listSize?>";
var page = "<?php echo $page?>";
var search_name = "<?php echo $_POST['search_name']?>";
var datepicker11 = "<?php echo $date_picker1?>";
var datepicker22 = "<?php echo $date_picker2?>";

//페이지 로딩시 
$(document).ready(function(){
	$("#datepicker1").val(datepicker11);
	$("#datepicker2").val(datepicker22);
	
	$("#p_"+page).addClass("current");
	$("#search_name").val(search_name);
	if(listSize != "")
	{
		$("#listSize").val(listSize);
	}
})

// 페이지
function pageMove(page)
{
	$("#page").val(page);
	$("#fncForm").submit();
}

//검색
function reSelect(act)
{
	$("#page").val(1);
	$("#fncForm").submit();
}

//엔터로 검색
function enter_check()
{
	if(event.keyCode == 13){
		reSelect('search');
		return;
	}
}

//조회
function goSocial(seq)
{
	location.href="/contributionView?seq="+seq;
}



</script>

<div class="contri-wr text-center">
	<div class="contri-sec contri-sec01">
		<h2 class="ft-42 bold color-000 global-tit img-ani bottom-top">사회공헌 최근 소식</h2>
		<p class="ft-20 color-7d img-ani bottom-top">SPC그룹의 따끈따끈한 사회공헌 소식을 만나보세요</p>
		<form id="fncForm" name="fncForm" method="post" action="/share/society/contribution/">
			<select id="listSize" name="listSize" class="hidden">
        		<option value="12">12개 보기</option>
        		<option value="50">50개 보기</option>
        		<option value="100">100개 보기</option>
        		<option value="300">300개 보기</option>
        		<option value="500">500개 보기</option>
        		<option value="1000">1000개 보기</option>
        	</select>
            <input type="hidden" id="page" name="page" value="<?php echo $page?>">
            <input type="hidden" id="idx" name="idx" value="<?php echo $row2['seq']?>">
		<div class="contri-box img-ani">
			<div class="contri-list cardtype-list">
				<div class="swiper-container">
					<ul class="swiper-wrapper tranDelayList">
					 <?php 
                        $query = "select *,DATE_FORMAT(submit_date, '%Y.%m.%d') as submit_date2 from SPC_SOCIAL where expo_yn='Y' order by submit_date DESC LIMIT 5";
                        $result = sql_query($query);
                        for($i = 0; $i < sql_count($result); $i++){
                        $row = sql_fetch($result);
                            ?>
						<li class="swiper-slide">
							<a href="javascript:goSocial(<?php echo $row['seq']?>);">
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
								
								<div class="cont">
									<h2 class="ft-20"><?php echo $row['title']?></h2>
									
									<div class="etc">
										<span class="writer">SPC</span><time class="date"><?php echo $row['submit_date2']?></time>
									</div>
								</div>
							</a>
						</li>
						<?php 
                        }
        				?>
					</ul>
					<!--
					<div class="swiper-button-prev circle-arrow"></div>
					<div class="swiper-button-next circle-arrow"></div>
					-->
				</div>
			</div>
		</div><!-- //contri-box -->
	</div>
	<div class="contri-sec contri-sec02">
		<h2 class="ft-42 bold color-000 global-tit img-ani bottom-top">SPC행복한재단 인스타그램</h2>
		<div class="contri-box sns-show">
			<div class="main-insta">
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
						<li class="swiper-slide">
							<a href="<?php echo $result[$i]['permalink']; ?>" target="_blank">
							<?php 
							if($result[$i]['media_type'] == "VIDEO"){
							?>
								<video controls>
								  <source src="<?php echo $result[$i]['media_url']; ?>" type="video/mp4">
								</video>
							<?PHP
							}else{
							?>
								<img src="<?php echo $result[$i]['media_url']; ?>">
							<?PHP
							}
							?>
							
<!-- 								<div class="insta-txt"> -->
<!-- 									<div class="insta-cell"> -->
<!-- 										<?php echo $result[$i]['caption']; ?> -->
<!-- 									</div> -->
<!-- 								</div> -->
							</a>
						</li>
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
			<div class="btnwr img-ani bottom-top">
				<a href="#" class="main-btn home-href">
					<img src="/img/insta-i01.png" alt="spc.happyphoto 바로가기">@spc.happyphoto
				</a>
			</div>
		</div><!-- //contri-box -->
	</div>
	<div class="contri-sec contri-sec03">
		<h2 class="ft-42 bold color-000 global-tit img-ani bottom-top">사회공헌 소식 영상보기</h2>
		<div class="contri-box">
			<div class="img-ani bottom-top">
				<div class="swiper-container"><div id="youtubeBox" class="vdo-wr swiper-wrapper"></div></div>
			</div>
			<div class="main-video-wrap sns-show">
				<div class="main-video-cont">
					<a href="#videoClose"><img src="/img/layout/icon_popup_close.png" alt="닫기"></a>
					<iframe src=""></iframe>
				</div>
			</div>
			<div class="btnwr img-ani bottom-top">
				<a href="https://www.youtube.com/playlist?list=PLHRufFL8G9GUTVRjBCHnUflpQ-ij_26AW" target="_blank" class="main-btn home-href">
					<img src="/img/youtube-i01.png" alt="YOUTUBE 바로가기">YOUTUBE 바로가기
				</a>
			</div>
		</div><!-- //contri-box -->
	</div>
	<div class="contri-sec contri-sec04">
		<h2 class="ft-42 bold color-000 global-tit img-ani bottom-top">사회공헌 소식</h2>
		<p class="ft-20 color-7d img-ani bottom-top">SPC그룹의 따끈따끈한 사회공헌 소식을 만나보세요</p>
		<div class="contri-box img-ani">
			<div class="board-search table">
				<div class="contri-data">
					<div class="table">
					    <div><input autocomplete="off" type="text" id="datepicker1" class="search_date" name="datepicker1" value="<?php echo $_POST['datepicker1']?>"></div>
						<div class="data-hi">~</div>
						<div><input autocomplete="off" type="text"  class="search_date"  id="datepicker2" name="datepicker2" value="<?php echo $_POST['datepicker2']?>"></div>
					</div>
				</div>
				<div class="serch_key_box">
					<div class="search-input">
						<input type="text" id="search_name" name="search_name" class="search_key" placeholder="제목 또는 내용을 입력해주세요" value="<?php echo $_POST['search_name']?>" onkeydown="javascript:enter_check();">
						<input type="button" class="ico_search" value="" onclick="reSelect('search');" >
					</div>
				</div>
			</div>
			<ul class="contri-list cardtype-list">
			  <?php 
			  		    $s_point = ($page-1) * $list;
			  		    $result2 = sql_query($query2." limit {$s_point},{$list}");
                        for($n = 0; $n < sql_count($result2); $n++)
                        {
                          $row2 = sql_fetch($result2);
                        ?>
				<li>
					<a href="javascript:goSocial(<?php echo $row2['seq']?>);">
						<?php 
            			if($row2['thumb'] != null) {
            			?>
            				<div class="thumb"><img src="/aDmin/file/<?php echo $row2['thumb']?>" alt="spc그룹"><img class="de-img" src="/img/sub/card-thumb.png" alt="SPC그룹"/></div>
            			<?php 					
            			} else {
            			?>
            				<div class="thumb"><img src="/aDmin/img/youtube-logo01.png" alt="spc그룹"><img class="de-img" src="/img/sub/card-thumb.png" alt="SPC그룹"/></div>
            			<?php 
            			}
            			?>
						
						<div class="cont">
							<h2 class="ft-20"><?php echo $row2['title']?></h2>
							<div class="etc">
								<span class="writer">SPC</span><time class="date"><?php echo $row2['submit_date2']?></time>
							</div>
						</div>
					</a>
				</li>
			<?php 
                }
			?>				
			</ul>
		</div><!-- contri-box -->
		</form>
	 	<!-- 페이징  -->
		<div class="page_box">
			<div class="board-pagination">
				    <a href="" class="prev-btn prev_"  onclick="pageMove(<?=$s_page-1?>)">이전</a>
                    <?php 
                    $pagingCnt = 0;
                    if($e_page != 0)
                    {
                        for ($p=$s_page; $p<=$e_page; $p++)
                        {
                            $pagingCnt ++;
                            ?>
                            <a class="bt_num" onclick="pageMove(<?=$p?>)" id="p_<?=$p?>"><?=$p?></a>
                     	    <?php
                        }
                    }
                    else
                    {
                        ?>
                        <a onclick="pageMove(1)">1</a>
                        <?php
                    }
                    
                    if($pageNum != $page && $pageNum > 5)
                    {
                        if($pagingCnt > 4)
                        {
                            if($e_page+1 > $pageNum)
                            {
                                ?>
                                <a class="next-btn next_" onclick="pageMove(<?=$pageNum?>)"></a>
                                <?php
                            }
                            else
                            {
                                ?>
                                <a class="next-btn next_" onclick="pageMove(<?=$e_page+1?>)">다음</a>
                                <?php
                            }
                        }
                    }
					?>
					
					<?php 
					if($pagingCnt < 4){
					?>
    				 <a href="" class="next-btn next_"  onclick="pageMove(<?=$e_page+1?>)">다음</a>
    				<?php 
                    }      
				    ?>
			</div>
		</div>
	</div>
</div>
<script src="//code.jquery.com/jquery-1.12.4.js"></script> 
<script src="/js/jquery-ui.js"></script>
<link rel="stylesheet" href="/js/jquery-ui.css" type="text/css" />
<script>
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
			/*
			navigation:{
				prevEl:'.contri-list .swiper-button-prev',
				nextEl:'.contri-list .swiper-button-next'
			}
			*/
		});

		var snsSlide = new Swiper('.main-insta .swiper-container',{
			slidesPerView:5,
			spaceBetween:38,
			navigation:{
				prevEl:'.main-insta .swiper-button-prev',
				nextEl:'.main-insta .swiper-button-next'
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
					slidesPerView:2.5,
					spaceBetween:15
				}
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
	//유튜브
	var ytUrl = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=50&playlistId=PLHRufFL8G9GUTVRjBCHnUflpQ-ij_26AW&key=AIzaSyDzO3OGhvSsDt_M8VmxKfUNcNTt7mgXTMg";
	var firstVideoId;
	$.getJSON(ytUrl, function(data) {
		$.each(data.items, function(i, item) {
			var id = item.snippet.resourceId.videoId,
				title = item.snippet.title,
				url = 'https://www.youtube.com/watch?v=' + item.id,
				thumb = item.snippet.thumbnails,
				date = item.snippet.publishedAt.substr(0,10);
			if(i == 0) {
			  firstVideoId = id;
			}
			$("#youtubeBox").append("<div class='vdo-list swiper-slide' data-id="+id+"><div class='vdo-img' style='background-image:url("+thumb.high.url+")'><img src='" + thumb.medium.url + "' alt="+title+" /></div><div class='vdo-cont'><p class='vdo-tit'>"+title+"</p><p class='vdo-date'>"+date+"</p></div></div>");
		});
		var videoSlide = new Swiper('.contri-sec03 .swiper-container',{
			slidesPerView:3,
			spaceBetween:44,
			navigation:{
				prevEl:'contri-sec03 .swiper-button-prev',
				nextEl:'contri-sec03 .swiper-button-next'
			},
			breakpoints:{
				767:{
					spaceBetween:15,
					slidesPerView:1.2,
					scrollbar: {
						el: 'contri-sec03 .swiper-scrollbar',
						draggable: true,
					}
				},
				1439:{
					slidesPerView:2,
					spaceBetween:30,
				}
			}
		});
	});
	$(window).ready(function(){		
		$(document).on("click",".vdo-list",function(){
			var data = $(this).attr("data-id");
			console.log(data)
			$('.main-video-cont iframe').attr("src",'https://www.youtube.com/embed/'+data+'?enablejsapi=1&autoplay=1&cc_load_policy=0&iv_load_policy=1&loop=0&modestbranding=1&fs=1&playsinline=0&controls=1&color=red&cc_lang_pref=&rel=0&autohide=2&theme=dark&')
			$('.main-video-wrap').addClass('view');

		})
		$(document).on("click",".main-video-cont > a",function(){
			$('.main-video-cont iframe').removeAttr("src"); //직접 영상 멈추게하기
			$('.main-video-wrap').removeClass('view');
		})
	})
	//sns 로드 후 노출
	$(window).load(function(){
		setTimeout(function(){
			$(".sns-show").css("opacity","1");
		},200)
	});
</script>
