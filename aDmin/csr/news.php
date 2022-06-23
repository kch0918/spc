<?php
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/admin_header.php");
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/admin_lnb.php");

$order_by = (isset($_REQUEST['order_by'])) ? $_REQUEST['order_by'] : "desc";

$query = "SELECT *,DATE_FORMAT(submit_date, '%Y.%m.%d') as submit_date2 FROM SPC_NEWS where 1";

if(isset($_POST['search_name']) && $_POST['search_name'] != null && $_POST['search_name'] != "")
{
    $query .= " and title like '%{$_POST['search_name']}%'";
}

$time_stamp = strtotime("-9 year");
$start_date = date("Ymd", $time_stamp);
$end_date = date("Ymd");
$date_picker1 = (isset($_REQUEST['datepicker1'])) ? $_REQUEST['datepicker1'] : $start_date;
$date_picker2 = (isset($_REQUEST['datepicker2'])) ? $_REQUEST['datepicker2'] : $end_date;

// 조회기간 검색
if($date_picker1 != "" && $date_picker2 != "")
{
    $query .= " and submit_date BETWEEN '{$date_picker1}' and '{$date_picker2}'";
}

// 노출o & 노출x
if(isset($_POST['expo_yn']) && $_POST['expo_yn'] != null && $_POST['expo_yn'] != "")
{
    $expo_yn = implode(",", $_POST['expo_yn']);
    $query .= " and expo_yn in ( {$expo_yn} )";
}

else 
{
    $query .= " order by submit_date {$order_by}";
}

$result_cnt = sql_query($query);

// 현재 페이지
$page = ($_REQUEST['page'])?$_REQUEST['page']:1;
if(!isset($_REQUEST['listSize']))
{
    $listSize = 10;
}
else
{
    $listSize = $_REQUEST['listSize'];
}

$list = $listSize;
$block = 5;
$pageNum = ceil(sql_count($result_cnt)/$list); // 총 페이지
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

$n = sql_count($result_cnt);
$expo_yn = implode(",", $_POST['expo_yn']); 
?>

<script>
var listSize = '<?php echo $listSize?>';
var page = "<?php echo $page?>";
var search_name = "<?php echo $_POST['search_name']?>";
var order_by = "<?php echo $order_by?>";
var expo_yn = "<?php echo $expo_yn?>";
var datepicker11 = "<?php echo $date_picker1?>";
var datepicker22 = "<?php echo $date_picker2?>";
var dateType 	= "<?php echo $_POST['dateType']?>";

//최신등록순 , 오래된순
function changeFunc() {
	
	 var selectBox = document.getElementById("selectBox");
	 var selectedValue = selectBox.options[selectBox.selectedIndex].value;
	 location.href = "/aDmin/csr/news.php?order_by="+selectedValue;
	 
	}
	
// 페이지 로딩시 
$(document).ready(function(){

	$('input:radio[name="dateType"]')[0].checked = true;
	$("#datepicker1").val(datepicker11);
	$("#datepicker2").val(datepicker22);
	
	var selectBox = document.getElementById("selectBox");
    var selectedValue = selectBox.options[selectBox.selectedIndex].value;
	$("#p_"+page).addClass("active");
	$("#search_name").val(search_name);
	if(order_by == "asc")
	{
		$( '.selectBox' ).text("오래된 순");
	}
	if(listSize != "")
	{
		$("#listSize").val(listSize);
	}
	if(expo_yn != "")
	{
		var expo_yn_arr = expo_yn.split(",");
		for(var i = 0; i < expo_yn_arr.length; i++){
			$('input:checkbox[name="expo_yn[]"]').filter(function(){
				if(expo_yn_arr[i] == this.value){
					this.checked = true;
				}
			});
		}
	}
	if(dateType != "")
	{	
		var len = $('input:radio[name="dateType"]').length;
		var chk_val =  "";
		for (var i = 0; i < len; i++) 
		{
			chk_val = $('input:radio[name="dateType"]')[i].value;
			if (chk_val==dateType) 
			{
				$('input:radio[name="dateType"]')[i].checked = true;
				break;
			}
		}
	}
})

// 페이지
function pageMove(page)
{
	$("#page").val(page);
	$("#fncForm").submit();
}

// 조회
function goNews(idx)
{
	location.href="/aDmin/csr/news_edit.php?idx="+idx;
}

