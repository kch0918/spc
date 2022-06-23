<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/header.php");

$query="select * from popup where 1 order by idx asc";

$result = sql_query($query);
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
?>
<title>팝업관리 페이지</title> 
<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="https://malsup.github.io/min/jquery.form.min.js"></script>
<script>
var listSize = '<?php echo $listSize?>';
var page = "<?php echo $page;?>";

$(document).ready(function(){
	if(listSize != "")
	{
		$("#listSize").val(listSize);
	}
});

function popOpen(url)
{
    var name = "popup";
    var option = "width = 800, height = 800, top = 10, left = 200, location = no, scrollbars=yes";
    window.open(url, name, option);
}

function pageMove(page)
{
	$("#page").val(page);
	$("#productForm").submit();
}
</script>
<div class="contain-wr">
	<div class="btn-list">
		<ul class="btn-liul">
			<li>
			<a href="javascript:popOpen('popup.php');">팝업 등록</a>
			</li>
		</ul>
	</div>
	<div class="table-list text-center table-fix list-top">
		<table>
			<thead>
			<tr>
				<td>이미지</td>
				<td>제목</td>
				<td>시작일</td>
				<td>종료일</td>
				<td>노출</td>
				<td>세로위치(단위)</td>
				<td>가로위치(단위)</td>
				<td>수정</td>
			</tr>
			</thead>
			<tbody>
				<?php
				for($i = 0; $i < sql_count($result); $i++)
				{
					$row = sql_fetch($result);
				?>
				<tr>
					<td class="popimg-wr"><?php echo $row['conts']?><!-- <p><img src=... style=..... /></p> --></td>
					<td><?php echo $row['title']?></td>
					<td><?php echo $row['show_date']?></td>
					<td><?php echo $row['end_date']?></td>
					<td><?php echo $row['enum_show']?></td>
					<td><?php echo $row['loca_top']."(".$row['loca_top_unit'].")"?></td>
					<td><?php echo $row['loca_left']."(".$row['loca_left_unit'].")"?></td>
					<td><a class="btn sbtn btn02" href="javascript:popOpen('popup_edit.php?idx=<?php echo $row['idx']?>');" >수정</a></td>
				</tr>
				<?php 
				}
				?>
			</tbody>
		</table>
	</div>
	<form id="list_delForm" name="list_delForm" method="post" action="./popup_proc.php" enctype="multipart/form-data">
		<input type="hidden" id="choose" name="choose" value="del">
	</form>
</div>