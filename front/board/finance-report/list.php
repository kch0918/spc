<?php
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");

$query2 = "select *,DATE_FORMAT(submit_date, '%Y.%m.%d') as submit_date2 from SPC_FINANCE where lang = 'ko' and expo_yn='Y'";
// print_r($_POST);

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
    $listSize = 10;
}
else
{
    $listSize = $_REQUEST['listSize'];
}

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

//페이지 로딩시 
$(document).ready(function(){
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
function goNotice(idx)
{
	location.href="/share/spc-foundation/finance-report-list/detail/?idx="+idx;
}

</script>

<div class="board-default-wrap">
    <form id="fncForm" name="fncForm" method="post" action="/share/spc-foundation/finance-report-list/">
    	<select id="listSize" name="listSize" class="hidden">
        		<option value="10">10개 보기</option>
        		<option value="50">50개 보기</option>
        		<option value="100">100개 보기</option>
        		<option value="300">300개 보기</option>
        		<option value="500">500개 보기</option>
        		<option value="1000">1000개 보기</option>
        	</select>
    	    <input type="hidden" id="page" name="page" value="<?php echo $page?>">
    	    <input type="hidden" id="idx" name="idx" value="<?php echo $row2['idx']?>">
    	<div class="board-search">
    		<div class="search-input">
		    	<input type="text" id="search_name" name="search_name" placeholder="제목 + 내용"  value="<?php echo $_POST['search_name']?>">
    	 		<input type="button" class="ico_search" value="" onclick="reSelect('search');" >
    		</div>
    	</div>
    </form>
    <div class="board-default-list">
    	<table>
    		<colgroup>
    			<col style="width:15%;">
    			<col>
    			<col style="width:24%;"> 
    		</colgroup>
    		<thead>
    			<tr>
    				<th>NO.</th>
    				<th>제목</th>
    				<th>날짜</th>
    			</tr>
    		</thead>
    		<tbody>
		  <?php 
	  		    $s_point = ($page-1) * $list;
	  		    $result2 = sql_query($query2." limit {$s_point},{$list}");
                for($i = 0; $i < sql_count($result2); $i++)
                {
                  $row2= sql_fetch($result2);
                ?>
    			<tr>
    				<td><?php echo ($n - $i) - (($page-1) * $listSize)?></td>
    				<td class="subject"><a href="javascript:goNotice(<?php echo $row2['idx']?>);"><?php echo $row2['title']?></a></td>
    				<td><?php echo $row2['submit_date2']?></td>
    			</tr>
			<?php 
                }
			?>
    		</tbody>
    	</table>
 	 </div>
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