//datepicker
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
    $("#datepicker1, #datepicker2").datepicker({
        dateFormat: 'yymmdd'
    });
});

//기간 계산
function setSearchDate(start){

            var num = start.substring(0,1);
            var str = start.substring(1,2);

            var today = new Date();
    		var year =  today.getFullYear();
			//var month = today.getMonth() + 1;
			//var day = today.getDate();
            
            
            var endDate = $.datepicker.formatDate('yymmdd', today);
            $('#datepicker2').val(endDate);
            
            if(str == 'd'){
                today.setDate(today.getDate() - num);
            }else if (str == 'w'){
                today.setDate(today.getDate() - (num*7));
            }else if (str == 'm'){
                today.setMonth(today.getMonth() - num);
                today.setDate(today.getDate() + 1);
            }else if (str == 'y'){
            	today.setYear(year - num); 
            	today.setMonth(today.getMonth());
                today.setDate(today.getDate());
            }

            var startDate = $.datepicker.formatDate('yymmdd', today);
            $('#datepicker1').val(startDate);
                    
            // 종료일은 시작일 이전 날짜 선택하지 못하도록 비활성화
            $("#datepicker2").datepicker( "option", "minDate", startDate );
            
            // 시작일은 종료일 이후 날짜 선택하지 못하도록 비활성화
            $("#datepicker1").datepicker( "option", "maxDate", endDate );

        }

// 검색
function reSelect(act)
{
	$("#page").val(1);
	$("#fncForm").submit();
}

// 엔터로 검색
function enter_check()
{
	if(event.keyCode == 13){
		reSelect('search');
		return;
	}
}

