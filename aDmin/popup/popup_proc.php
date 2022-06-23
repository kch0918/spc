<?php
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");


header('Content-Type: text/html; charset=utf-8');
?>
<?php 

    $title = htmlspecialchars(addslashes($_POST['title']));
    $show_date = htmlspecialchars(addslashes($_POST['show_date']));
    $end_date = htmlspecialchars(addslashes($_POST['end_date']));
    $enum_show = htmlspecialchars(addslashes($_POST['enum_show']));
    $loca_top = htmlspecialchars(addslashes($_POST['loca_top']));
    $loca_top_unit = htmlspecialchars(addslashes($_POST['loca_top_unit']));
    $loca_left = htmlspecialchars(addslashes($_POST['loca_left']));
    $loca_left_unit = htmlspecialchars(addslashes($_POST['loca_left_unit']));
    $conts = $_POST['p_content'];
        
    if ($_POST['choose']=="edit") {
        $query = "update popup
        set
        title = '{$title}',
        show_date = '{$show_date}',
        end_date = '{$end_date}',
        conts = '{$conts}',
        enum_show = '{$enum_show}',
        loca_top = '{$loca_top}',
        loca_top_unit = '{$loca_top_unit}',
        loca_left = '{$loca_left}',
        loca_left_unit = '{$loca_left_unit}'
        where idx = {$_POST['idx']}
        ";
    sql_query($query);
    }else if($_POST['choose']=="del"){
        $query = "delete from popup where idx='{$_POST['idx']}'";
        sql_query($query);
    }
    else{
    $query = "insert into popup
    set
    title = '{$title}',
    show_date = '{$show_date}',
    end_date = '{$end_date}',
    conts = '{$conts}',
    enum_show = '{$enum_show}',
    loca_top = '{$loca_top}',
    loca_top_unit = '{$loca_top_unit}',
    loca_left = '{$loca_left}',
    loca_left_unit = '{$loca_left_unit}',
    submit_date = now()+0
    ";
    sql_query($query);
    }
    
    ?>
    {
    	"isSuc":"success",
    	"msg":"처리되었습니다."
    }
    <?php




