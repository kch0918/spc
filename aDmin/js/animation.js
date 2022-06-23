(function($) { 

	$(window).ready(function(){
		img_event();
		$(window).scroll(function(e){
			var s = $(window).scrollTop();	// 현재 window scrollTop
			if(s>50){
				img_event();
			}
		})
		function img_event(){
			$(".img-ani").each(function(){
				var w_t = $(window).scrollTop() + $(window).height();
				var i_t = $(this).offset().top;
				if(w_t > i_t + 200){
					$(this).addClass("img-aniload");
				}
			})
		}

		img_event_remove();

		
		


		/******************************************
		* 이미지 effect remove event
		* img_event() 가 적용되었던 요소들을 초기화 시켜주겠습니다.
		******************************************/
		function img_event_remove(){
			$(".img-ani").removeClass("img-aniload");
		}
	})

	
	
} ) ( jQuery);