<?php
require_once("include/init.php");
// require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");
// require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/admin_header.php");
// require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/admin_lnb.php");
require_once("include/header.php");
use mu_pop;

$page = (isset($_REQUEST['page'])) ? sql_str($_REQUEST['page']) : 1;
$listSize = (isset($_REQUEST['listSize'])) ? sql_str($_REQUEST['listSize']) : 10;
$sort_type = (isset($_REQUEST['sort_type'])) ? sql_str($_REQUEST['sort_type']) : "submit_date";
$order_by = (isset($_REQUEST['order_by'])) ? sql_str($_REQUEST['order_by']) : "asc";
$search_name = (isset($_REQUEST['search_name'])) ? sql_str($_REQUEST['search_name']) : "";

$query = "SELECT * FROM mu_popup WHERE 1=1 AND title LIKE '%{$search_name}%' ORDER BY {$sort_type} {$order_by}";
$result_cnt = (int)mu_pop\sql_count(mu_pop\sql_query($query)); //총 개수
$block = 5;
$pageNum = ceil($result_cnt/$listSize); // 총 페이지
$blockNum = ceil($pageNum/$block); // 총 블록
$nowBlock = ceil($page/$block);

$s_page = ($nowBlock * $block) - ($block-1);
if ($s_page <= 1) {
    $s_page = 1;
}

$e_page = $nowBlock*$block;
if ($pageNum <= $e_page) {
    $e_page = $pageNum;
}
$s_point = ($page-1) * $listSize;
$query .= " limit {$s_point}, {$listSize}";
$result = mu_pop\sql_query($query);
?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="//polyfill.io/v3/polyfill.min.js?features=Array.prototype.filter%2CElement.prototype.remove%2CArray.prototype.map%2Cfetch"></script>
<link rel="stylesheet" media="all" href="./css/output.css">
<title>팝업관리 페이지</title>
<div class="contain-wr">
	<div class="btn-list">
		<ul class="btn-liul">
			<li>
			<a href="javascript:popOpen('popup_write.php');">팝업 등록</a>
			</li>
		</ul>
	</div>
	<div class="table-list text-center table-fix list-top">
		<table>
			<thead>
			<tr>
				<td></td>
				<td>제목</td>
				<td>시작일</td>
				<td>종료일</td>
				<td>노출</td>
				<td>세로위치(단위)</td>
				<td>가로위치(단위)</td>
				<td>수정</td>
				<td>삭제</td>
			</tr>
			</thead>
			<tbody>
				<?php for($i = 0; $i < mu_pop\sql_count($result); $i++): $row = mu_pop\sql_fetch($result); ?>
				<tr>
					<td><a class="btn sbtn btn02" href="javascript:popPreview('<?php echo $row['idx']?>');" >미리보기</a></td>
					<td><?php echo $row['title']?></td>
					<td><?php echo $row['show_date']?></td>
					<td><?php echo $row['end_date']?></td>
					<td><?php echo $row['enum_show']?></td>
					<td><?php echo $row['loca_top']."(".$row['loca_top_unit'].")"?></td>
					<td><?php echo $row['loca_left']."(".$row['loca_left_unit'].")"?></td>
					<td><a class="btn sbtn btn02" href="javascript:popOpen('popup_write.php?idx=<?php echo $row['idx']?>');" >수정</a></td>
					<td><a class="btn sbtn btn02" href="javascript:popDel('<?php echo $row['idx']?>');" >삭제</a></td>
				</tr>
				<?php endfor;?>
			</tbody>
		</table>
		<div class="paginate">
			<?php if(5 < $page):?>
				<a class="first" href="javascript:pageMove(1);">&lt;&lt;</a>
				<a class="first" href="javascript:pageMove(<?php echo $s_page-1?>)">&lt;</a>
			<?php endif;?>
			<?php $pagingCnt = 0; ?>
			<ul class="pagination">
			<?php if($e_page != 0): ?>
				<?php for ($p=$s_page; $p<=$e_page; $p++): $pagingCnt ++; ?>
					<li id="p_<?php echo $p?>"><a href="javascript:pageMove(<?php echo $p?>);"><?php echo $p?></a></li>
				<?php endfor;?>
			<?php else: ?>
					<li><a href="javascript:pageMove(1);">1</a></li>
			<?php endif; ?>
			</ul>
			<?php if($pageNum != $page && $pageNum > 5): ?>
				<?php if($pagingCnt > 4):?>
					<a class="last" href="javascript:pageMove(<?php echo $e_page+1?>)"><span>&gt;</span></a>
					<a class="last" href="javascript:pageMove(<?php echo $pageNum?>);">&gt;&gt;</a>
				<?php endif; ?>
			<?php endif; ?>
		</div>
	</div>
</div>
<script>
var listSize = '<?php echo $listSize?>';
var page = '<?php echo $page;?>';

function popOpen(url)
{
    var name = "popup";
    var option = "width = 800, height = 800, top = 10, left = 200, location = no, scrollbars=yes";
    window.open(url, name, option);
}

function pageMove(page)
{
	location.href = "./popup_list.php?page="+page;
}

function popDel(idx){
	if(confirm("정말 삭제하시겠습니까?"))
	{
		var formData = new FormData();
		formData.append("idx", idx);
		formData.append("act", "del");

		fetch("./popup_proc.php",{
			method: "POST",
			body: formData,
		}).then(function(response){
			if(response.ok){ return response.json(); }
			throw new Error("ajax error");
		}).then(function(result){
			alert(result.msg);
			if(result.isSuc == "success"){
				location.reload();
			}
		});
	}
}
function popPreview(idx){
	var formData = new FormData();
	formData.append("idx", idx);

	fetch("./getPreview.php",{
		method: "POST",
		body: formData,
	}).then(function(response){
		if(response.ok){ return response.json(); }
		throw new Error("ajax error");
	}).then(function(result){
		for(var i = 0; i < result.length; i++){
			document.querySelector("body").append(popMake(result[i]));
		}
	});
}

function popMake(obj){
	var inner = "";
	inner += '<div id="mu_pop'+obj.idx+'" class="main_mu_popup" style="top:'+obj.loca_top+obj.loca_top_unit+'; left:'+obj.loca_left+obj.loca_left_unit+';">';
	inner += '	<div class="mu_popup_img">'+obj.conts+'</div>';
	inner += '	<div class="mu_popup_bottom">';
	inner += '		<span class="close_mu_popup_day" onclick="alert(\'미리보기에서는 작동하지 않습니다.\');">오늘하루 열지않기</span>';
	inner += '		<span class="close_mu_popup" onclick="popClose(\''+obj.idx+'\');">닫기</span>';
	inner += '	</div>';
	inner += '</div>';

	return createElementFromHTML(inner);
}
function createElementFromHTML(htmlString) {
	var div = document.createElement('div');
	div.innerHTML = htmlString.trim();

  // Change this to div.childNodes to support multiple top-level nodes
	return div.firstChild; 
}

function popClose(idx){
	const target = document.querySelector("#mu_pop"+idx);
	target.remove();
}
</script>