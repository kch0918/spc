
<script type="text/javascript">


$(function(){
	
	$("#main #awards-sec01").wrapAll("<div id='awards_wrap'></div>");


	var awardsItem = $("#awards_wrap #awards-sec01");
	var awardsTab = $("#award-performance .board-category-wrap > div");



	awardsItem.each(function(index, element){
		var $this = $(this);

		$this.find(".av_one_fourth").addClass("swiper-slide")
		$this.find(".av_one_fourth").wrapAll("<div class='slide_wrap'><div class='swiper-container'><div class='swiper-wrapper'></div></div></div>");
		$this.find(".slide_wrap").append("<div class='swiper-button swiper-button-next'></div><div class='swiper-button swiper-button-prev'></div>");
		$this.find(".swiper-container").addClass("awards-" + index);
		$this.find(".swiper-button-next").addClass("swiper-button-next-" + index);
		$this.find(".swiper-button-prev").addClass("swiper-button-prev-" + index);

		var swiper = new Swiper(".awards-" + index, {
			cssWidthAndHeight : true,
			slidesPerView : '4',
			visibilityFullFit : true,
			autoResize : false,
			spaceBetween:20,
			navigation: {
				nextEl: $('.swiper-button-next-' + index),
				prevEl: $('.swiper-button-prev-' + index),
			},
			breakpoints: {
				600: {
					slidesPerView: 1,
					spaceBetween: 20
				},
				900: {
					slidesPerView: 2,
					spaceBetween: 20
				},
				1200: {
					slidesPerView: 3,
					spaceBetween: 20
				},
				1920: {
					slidesPerView: 4,
					spaceBetween: 20
				}
				}
		});

	});


	awardsItem.hide();
	awardsItem.eq(0).show();

	awardsTab.click(function(){
		var _this = $(this);
		var _ind = _this.index();
		awardsTab.removeClass("on");
		_this.addClass("on");
		awardsItem.hide();
		awardsItem.eq(_ind).show();
	});


});




</script>

