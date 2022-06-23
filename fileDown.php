<?php 

$file_name = explode("/",$_GET['file']);
$file_name = $file_name[sizeof($file_name) -1];

$file_dir = ".".$_GET['file'];

header('Content-Type: application/x-octetstream');
header('Content-Length: '.filesize($file_dir));
header('Content-Disposition: attachment; filename='.$file_name);
header('Content-Transfer-Encoding: binary');


$fp = fopen($file_dir, "r");
fpassthru($fp);
fclose($fp);

?>