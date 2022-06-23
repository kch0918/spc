<?php
require_once("./include/init.php");
use mu_pop;
if(!mu_pop\sql_query("select count(*) from mu_popup where 1")){
	mu_pop\sql_query(
		"CREATE TABLE `mu_popup` (
			`idx` INT(255) NOT NULL AUTO_INCREMENT,
			`title` VARCHAR(255) NULL DEFAULT NULL COMMENT '팝업 제목' COLLATE 'utf8_general_ci',
			`show_date` VARCHAR(255) NULL DEFAULT NULL COMMENT '팝업 스타트' COLLATE 'utf8_general_ci',
			`end_date` VARCHAR(255) NULL DEFAULT NULL COMMENT '팝업 엔드' COLLATE 'utf8_general_ci',
			`conts` TEXT NULL DEFAULT NULL COMMENT '내용(이미지)' COLLATE 'utf8_general_ci',
			`enum_show` ENUM('O','X') NULL DEFAULT 'X' COMMENT '활성여부' COLLATE 'utf8_general_ci',
			`loca_top` VARCHAR(255) NULL DEFAULT '0' COMMENT '세로위치' COLLATE 'utf8_general_ci',
			`loca_top_unit` VARCHAR(255) NULL DEFAULT 'px' COMMENT '세로단위' COLLATE 'utf8_general_ci',
			`loca_left` VARCHAR(255) NULL DEFAULT '0' COMMENT '가로위치' COLLATE 'utf8_general_ci',
			`loca_left_unit` VARCHAR(255) NULL DEFAULT 'px' COMMENT '가로단위' COLLATE 'utf8_general_ci',
			`click_day` VARCHAR(255) NULL DEFAULT '1' COMMENT '클릭시 안보이는 기간' COLLATE 'utf8_general_ci',
			`submit_date` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
			PRIMARY KEY (`idx`) USING BTREE
		)"
	);
}
?>
<script>
location.replace("./popup_list.php");
</script>