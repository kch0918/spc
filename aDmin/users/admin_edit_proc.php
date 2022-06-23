<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");
    
$idx            =  $_REQUEST['idx'];
$name           =  $_REQUEST['name'];
$tel            =  $_REQUEST['tel'];
$id             =  $_REQUEST['id'];
$email          =  $_REQUEST['email'];
$pw             =  hash("sha256",$_REQUEST['pw']);
$chmod          =  $_REQUEST['chmod'];

$media_yn       =  $_REQUEST['media_yn'];
$news_yn        =  $_REQUEST['news_yn'];
$magazine_yn    =  $_REQUEST['magazine_yn'];
$sns_yn         =  $_REQUEST['sns_yn'];
$cf_yn          =  $_REQUEST['cf_yn'];

$csr_yn         =  $_REQUEST['csr_yn'];
$notice_yn      =  $_REQUEST['notice_yn'];
$financial_yn   =  $_REQUEST['financial_yn'];
$newsletter_yn  =  $_REQUEST['newsletter_yn'];
$review_yn      =  $_REQUEST['review_yn'];
$social_yn      =  $_REQUEST['social_yn'];

$nagation_yn    =  $_REQUEST['nagation_yn'];

$type_yn        =  $_REQUEST['type_yn'];
$cate_yn        =  $_REQUEST['cate_yn'];
$brand_yn       =  $_REQUEST['brand_yn'];
$sub_yn         =  $_REQUEST['sub_yn'];

$manage_yn      =  $_REQUEST['manage_yn'];
$adlist_yn      =  $_REQUEST['adlist_yn'];
$iplist_yn      =  $_REQUEST['iplist_yn'];

$popup_yn       = $_REQUEST['popup_yn'];
$poplist_yn       = $_REQUEST['poplist_yn'];


if($_SESSION['chmod'] == "마스터") {
    
    $query =                                                                                                                                                                                                                                                                                 "
          update SPC_ADMIN
            set
                name            = '{$name}',
                tel             = '{$tel}',
                id              = '{$id}',
                email           = '{$email}',
                media_yn        = '{$media_yn}',
                news_yn         = '{$news_yn}',
                magazine_yn     = '{$magazine_yn}',
                sns_yn          = '{$sns_yn}', 
                cf_yn           = '{$cf_yn}',
                csr_yn          = '{$csr_yn}',
                notice_yn       = '{$notice_yn}',
                financial_yn    = '{$financial_yn}',
                newsletter_yn   = '{$newsletter_yn}',
                review_yn       = '{$review_yn}',
                social_yn       = '{$social_yn}',
                nagation_yn     = '{$nagation_yn}',
                type_yn         = '{$type_yn }',
                cate_yn         = '{$cate_yn}',
                brand_yn        = '{$brand_yn}',
                sub_yn          = '{$sub_yn}',
                manage_yn       = '{$manage_yn}',
                adlist_yn       = '{$adlist_yn}',
                iplist_yn       = '{$iplist_yn}',
                popup_yn        = '{$popup_yn }',
                poplist_yn      = '{$poplist_yn}'
            where idx = '$idx'
          ";
    
    sql_query($query);
    
} else {

$query =                                                                                                                                                                                                                                                                                 "
          update SPC_ADMIN 
            set 
                name            = '{$name}', 
                tel             = '{$tel}',
                id              = '{$id}',
                email           = '{$email}',
                pw              = '{$pw}', 
                chmod           = '{$chmod}',
                media_yn        = '{$media_yn}', 
                news_yn         = '{$news_yn}',
                magazine_yn     = '{$magazine_yn}',
                csr_yn          = '{$csr_yn}',
                notice_yn       = '{$notice_yn}',
                newsletter_yn   = '{$newsletter_yn}',
                review_yn       = '{$review_yn}',
                nagation_yn     = '{$nagation_yn}',
                type_yn         = '{$type_yn }',
                cate_yn         = '{$cate_yn}',
                brand_yn        = '{$brand_yn}',
                sub_yn          = '{$sub_yn}',
                manage_yn       = '{$manage_yn}', 
                adlist_yn       = '{$adlist_yn}',
                iplist_yn       = '{$iplist_yn}',
                popup_yn        = '{$popup_yn }',
                poplist_yn      = '{$poplist_yn}',
                submit_date     =  DATE_FORMAT(NOW()+0, '%Y%m%d')
            where idx = '$idx'
          ";

 sql_query($query);
}
 
?>

{
	"isSuc":"success"
}
