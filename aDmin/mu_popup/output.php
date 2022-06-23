<?php
include_once('include/init.php');
use mu_prop\mu_popup as prop;

$path = prop::$mu_popup_path;

$query = "SELECT 
		idx, 
		conts, 
		click_day, 
		concat(loca_top, loca_top_unit)as loca_top, 
		concat(loca_left, loca_left_unit)as loca_left 
	FROM mu_popup WHERE 1=1
	AND enum_show = 'O' 
	AND show_date <= DATE_FORMAT(NOW(), '%Y/%m/%d %H:%i') 
	AND end_date > DATE_FORMAT(NOW(), '%Y/%m/%d %H:%i')
";
$result = mu_pop\sql_query($query, true);
?>

<script src="https://polyfill.io/v3/polyfill.min.js?features=Array.prototype.filter%2CElement.prototype.remove%2CArray.prototype.map%2Cfetch"></script>
<script src="<?php echo $path?>/mu_popup/js/mu_cookie.js"></script>
<link rel="stylesheet" media="all" href="<?php echo $path?>/mu_popup/css/output.css">
<?php for($i = 0; $i < mu_pop\sql_count($result); $i++): $row = mu_pop\sql_fetch($result);?>
	<!-- HTML -->
	<div id="mu_pop<?php echo $row['idx']?>" class="main_mu_popup" style="top:<?php echo $row['loca_top']?>; left:<?php echo $row['loca_left']?>;">
		<div class="mu_popup_img"><?php echo $row['conts']?></div>
		<div class="mu_popup_bottom">
			<span class="close_mu_popup_day" onclick="popCloseDay('mu_pop', '<?php echo $row['idx']?>', '<?php echo $row['click_day']?>');">오늘하루 열지않기</span>
			<span class="close_mu_popup" onclick="popClose('<?php echo $row['idx']?>');">닫기</span>
		</div>
	</div>
	<!-- HTML END -->
<?php endfor; ?>

<script>
document.addEventListener('DOMContentLoaded', function(){
	const cont = document.querySelectorAll("div[id*='mu_pop']");
	for(let i = 0; i < cont.length; i++){
		if(getCookie(cont[i].id)){
			cont[i].remove();
		}
	}
});
const popCloseDay = function(name, idx, day){
	setCookie(name, idx, day);
	popClose(idx);
}
const popClose = function(idx){
	const target = document.querySelector("#mu_pop"+idx);
	target.remove();
}
</script>