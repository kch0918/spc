<?php
require_once("./include/init.php");
use mu_pop;
$idx = (isset($_REQUEST['idx'])) ? $_REQUEST['idx'] : "";
$query = "select * from mu_popup where idx = '{$idx}'";
if($idx == ""){
	$query = "select * from mu_popup";
}
$result = mu_pop\sql_query($query);
mu_pop\sql_json($result);
?>