<?php
require_once("./include/init.php");
require_once("./include/inc_ckeditor.php");
require_once("./include/header_pop.php");
use mu_pop;

$idx = (isset($_REQUEST['idx'])) ? mu_pop\sql_str($_REQUEST['idx']) : "";
if($idx != ""){
	$query = "SELECT * FROM mu_popup WHERE idx = '{$idx}'";
	$result = mu_pop\sql_query($query);
	$row = mu_pop\sql_fetch($result, "assoc");
}else{
	$row = array(
		"idx" => "", "title" => "", "show_date" => "", "end_date" => "", "conts" => "",
		"enum_show" => "X", "not_today" => "Y", "loca_top" => "", "loca_top_unit" => "px", "loca_left" => "", "loca_left_unit" => "px"
	);
}
?>
<link rel="stylesheet" media="all" href="./css/mu_popup.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.8.18/themes/base/jquery-ui.css" type="text/css" />
<link rel="stylesheet" href="./css/jquery-ui-timepicker-addon.css" type="text/css">
<!-- <script src="//code.jquery.com/jquery-1.11.3.min.js"></script> -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="//code.jquery.com/ui/1.8.18/jquery-ui.min.js"></script>
<script src="//malsup.github.io/min/jquery.form.min.js"></script>
<script type="text/javascript" src="./js/jquery-ui-timepicker-addon.js"></script>

<div class="popup-wr">
<h2 class="h2-tit">팝업 <?php echo ($idx != "") ? "수정" : "등록";?></h2>

<form id="popup_form" method="post" action="popup_proc.php">
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
				<label><input type="radio" name="enum_show" value="O">O</label>
				&nbsp;&nbsp;&nbsp;
				<label><input type="radio" name="enum_show" value="X">X</label>
			</td>
		</tr>
		<tr>
			<th>'오늘 하루 열지 않기' 기능을 사용함</th>
			<td>
				<label><input type="radio" name="not_today" value="Y">O</label>
				&nbsp;&nbsp;&nbsp;
				<label><input type="radio" name="not_today" value="N">X</label>
			</td>
		</tr>
		<tr>
			<th>세로위치(단위)</th>
			<td>
				<input type="text" name="loca_top" placeholder="세로위치" value="<?php echo $row['loca_top']?>">
				<!-- <span>단위</span> -->
				&nbsp;&nbsp;&nbsp;
				<label><input type="radio" name="loca_top_unit" value="px">픽셀(px)</label>
				&nbsp;&nbsp;&nbsp;
				<label><input type="radio" name="loca_top_unit" value="%">퍼센트(%)</label>
			</td>
		</tr>
		<tr>
			<th>가로위치(단위)</th>
			<td>
				<input type="text" name="loca_left" placeholder="가로위치" value="<?php echo $row['loca_left']?>">
				<!-- <span>단위</span> -->
				&nbsp;&nbsp;&nbsp;
				<label><input type="radio" name="loca_left_unit" value="px">픽셀(px)</label>
				&nbsp;&nbsp;&nbsp;
				<label><input type="radio" name="loca_left_unit" value="%">퍼센트(%)</label>
			</td>
		</tr>
		<!-- <tr>
			<th>캐시기간</th>
			<td><input class="wid50" type="text" name="click_day" value="<?php //echo $row['click_day']?>" /> 일동안 보이지 않기</td>
		</tr> -->
		<tr>
			<td colspan="2"><textarea class="form-control" id="p_content" name="p_content"><?php echo $row['conts']?></textarea></td>
		</tr>
	</table>
	</div>
	<div class="btn-wr">
		<?php if($idx != ""):?>
		<input class="btn btn01" type="button" value="수정" onclick="form_submit('edit')">
		<?php else: ?>
		<input class="btn btn01" type="button" value="등록" onclick="form_submit('ins')">
		<?php endif;?>
	</div>
</div>
</form>
<script>
var idx = '<?php echo $idx ?>';
var enum_show = '<?php echo $row['enum_show']?>';
var not_today = '<?php echo $row['not_today']?>';
var loca_top_unit = '<?php echo $row['loca_top_unit']?>';
var loca_left_unit = '<?php echo $row['loca_left_unit']?>';

$( document ).ready(function() {
	CKEDITOR.replace('p_content', {
		height: 500
	});
    $(".datepicker").datetimepicker({
		dateFormat: 'yy/mm/dd',
		timeInput: true
    });
	document.querySelector("input[name='enum_show'][value='"+enum_show+"']").checked = true;
	document.querySelector("input[name='not_today'][value='"+not_today+"']").checked = true;
	document.querySelector("input[name='loca_top_unit'][value='"+loca_top_unit+"']").checked = true;
	document.querySelector("input[name='loca_left_unit'][value='"+loca_left_unit+"']").checked = true;
});

function form_submit(act)
{
	CKEDITOR.instances.p_content.updateElement();
	$("#popup_form").ajaxSubmit({
		data: {
			idx: idx,
			act: act
		},
		success: function(data)
		{
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
</script>
