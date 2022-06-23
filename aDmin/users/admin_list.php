<?php
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/admin_header.php");
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/admin_lnb.php");

$order_by = (isset($_REQUEST['order_by'])) ? $_REQUEST['order_by'] : "desc";

$query = "SELECT *,DATE_FORMAT(submit_date, '%Y.%m.%d') as submit_date2 FROM SPC_ADMIN where 1 order by submit_date {$order_by}";

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
?>

<script>
var listSize = '<?php echo $listSize?>';
var page = "<?php echo $page?>";
var order_by = "<?php echo $order_by?>";

//최신등록순 , 오래된순
function changeFunc() {
	
	 var selectBox = document.getElementById("selectBox");
	 var selectedValue = selectBox.options[selectBox.selectedIndex].value;
	 location.href = "/aDmin/users/admin_list.php?order_by="+selectedValue;
	 
	}
	
// 페이지 로딩시 
$(document).ready(function(){
	$("#p_"+page).addClass("active");
	var selectBox = document.getElementById("selectBox");
    var selectedValue = selectBox.options[selectBox.selectedIndex].value;
	if(order_by == "asc")
	{
		$( '.selectBox' ).text("오래된 순");
	}
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

// 조회
function goAdmin(idx)
{
	location.href="/aDmin/users/admin_edit.php?idx="+idx;
}


$(document).ready(function(){
    $('body').addClass('admin');
});

//삭제
function goDelete(idx)
{
	if(confirm("해당 게시물을 삭제하시겠습니까?"))
    {
	   // ajax 호출 
	   $.ajax({
   		type: "post",
   		url: "/aDmin/users/admin_delete_proc.php",
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

<div id="container" class="report"> 
    <div class="search">
        <p>관리자 리스트<strong>관리자 계정을 관리합니다.</strong></p>
        <input type="button" class="enroll" value="등록" onclick="location.href='/aDmin/users/admin_add.php'">
		<form id="fncForm" name="fncForm" method="post" action="notice.php">
        	<select id="listSize" name="listSize" class="novis">
        		<option value="10">10개 보기</option>
        		<option value="50">50개 보기</option>
        		<option value="100">100개 보기</option>
        		<option value="300">300개 보기</option>
        		<option value="500">500개 보기</option>
        		<option value="1000">1000개 보기</option>
        	</select>
        	
    </div>
    <div class="search_cont top">
	<?php 
    	$now_point = ($page-1) * $list;
    	$now_page = sql_query($query." limit {$now_point},{$list}");
	?>
	<span class="serch_cont_txt">결과  <?php echo sql_count($now_page);?>개 / 전체 <?php echo sql_count($result_cnt);?>개</span>
    <select id="selectBox" class="serch_cont_sort" onchange="changeFunc();">
        <option value="desc">최신 등록 순</option>
        <option value="asc">오래된 순</option>
    </select>    
    <table class="table_tit table_admin">
        <tr>
            <th>NO.</th>
            <th>관리자명</th>
            <th>아이디</th>
            <th>연락처</th>
            <th>이메일</th>
            <th>등록일</th>
            <th>권한</th>
            <th></th>
            <th></th>
        </tr>
        <table class="tablecont table_admin">
    	<?php
            $s_point = ($page-1) * $list;
            $result = sql_query($query." limit {$s_point},{$list}");
            for ($i=0; $i<sql_count($result); $i++)
            {
                $row = sql_fetch($result);
        ?>
        <tr>
            <td class="num"><?php echo ($n - $i) - (($page-1) * $listSize)?></td>
            <td><?php echo $row['name'];?></td>
            <td><?php echo $row['id'];?></td>
            <td><?php echo $row['tel'];?> / <?php echo $row['corp_tel'];?></td>
            <td><?php echo $row['email'];?></td>
            <td><?php echo $row['submit_date2'];?></td>
            <td><?php echo $row['chmod'];?></td>
            <td><a onclick="goAdmin(<?php echo $row['idx']?>)" class="edit">수정</a></td>
            <td><a class="delete" onclick="goDelete(<?php echo $row['idx']?>)">삭제</a></td>
        </tr>
        <?php 
        }
        ?>
    </table>
    </div>
    </form>
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
</div>
<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/admin_footer.php");
?>