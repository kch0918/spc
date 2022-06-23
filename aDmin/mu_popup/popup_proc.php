<?php
require_once("./include/init.php");
use mu_pop;

$act = (isset($_REQUEST['act'])) ? mu_pop\sql_str($_REQUEST['act']) : "";

$idx = (isset($_REQUEST['idx'])) ? mu_pop\sql_str($_REQUEST['idx']) : "";
$title = (isset($_REQUEST['title'])) ? mu_pop\sql_str($_REQUEST['title']) : "";
$show_date = (isset($_REQUEST['show_date'])) ? mu_pop\sql_str($_REQUEST['show_date']) : "";
$end_date = (isset($_REQUEST['end_date'])) ? mu_pop\sql_str($_REQUEST['end_date']) : "";
$enum_show = (isset($_REQUEST['enum_show'])) ? mu_pop\sql_str($_REQUEST['enum_show']) : "X";
$not_today = (isset($_REQUEST['not_today'])) ? mu_pop\sql_str($_REQUEST['not_today']) : "Y";
$loca_top = (isset($_REQUEST['loca_top'])) ? mu_pop\sql_str($_REQUEST['loca_top']) : "";
$loca_top_unit = (isset($_REQUEST['loca_top_unit'])) ? mu_pop\sql_str($_REQUEST['loca_top_unit']) : "";
$loca_left = (isset($_REQUEST['loca_left'])) ? mu_pop\sql_str($_REQUEST['loca_left']) : "";
$loca_left_unit = (isset($_REQUEST['loca_left_unit'])) ? mu_pop\sql_str($_REQUEST['loca_left_unit']) : "";
$conts = (isset($_REQUEST['p_content'])) ? $_REQUEST['p_content'] : "";

if($act == "ins"){
	$query = "
		INSERT INTO mu_popup
		(
			title, show_date, end_date, conts, enum_show,not_today,
			loca_top, loca_top_unit, loca_left, loca_left_unit, submit_date
		)
		values
		(
			'{$title}', '{$show_date}', '{$end_date}', '{$conts}', '{$enum_show}','{$not_today}',
			'{$loca_top}', '{$loca_top_unit}', '{$loca_left}', '{$loca_left_unit}', now()+0
		)
	";
}elseif($act == "edit"){
	$query = "
		UPDATE mu_popup SET
		title = '{$title}', 
		show_date = '{$show_date}', 
		end_date = '{$end_date}', 
		enum_show = '{$enum_show}',
        not_today = '{$not_today}', 
		conts = '{$conts}',
		loca_top = '{$loca_top}',
		loca_top_unit = '{$loca_top_unit}', 
		loca_left = '{$loca_left}', 
		loca_left_unit = '{$loca_left_unit}'
		WHERE idx = '{$idx}'
	";
}elseif($act == "del"){
	$query = "
		DELETE FROM mu_popup
		WHERE idx = '{$idx}'
	";
}else{
	exit;
}

$res_msg = array("issuc" => "", "msg" => "");
$res = mu_pop\sql_query($query);
if($res){
	$res_msg['isSuc'] = "success";
	$res_msg['msg'] = "저장되었습니다.";
}else{
	$res_msg['isSuc'] = "fail";
	$res_msg['msg'] = "오류가 발생하였습니다.";
}
echo json_encode($res_msg);
?>