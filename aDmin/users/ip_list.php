<?php
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/admin_header.php");
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/admin_lnb.php");

$order_by = (isset($_REQUEST['order_by'])) ? $_REQUEST['order_by'] : "desc";

$query = "SELECT *,DATE_FORMAT(submit_date, '%Y.%m.%d') as submit_date2 FROM SPC_IP where 1 order by submit_date {$order_by}";

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
	 location.href = "/aDmin/users/ip_list.php?order_by="+selectedValue;
	 
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
	location.href="/aDmin/users/ip_edit.php?idx="+idx;
}


$(document).ready(function(){
    $('body').addClass('admin');
});

$(document).ready(function() {
$('.enroll').click(function(){
    $('.ip_add').show();
});
$('.modal').click(function() {
    $('.modal').hide();
});

$('.edit').click(function(){
    $('.ip_eidt').show();
});

$('.modal_con').click(function(event) {
    event.preventDefault();
    event.stopPropagation();
});
});

function reg_ip() {

	var reg_ip = $("#ip").val();
    var checkNumber = reg_ip.search(/[0-9]/g);

	if($("#ip").val() == "" ) {
		alert('아이피를 입력해주세요.');
		$("#ip").focus();
	    return;	    
	    	    
	}else if(checkNumber <0){
	    alert("숫자만 사용 가능합니다.");
	    $("#ip").val('');
		$("#ip").focus();
	    return;
	    
	}else if(reg_ip.length > 15){            
	    alert('ip는 .을 제외한 12자리 이하로 사용해야 합니다.');
	    $("#ip").val('');
		$("#ip").focus();
	    return false;
	}
	
	var ip = "";
	ip = $('input[name="ip"]').val();
	
	$.ajax({
		type: "get",
		url: "/aDmin/users/ip_list_proc.php",
		dataType:"text",
		async: false,
		data:{
			reg_ip : ip
		},
		success: function(data)
		{
    		location.reload();
			console.log(data);
			
			var result = JSON.parse(data);
    		if(result.isSuc == "success")
    		{
    			alert("저장되었습니다.");
    			location.href="/aDmin/users/ip_list.php";
    		}
    		else
    		{
    			alert(result.msg);
    		}
		}
	});
};

function edit_ip() {

	var edit_ip = $("#edit_ip").val();
    var checkNumber = edit_ip.search(/[0-9]/g);

	if($("#edit_ip").val() == "" ) {
		alert('아이피를 입력해주세요.');
		$("#edit_ip").focus();
	    return;	    
	    	    
	}else if(checkNumber <0){
	    alert("숫자만 사용 가능합니다.");
	    $("#edit_ip").val('');
		$("#edit_ip").focus();
	    return;
	    
	}else if(edit_ip.length > 15){            
	    alert('ip는 .을 제외한 12자리 이하로 사용해야 합니다.');
	    $("#edit_ip").val('');
		$("#edit_ip").focus();
	    return false;
	}
	
	var edit_ip = "";
	edit_ip = $('input[name="edit_ip"]').val();

	var idx = "";
	idx = $('input[name="idx"]').val();


	console.log("씨발 :" +edit_ip);
	console.log("씨발2 :" + idx);
	
	$.ajax({
		type: "get",
		url: "/aDmin/users/ip_editlist_proc.php",
		dataType:"text",
		async: false,
		data:{
			idx		: idx,
			edit_ip : edit_ip
		},
		success: function(data)
		{
    		location.reload();
			console.log(data);
			
			var result = JSON.parse(data);
    		if(result.isSuc == "success")
    		{
    			alert("수정되었습니다.");
    			location.href="/aDmin/users/ip_list.php";
    		}
    		else
    		{
    			alert(result.msg);
    		}
		}
	});
};

function goEdit(ip,idx) {

	$('input[name="edit_ip"]').val(ip);

	$('input[name="idx"]').val(idx);
}

//삭제
function goDelete(idx)
{
	if(confirm("해당 게시물을 삭제하시겠습니까?"))
    {
	   // ajax 호출 
	   $.ajax({
   		type: "post",
   		url: "/aDmin/users/ip_delete_proc.php",
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
        <p>IP 관리<strong>관리자 계정을 관리합니다.</strong></p>
        <input type="button" class="enroll" value="IP등록">
        <input type="hidden" id="idx" name="idx" value="">
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
    <table class="table_tit admin_ip">
        <tr>
            <th>NO.</th>
            <th>관리자명</th>
            <th>IP</th>
            <th>등록일</th>
            <th></th>
            <th></th>
        </tr>
        <table class="tablecont admin_ip">
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
            <td><?php echo $row['ip'];?></td>
            <td><?php echo $row['submit_date2'];?></td>
            <td><a href="javascript:goEdit('<?php echo $row['ip']?>','<?php echo $row['idx']?>');" class="edit">수정</a></td>
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
</div>

<!-- ip등록모달 -->
<div class="modal ip_add">
    <div class="modal_con">
        <span>IP 등록</span>
   		<div><input type="text" id="ip" name="ip" class="info_area" placeholder="000.000.000.000">
        <button class="modal_close" onclick="reg_ip();">등록</button></div>
    </div>
</div>

<!-- ip수정모달 -->
<div class="modal ip_eidt">
    <div class="modal_con">
        <span>IP 수정</span>
        <div><input type="text" id="edit_ip" name="edit_ip" class="info_area" placeholder="000.000.000.000" value="">
        <button class="modal_close" onclick="edit_ip();">수정</button></div>
    </div>
</div>

<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/admin_footer.php");
?>