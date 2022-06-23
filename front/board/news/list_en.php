<?php
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");

$query2 = "select *,DATE_FORMAT(submit_date, '%Y.%m.%d') as submit_date2 from SPC_REPORT where expo_yn='Y' and lang='en'";
// print_r($_POST);

if(isset($_POST['type']) && $_POST['type'] != null && $_POST['type'] != "")
{
    $query2 .= " and type = '{$_POST['type']}'";
}

if(isset($_POST['type2']) && $_POST['type2'] != null && $_POST['type2'] != "")
{
    $query2 .= " and type2 = '{$_POST['type2']}'";
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
var type = "<?php echo $_POST['type']?>";
var type2 = "<?php echo $_POST['type2']?>";

if(type == "brand"){
	type = "brand";
}else if(type == "subsidiary") {
	type = "subsidiary";
}else if(type == "spc_group"){
	type = "spc_group룹";
}else{
	type = "all";
}

console.log(listSize);

//페이지 로딩시 
$(document).ready(function(){
	$("#p_"+page).addClass("current");
	$("#search_name").val(search_name);
	if(listSize != "")
	{
		$("#listSize").val(listSize);
	}
	if(type != ""){
		$("#type_name").text(type);
	}
	if(type2 != ""){
		$("#type_name2").text(type2);
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
function goDetail(seq)
{
	location.href="/media-hub/news/detail_en/?seq="+seq + "&lang=en";
}

function brandCate(brand){
	
	// input에 value 값 넣어주기
	$('input[name="type"]').val(brand);
	
	$.ajax({
		url: "/front/board/news/brandCate.php",
		type: "POST",
		success: function(data){
    			var result = JSON.parse(data);
    			console.log(result);
    			var inner = "";
    			var inner2 = "";

    			inner += '<li><a>all</a></li>';
    			for(var i = 0; i < result.length; i++) {

    	   			inner += 	'<li><a href="javascript:cateType(\''+result[i].cate_name_en+'\');" value="'+result[i].cate_name_en+'">'+result[i].cate_name_en+'</li>';
    	   			
					}
    				$("#Cate2").empty();
					$("#Cate2").append(inner);
		   		 }
		});
	}

function cateType(type2){
	console.log(type2);
	// input에 value 값 넣어주기
	$('input[name="type2"]').val(type2);
	
	}

function subCate(subsidiary){

	$('input[name="type"]').val(subsidiary);
	
	$.ajax({
		url: "/front/board/news/subCate.php",
		type: "POST",
		success: function(data){
    			var result = JSON.parse(data);
    			console.log(result);
    			var inner = "";
    			var inner2 = "";
    			
    			inner += '<li><a>all</a></li>';
    			for(var i = 0; i < result.length; i++) {
        			
    				inner += 	'<li><a href="javascript:cateType(\''+result[i].cate_name_en+'\');" name="cateType">'+result[i].cate_name_en+'</li>';
    				
					}
    				$("#Cate2").empty();
					$("#Cate2").append(inner);
		   		 }
		});
	}

function groupCate(spc_group){

	var inner = "";
	
	$("#Cate2").empty();
	$("#Cate2").append(inner);
	$("#type_name2").empty();
	// input에 value 값 넣어주기
	$('input[name="type"]').val(spc_group);
	
	}

function allCate(){

	var inner = "";
	
	$("#Cate2").empty();
	$("#type_name2").empty("");
	$("#type_name2").text("전체");
	// input에 value 값 넣어주기
	$('input[name="type"]').val();
	
	}
	
</script>

<div class="contri-wr text-center">
	<div class="contri-sec contri-sec01">
		<h2 class="ft-42 bold color-000 global-tit img-ani bottom-top">NEWS Feed</h2>
		<form id="fncForm" name="fncForm" method="post" action="/media-hub/news/?lang=en">
			<select id="listSize" name="listSize" class="hidden">
        		<option value="12">12개 보기</option>
        	</select>
    	    <input type="hidden" id="page" name="page" value="<?php echo $page?>">
            <input type="hidden" id="seq" name="seq" value="<?php echo $row2['seq']?>">
    	    <input type="hidden" id="type" name="type" value="">
    	    <input type="hidden" id="type2" name="type2" value="">
    	    
		<div class="contri-box img-ani slide-type03">
			<div class="contri-list cardtype-list cardtype-list02 slide-wr">
				<div class="swiper-container">
					<ul class="swiper-wrapper tranDelayList">
						<?php 
                        $query = "select *,DATE_FORMAT(submit_date, '%Y.%m.%d') as submit_date2 from SPC_REPORT where expo_yn = 'Y' and lang = 'en' order by submit_date DESC LIMIT 5 ";
                        $result = sql_query($query);
                        for($i = 0; $i < sql_count($result); $i++){
                        $row = sql_fetch($result);
                        ?>
						<li class="swiper-slide">
							<a href="javascript:goDetail(<?php echo $row['seq']?>);">
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
									<?php 
									if($row['type2'] != null) {
									?>
										<span class="writer"><?php echo $row['type2']?></span><time class="date"><?php echo $row['submit_date2']?></time>
									<?php 
									} else {
									?>
										<span class="writer">SPC GROUP</span><time class="date"><?php echo $row['submit_date2']?></time>
									<?php 
									}
									?>
										<span class="view-btn" href="#">VIEW MORE</span>
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
			<div class="mu-swiper-button mu-swiper-button-next"></div>
			<div class="mu-swiper-button mu-swiper-button-prev"></div>
		</div><!-- //contri-box -->
	</div>
	<div class="contri-sec contri-sec04">
		<h2 class="ft-42 bold color-000 global-tit img-ani bottom-top">Hot Press Release</h2>
		<div class="contri-box img-ani">
			<div class="board-search table">
				<div class="contri-data">
					<div class="table">
						<div>
							<div class="select">
								<p id="type_name"><strong>all</strong></p>
								<ul>
									<li><a href="javascript:allCate();">all</a></li>
									<li><a href="javascript:brandCate('brand');">brand</a></li>
									<li><a href="javascript:subCate('subsidiary');">subsidiary</a></li>
									<li><a href="javascript:groupCate('spc_group');">spc_group</a></li>
								</ul>
							</div>
						</div>
						<div>
							<div class="select">
								<p id="type_name2"><strong>all</strong></p>
    								<ul id="Cate2">
    								</ul>
							</div>
						</div>

					</div>
				</div>
				<div class="serch_key_box">
					<div class="search-input">
						<input type="text" id="search_name" name="search_name" class="search_key" placeholder="Enter subject or content." value="<?php echo $_POST['search_name']?>" onkeydown="javascript:enter_check();">
						<input type="button" class="ico_search" value="" onclick="reSelect('search');" >
					</div>
				</div>
			</div>
			<ul class="contri-list cardtype-list cardtype-list02">
				<?php 
			  		    $s_point = ($page-1) * $list;
			  		    $result2 = sql_query($query2." limit {$s_point},{$list}");
                        for($n = 0; $n < sql_count($result2); $n++)
 
                        {
                          $row2 = sql_fetch($result2);
                        ?>
				<li>
					<a href="javascript:goDetail(<?php echo $row2['seq']?>);">
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
								<?php 
									if($row2['type2'] != null) {
									?>
										<span class="writer"><?php echo $row2['type2']?></span>
									<?php 
									} else {
									?>
										<span class="writer">SPC GROUP</span>
									<?php 
									}
									?>
									<time class="date"><?php echo $row2['submit_date2']?></time>
								<span class="view-btn" href="javascript:goDetail(<?php echo $row2['seq']?>);">VIEW MORE</span>
							</div>
						</div>
					</a>
				</li>
				<?php 
                    }
				?>
			</ul>
		</div><!-- //contri-box -->
		</form>
		
	 	<!-- 페이징  -->
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

<script src="//code.jquery.com/jquery-1.12.4.js"></script> 
<script src="/js/jquery-ui.js"></script>
<link rel="stylesheet" href="/js/jquery-ui.css" type="text/css" />
<script>
	$(function(){
		var newsSlide = new Swiper('.slide-type03 .swiper-container',{
			slidesPerView:3,
			spaceBetween:30,
			breakpoints:{
				989:{
					spaceBetween:28,
					slidesPerView:2
				},
				767:{
					spaceBetween:15,
					slidesPerView:1,
				}
			},
			navigation:{
				prevEl:'.slide-type03 .mu-swiper-button-prev',
				nextEl:'.slide-type03 .mu-swiper-button-next'
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
