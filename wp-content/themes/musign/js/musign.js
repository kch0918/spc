(function($) { 
	$(function() {
	});
	$(window).ready(function(){
		//임시동작
		$('a[href="#"]').not('.av-burger-menu-main > a').click(function(e){
			e.preventDefault();
			alert('준비중입니다.');
		})
		
		//언어체크
		var lang = window.location.href.indexOf('lang');
		if(lang < 0){
			$('#avia-menu li.lang .sub-menu li:first-child').addClass('on');
		}
		
		//헤더 동작
		$('#header').mouseover(function(){
			$('#header').addClass('header-hov');
		}).mouseout(function(){
			$('#header').removeClass('header-hov');
		})
		
		
		//푸터 패밀리사이트
		$('.family-site ul').addClass('scrollbar-inner').scrollbar();
		$('.family-site-btn').click(function(){
			$('.family-site').toggleClass('active');
			if($('.family-site').hasClass('active')){
				//$('.family-site ul').scrollbar();
			}
		})
		
		//SVG 포인터 이벤트 작동안되게
		$('svg').attr('pointer-events', 'none');
		
		//메인에서 작동
		if($('#main-sec01').length > 0){
			
			$('#main-sec02 .flex_column').addClass('swiper-slide').wrapAll('<div class="swiper-wrapper"></div>');
			$('#main-sec02 .swiper-wrapper').wrap('<div class="swiper-container"></div>');
//			$('#main-sec02 .swiper-container').append('<div class="swiper-scrollbar"></div>');
			$('#main-sec02 .swiper-container').append('<div class="swiper-pagwr"><div class="swiper-button-prev"></div><div class="swiper-button-next"></div><div class="swiper-pagination"></div></div>');
			var groupSwiper = new Swiper('#main-sec02 .swiper-container',{
				slidesPerView:4,
				spaceBetween:45,
				loop:false,
				breakpoints:{
					500:{
						slidesPerView:1,
						spaceBetween:5,
//						scrollbar: {
//						    el: '#main-sec02 .swiper-scrollbar',
//						    draggable: true,
//						},	,
						loop:true,
					},
					989:{
						slidesPerView:2,
						spaceBetween:25,
					},
					1279:{
						slidesPerView:3,
						spaceBetween:30,
					},
					1600:{
						spaceBetween:15,
					}
				},
				pagination:{
					el:'#main-sec02 .swiper-pagination',
					type: 'bullets',
				},
				navigation: {
				  nextEl: "#main-sec02 .swiper-button-next",
				  prevEl: "#main-sec02 .swiper-button-prev",
				}
			});
			

			var svgEl;
			var minRadius = 107,
			  	maxRadius = 360;
			//축소:reduct
			var enlargeCircle = function($this) {
				var r = Number($this.attr('r'));
				var animLoop = function() {
					if($this.closest('.flex_column').hasClass('hov')){
						if(r >= maxRadius){
							cancelAnimationFrame(animLoop);
								$this.attr('r',maxRadius);
						}else{
							r = r + 14;
							$this.attr('r',r);
							requestAnimationFrame(animLoop);
						}
					}
				}
				animLoop(); //계속 애니메이션이 진행될 수 있도록 함수 호출
			};
			
			var reductCircle = function($this) {
				var r = $this.attr('r');
				var animLoop = function() {
					if(!$this.closest('.flex_column').hasClass('hov')){
						if(r <= minRadius){
							cancelAnimationFrame(animLoop);
							$this.attr('r',minRadius);
						}else{
							r = r - 14;
							$this.attr('r',r);
							requestAnimationFrame(animLoop);
						}
					}
				}
				animLoop(); //계속 애니메이션이 진행될 수 있도록 함수 호출
			};
			
			$('#main-sec02 .flex_column').mouseenter(function(){
				$(this).addClass('hov');
				enlargeCircle($(this).find('svg circle'));
			}).mouseleave(function(){
				$(this).removeClass('hov');
				reductCircle($(this).find('svg circle'));
			})
			
			$('#main-sec03 .tab-content .swiper-container').each(function(){
				$(this).parent().append('<div class="swiper-pagwr"><div class="swiper-button-prev"></div><div class="swiper-button-next"></div><div class="swiper-pagination"></div></div>');
//				$(this).append('<div class="swiper-pagination"></div>');
				var mainSolutionSlide = new Swiper($(this)[0], {
					slidesPerView:5,
					navigation:{
						prevEl:$(this).parent().find('.swiper-button-prev')[0],
						nextEl:$(this).parent().find('.swiper-button-next')[0]
					},
					observer:true,
					observeParents:true,
					spaceBetween:35,
					pagination:{
					    el: $(this).parent().find('.swiper-pagination')[0],
					    type: 'bullets',
					},
					breakpoints:{
						1679:{
							spaceBetween:30,
						},
						1279:{
							slidesPerView:4,
							spaceBetween:25,
						},
						989:{
							spaceBetween:15,
							slidesPerView:3
						},
						500:{
							spaceBetween:15,
							slidesPerView:2
						}
					}
				})
			})
			
			var newsSlide = new Swiper('.news-latest .swiper-container',{
				slidesPerView:3,
				spaceBetween:43,
				loop:false,
				breakpoints:{
					989:{
						spaceBetween:28,
						slidesPerView:3
					},
					767:{
						spaceBetween:15,
						slidesPerView:2,					
					},
					500:{
						spaceBetween:5,
						slidesPerView:1,
						loop:true,
					}
				},
				pagination:{
					el:$(".news-latest .swiper-pagination"),
					type: 'bullets',
				},
				navigation: {
				  nextEl:$(".news-latest .swiper-button-next"),
				  prevEl:$(".news-latest .swiper-button-prev"),
				}
			})
			
			/*$('.magazine-latest li').mousemove(function(e){
				var x = e.pageX,
					y = e.pageY,
					parentX = $(this).offset().left,
					parentY = $(this).offset().top;
				$(this).find('.img').css({
					top:y - parentY + 45,
					left:x - parentX + 45
				})
			})*/
			
			/*
			setTimeout(function(){
				$('#main-sec06 .epyt-gallery-allthumbs').addClass('swiper-container').append('<div class="swiper-scrollbar"></div>').find('.epyt-gallery-rowbreak').remove();
				$('#main-sec06 .epyt-video-wrapper').wrap('<div class="main-video-wrap"></div>').wrap('<div class="main-video-cont"></div>');
				$('#main-sec06 .main-video-cont').append('<a href="#videoClose"><img src="/img/layout/icon_popup_close.png" alt="닫기"></a>');
				$('#main-sec06 .epyt-gallery-allthumbs .epyt-gallery-thumb').addClass('swiper-slide').wrapAll('<div class="swiper-wrapper"></div>');
				$('#main-sec06 .epyt-gallery-allthumbs').show();
				var videoSlide = new Swiper('#main-sec06 .epyt-gallery-allthumbs',{
					slidesPerView:2.8,
					spaceBetween:44,
					navigation:{
						prevEl:'#main-sec06 .swiper-button-prev',
						nextEl:'#main-sec06 .swiper-button-next'
					},
					breakpoints:{
						767:{
							spaceBetween:15,
							slidesPerView:1.2,
							scrollbar: {
							    el: '#main-sec06 .swiper-scrollbar',
							    draggable: true,
							}
						},
						1439:{
							slidesPerView:2.2,
							spaceBetween:30,
						}
					}
				});
				
				$('.epyt-gallery-thumb').click(function(){
					$('.main-video-wrap').addClass('view');
				})
				$('.main-video-cont > a').click(function(){
					$('.main-video-cont iframe')[0].contentWindow.postMessage('{"event":"command","func":"pauseVideo","args":""}', '*'); //직접 영상 멈추게하기
					$('.main-video-wrap').removeClass('view');
				})
			}, 400);
			
			
			*/
			$('#main-sec08 .flex_cell_inner').slick({
				//variableWidth:true,
				slidesToShow:5,
				//autoplay:true,
				//autoplaySpeed:3000,
				//arrows:false,
				//touchMove:false,
				//swipe:false,
				pauseOnHover:false,
				pauseOnFocus:false,
				//draggable:false,
				accessibility:false,
				//cssEase:'linear',
				speed:500,
				//centerMode:true,
				//edgeFriction:0
				//dots:true,
				responsive:[
					{
						breakpoint:768,
						settings:{
							slidesToShow:3,								
							autoplay: true,
							autoplaySpeed: 5000,
							arrows: false
						}
					},
					{
						breakpoint:989,
						settings:{
							slidesToShow:4,								
							autoplay: true,
							autoplaySpeed: 5000,
							arrows: false
						}
					},
					{
						breakpoint:1024,
						settings:{
							slidesToShow:4
						}
					}
				]
			})
			
		}
		//메인에서 작동 끝
		
		//연혁에서 작동
		if($('.history-title').length > 0){
			$('.history-list .scrollbar-inner').scrollbar();
			
			//텍스트 인터랙션
			var bigTxt = $('.history-bgnum').text(),
				bigTxtArray = [];
			
			for(i=0;i<bigTxt.length;i++){
				bigTxtArray.push(bigTxt.substring(i,i+1));
			}
			$('.history-bgnum').html('');
			for(a=0;a<bigTxtArray.length;a++){
				$('.history-bgnum').append('<span class="img-ani" style="transition-delay:' + a * 0.1 + 's">' + bigTxtArray[a] + '</span>');
			}
			
			//연혁 팝업
			$('.history-popup .flex_column').addClass('swiper-wrapper')
			.wrap('<div class="swiper-container"></div>').find('.avia-image-container').addClass('swiper-slide');
			$('.history-popup .swiper-container').append('<div class="swiper-pagination"></div><div class="swiper-button-prev"></div><div class="swiper-button-next"></div>');
			
			$('.history-popup .swiper-container').each(function(){
				if($(this).find('.swiper-slide').length > 1){
					var historySlide = new Swiper($(this)[0],{
						slidesPerView:1,
						observer:true,
						observeParents:true,
						loop:true,
						pagination:{
							el: $(this).find('.swiper-pagination')[0],
							type:'bullet'
						},
						navigation: {
							nextEl: $(this).find('.swiper-button-next')[0],
							prevEl: $(this).find('.swiper-button-prev')[0]
						}
					})
					
					
				}
			});
			
		}
		
		//재단 연혁에서 작동
		if($('.foundation-history-sec02').length > 0){
			$('.foundation-history-sec02 .flex_column').addClass('swiper-slide').wrapAll('<div class="swiper-container"></div>').wrapAll('<div class="swiper-wrapper"></div>');
			$('.foundation-history-sec02 .swiper-container').append('<div class="swiper-scrollbar"></div><div class="swiper-pagination"></div>');
			$('.foundation-history-sec02 .swiper-wrapper').addClass('tranDelayList');
			var foundHistorySlide = new Swiper('.foundation-history-sec02 .swiper-container',{
				slidesPerView:2.5,
				spaceBetween:35,
				scrollbar:{
					el:'.foundation-history-sec02 .swiper-scrollbar',
					draggable:true
				},
				pagination:{
					el: '.foundation-history-sec02 .swiper-pagination',
					type:'custom',
					renderCustom:function(swiper,current,total){
						var names = [];
						$(".foundation-history-sec02 .swiper-slide").each(function(i) {
							names.push($(this).find("h3").text());
						});
						var text = "<span>";
						for (var i = 0; i < total; i++) {
							if (current - 1 == i) {
								text += '<button type="button" class="ft-20 active">' + names[i] + '</button>';
							} else {
								text += '<button type="button" class="ft-20">' + names[i] + '</button>';
							}
						}
						text += "</span>";
						return text;
					}
				},
				breakpoints:{
					767:{
						slidesPerView:1.2,
						spaceBetween:15
					},
					1023:{
						slidesPerView:2.2,
						spaceBetween:28
					}
					
				}

			})
			
			$(document).on('click', '.foundation-history-sec02 .swiper-pagination button', function(){
				var idx = $(this).index();
				foundHistorySlide.slideTo(idx);
			})
			
		}
		
		
		//팝업 동작
		$('.popup-btn').click(function(e){
			e.preventDefault();
			var link = $(this).attr('href');
			$(link).addClass('popup-open');
		})
		$('.history-popup-close').click(function(e){
			e.preventDefault();
			$(this).closest('.history-popup').removeClass('popup-open');
		})

	}); 
	// 헤더스크롤
	$(function(){
		head();
		$(window).scroll(function(){
			head();
		})
		function head(){
			var top = $(window).scrollTop();
			if(top > 88){
				$("#header").addClass("head-fix");
			}else{
				$("#header").removeClass("head-fix");
			}
		}
		
	})


	$(window).load(function(){
		$("#sub-top, #sub-tab").addClass("active");
	});
	
	//rnb
	$(window).load(function(){
		$('.select').each(function(){
			var $this = $(this),
				p = $(this).find("p"),
				ul = $(this).find("ul");
			ul.addClass('scrollbar-inner').scrollbar();		
			p.click(function(){
				if($this.hasClass('active')){
					$this.removeClass('active');
					ul.hide();
				}else{
					$this.addClass('active');
					ul.show();
				}
				selli();
			})
		})
		function selli(){
			$('.select li').each(function(){
				var $this = $(this),
					div = $(this).parents(".select"),
					p = $(this).parents(".select").find("p");
				$this.click(function(){
					p.text($(this).text());
					div.removeClass('active');
					div.find("ul").hide();
				})
			})
		}
		$("#sub-top .select li").each(function(){
			var path= location.pathname,
				href = $(this).find("a").attr("href"),
				a = $(this).find("a"),
				sub = a.attr("data-url");
			if(!sub === 'undefined'){
				if(href == path || sub.indexOf(href) > -1){
					$('#sub-top .select p').text(a.text())
				}
			}else{
				if(href == path){
					$('#sub-top .select p').text(a.text())
				}
			}
		});
	});


	// 사회공헌소개 - 장애인자립지원
	$(window).load(function(){
		$("#main > .independence-support-item").wrapAll("<div class='tab_item'></div>");
		$(".independence-support-item").each(function(){
			$(this).find(".av_one_half").wrapAll("<div class='av_one_half_wrap'></div>");		
			var SocialContributionItem = new Swiper('.slide_btn_wrap .swiper-container ', {
				cssWidthAndHeight : true,
				slidesPerView : 'auto',
				visibilityFullFit : true,
				autoResize : false,
				spaceBetween:20,
				navigation:{
					prevEl:'.slide_btn_wrap .swiper-button-prev',
					nextEl:'.slide_btn_wrap .swiper-button-next'
				},
			});
		});

		var tab = $(".slide_btn_wrap ul li");
		var tabItem = $(".tab_item > .independence-support-item");

		tab.click(function(){
			var _this = $(this);
			var _ind = _this.index();
			tab.removeClass("on");
			_this.addClass("on");
			tabItem.hide();
			tabItem.eq(_ind).css("display","table");
		});
	})



	// 개인정보취급방침 팝업
	$(document).ready(function(){
		$('#human-resource-development02 a.table_pop_btn').click(function(){
			popupOpen();
		});
		  
		function popupOpen(){
			window.open ('/privacy','','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=700,height=750,left=100px,top=50')
		}
	})
	
	// 뉴스테러 구독신청 팝업
	$(document).ready(function(){
		$('.global-popwr .scrollbar-inner').scrollbar();
	})

	// 컬리너리아카데미 슬라이드
	$(window).load(function(){		
		$(".aca-slidewr").each(function(){
			$(this).find("ul").slick({
				infinite: true,
				slidesToShow: 1,
				slidesToScroll: 1,
				dots:true
				
			});
		});
	});

	// 컬리너리아카데미 슬라이드
	$(window).load(function(){		
		$(".car-tab > li").each(function(index){
			$(this).click(function(){
				$(".car-tab > li").removeClass("on");
				$(".car-tab > li").eq(index).addClass("on");
				$(".car-process .av_one_full > section").hide();
				$(".car-process .av_one_full > section").eq(index).show();
			})

		});
	})

	//개인정보처리방침
	$(function(){
		var path = location.pathname;
		if(path == "/privacy/"){
			$(".select li").each(function(index){
				$(this).click(function(){
					$("#privacy_sec .flex_cell_inner .av_one_full").hide();
					$("#privacy_sec .flex_cell_inner .av_one_full").eq(index).show();
					console.log(index)
				})
			})
		}
	});

	// 서브 상단 네비
	$(function(){
		var path = location.pathname;
		$(".av-submenu-container .menu-item > a").each(function(){
			var $this = $(this);
			if($this.attr("href") == path){
				$this.parents("li").addClass("current-menu-item");
				$this.parents(".menu-item-top-level").addClass("current-menu-ancestor");
				
			}
		})
		$("#sub-tab .sub-menu").each(function(){
			$(this).wrap('<div class="sub-menuwr"></div>');
			
		})
	})
	$(window).load(function(){
		setTimeout(function(){
			var chk = $("#sub-tab .av-subnav-menu > li.current-menu-item").length,
				chk2 = $("#sub-tab .av-subnav-menu > li.current-menu-parent .sub-menuwr").length;
//			console.log(chk)
			if(chk2 > 0){
				var x = $("li.current-menu-parent .sub-menuwr > ul > li.current-menu-item").offset().left;
				$("#sub-tab .menu-item-top-level").find(".sub-menuwr").scrollLeft(x);			
				$("#sub-tab").addClass("child-tab");
			}
			if(chk > 0){
				var x2 = $("#sub-tab .av-subnav-menu > li.current-menu-item").offset().left;
				$("#sub-tab .container").scrollLeft(x2);
			}
		},100)
	});

	// 상생삿앵..
	$(window).load(function(){
		$("#shar-sec04 .avia-content-slider-element-slider").wrapAll("<div class='slide_wrap'></div>");

		var slideTab = $("#shar-sec04 .shar-tab-wrap > .shar-tab");
		slideTab.click(function(){
			var _ind = $(this).index();
			slideTab.removeClass("on");
			$(this).addClass("on");
			$("#shar-sec04 .slide_wrap > div").hide();
			$("#shar-sec04 .slide_wrap > div").eq(_ind).show();
		});	
	});


	// ESG카테고리 도메인변경

	var location = window.location.href;
	console.log(location)

	// 국문
	if ( location == 'https://www.spc.co.kr/share/') {
		window.location.href='https://www.spc.co.kr/share/spc-foundation/introduction';
	}
	if ( location == 'spc.co.kr/share') {
		window.location.href='https://www.spc.co.kr/share/spc-foundation/introduction';
	}

	// 영문
	if ( location == 'https://www.spc.co.kr/share/?lang=en' ) {
		window.location.href='https://www.spc.co.kr/share/spc-foundation/introduction/?lang=en';
	}

	if ( location == 'spc.co.kr/share/?lang=en') {
		window.location.href='https://www.spc.co.kr/share/spc-foundation/introduction';
	}

	// 중문
	if ( location == 'https://www.spc.co.kr/share/?lang=zh-hans' ) {
		window.location.href='https://www.spc.co.kr/share/spc-foundation/introduction/?lang=zh-hans';
	}

	if ( location == 'spc.co.kr/share/?lang=zh-hans') {
		window.location.href='https://www.spc.co.kr/share/spc-foundation/introduction';
	}
	
} ) ( jQuery);