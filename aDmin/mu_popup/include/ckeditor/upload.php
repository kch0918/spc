<?php
require_once("../../mu_config.php");
use mu_prop;
$mu_popup_path = mu_prop\mu_popup::$mu_popup_path;

$imageBaseUrl = $mu_popup_path."/mu_popup/include/ckeditor/upload/"; //출력시 절대경로

$uploadfullPath = "./upload/";

$CKEditor = $_GET['CKEditor'] ; 
$funcNum = $_GET['CKEditorFuncNum'] ; 
$langCode = $_GET['langCode'] ; 
$url = '' ; 
$message = ''; 
$imageCheck = array('jpg', 'png', 'gif', 'jpeg', 'bmp');
if (isset($_FILES['upload'])) {
    $imgPath = pathinfo($_FILES['upload']['name']);
    $imgExt = strtolower($imgPath['extension']);
    if(in_array($imgExt, $imageCheck)){
        $name = $_FILES['upload']['name'];
        $uploadName = explode('.', $name);
        $uploadname = time().'.'.$uploadName[1];
        move_uploaded_file($_FILES["upload"]["tmp_name"], $uploadfullPath . $uploadname); 
        $url = $imageBaseUrl . $uploadname ; 
    }else{
        $message = '이미지 파일이 아닙니다.';
    }
} 
else 
{ 
    $message = '업로드된 파일이 없습니다.'; 
}
echo "<script type='text/javascript'>; window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message')</script>"; 
?>

