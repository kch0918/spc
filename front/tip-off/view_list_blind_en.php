<?php
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");

if ($_SESSION['user_idx'] == "") {
    
    echo "<script>alert('로그인이 필요한 서비스 입니다.');</script>";
    
    echo "<meta http-equiv='refresh' content='0;url=/csr/right-mng/tip-off-login/?lang=en'>";
    
    exit;
}

$query  = "SELECT *,DATE_FORMAT(submit_date, '%Y.%m.%d') as submit_date2 from SPC_NAGATION where id = '{$_SESSION['user_id']}'";
$result = sql_query($query);
$row    = sql_fetch($result);
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
$pageNum = ceil(sql_count($result)/$list); // 총 페이지
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
$n = sql_count($result);

?>

<script src="/aDmin/js/jquery-1.12.4.js"></script>
<script src="/aDmin/js/jquery-ui.js"></script> 
<link rel="stylesheet" href="/js/jquery-ui.css" type="text/css" />
<script src="/aDmin/js/malsup.js"></script>
<script type="text/javascript" src="/aDmin/include/ckeditor/ckeditor.js"></script>
<script>
var listSize = '<?php echo $listSize?>';
var page = "<?php echo $page?>";

console.log(listSize);
//페이지 로딩시 
$(document).ready(function(){
	$("#p_"+page).addClass("current");
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

function goDetail(idx) {
	location.href="/csr/right-mng/view-detail-blind/?lang=en&idx="+idx;
}
</script>

<div class="report-list">
    <div class="board-default-list">
    	<form id="fncForm" name="fncForm" method="post" action="/csr/right-mng/view-list-blind/">
        	<select id="listSize" name="listSize" class="hidden">
                		<option value="10">10개 보기</option>
                		<option value="50">50개 보기</option>
                		<option value="100">100개 보기</option>
                		<option value="300">300개 보기</option>
                		<option value="500">500개 보기</option>
                		<option value="1000">1000개 보기</option>
            </select>
            <input type="hidden" id="page" name="page" value="<?php echo $page?>">
            <table>
                <caption>The result of my report</caption>
            	<thead>
            		<tr>
                		<th>NO.</th>
                		<th>Subject</th>
                		<th>Submission date</th>
                		<th>Progress</th>
            		</tr>
            	</thead>
            	<tbody>
            	<?php 
                	$s_point = ($page-1) * $list;
                	$result = sql_query($query." limit {$s_point},{$list}");
                	for($i = 0; $i < sql_count($result); $i++)
                	{
                	    $row = sql_fetch($result);
                	    ?>
            		<tr>
                		<td><?php echo ($n - $i) - (($page-1) * $listSize)?></td>
                		<td class="align-left"><a href="javascript:goDetail('<?php echo $row['idx']?>')"><?php echo $row['title']?></a></td><!-- 게시글 내용으로 들어가는 링크 -->
                		<td><?php echo $row['submit_date2']?></td>
            			<?php 
            			if($row['status'] == "Y") {
            			    ?>
                    		<td><span class="status">답변완료</span></td><!-- 진행상태가 매 번 컬러 다를 것 같아서 상태값은 영문으로 된 걸 클래스에 같이 넣어주세요!! !!!! -->
            			<?php 
            			} else {
            		    ?>
            			    <td><span class="status">접수완료</span></td><!-- 진행상태가 매 번 컬러 다를 것 같아서 상태값은 영문으로 된 걸 클래스에 같이 넣어주세요!! !!!! -->
            			<?php 
            			}
            			?>
            		</tr><!-- 한페이지에 최대 10개 루프 -->
            		<?php 
                	}
            		?>
            	</tbody>
            </table>
    	</form>
    </div>

    <!-- 페이징  -->
    <div class="page_box">
        <div class="board-pagination">
    		<a href="" class="prev_ prev-btn"  onclick="pageMove(<?=$s_page-1?>)">Prev</a>
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
                <a class="bt_num current" onclick="pageMove(1)">1</a>
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
                        <a class="next-btn next_" onclick="pageMove(<?=$e_page+1?>)">Next</a>
                        <?php
                    }
                }
            }
    		?>
        		 <?php 
					if($pagingCnt < 4){
					?>
    				 <a href="" class="next-btn next_"  onclick="pageMove(<?=$e_page+1?>)">Next</a>
    				<?php 
                    }      
				    ?>
        </div>
    </div>
</div>
