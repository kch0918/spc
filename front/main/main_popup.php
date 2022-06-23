<?php ##### 여기부터 #####
$query = "select * from mu_popup where 1";
$result = sql_query($query);
$popup_cnt = sql_count($result);
?>
<!-- <script src="//code.jquery.com/jquery-1.12.4.js"></script> -->
<link rel="stylesheet" media="all" href="/aDmin/mu_popup/css/output.css">
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="/aDmin/js/function.js"></script>

<?php 
$n = 1;
$tz = 'Asia/Seoul';
$timestamp = time();
$dt = new DateTime("now", new DateTimeZone($tz));
$dt->setTimestamp($timestamp);
$dt_ymd = $dt->format('Ymd');
$dt_ymdhi = $dt->format('YmdHi');
$str = array(" ", "/", ":");
?>
<!-- <div id="main_popup_bg"> -->
<?php 
for($i = 0; $i < $popup_cnt; $i++){
    $row = sql_fetch($result);
    if(strlen($row['show_date']) == 10){
        $dt = $dt_ymd;
    }else{
        $dt = $dt_ymdhi;
    }
    $show_date = str_replace($str, '', $row['show_date']);
    $end_date = str_replace($str, '', $row['end_date']);
    if($dt >= $show_date && $dt <= $end_date && $row['enum_show'] == "O"){
?>
	<div id="main_popup<?php echo $n;?>" class="main_mu_popup main_mu_popup<?php echo $n;?>" style="position:fixed; z-index:999; top:<?php echo $row['loca_top'].$row['loca_top_unit']?>; left:<?php echo $row['loca_left'].$row['loca_left_unit']?>;">
		<div class="mu_popup_img"><?php echo $row['conts'];?></div>
		<div class="mu_popup_bottom">
		<?php 
		if($row['not_today'] == 'Y') {
        ?>		
			<span class="close_mu_popup_day" onclick="pop_todayclose('<?php echo $n;?>')">오늘하루 열지않기</span>
			<span class="close_mu_popup"  onclick="popClose('<?php echo $n;?>')">닫기</span>
		<?php 
		} else {
		?>
			<span class="close_mu_popup_day"></span>
			<span class="close_mu_popup"  onclick="popClose('<?php echo $n;?>')">닫기</span>
		<?php 
		}
		?>
		</div>
	</div>
<?php
        $n++;
    }
}
?>
<input type="hidden" class="pop_cnt" value="<?php echo $n-1?>">
<?php ##### 여기까지 ##### ?>

<script>
console.log(document.cookie);

  $(document).ready(function(){
		var main_popup = $(".main_mu_popup");
// 		console.log("쿠키 : " + getCookie("#main_popup1"));
		for(var i=0; i < main_popup.length; i++){
// 			console.log("dd" + getCookie(main_popup[i].id));
			if(getCookie(main_popup[i].id)){
				main_popup[i].remove();
			}
		}
  	})
 
function pop_todayclose(idx){
	setCookie("main_popup"+idx,'Y', 1);
	$("#main_popup"+idx).hide('fade');
}

function popClose(idx){
	$("#main_popup"+idx).hide('fade');
}
</script>