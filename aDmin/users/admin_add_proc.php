<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");

$name           =  $_REQUEST['name'];
$tel            =  $_REQUEST['tel'];
$corp_tel       =  $_REQUEST['corp_tel'];
$id             =  $_REQUEST['id'];
$email          =  $_REQUEST['email'];
$chmod          =  $_REQUEST['chmod'];
$pw             =  hash("sha256",$_REQUEST['pw']);

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


$query =                                                                                                                                                                                                                                                                                 "
          insert into SPC_ADMIN 
            set 
                name            = '{$name}', 
                tel             = '{$tel}',
                corp_tel        = '{$corp_tel}',
                id              = '{$id}',
                pw              = '{$pw}',
                email           = '{$email}',
                chmod           = '{$chmod}',
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
                submit_date     =  DATE_FORMAT(NOW()+0, '%Y%m%d')
          ";

 sql_query($query);

?>

{
	"isSuc":"success"
}
