<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function send_mail($email, $re_name)
{
    // $send_email 보낼 이메일
    // $user_id 아이디
    require_once ($_SERVER['DOCUMENT_ROOT'] . "/aDmin/include/PHPMailer-master/src/PHPMailer.php");
    require_once ($_SERVER['DOCUMENT_ROOT'] . "/aDmin/include/PHPMailer-master/src/SMTP.php");
    require_once ($_SERVER['DOCUMENT_ROOT'] . "/aDmin/include/PHPMailer-master/src/Exception.php");
    require_once ($_SERVER['DOCUMENT_ROOT'] . "/aDmin/include/init.php");

    $query = "select * ,DATE_FORMAT(submit_date, '%Y-%m-%d') as submit_date2 from SPC_NAGATION where email='$email' order by submit_date desc";
    $result = sql_query($query);
    $row = sql_fetch($result);

    $date = $row['submit_date2'];
    $user_id = $row['id'];
    $user_tel = $row['tel'];
    $user_yn = $row['tel_yn'];
    $user_file = $row['file'];
    
    if ($user_yn == "Y") {
        $user_yn = "가능";
    } else {
        $user_yn = "불가능";
    }

    $user_title = $row['title'];
    $user_contents = $row['contents'];
    $user_add = $row['add_answer'];

    $fromEmail = "spchotline@naver.com";
    $fromName = "SPC";
    $toName = "";
    $subject = "Hot-Line 제보가 등록되었습니다";
    $toEmail = "$email";

    $message = "<div id='e-page' style='width:850px; margin: 0 auto; padding:49px 55px 74px; background: url(https://spc.co.kr/img/edm/email-bg.png) no-repeat center center; border-radius: 50px 50px 0 0;'>
	           <div class='e-page-wrap' style='background:#fff; border-radius: 50px; padding-bottom:66px;'>";

    $message .= "<div class='e-main-top'>
                			<div class='e-main-img' style='margin:0 auto; width:241px; padding: 80px 0 45px 0;'>
                				<img src='https://spc.co.kr/img/edm/email-logo.png' alt='spc로고' style='width:100%;'>
                			</div>
                			<div class='e-main-txt' style='text-align: center;'>
                				<h2 style='font-size:36px; margin-bottom: 20px;'>Hot-Line 제보가 등록되었습니다</h2>
                				<p style='font-size:18px; color:#7d7d7d; font-weight:600;'>저희 SPC는 법과 윤리를 준수하는 정도경영을 통해 기업의 사회적 책임을 다하며,<br> 식품문화를 선도하는 Great Food Company이 되겠습니다.</p>
                			</div>
                			<div class='round-text' style='text-align: center; margin-top: 30px;'>
                				<span style='width: 382px; height: 65px; line-height:65px; border-radius: 32.5px; background-color: #23afe3; font-size:20px; color:#fff; margin: 0 auto; text-align: center; font-weight:700; display:block;'>Hot-Line 접수가 등록되었습니다</span>
                			</div>
                		</div";

    $message .= "<div class='e-main-bot' >
            			<div class='e-main-txt'>
            				<table style='border-top:1px solid #000; margin:20px auto 0; border-spacing: 0; width:90%;'>
            					<caption style=' font-size:18px; color:#000; margin-bottom:20px; font-weight:800;'>제보내용</caption>
            					<colgroup>
            						<col class='th-w' style='width:21%;'>
            						<col class='td-w' style='width:29%;'>
            						<col class='th-w' style='width:21%;'>
            						<col class='td-w' style='width:29%;'>
            					</colgroup>";

    $message .= "<tr style='border-bottom:1px solid #eaeaea;'>
    						<th style='background:#f8f8f8; color:#afafaf; font-size:16px; padding: 23px 0 23px 0; border-bottom:1px solid #eaeaea; border-right:1px solid #eaeaea; letter-spacing: -0.05em; font-weight:800;'>접수일자</th>
    						<td style='color:#7d7d7d; font-size:16px; padding: 20px 0 20px 30px; text-align: left; border-bottom:1px solid #eaeaea; letter-spacing: -0.05em; font-weight: 600;'>{$date}</td>
    						<th class='bor-left' style='border-left:1px solid #eaeaea; background:#f8f8f8; color:#afafaf; font-size:16px; padding: 23px 0 23px 0; border-bottom:1px solid #eaeaea; border-right:1px solid #eaeaea; letter-spacing: -0.05em;; font-weight:800;'>접수아이디</th>
    						<td style='color:#7d7d7d; font-size:16px; padding: 20px 0 20px 30px; text-align: left; border-bottom:1px solid #eaeaea; letter-spacing: -0.05em; font-weight: 600;'>{$user_id}</td>
    			     </tr>";

    $message .= "<tr style='border-bottom:1px solid #eaeaea;'>
    						<th style='background:#f8f8f8; color:#afafaf; font-size:16px; padding: 23px 0 23px 0; border-bottom:1px solid #eaeaea; border-right:1px solid #eaeaea; letter-spacing: -0.05em; font-weight:800;'>제보자</th>
    						<td style='color:#7d7d7d; font-size:16px; padding: 20px 0 20px 30px; text-align: left; border-bottom:1px solid #eaeaea; letter-spacing: -0.05em; font-weight: 600;'>$re_name</td>
    						<th class='bor-left' style='border-left:1px solid #eaeaea; background:#f8f8f8; color:#afafaf; font-size:16px; padding: 23px 0 23px 0; border-bottom:1px solid #eaeaea; border-right:1px solid #eaeaea; letter-spacing: -0.05em; font-weight:800;'>상태</th>
    						<td style='color:#7d7d7d; font-size:16px; padding: 20px 0 20px 30px; text-align: left; border-bottom:1px solid #eaeaea; letter-spacing: -0.05em; font-weight: 600;'>접수</td>
    				</tr>";

    $message .= "<tr style='border-bottom:1px solid #eaeaea;'>
						<th style='background:#f8f8f8; color:#afafaf; font-size:16px; padding: 23px 0 23px 0; border-bottom:1px solid #eaeaea; border-right:1px solid #eaeaea; letter-spacing: -0.05em; font-weight:800;'>이메일</th>
						<td style='color:#7d7d7d; font-size:16px; padding: 20px 0 20px 30px; text-align: left; border-bottom:1px solid #eaeaea; letter-spacing: -0.05em; font-weight: 600;'>$email</td>
						<th class='bor-left' style='border-left:1px solid #eaeaea; background:#f8f8f8; color:#afafaf; font-size:16px; padding: 23px 0 23px 0; border-bottom:1px solid #eaeaea; border-right:1px solid #eaeaea; letter-spacing: -0.05em; font-weight:800;'>전화번호</th>
						<td style='color:#7d7d7d; font-size:16px; padding: 20px 0 20px 30px; text-align: left; border-bottom:1px solid #eaeaea; letter-spacing: -0.05em; font-weight: 600;'>{$user_tel}</td>
					</tr>";

    $message .= "<tr style='border-bottom:1px solid #eaeaea;'>
						<th style='background:#f8f8f8; color:#afafaf; font-size:16px; padding: 23px 0 23px 0; border-bottom:1px solid #eaeaea; border-right:1px solid #eaeaea; letter-spacing: -0.05em; font-weight:800;'>유선상담가능 여부</th>
						<td colspan='3' style='color:#7d7d7d; font-size:16px; padding: 20px 0 20px 30px; text-align: left; border-bottom:1px solid #eaeaea; letter-spacing: -0.05em; font-weight: 600;'>{$user_yn}</td>
					</tr>";

    $message .= "<tr style='border-bottom:1px solid #eaeaea;'>
						<th  style='background:#f8f8f8; color:#afafaf; font-size:16px; padding: 23px 0 23px 0; border-bottom:1px solid #eaeaea; border-right:1px solid #eaeaea; letter-spacing: -0.05em; font-weight:800;'>제목</th>
						<td colspan='3' style='color:#7d7d7d; font-size:16px; padding: 20px 0 20px 30px; text-align: left; border-bottom:1px solid #eaeaea; letter-spacing: -0.05em; font-weight: 600;'>{$user_title}</td>
					</tr>";

    $message .= "<tr style='border-bottom:1px solid #eaeaea;'>
						<th class='top-th' style='background:#f8f8f8; color:#afafaf; font-size:16px; padding: 23px 0 23px 0; border-bottom:1px solid #eaeaea; border-right:1px solid #eaeaea; letter-spacing: -0.05em; font-weight:800;'>내용</th>
						<td colspan='3' style='color:#7d7d7d; font-size:16px; padding: 20px 0 20px 30px; text-align: left; border-bottom:1px solid #eaeaea; letter-spacing: -0.05em; font-weight: 600;'>
                        {$user_contents} 
						</td>
					</tr>";

    $message .= "<tr style='border-bottom:1px solid #eaeaea;'>
						<th class='top-th' style='background:#f8f8f8; color:#afafaf; font-size:16px; padding: 23px 0 23px 0; border-bottom:1px solid #eaeaea; border-right:1px solid #eaeaea; letter-spacing: -0.05em; font-weight:800;'>제보관련 추가질문</th>
						<td colspan='3' style='color:#7d7d7d; font-size:16px; padding: 20px 0 20px 30px; text-align: left; border-bottom:1px solid #eaeaea; letter-spacing: -0.05em; font-weight: 600;'>
						{$user_add}
						</td>
					</tr>";
		
	    $message .= "  
    				</table>
    			</div>
    			<div class='btn-wrap' style='text-align: center; margin-top: 55px;'>
    				<a href='https://spc.co.kr/csr/right-mng/tip-off-login/' class='e-btn2' style='width: 280px; height: 65px; margin: 40px 0 0 51px; padding: 24px 70px; border-radius: 32.5px; border:1px solid #eaeaea; background-color: #ffffff; font-size:18px; color:#000; margin-bottom:42px; font-weight: 600; text-decoration:none;'>제보 확인하러 가기</a>
    			</div>
    		</div>
    	</div>
      </div>";

    $message .= "<div class='f-wrap' style='width:850px; margin: 0 auto; border-radius: 0 0 50px 50px; border: solid 1px #eaeaea; padding:20px 55px 50px;'>
        		 <footer class='e-page-footer' style='background:#fff; border-radius: 0 0 50px 50px; margin: 0 auto;  background:#fff;'>
        			<div class='e-footer-top' style='margin-bottom:35px;'>
        				<ul style='overflow:hidden; margin-bottom:0; list-style:none; padding-left:0px;'>
        					<li style='display:inline-block; position:relative; margin-right:20px; margin-left: 0 !important; padding-right:25px; border-right:1px solid #afafaf'><a href='https://spc.co.kr/privacy-policy/' target='_blank' style='font-weight:600; text-decoration:none;'>개인정보처리방침</a></li>
        					<li style='display:inline-block; position:relative; margin-right:30px; padding-right:30px; margin-left: 0 !important;'><a href='https://spc.co.kr/' target='_blank' style='font-weight:600; text-decoration:none;'>SPC 홈페이지 바로가기</a></li>
        				</ul>
        				<p style='font-size:16px; color:#7d7d7d; margin-top:10px; white-space:normal;'>본 메일은 발신전용 입니다. 궁금하신 점이나 불편사항은 <a href='mailto:SPChotline@spc.co.kr' class='color-point1' style='color:#23afe3;'>SPChotline@spc.co.kr</a>에 문의해 주시기 바랍니다.</p>
        			</div>
        			<div class='e-footer-bot' style='overflow:hidden;'>
        				<div class='e-main-img' style='width:151px; float:left; padding:0; margin-right:45px;'>
        					<img src='https://spc.co.kr/img/edm/e-footer.png' alt='spc로고'  style='width:100%;'>
        				</div>
        				<ul style='margin:13px 0 0 0; list-style:none; padding-left:0px;'>
        					<li style='font-size:14px; color:#7d7d7d;'>서울시 서초구 양재동 남부순환로 2620(양재동 11-149) SPC그룹</li>
        					<li style='font-size:14px; color:#7d7d7d;'>Copyright SPC All rights reserverd.</li>
        				</ul>
        			</div>
        		</footer>
          </div>";

    $mail = new PHPMailer(true);
    try {
        $mail->SMTPDebug = 0; // 디버깅 설정
        $mail->isSMTP(); // SMTP 사용 설정
                         // 지메일일 경우 smtp.gmail.com, 네이버일 경우 smtp.naver.com
        $mail->Host = "smtp.naver.com"; // 네이버의 smtp 서버
        $mail->SMTPAuth = true; // SMTP 인증을 사용함
        $mail->Username = "spchotline@naver.com"; // 메일 계정 (지메일일경우 지메일 계정)
        $mail->Password = "dbsflruddudxla14"; // 메일 비밀번호
        $mail->SMTPSecure = "ssl"; // SSL을 사용함
        $mail->Port = 465; // email 보낼때 사용할 포트를 지정
        $mail->CharSet = "utf-8"; // 문자셋 인코딩
                                  // 보내는 메일
        $mail->setFrom($fromEmail, $fromName);
        // 받는 메일
        $mail->addAddress($toEmail, $toName);
        $mail->addAddress("kwanpyo@spc.co.kr", "SPC담당자");
        $mail->addcc("yangseog.seo@spc.co.kr", "SPC담당자");
        $mail->addcc("catchu79@spc.co.kr", "SPC담당자");
        $mail->addcc("torsokang@spc.co.kr", "SPC담당자");   
        // 숨은참조
        /* $mail -> addBcc("coscoswkd@musign.net", "SPC담당자"); */
        //$mail -> addBcc("jino994@musign.net", "SPC담당자"); 

        // $mail -> addAttachment("../pdf/musign_our_Company.pdf");
        // 첨부파일
        // $mail -> addAttachment("./test1.zip");
        // $mail -> addAttachment("./test2.jpg");*/
        // 메일 내용
        $mail->isHTML(true); // HTML 태그 사용 여부
        $mail->Subject = $subject; // 메일 제목
        if ($message == "") {
            $message = "  ";
        }
        $mail->Body = $message; // 메일 내용
                                // Gmail로 메일을 발송하기 위해서는 CA인증이 필요하다.
                                // CA 인증을 받지 못한 경우에는 아래 설정하여 인증체크를 해지하여야 한다.
        $mail->SMTPOptions = array(
            // "tls" => array(
            // "verify_peer" => false
            // , "verify_peer_name" => false
            // , "allow_self_signed" => true
            // )
        );
        // 메일 전송
        $mail->send();
    } catch (Exception $e) {
        ?>
        {
            "isSuc":"fail",
            "msg": <?php echo $mail -> ErrorInfo; ?>
        }
    <?php
    }
}
?>
