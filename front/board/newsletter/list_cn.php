<?php
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");

$query2 = "select *,DATE_FORMAT(submit_date, '%Y.%m.%d') as submit_date2 from SPC_NEWS where lang = 'cn' and expo_yn='Y'";
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
function goDetail(idx)
{
	location.href="/csr/society/newsletter/detail_cn/?idx="+idx + "&lang=zh-hans";
}
</script>

<div class="contri-wr text-center">
	<div class="contri-sec contri-sec05">
		<h2 class="ft-42 bold color-000 global-tit img-ani bottom-top">Newsletter</h2>
		<form id="fncForm" name="fncForm" method="post" action="/csr/society/newsletter/?lang=zh-hans">
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
		<div class="magazine-slide">
			<div class="slide-wr">
				<div class="magazine-latest swiper-container">
					<ul class="tranDelayList swiper-wrapper">
					    <?php 
                        $query = "select *,DATE_FORMAT(submit_date, '%Y.%m.%d') as submit_date2 from SPC_NEWS where expo_yn = 'Y' and lang = 'cn' order by submit_date DESC LIMIT 5";
                        $result = sql_query($query);
                        for($i = 0; $i < sql_count($result); $i++){
                        $row = sql_fetch($result);
                            ?>
                                <li class="swiper-slide">
                              <?php   
                             if($row['thumb'] != null) {
                    			?>
                				<div class="img">
                    				<div class="img-hov"><a href="javascript:goDetail(<?php echo $row['idx']?>);">
                    				<img src="/aDmin/file/<?php echo $row['thumb']?>" alt=""></a></div>
                				</div>
                    			<?php 					
                    			} else {
                    			?>
                    			<div class="img">
                    					<img src="/aDmin/img/youtube-logo01.png" alt="spc그룹">
                    					<a href="javascript:goDetail(<?php echo $row['idx']?>);">
                    					<img class="de-img" src="/img/sub/card-thumb.png" alt="SPC그룹"/></a>
                    			</div>
                    			<?php 
                    			}
                    			?>
        							<div class="cont">
        								<h3 class="ft-18"><?php echo $row['title']?></h3>
        								<time class="date"><?php echo $row['submit_date2']?></time>
        							</div>
        						</li>
            				<?php 
                                }
            				?>
					</ul>
				</div>			
			</div>
			<div class="mu-swiper-button mu-swiper-button-next"></div>
			<div class="mu-swiper-button mu-swiper-button-prev"></div>
		</div>
		<div class="magazine-latest magazine-list">
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
						<input type="text" id="search_name" name="search_name" class="search_key" placeholder="请输入题目或内容" value="<?php echo $_POST['search_name']?>" onkeydown="javascript:enter_check();">
						<input type="button" class="ico_search" value="" onclick="reSelect('search');" >
					</div>
				</div>
			</div>
			<ul class="tranDelayList">
			  		  <?php 
			  		    $s_point = ($page-1) * $list;
			  		    $result2 = sql_query($query2." limit {$s_point},{$list}");
                        for($n = 0; $n < sql_count($result2); $n++)
                        {
                          $row2 = sql_fetch($result2);
                        ?>
        				<li>
        					 <?php   
                             if($row2['thumb'] != null) {
                    			?>
                				<div class="img">
                    				<div class="img-hov"><a href="javascript:goDetail(<?php echo $row['idx']?>);">
                    				<img src="/aDmin/file/<?php echo $row2['thumb']?>" alt=""></a></div>
                				</div>
                    			<?php 					
                    			} else {
                    			?>
                    			<div class="thumb">
                        			<a href="javascript:goDetail(<?php echo $row2['idx']?>);">
                        			<img src="/aDmin/img/youtube-logo01.png" alt="spc그룹"><img class="de-img" src="/img/sub/card-thumb.png" alt="SPC그룹"/>
                        			</a>
                    			</div>
                    			<?php 
                    			}
                    			?>
        					<div class="cont">
        							<h3 class="ft-18"><?php echo $row2['title']?></h3>
        							<time class="date"><?php echo $row2['submit_date2']?></time>
        					</div>
        				</li>
        				<?php 
                            }
        				?>
			</ul>
		</div>
		</form>

	 	<!-- 페이징  -->
		<div class="page_box">
			<div class="board-pagination">
				    <a href="" class="prev-btn prev_"  onclick="pageMove(<?=$s_page-1?>)">上一个</a>
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
                                <a class="next-btn next_" onclick="pageMove(<?=$e_page+1?>)">下一个</a>
                                <?php
                            }
                        }
                    }
					?>
					
					<?php 
					if($pagingCnt < 4){
					?>
    				 <a href="" class="next-btn next_"  onclick="pageMove(<?=$e_page+1?>)">下一个</a>
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
	$(window).ready(function(){		
		
	})
	$(function(){
		var newsSlide = new Swiper('.magazine-slide .swiper-container',{
			slidesPerView:4,
			breakpoints:{
				989:{
					slidesPerView:2
				},
				767:{
					slidesPerView:1					
				}
			},
			navigation:{
				prevEl:'.magazine-slide .mu-swiper-button-prev',
				nextEl:'.magazine-slide .mu-swiper-button-next'
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
</script>