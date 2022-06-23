<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/headerPop.php");

$query = "select * from popup where idx = {$_REQUEST['idx']}";
$result = sql_query($query);
$row = sql_fetch($result);

?>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.8.18/themes/base/jquery-ui.css" type="text/css" />
<link rel="stylesheet" href="/admin/css/jquery-ui-timepicker-addon.css" type="text/css">
<script type="text/javascript" src="/aDmin/include/ckeditor/ckeditor.js"></script>
<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.8.18/jquery-ui.min.js"></script>
<script src="https://malsup.github.io/min/jquery.form.min.js"></script>
<!--<script type="text/javascript" src="/js/jquery-ui-timepicker-addon.js"></script>-->
<script type="text/javascript">

function form_submit(act)
{
	CKEDITOR.instances.p_content.updateElement();
	if(act == 'edit'){
		$('#choose').val('edit');
	}
	if(act == 'del'){
		var chk = confirm("삭제하시겠습니까?");
		if(chk){
			$('#choose').val('del');
		}else{
			return;
		}
	}
	$("#popup_form").ajaxSubmit({
		success: function(data)
		{
			//console.log(data);
			var result = JSON.parse(data);
			if(result.isSuc == "success")
			{
				alert(result.msg);
				opener.document.location.reload();
				self.close();
			}
			else
			{
    			alert(result.msg);
			}
		},
	});
}
var enum_val = '<?php echo $row['enum_show']?>';
var loca_top_unit = '<?php echo $row['loca_top_unit'] ?>';
var loca_left_unit = '<?php echo $row['loca_left_unit'] ?>';
$( document ).ready(function() {
	CKEDITOR.replace('p_content' 
			, {height: 500
	});

    $(".datepicker").datepicker({
		dateFormat: 'yy/mm/dd',
		timeInput: true
    });
    /*
    $(".datepicker").datetimepicker({
		dateFormat: 'yy/mm/dd',
		timeInput: true
    });
	*/
	$("input:radio[name='enum_show']:input[value='"+enum_val+"']").attr("checked", true);
	$("input:radio[name='loca_top_unit']:input[value='"+loca_top_unit+"']").attr("checked", true);
	$("input:radio[name='loca_left_unit']:input[value='"+loca_left_unit+"']").attr("checked", true);
});

</script>

<div class="popup-wr">
<h2 class="h2-tit">팝업</h2>


<form id="popup_form" method="post" action="popup_proc.php">
	<input type="hidden" name="idx" value="<?php echo $row['idx']?>">
	<div class="table-list table-list02">
		<table>
			<tr>
				<th>제목</th>
				<td><input type="text" name="title" placeholder="팝업제목" value="<?php echo $row['title']?>"></td>
			</tr>
			<tr>
				<th>시작일</th>
				<td><input type="text" class="datepicker" name="show_date" placeholder="시작일" readonly="readonly" value="<?php echo $row['show_date']?>"></td>
			</tr>
			<tr>
				<th>종료일</th>
				<td><input type="text" class="datepicker" name="end_date" placeholder="종료일" readonly="readonly" value="<?php echo $row['end_date']?>"></td>
			</tr>
			<tr>
				<th>노출</th>
				<td>
					<input type="radio" name="enum_show" value="O">O &nbsp;&nbsp;&nbsp;
					<input type="radio" name="enum_show" value="X">X
				</td>
			</tr>
			<tr>
				<th>세로위치(단위)</th>
				<td>
					<input type="text" name="loca_top" placeholder="세로위치" value="<?php echo $row['loca_top']?>">
					<span>단위</span>&nbsp;&nbsp;&nbsp;
					<input type="radio" name="loca_top_unit" value="px">픽셀(px)&nbsp;&nbsp;&nbsp;
					<input type="radio" name="loca_top_unit" value="%">퍼센트(%)
				</td>
			</tr>
			<tr>
				<th>가로위치(단위)</th>
				<td>
					<input type="text" name="loca_left" placeholder="가로위치" value="<?php echo $row['loca_left']?>">
					<span>단위</span>&nbsp;&nbsp;&nbsp;
					<input type="radio" name="loca_left_unit" value="px">픽셀(px)&nbsp;&nbsp;&nbsp;
					<input type="radio" name="loca_left_unit" value="%">퍼센트(%)
				</td>
			</tr>
			<!-- 
			<tr>
				<th>캐시기간</th>
				<td><input class="wid50" type="text" name="click_day" value="<?php //echo $row['click_day']?>" /> 일동안 보이지 않기</td>
			</tr>
			 -->
			<tr>
				<td colspan="2"><textarea class="form-control" id="p_content" name="p_content"><?php echo $row['conts']?></textarea></td>
			</tr>
		</tr>
	</table>
	</div>
	<div class="btn-wr">
		<input class="btn btn01" type="button" value="수정" onclick="form_submit('edit')">
		<input class="btn btn02" type="button" value="삭제" onclick="form_submit('del')">
		<input type="hidden" id="choose" name="choose">
	</div>
</form>
</div>