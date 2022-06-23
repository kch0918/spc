// 파일 추가 버튼 클릭시 
$(document).ready(function() {

    //파일 추가 
    var btAdd = $('.bt-add .bt_add');
    var btAdd2 = $('.bt-add .bt_add2');
    var btAdd3 = $('.bt-add .bt_add3');
    var btAdd4 = $('.bt-add .bt_add4');
    var contBox = $('.write_cont_inline');
    var jb = $('.write_cont_inline').html();

    // 상단 이미지
    var innerIdx = 0;
    $.each(btAdd, function(index, item) {
        $(this).click(function(e) {
            innerIdx++;
            var inner = '';
            inner += '<div class="file_d file_in_add">';
            inner += '	<span class="upload-name file_area top_img">500MB 이내로 업로드</span>';
            inner += '  <input type="file" name="top_img[]" id="upload_up' + innerIdx + '" class="upload-hidden">';
            inner += '  <label for="upload_up' + innerIdx + '" class="file_bt bt_up">업로드</label>';
            inner += '  <a href="#" class="bt_del">삭제</a>';
            inner += '</div>';
            e.preventDefault();
            $(this).parents('.write_cont_inline').append(inner);
        });
    });

    // 본문 이미지
    $.each(btAdd2, function(index, item) {
        $(this).click(function(e) {
            innerIdx++;
            var inner = '';
            inner += '<div class="file_d file_in_add2">';
            inner += '	<span class="upload-name file_area cont_img">500MB 이내로 업로드</span>';
            inner += '  <input type="file" name="cont_img[]" id="upload_main' + innerIdx + '" name="" class="upload-hidden">';
            inner += '  <label for="upload_main' + innerIdx + '" class="file_bt bt_up">업로드</label>';
            inner += '  <a href="#" class="bt_del">삭제</a>';
            inner += '</div>';
            e.preventDefault();
            $(this).parents('.write_cont_inline2').append(inner);
        });
    });

    // 계열사 본문 이미지2
    $.each(btAdd3, function(index, item) {
        $(this).click(function(e) {
            innerIdx++;
            var inner = '';
            inner += '<div class="file_d file_in_add3">';
            inner += '	<span class="upload-name file_area cont_img2">500MB 이내로 업로드</span>';
            inner += '  <input type="file" name="cont_img2_sub[]" id="upload_plus' + innerIdx + '" name="" class="upload-hidden">';
            inner += '  <label for="upload_plus' + innerIdx + '" class="file_bt bt_up">업로드</label>';
            inner += '  <a href="#" class="bt_del">삭제</a>';
            inner += '</div>';
            e.preventDefault();
            $(this).parents('.write_cont_inline3').append(inner);
        });
    });

    // 첨부파일 이미지
    var innerIdx = 0;
    $.each(btAdd4, function(index, item) {
        $(this).click(function(e) {
            innerIdx++;
            var inner = '';
            inner += '<div class="file_d file_in_add4">';
            inner += '	<span class="upload-name file_area file">500MB 이내로 업로드</span>';
            inner += '  <input type="file" name="file[]" id="upload_file' + innerIdx + '" class="upload-hidden" aria-invalid="false">';
            inner += '  <label for="upload_file' + innerIdx + '" class="file_bt bt_up">업로드</label>';
            inner += '  <a href="#" class="bt_del">삭제</a>';
            inner += '</div>';
            e.preventDefault();
            $(this).parents('.write_cont_inline').append(inner);

        });
    });


    //주소
    var btSiteAdd = $('.bt-add .bt_site_add');
    var adressBox = $('.adress_box');
    var siteIdx = 1;
    var Idx = 1;

    $.each(btSiteAdd, function(index, item) {
        $(this).click(function(e) {
            siteIdx++;
            Idx++;
            var inner = '';
            inner += '<div class="adress_box">';
            inner += '	<p class="write_cont_tit ver_middle">주소 </p>';
            inner += '  <input type="text" name="addr[]" class="file_area" placeholder="텍스트 입력">';
            inner += '  <a href="#" class="bt_del bt_site_del">삭제</a>';
            inner += '</div>';
            e.preventDefault();
            adressBox.eq(index).parent('.write_li_file').append(inner);
        });
    });

});


