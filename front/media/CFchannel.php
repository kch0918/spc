<?php
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");

$query = "select *,DATE_FORMAT(submit_date, '%Y.%m.%d') as submit_date2 from SPC_CF where lang = 'ko' and expo_yn='Y'";

if(isset($_POST['type2']) && $_POST['type2'] != null && $_POST['type2'] != "")
{
    $query = "select *,DATE_FORMAT(submit_date, '%Y.%m.%d') as submit_date2 from SPC_CF where 1 and type = '{$_POST['type2']}' order by type desc";
}

else
{
    $query .= " order by type desc";
}

$result = sql_query($query);

?>
<script>
var type2 = "<?php echo $_POST['type2']?>";

//검색
function reSelect(act)
{
	$("#page").val(1);
	$("#fncForm").submit();
}

function Cate2(type2) {
	// input에 value 값 넣어주기
	$('input[name="type2"]').val(type2);
}

function Type(type) {
	// input에 value 값 넣어주기
	$('input[name="type"]').val(type);
}

//페이지 로딩시 
$(document).ready(function(){
	if(type2 != ""){
		$("#type_name2").text(type2);
	}
})


</script>

<form id="fncForm" name="fncForm" method="post" action="/media-hub/cf/">
<input type="hidden" id="type" name="type" value="">
<input type="hidden" id="type2" name="type2" value="">
<div class="contri-wr text-center">
	<div class="contri-sec contri-sec01">
		<h2 class="ft-42 bold color-000 global-tit letter-0 img-ani bottom-top">NEW CF</h2>
		<div class="contri-box img-ani">
			<div class="cf-slidewr" data-key="AIzaSyDzO3OGhvSsDt_M8VmxKfUNcNTt7mgXTMg" data-id="PLQggemk8sda90XN0uuikstiTuRpmp1wds">
				<div class="cf-slide">
					<img src="/img/sub/cf-thumb01.png" alt="CF"/>
					<div id="youtubeBox" class="vdo-wr"></div>
				</div>
			</div>
		</div><!-- //contri-box -->
	</div>
	<div class="contri-sec contri-sec04">
		<div class="board-search table board-search-cf">
			<div class="contri-data">
				<div class="table">
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
                            for($i = 0; $i < sql_count($result); $i++){
                            $row = sql_fetch($result);
                            
                            $youtube_url = $row['url'];
                            $regExp = '/^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/';
                            preg_match($regExp, $youtube_url, $matches);
                            $thumb = $matches[7];
                        ?>
						<li data-id="<?php echo $thumb?>">
							<a href="javascript:getPlayList('<?php echo $row['type']?>');">
								<div class="thumb vdo-img" style="background-image:url(http://img.youtube.com/vi/<?php echo $thumb?>/hqdefault.jpg">
									<img src="http://img.youtube.com/vi/<?php echo $thumb?>/mqdefault.jpg" alt="사회공헌 최근소식" class="">
									<img class="de-img" src="/img/sub/card-thumb.png" alt="SPC그룹"/>
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
<!-- 팝업창  -->
<div class="main-video-wrap">
	<div class="main-video-cont">
		<a href="#videoClose"><img src="/img/layout/icon_popup_close.png" alt="닫기"></a>
		<iframe src=""></iframe>
	</div>
</div>
<!--  //팝업창  -->
</form>
<script src="https://www.youtube.com/iframe_api"></script>
<Script>
$(window).load(function(){
	//유튜브
	var player;
	onYouTubeIframeAPIReady();
	function onYouTubeIframeAPIReady() {
		$(".cf-slidewr").each(function(){	
			var $this = $(this),
				yt = $(this).attr("data-key"),
				ytid = $(this).attr("data-id"),
				ytUrl = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=50&playlistId="+ytid+"&key="+yt;
			$.getJSON(ytUrl, function(data) {
				$.each(data.items, function(i, item) {
					var id = item.snippet.resourceId.videoId;
					if(i < 1) {
						player = new YT.Player('youtubeBox', {
							videoId: id,
							events: {
							'onReady': onPlayerReady,
							'onStateChange': onPlayerStateChange
							},
							playerVars:{ // 아래는 해당 플레이어의 기본 속성들을 정할 수 있습니다.
								'modestbranding': 1,
								'autoplay' : 1, // 자동재생
								'controls' : 0, // 컨트롤러의 유무
								'showinfo' : 0, // 재생영상에 대한 정보 유무
								'rel': 0, // 해당 영상이 종류 된 후, 관련 동영상을 표시할지의 여부
								'loop': 1, // 반복 재생의 여부
								'playlist': id
							},
						});
					}
					
				});
			});
			
			
		});
	}
	function onPlayerReady(event) {
		event.target.playVideo();
	}
	var done = false;
	function onPlayerStateChange(event) {
//		if (event.data == YT.PlayerState.PLAYING && !done) {
//		  setTimeout(stopVideo, 6000);
//		  done = true;
//		}
	}
	function stopVideo() {
		player.stopVideo();
	}

	$(window).ready(function(){		
		$(document).on("click",".cardtype-list > li",function(){
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
});
</script>