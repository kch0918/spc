$(function(){

	$(document).ready(function(){
		setTimeout(function(){
			$("body").css("opacity","1");
		},200)		
	})
	
	$(document).ready(function(){
	
		var he = window.innerHeight;
		var nav = $(".nav-overlay_wrap");
		//console.log(he)
		
		nav.css("height",he);
	})


	$('.main-slider').slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		autoplay: true,
		autoplaySpeed: 5000,
	});


	$(document).on("click",".ham-wrap",function(){
		$("header").addClass("menu-on");
		$(".nav-overlay_wrap").css("opacity","1");
		$(".nav-overlay_wrap").css("z-index","999");
		setTimeout(function(){
			$(".nav-overlay_wrap").addClass("menu-ani");
		},500)
	})

	$(document).on("click",".nav-exit",function(){
		$("header").removeClass("menu-on");
		$(".nav-overlay_wrap").css("opacity","0");
		$(".nav-overlay_wrap").css("z-index","-1");
		$(".nav-overlay_wrap").removeClass("menu-ani");
	})

	$(document).ready(function(){	
		var loc = location.pathname;
		console.log(loc)
		if(loc == "/") {
			$("#header").addClass("main");
		}
	})

	// header fix 
	$(window).scroll(function(){
		var s = $(window).scrollTop();	

		if(s>50){
			$("#header").addClass("fix");
		}else{
			$("#header").removeClass("fix");
		}
	});


	/* 탭메뉴
	$(window).ready(function(){
		var path = location.pathname;
		var loca = path+sear;
		console.log(path)

		//console.log(loca);
		$("ul.menu > li").each(function(){
			var a = $(this).find("a");
			var href = a.attr("href");
			console.log(href);
			if(href == loca){
				$(this).addClass("tab_on");

			}
		})
	*/


	$(document).ready(function(){
		//전체
		$('.all').click(function(){
			$('.noti_tab > li').removeClass('noti_act');
			$(this).addClass("noti_act");
			$('.jobNt-box').fadeIn();
			$('.notice-wrap.nt02 > div:nth-child(4n)').css("margin-right","0");
			$('.notice-wrap.nt02 > .tempo_bx05').css("margin-right","2%");
		});

		// 채용공고 탭메뉴 주석 처리: 정기
		$('.regular').click(function(){
			$('.noti_tab > li').removeClass('noti_act');
			$(this).addClass("noti_act");
			$('.regul_bx').fadeIn();
			$('.tempo_bx').hide();
		});

		//수시
		$('.tempo').click(function(){
			$('.noti_tab > li').removeClass('noti_act');
			$(this).addClass("noti_act");
			$('.tempo_bx').fadeIn();
			$('.regul_bx').hide();
			$('.notice-wrap.nt02 > div:nth-child(4n)').css("margin-right","2%");
			$('.notice-wrap.nt02 > .tempo_bx05').css("margin-right","0");

		}); 

		// 공지사항 목록	
		$('.noti_list').click(function(){	
			$('.noti_list').removeClass('lt_act');	
			$(this).addClass('lt_act');
		});

		// FAQ 아코디언 
		$('.faq_box').click(function(){
			var $cur_open = $(this).find(".faq_q").hasClass("open"); 
			
			if($cur_open){
				$(this).find('.faq_q').removeClass('arr_act');	
				$(this).find('.faq_a').slideUp();
				$(this).find(".faq_q").removeClass("open");

			}else{
				$(this).find('.faq_q').addClass('arr_act');	
				$(this).find('.faq_a').slideDown();
				$(this).find(".faq_q").addClass("open");
			}
		});

		// 채용정보-지원서 작성 : 병역구분 선택
		$('.sec_part.part01 label').click(function(){
			$('.sec_part.part01 label').removeClass('chosen');
			$(this).addClass('chosen');

		});
		
		// 채용정보-지원서 작성 : 보훈사항 선택
		$('.sec_part.part02 label').click(function(){
			$('.sec_part.part02 label').removeClass('chosen');
			$(this).addClass('chosen');

		});

		// 채용정보-지원서 작성 : 장애사항 선택
		$('.sec_part.part03 label').click(function(){
			$('.sec_part.part03 label').removeClass('chosen');
			$(this).addClass('chosen');

		});

		// 채용정보- 대학교(학사) 입학구분 
		$('.row04 .sec_part.part01 label').click(function(){
			$('.row04 .sec_part.part01 label').removeClass('chosen');
			$(this).addClass('chosen');
		});

		// 채용정보 -대학교(학사) 본교/분교
		$('.row04 .sec_part.part02 label').click(function(){
			$('.row04 .sec_part.part02 label').removeClass('chosen');
			$(this).addClass('chosen');

		});

		// 채용정보 - 전공 플러스 버튼 클릭시 마이너스 추가
		$('.plus01 .more_line_p').click(function(){
			var minus = $(this).parents('.edu_line').siblings('.minus01');
			$(minus).fadeIn(300);
		});

		$('.plus02 .more_line_p').click(function(){
			var minus02 = $(this).parents('.edu_line').siblings('.minus02');
			$(minus02).fadeIn(300);

		});

		// 전공 : 마이너스 클릭시 자기 행 삭제
		$('.more_line_m').click(function(){
			$(this).parents('.edu_line').hide();

		});

		$('.add_file').click(function(){
			$('#hidden').trigger('click');
		});

		// 파일첨부 - 첨부한 파일명 텍스트 보이기 
		$('#hidden').change(function(){
			
			var inputValue = $(this).val().split('fakepath')[1];
			
			console.log($(this).val());

			if(inputValue === undefined){
				$('.ex_txt').text('선택된 파일 없음');
			}else{
 				$('.ex_txt').text(inputValue.substr(1,inputValue.length));
			}

/*
			if(inputValue === ''){
			}
*/
		});

		// 공인어학성적 플러스/마이너스 버튼
		$('#lang_grade .more_line_p').click(function(){
			$('#lang_grade tr.grade02').show();
		});

		$(".more_line_m").click(function(){
			$(this).parents('tr').hide();
		});


		// 자격증 플러스/마이너스 버튼
		$('#certificate .more_line_p').click(function(){
			$('#certificate tr.grade02').show();

		});

		// 자격증 합격 구분 
		$('#certificate .grade01 label').click(function(){
			$('#certificate .grade01 label').removeClass('chosen');
			$(this).addClass('chosen');
		});

		$('#certificate .grade02 label').click(function(){
			$('#certificate .grade02 label').removeClass('chosen');
			$(this).addClass('chosen');
		});


		// 채용정보-지원서작성2 : 학교명 검색 '팝업' 
		$('#apply .high_school').click(function(){
			$('.layer_bg').show();
			$('.popup_outline').show();
		});

		$('#apply .bachelor').click(function(){
			$('.layer_bg').show();
			$('.popup_outline').show();
		});

		$('#apply .master').click(function(){
			$('.layer_bg').show();
			$('.popup_outline').show();
		});

		// 암막 클릭시 팝업 닫히기 
		$('.layer_bg').click(function(){
			$(this).hide();
			$('.popup_outline').hide();
		});

		// 학교명 검색 팝업 닫기
		$('.closed_btn').click(function(){
			$('.layer_bg').hide();
			$('.popup_outline').hide();
		});


		// 경력사항2 숨겼다 보여주기
		$('.plus_wra .more_line_p').click(function(){
			$('.section_tit.career2').show();
		});


		// 경력사항2 마이너스클릭시 사라짐
		$('.plus_wra .more_line_m').click(function(){
			$('.career2').hide();

		});


		// 인증번호요청 버튼 클릭시 입력칸 나타남
		$('.certi_btn').click(function(){
			$('.certi_bottom').show();

		});

		// 이메일, 휴대폰번호 아이디 찾기 탭
		$('.email_tab').click(function(){
			$('.email_tab_cont').show();
			$('.phone_tab_cont').hide();

		});
		$('.phone_tab').click(function(){
			$('.phone_tab_cont').show();
			$('.email_tab_cont').hide();

		});

		// 회원정보수정: 비번 변경
		$('.modi_btn').click(function(){
			$(this).css("display","none");
			$('.pw_info').show();

		});

		// 모바일 - 채용절차 프로세스 
		$('.rc_step_m').addClass("owl-carousel");
		$('.owl-carousel').owlCarousel({
			loop:true,
			margin:0,
			nav:true,
			center:true,
			autoHeight:true,
			responsive:{
				0:{
					items:1
				},
				600:{
					items:1
				},
				1000:{
					items:6
				}
			}
		});


	//햄버거 메뉴 아코디언 
	$('.nav-ul > li ').click(function(){
	
			var $cur_open = $(this).hasClass("open"); 
			
			if($cur_open == true){
				$(this).find('.dep-ul').slideUp();
				$(this).removeClass("open");
				$(this).removeClass("icon_cha");

			}else{
				$(this).find('.dep-ul').slideDown();
				$(this).addClass("open");
				$(this).addClass("icon_cha");
			}


	});



	// 메인 헤더만 다른 스타일 적용 
	 $(document).ready(function() {
         if (window.location.pathname == '/index.php'){
			$('#header').addClass('trans-hea');

         }else{
			$('#header').removeClass('trans-hea');

         }

	
	 });




	}); // 제이쿼리 끝 

})