//업로드 추가 라인 전체 삭제
$(document).on('click', '.file_d .bt_del', function(e) {
    e.preventDefault();
    $(this).parents('.file_d').remove();
});

$(document).on('click', '.bt_site_del', function(e) {
    e.preventDefault();
    var idx = $('.bt_site_del').index(this);
    $('.adress_box').eq(idx + 1).remove();
});

//삭제 클릭시 파일 비우기 썸네일용
$(document).on('click', '.bt_clear', function(e) {
   e.preventDefault(); 
    if ($.browser.msie) { 
        $("#upload1").replaceWith( $("#filename").clone(true) ); 
    }
    else { 
        $("#upload1").val(""); 
    }
    $(this).siblings('.upload-name').text("500MB 이내로 업로드");
});


//업로드 파일명 표시
$(document).on('click', function(e) {
    var fileTarget = $('.upload-hidden');
    console.log(fileTarget);
    fileTarget.on('change', function() {
        if (window.FileReader) {
            filename = $(this)[0].files[0].name;
            console.log($(this));

        } else {
            var filename = $(this).val().split('/').pop().split('\\').pop();
        }
        $(this).siblings('.upload-name').text(filename);
    });
});


$(document).ready(function() {
    $(function() {
        $("#start_date").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-mm-dd",
        });
        $("#finish_date").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-mm-dd"
        });
    });

    //셀렉버튼 실행
    selectUlInit()
});

// 셀렉트 버튼 커스텀 
$(document).on('click', '.selectedOption', function() {
    var $this = $(this);
    var chk = $(this).next('ul').css('display');
    $('.select-box').removeClass('on');
    if (chk == "none") {
        $this.parents(".select-box").addClass('on');
    } else {
        $this.parents(".select-box").removeClass('on');
    }
    $(this).next('ul').slideToggle(200);
    $('.selectedOption').not(this).next('ul').hide();
});

$('body').on('click', function(e) {
    var chk = $(".select-box ul").css('display');
    if (!$(e.target).hasClass("selectedOption")) {
        $(".select-box").removeClass('on');
        $(".select-box").find('ul').hide();
    }
});

$(document).on('click', '.select-box ul li', function() {
    var $this = $(this);
    var selectedLI = $(this).text();
    var select = $this.parents(".select-box").find("select");
    var ind = $this.index();

    select.find("option").eq(ind).attr("selected", "selected");
    $(this).parent().prev('.selectedOption').text(selectedLI);
    $this.parents(".select-box").removeClass('on');
    $(this).parent('ul').hide();
    select.trigger("onchange");
});

$('.select-box').show();
$('select').hide();

function selectUlInit() {


    $('select').not('.novis').each(function(index, element) {
        var this_id = $(this).attr("id");
        var title = $(this).children('option:first-child').text();

        $(this).wrap("<div class='select-box'></div>");
        $(this).parent(".select-box").prepend("<div class='selectedOption " + this_id + "'></div><ul class='select-ul " + this_id + "_ul'></ul>")
        console.log(element);
        var selBox = $(this).parent(".select-box");
        $(element).each(function(idx, elm) {
            $('option', elm).each(function(id, el) {
                selBox.find('ul').append('<li>' + el.text + '</li>');
                console.log($('.select-box ul:last'));
            });
            $('.select-box ul').hide();
            // $(this).parent('.makeMeUl .selectedOption').text(defTxt);
        });
        $(this).parent(".select-box").children('div.selectedOption').text(title);
        $(this).parent(".notit").children('div.selectedOption').text();
        $(this).addClass('novis');
    });

    var optionLi = $('select').not('.novis').find('option:first-child');
    var optDiv = $('select').not('.novis').find('.selectedOption');

    $.each(optDiv, function(index, item) {
        $(this).text(optionLi.eq(index).text());
    });
}



// 썸네일 파일 지우기
function RemoveFile() 
{   
    
}