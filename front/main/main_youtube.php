<div class="swiper-container"><div id="youtubeBox" class="vdo-wr swiper-wrapper"></div></div>
<div class="main-video-wrap">
	<div class="main-video-cont">
		<a href="#videoClose"><img src="/img/layout/icon_popup_close.png" alt="닫기"></a>
		<iframe src=""></iframe>
	</div>
</div>
<script>
//유튜브
var ytUrl = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=50&playlistId=PLHRufFL8G9GXD8SnkYJt3goS8zSmHI0wm&key=AIzaSyDzO3OGhvSsDt_M8VmxKfUNcNTt7mgXTMg";
var firstVideoId;
$.getJSON(ytUrl, function(data) {
	$.each(data.items, function(i, item) {
		if(i < 8){
		var id = item.snippet.resourceId.videoId,
			title = item.snippet.title,
			url = 'https://www.youtube.com/watch?v=' + item.id,
			thumb = item.snippet.thumbnails,
			date = item.snippet.publishedAt.substr(0,10);
		if(i == 0) {
		  firstVideoId = id;
		}
		$("#youtubeBox").append("<div class='vdo-list swiper-slide' data-id="+id+"><div class='vdo-img' style='background-image:url("+thumb.high.url+")'><img src='" + thumb.medium.url + "' alt="+title+" /></div><div class='vdo-cont'><p class='vdo-tit'>"+title+"</p><p class='vdo-date'>"+date+"</p></div></div>");
		}else{
//			console.log("zz")
		}
	});
	var videoSlide = new Swiper('#main-sec06 .swiper-container',{
		slidesPerView:3,
		spaceBetween:44,
		pagination:{
			el:$("#main-sec06 .swiper-pagination"),
			type: 'bullets',
		},
		navigation: {
		  nextEl:$("#main-sec06 .swiper-button-next"),
		  prevEl:$("#main-sec06 .swiper-button-prev"),
		},
		loop:false,
		breakpoints:{
			767:{
				spaceBetween:5,
				slidesPerView:1,
//				scrollbar: {
//					el: '#main-sec06 .swiper-scrollbar',
//					draggable: true,
//				}
				loop:true,
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
</script>
