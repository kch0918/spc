<?php
function sql_query($query) {
    $link = mysqli_connect('localhost','root','spcmusign1!@','spc');
    return mysqli_query($link, $query);
}

function sql_fetch($result) {
    return mysqli_fetch_array($result);
}

function sql_count($result) {
    return mysqli_num_rows($result);
}

function sql_str($str){ //문자열 이스케이프
    global $link;
    return mysqli_real_escape_string($link, $str);
}

function sql_json($result, $obj = null) {   //json 텍스트로 뿌려줌
    /*
     * obj: 따로 추가할 데이터배열
     * $obj = array();
     * $obj['page'] = 1;
     * $obj['listSize'] = 20;
     */
    $emparray = array();
    while($row = mysqli_fetch_assoc($result)){
        $emparray[] = $row;
    }
    if($obj != null){
        foreach($obj as $key=>$value){
            $emparray[$key] = $value;
        }
    }
    /*
     *  res = {
     *      0: [
     *        0: {row: value},
     *        1: {row2: value2}
     *      ],
     *      key: value,
     *      key2: value
     *  }
     *
     */
    echo json_encode($emparray);
}
