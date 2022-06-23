(function($) { 

	$(document).ready(function(){
		img_event();
		
		$('.tranDelayList > li, .tranDelayList > div').each(function(){
			var i = $(this).index();
			$(this).css('transitionDelay', 0.2 * i + 's');
		})
		
		$(window).scroll(function(e){
			var s = $(window).scrollTop();	// 현재 window scrollTop
			if(s>50){
				img_event();
			}
		})
		function img_event(){
			$(".av-layout-grid-container, .img-ani, .text-ani").each(function(){
				var w_t = $(window).scrollTop() + $(window).height();
				var i_t = $(this).offset().top;
				if(w_t > i_t + 100){
					$(this).addClass("img-aniload");
				}
			})
		}
	})
	
} ) ( jQuery);