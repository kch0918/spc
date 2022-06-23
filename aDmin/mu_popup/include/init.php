<?php
namespace mu_pop;

// error_reporting(E_ALL);
// ini_set('display_errors', '1');

require_once("mu_config.php");
use mu_prop\mu_popup as prop;

$link = mysqli_connect(
	prop::$db_host,
	prop::$db_user,
	prop::$db_pswd,
	prop::$db_name
);

function sql_query($query, $debug = false) {
    global $link;
    $res = mysqli_query($link, $query); //쿼리문 실행
    if(!$res && $debug){
        echo "<br>SQL_DEBUG<br>"."(".mysqli_errno($link).") ".mysqli_error($link)."<br>";
        exit;
    }
    return $res;
}

function sql_fetch($result, $option = null) {
    if($option == "assoc"){
        return mysqli_fetch_assoc($result); 
    }else if($option == "row"){
        return mysqli_fetch_row($result);
    }else{
        return mysqli_fetch_array($result); 
    }
}

function sql_count($result) {
    return mysqli_num_rows($result); //쿼리문의 결과값 갯수
}

function sql_str($str){ //문자열 이스케이프
    global $link;
    return mysqli_real_escape_string($link, $str);
}

function sql_editor($text){ //에디터 사용한 문자열 이스케이프
    global $link;
    $txt = mysqli_real_escape_string($link, $text);
    return str_ireplace(array("\r", "\n", '\r', '\n'), '', $text);
}

function sql_json($result, $obj = null) {   //json 텍스트로 뿌려줌
    $emparray = array();
    while($row = mysqli_fetch_assoc($result)){
        $emparray[] = $row;
    }
    if($obj != null){
        foreach($obj as $key=>$value){
            $emparray[$key] = $value;
        }
    }

    echo json_encode($emparray);
}

