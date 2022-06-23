<?php
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");

$query2 = "select *,DATE_FORMAT(submit_date, '%Y.%m.%d') as submit_date2 from SPC_REVIEW where expo_yn='Y' and lang = 'en' ";
// print_r($_POST);

$time_stamp = strtotime("-9 year");
$start_date = date("Ymd", $time_stamp);
$end_date = date("Ymd");
$date_picker3 = (isset($_REQUEST['datepicker3'])) ? $_REQUEST['datepicker3'] : $start_date;
$date_picker4 = (isset($_REQUEST['datepicker4'])) ? $_REQUEST['datepicker4'] : $end_date;

// 조회기간 검색
if($date_picker3 != "" && $date_picker4 != "")
{
    $query2 .= " and submit_date BETWEEN '{$date_picker3}' and '{$date_picker4}'";
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
var maxFileSize = 50 * 1024 * 1024; //바이트 단위
var datepicker33 = "<?php echo $date_picker3?>";
var datepicker44 = "<?php echo $date_picker4?>";

//페이지 로딩시 
$(document).ready(function(){
	$("#datepicker3").val(datepicker33);
	$("#datepicker4").val(datepicker44);
	
	$("#p_"+page).addClass("current");
	$("#search_name").val(search_name);
	if(listSize != "")
	{
		$("#listSize").val(listSize);
	}

	//첨부파일 용량 검증
	$('#uploadFile').change(function(){
	    var fileName = $(this).val().split('fakepath\\')[1],
	    	fileSize = $(this)[0].files[0].size;
		if(fileSize >= maxFileSize){
	    	alert('첨부파일의 용량은 최대 ' + (maxFileSize / 1024 / 1024) + 'MB까지 가능합니다.');
	    	$(this).val('');
	    	$('#fakeFileName').val('');
		}else{
	    	$('#fakeFileName').val(fileName);
		}
	});

	//첨부파일 용량 검증
	$('#uploadThumb').change(function(){
	    var fileName = $(this).val().split('fakepath\\')[1],
	    	fileSize = $(this)[0].files[0].size;
		if(fileSize >= maxFileSize){
	    	alert('첨부파일의 용량은 최대 ' + (maxFileSize / 1024 / 1024) + 'MB까지 가능합니다.');
	    	$(this).val('');
	    	$('#fakeThumbName').val('');
		}else{
	    	$('#fakeThumbName').val(fileName);
		}
	});
		
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
function goDetail(idx)
{
	location.href="/share/society/review/detail/?idx="+idx;
}

$.datepicker.setDefaults({
    dateFormat: 'yy-mm',
    prevText: '이전 달',
    nextText: '다음 달',
    monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
    monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
    dayNames: ['일', '월', '화', '수', '목', '금', '토'],
    dayNamesShort: ['일', '월', '화', '수', '목', '금', '토'],
    dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
    showMonthAfterYear: true,
    yearSuffix: '년'
  });

$(function() {
    $("#datepicker1, #datepicker2,#start_date, #end_date").datepicker({
        dateFormat: 'yymmdd'
    });
});


function fncSubmit2()
{

	CKEDITOR.instances.contents.updateElement(); 
	
	var validationFlag = "Y";
	$(".notempty").each(function()
	{ 
		if ($(this).val() == "") 
		{
			alert(this.dataset.name+"을(를) 입력해주세요.");
			$(this).focus();
			validationFlag = "N";
			return false;
		}
	});

	if(validationFlag == "Y")
	{
		$("#fncForm2").ajaxSubmit({
			success: function(data)
			{
				console.log(data);
				var result = JSON.parse(data);
	    		if(result.isSuc == "success")
	    		{
	    			alert("저장되었습니다.");
	    			location.href="/share/society/review/?lang=en";
	    		}
	    		else
	    		{
	    			alert(result.msg);
	    		}

			}

		});

	}
}   
</script>

<div class="contri-wr text-center">
<?php 
	if($row['idx'] != null) {
	?>
	<div class="contri-sec contri-sec01">
		<h2 class="ft-42 bold color-000 global-tit img-ani bottom-top">Hot comments from ESG participants</h2>
		 <form id="fncForm" name="fncForm" method="post" action="/share/society/review/?lang=en">
			<select id="listSize" name="listSize" class="hidden">
        		<option value="12">12개 보기</option>
        		<option value="50">50개 보기</option>
        		<option value="100">100개 보기</option>
        		<option value="300">300개 보기</option>
        		<option value="500">500개 보기</option>
        		<option value="1000">1000개 보기</option>
        	</select>
        	<input type="hidden" id="page" name="page" value="<?php echo $page?>">
    	    <input type="hidden" id="idx" name="idx" value="<?php echo $row2['idx']?>">
		<div class="contri-box img-ani review-slide">
			<div class="contri-list cardtype-list slide-wr">
				<div class="swiper-container">
					<ul class="swiper-wrapper tranDelayList">
					   <?php 
                        $query = "select *,DATE_FORMAT(submit_date, '%Y.%m.%d') as submit_date2 from SPC_REVIEW where top_review = 'Y' and lang = 'en' order by submit_date DESC LIMIT 5";
                        $result = sql_query($query);
                        for($i = 0; $i < sql_count($result); $i++){
                        $row = sql_fetch($result);
                            ?>
						<li class="swiper-slide">
							<a href="javascript:goDetail(<?php echo $row['idx']?>);">
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
										<span class="writer">Comments</span><time class="date"><?php echo $row['submit_date2']?></time>
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
			<div class="mu-swiper-button mu-swiper-button-next"></div>
			<div class="mu-swiper-button mu-swiper-button-prev"></div>
		</div><!-- //contri-box -->
		<?php 
	}
	?>
	</div>
	<div class="contri-sec contri-sec04">
		<h2 class="ft-42 bold color-000 global-tit img-ani bottom-top">All comments from ESG participants
			<div class="review-btnwr"><a class="maga-btn review-btn"><img src="/img/csr/write-btn.png" alt="참여후기 작성하기">write a comment</a></div>
		</h2>
		<div class="contri-box img-ani">
			<div class="board-search table">
				<div class="contri-data">
					<div class="table">
						<div><input autocomplete="off" type="text" id="datepicker3" class="search_date" name="datepicker3" value="<?php echo $_POST['datepicker1']?>"></div>
						<div class="data-hi">~</div>
						<div><input autocomplete="off" type="text"  class="search_date"  id="datepicker4" name="datepicker4" value="<?php echo $_POST['datepicker2']?>"></div>
					</div>
				</div>
				<div class="serch_key_box">
					<div class="search-input">
						<input type="text" id="search_name" name="search_name" class="search_key" placeholder="Enter subject or content." value="<?php echo $_POST['search_name']?>" onkeydown="javascript:enter_check();">
						<input type="button" class="ico_search" value="" onclick="reSelect('search');" >
					</div>
				</div>
			</div>
			</form>
			<ul class="contri-list cardtype-list">
			  <?php 
			  		    $s_point = ($page-1) * $list;
			  		    $result2 = sql_query($query2." limit {$s_point},{$list}");
                        for($n = 0; $n < sql_count($result2); $n++)
                        {
                          $row2 = sql_fetch($result2);
                        ?>
				<li>
					<a href="javascript:goDetail(<?php echo $row2['idx']?>);">
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
								<span class="writer">Comments</span><time class="date"><?php echo $row2['submit_date2']?></time>
							</div>
						</div>
					</a>
				</li>
			<?php 
                    }
				?>
			</ul>
		</div><!-- //contri-box -->
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
<!-- 팝업 -->
<div class="global-popwr">
	<div class="global-bg"></div>
	<div class="global-pop newslatter-pop review-pop">
		<div class="gpop-wr">
			<div>
				<div class="table">
					<div>
						<div class="pop-h2">
							<div class="global-cls">x</div>
							<h2>ESG Write a comment</h2>
						</div>
						<form id="fncForm2" method="post" action="/front/board/review/list_en_proc.php" enctype="multipart/form-data" onSubmit="return false;">
						<div class="pop-cont">
							<div class="scrollbar-inner">
								<div class="pop-form">
									<div class="table">
										<div class="pop-th">Written by</div>
										<div class="pop-td"><input type="text" name="reg_name" class="notempty" data-name="작성자" placeholder=""></div>
									</div>
									<div class="table">
										<div class="pop-th">Email</div>
										<div class="pop-td">
											<div class="email-row table">
												<div>
													<div class="table ">
														<div><input type="text" placeholder="Email" name="email1" class="notempty" data-name="이메일"></div>
														<div class="data-hi">@</div>
														<div><input type="text" id="email-list" placeholder="If your email address uses a domain other than those in the dropdown menu" name="email2" class="notempty" data-name="이메일"></div>
													</div>
												</div>
												<div>
													<div class="select">
														<p><strong>Enter email address domain</strong></p>
														<ul>
															<li data-id="1"><a>Enter email address domain</a></li>
															<li><a>naver.com</a></li>
															<li><a>gmail.com</a></li>
															<li><a>nate.com</a></li>
															<li><a>hanmail.net</a></li>
															<li><a>daum.net</a></li>
														</ul>
													</div>
												</div>
											</div>											
										</div>
									</div>
									<div class="table">
										<div class="pop-th">Affiliation</div>
										<div class="pop-td">											
											<div class="table contri-data">
												<div><input type="text" name="corp" placeholder="Company Name" class="notempty" data-name="회사명"></div>
												<div><input type="text" name="corp_dep" placeholder="Department Name" class="notempty" data-name="부서명"></div>
											</div>
										</div>
									</div>
									<div class="table">
										<div class="pop-th">Participant</div>
										<div class="pop-td"><input type="text" placeholder="e.g.," name="attend" class="notempty" data-name="참석자"></div>
									</div>
									<div class="table">
										<div class="pop-th">Date & Time of Participation</div>
										<div class="pop-td">
											<div class="contri-data">
												<div class="table">
													<div><input autocomplete="off" type="text" id="start_date" class="search_date notempty" name="start_date" value="" data-name="참석일시" ></div>
													<div class="data-hi">~</div>
													<div><input autocomplete="off" type="text"  class="search_date"  id="end_date " name="end_date" value="" data-name="참석일시"></div>
												</div>
											</div>						
										</div>
									</div>
									
									<div class="table">
										<div class="pop-th">Venue</div>
										<div class="pop-td"><input type="text" placeholder="" name="place" class="notempty" data-name="활동장소"></div>
									</div>
									<div class="table">
										<div class="pop-th">Subject</div>
										<div class="pop-td"><input type="text" placeholder="Enter subject" name="title" class="notempty" data-name="제목"></div>
									</div>
									<div class="table">
										<div class="pop-th">Content</div>
										<div class="pop-td">
										<div class="edit-text">
										<textarea id="contents" name="contents" class="notempty" data-name="내용"></textarea></div></div>
									</div>
									<div class="table">
                            			<div class="pop-th"><label for="uploadThumb">thumbnail</label></div>
                            			<div class="pop-td">
                            				<div class="form-file">
                            					<input type="text" class="input-narrow notempty" id="fakeThumbName" placholder="Select file(s)" data-name="썸네일">
                            					<span class="file-btn">
                            						<span class="btn btn02 on">Select file(s)<img src="/img/csr/icon_plus_w.png" alt="" width="15"></span>
                                					<input type="file" id="uploadThumb" name="thumb[]">
                            					</span>
                        					</div>
                        					<p class="form-notice color-s ft-15">50MB or less</p>
                        				</div>
                            		</div>
									<div class="table">
                            			<div class="pop-th"><label for="uploadFile">Attachments</label></div>
                            			<div class="pop-td">
                            				<div class="form-file">
                            					<input type="text" class="input-narrow" id="fakeFileName" readonly placholder="Select file(s)">
                            					<span class="file-btn">
                            						<span class="btn btn02 on">Select file(s)<img src="/img/csr/icon_plus_w.png" alt="" width="15"></span>
                                					<input type="file" id="uploadFile" name="file[]">
                            					</span>
                        					</div>
                        					<p class="form-notice color-s ft-15">50MB or less</p>
                        				</div>
                            		</div>
        					</form>
								<div class="btn-wr">
									<a href="http://spcweb.musign.co.kr/csr/society/review/?lang=en" class="btn btn01">Cancel</a>
									<a href="javascript:fncSubmit2();" class= "btn btn02" >Submit</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div><!-- //global-pop -->
</div>

<script src="//code.jquery.com/jquery-1.12.4.js"></script> 
<script src="/js/jquery-ui.js"></script>
<link rel="stylesheet" href="/js/jquery-ui.css" type="text/css" />
<script src="https://malsup.github.io/min/jquery.form.min.js"></script>
<script type="text/javascript" src="/aDmin/include/ckeditor/ckeditor.js"></script>
<script>

$(document).ready(function(){
	CKEDITOR.replace('contents'); 
})

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
			navigation:{
				prevEl:'.review-slide .mu-swiper-button-prev',
				nextEl:'.review-slide .mu-swiper-button-next'
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
	$(window).load(function(){
		$(".maga-btn").click(function(){
			$(".global-popwr").show();
			$(".global-pop").show();

		});
		$(".global-bg, .global-cls").click(function(){
			$(".global-popwr").hide();
			$(".global-pop").hide();
			
		});
		$(".email-row").each(function(){
			$(".select").find("li").click(function(){
				var chk = $(this).attr("data-id"),
					text = $(this).text();
				if(chk == "1"){
					$("#email-list").val("");
				}else{
					$("#email-list").val(text);
				}
			})
		})
	})
</script>