//삭제
function goDelete(idx)
{
	if(confirm("해당 게시물을 삭제하시겠습니까?"))
    {
	   // ajax 호출 
	   $.ajax({
   		type: "post",
   		url: "/aDmin/csr/news_delete_proc.php",
   		dataType:"text",
   		data : 
   		{
       		idx : idx
   		},
   		error : function() 
   		{
   			console.log("AJAX ERROR");
   		},
   		success : function(data) 
   		{
   			console.log(data);
   			var result = JSON.parse(data);
   			if(result.isSuc == "success")
    		{
    			alert(result.msg);
    			location.reload();
    			
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

<div id="container" class="report magazine">
	<div class="search">
		<p>뉴스레터<strong>생성된 게시글을 관리합니다.</strong></p>
		<input type="button" class="enroll" value="등록" onclick="location.href='/aDmin/csr/news_write.php'">
		<form id="fncForm" name="fncForm" method="post" action="news.php">
        	<select id="listSize" name="listSize" class="novis">
        		<option value="10">10개 보기</option>
        		<option value="50">50개 보기</option>
        		<option value="100">100개 보기</option>
        		<option value="300">300개 보기</option>
        		<option value="500">500개 보기</option>
        		<option value="1000">1000개 보기</option>
        	</select>
        	<input type="hidden" id="order_by" name="order_by" value="<?php echo $order_by?>">
            <input type="hidden" id="page" name="page" value="<?php echo $page?>">
            <input type="hidden" id="expo_yn" name="expo_yn" value="<?php echo $expo_yn?>">
		<div class="seacrh_info">
			<div class="search_top">
				<div class="search_txt">기간검색</div>
				<div class="date_line">
					<div class="date_box"><input autocomplete="off" type="text" id="datepicker1" class="search_date" name="datepicker1" value="<?php echo $_POST['datepicker1']?>"></div>
					<div class="date_box"><input autocomplete="off" type="text"  class="search_date"  id="datepicker2" name="datepicker2" value="<?php echo $_POST['datepicker2']?>"></div>
				</div>
				<div class="check_box">
					<ul class="check_wrap">
						<li><input type="radio" name="dateType" id="dateType2" class="regular-radio" onclick="setSearchDate('9y')" value="전체"> <label for="dateType2"><span>전체</span></label></li>
						<li><input type="radio" name="dateType" id="dateType3" class="regular-radio" onclick="setSearchDate('1w')" value="1주"><label for="dateType3"><span>7일</span></label></li>
						<li><input type="radio" name="dateType" id="dateType4" class="regular-radio" onclick="setSearchDate('2w')" value="2주"><label for="dateType4"><span>15일</span></label></li>
						<li><input type="radio" name="dateType" id="dateType5" class="regular-radio" onclick="setSearchDate('1m')" value="1달"><label for="dateType5"><span>1개월</span></label></li>
						<li><input type="radio" name="dateType" id="dateType6" class="regular-radio" onclick="setSearchDate('3m')" value="3개월"><label for="dateType6"><span>3개월</span></label></li>
					</ul>
				</div>
			</div>
			<div class="search_bot">
				<div class="search_txt">검색어</div>
				<div class="news_search">
					<input type="text" id="search_name" name="search_name" class="search_key no_left" placeholder="여기에 검색어를 입력하세요" value="<?php echo $_POST['search_name']?>" onkeydown="javascript:enter_check();">
					<input type="button" class="ico_search" value="" onclick="">
				</div>
				<div class="check_box">
					<ul class="check_wrap">
						<li class="news_check_tit">노출 여부</li>
						<li><input type="checkbox" id="show" name="expo_yn[]" value="1" class="regular-radio"><label for="show"><span>노출</span></label></li>
						<li><input type="checkbox" id="noshow" name="expo_yn[]" value="2" class="regular-radio"><label for="noshow"><span>미노출</span></label></li>
					</ul>
				</div>
			</div>
            <a href="javascript:reSelect('search');" class="bt_search">검색</a>
		</div>
      </form>
	</div>
	<div class="search_cont">
	<?php 
    	$now_point = ($page-1) * $list;
    	$now_page = sql_query($query." limit {$now_point},{$list}");
	?>
	<span class="serch_cont_txt">결과  <?php echo sql_count($now_page);?>개 / 전체 <?php echo sql_count($result_cnt);?>개</span>
    <select id="selectBox" class="serch_cont_sort" onchange="changeFunc();">
        <option value="desc">최신 등록 순</option>
        <option value="asc">오래된 순</option>
    </select>   
	<table class="table_tit news_tb">
		<tr>
        	<th>NO.</th>
        	<th>제목</th>
        	<th>등록일</th>
        	<th>노출</th>
        	<th></th>
        	<th></th>
		</tr>
		<table class="tablecont news_tb">
				<?php
                        $s_point = ($page-1) * $list;
                        $result = sql_query($query." limit {$s_point},{$list}");
                        for ($i=0; $i<sql_count($result); $i++)
                        {
                            $row = sql_fetch($result);
                            ?>
            					<tr>
        							<td><?php echo ($n - $i) - (($page-1) * $listSize)?></td>
        							<td><?php echo $row['title'];?></td>
            						<td><?php echo $row['submit_date2'];?></td>
            						<?php if($row['expo_yn'] == "Y") {
                					    ?>
                						<td>노출</td>
                						 <?php 
            						}else {
            						    ?>
            						    <td>미노출</td>
            						    <?php 
            						}
                						  ?>
            						<td><a class="edit" onclick="goNews(<?php echo $row['idx']?>)">수정</a></td>
            						<td><a class="delete" onclick="goDelete(<?php echo $row['idx']?>)">삭제</a></td>
            					</tr>
                            <?php 
                        }
                        ?>
    	</table>
    	</div>
	       <!-- 페이징  -->
			<div class="page_box">
				<div class="page_num">
				 <ul>
					<?php 
						if(1 < $page)
						{
						    ?>
        					<li class="prev_" onclick="pageMove(<?=$s_page-1?>)"><a class="bt_left"></a></li>
                            <?php 
                        }
                        $pagingCnt = 0;
                        if($e_page != 0)
                        {
                            for ($p=$s_page; $p<=$e_page; $p++)
                            {
                                $pagingCnt ++;
                                ?>
                                <li onclick="pageMove(<?=$p?>)" id="p_<?=$p?>"><a class="bt_num"><?=$p?></a></li>
                         	    <?php
                            }
                        }
                        else
                        {
                            ?>
                            <li onclick="pageMove(1)"><a>1</a></li>
                            <?php
                        }
                        if($pageNum != $page && $pageNum > 5)
                        {
                            if($pagingCnt > 4)
                            {
                                if($e_page+1 > $pageNum)
                                {
                                    ?>
                                    <li class="next_" onclick="pageMove(<?=$pageNum?>)"><a class="bt_right"></a></li>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <li class="next_" onclick="pageMove(<?=$e_page+1?>)"><a class="bt_right"></a></li>
                                    <?php
                                }
                            }
                        }
						?>
					</ul>
				</div>
			</div>
</div>
<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/admin_footer.php");
?>