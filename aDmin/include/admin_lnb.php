<?php
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");

$query  = "SELECT * from SPC_ADMIN where id = '{$_SESSION['id']}'";
$result = sql_query($query);
$row    = sql_fetch($result);

?>
<meta http-equiv="X-UA-Compatible" content="IE=Edge">

<script>
$(document).ready(function(){
	var mainmenuTit = $(this).find('.mainmenu > li');

	$.each(mainmenuTit, function(index,item){
		$(this).click(function(){			
			showSub(index);	
		});
	});
	function showSub(_num) {
        mainmenuTit.find('.submenu').stop().slideUp();
        mainmenuTit.not('.active').removeClass('on');
        // $('.sub_bg').hide();

        if (_num == 10000) {
            return;
        }

        mainmenuTit.eq(_num).find('.submenu').stop().slideDown();
        mainmenuTit.eq(_num).addClass('on');
        // $('.subMenu').slideDown();
    }

    var subMenu = $('.submenu > li > a');
   	var localPath = window.location.pathname; 
   	var pathStr = localPath.split('_');
   	console.log(pathStr[0]);

	$.each(subMenu, function(index, item){
		var aHref = $(this).attr('href');
		if (aHref.indexOf(pathStr[0]) != -1) {
			$(this).parents('.submenu').addClass('on');
			$(this).parents('li').addClass('on');
			$(this).parents('li').addClass('active');
		};
	});	

});
</script>
<div id="inb">
	<ul class="mainmenu">
	<?php if($row['media_yn'] == "Y") {
	    ?>
		<li>
			<span>MEDIA HUB</span>
			<ul class="submenu">
		<?php if($row['news_yn'] == "Y") {
	    ?>
				<li><a href="/aDmin/media/report.php">보도자료</a></li>
    	<?php 
    	}
    	?>
    	<?php if($row['magazine_yn'] == "Y") {
	    ?>
				<li><a href="/aDmin/media/magazine.php">SPC 매거진</a></li>
		<?php 
    	}
    	?>
    	<?php if($row['sns_yn'] == "Y") {
	    ?>		
				<li><a href="/aDmin/media/sns.php">SNS</a></li>
		<?php 
    	}
    	?>
    	<?php if($row['cf_yn'] == "Y") {
	    ?>	
				<li><a href="/aDmin/media/cf.php">CF</a></li>
		<?php 
    	}
    	?>
			</ul>
		</li>
	<?php 
	}
	?>
	
	<?php if($row['csr_yn'] == "Y") {
	    ?>
		<li>
			<span>ESG</span>
			<ul class="submenu">
		<?php if($row['notice_yn'] == "Y") {
	    ?>
				<li><a href="/aDmin/csr/notice.php">공지사항</a></li>
    	<?php 
    	}
    	?>
    	<?php if($row['financial_yn'] == "Y") {
	    ?>
				<li><a href="/aDmin/csr/finance.php">재정보고</a></li>
		<?php 
    	}
    	?>
    	<?php if($row['news_yn'] == "Y") {
	    ?>		
				<li><a href="/aDmin/csr/news.php">뉴스레터</a></li>
		<?php 
    	}
    	?>
    	<?php if($row['review_yn'] == "Y") {
	    ?>	
				<li><a href="/aDmin/csr/review.php">참여후기</a></li>
		<?php 
    	}
    	?>
		<?php if($row['social_yn'] == "Y") {
	    ?>	
	    		<li><a href="/aDmin/csr/social.php">사회공헌 소식</a></li>
		<?php 
    	}
    	?>
			</ul>
		</li>
	<?php 
	}
	?>
	<?php if($row['nagation_yn'] == "Y") {
	    ?>
		<li>
			<span>부정제보 관리</span>
			<ul class="submenu">
				<li><a href="/aDmin/users/nagation.php">부정제보 관리</a>	</li>
			</ul>				
		</li>
	<?php 
	}
	?>
	
	<?php if($row['type_yn'] == "Y") {
	    ?>
		<li>
			<span>브랜드&계열사 관리</span>
			<ul class="submenu">
			<?php if($row['cate_yn'] == "Y") {
	        ?>
				<li><a href="/aDmin/cate/category.php">카테고리 관리</a></li>
				<li><a href="/aDmin/cate/category_en.php">카테고리 관리(영문)</a></li>
				<li><a href="/aDmin/cate/category_cn.php">카테고리 관리(중문)</a></li>
        	<?php 
        	}
        	?>
        	<?php if($row['brand_yn'] == "Y") {
	        ?>
				<li><a href="/aDmin/board/brand.php">브랜드 관리</a></li>
				<li><a href="/aDmin/board/brand_en.php">브랜드 관리(영문)</a></li>
				<li><a href="/aDmin/board/brand_cn.php">브랜드 관리(중문)</a></li>
			<?php 
        	}
        	?>
        	<?php if($row['sub_yn'] == "Y") {
	        ?>
				<li><a href="/aDmin/board/branch.php">계열사 관리</a></li>
				<li><a href="/aDmin/board/branch_en.php">계열사 관리(영문)</a></li>
				<li><a href="/aDmin/board/branch_cn.php">계열사 관리(중문)</a></li>
			<?php 
        	}
        	?>
			</ul>			
		</li>
	<?php 
	}
	?>
	<?php if($row['manage_yn'] == "Y") {
    ?>
		<li>
			<span>계정 관리</span>
			<ul class="submenu">
			<?php if($row['adlist_yn'] == "Y") {
	        ?>
				<li><a href="/aDmin/users/admin_list.php">관리자 리스트</a></li>
			<?php 
        	}
        	?>
        	<?php if($row['iplist_yn'] == "Y") {
	        ?>
				<li><a href="/aDmin/users/ip_list.php">IP관리</a></li>
			<?php 
        	}
        	?>
			</ul>			
		</li>
	<?php 
	}
	?>
	
	<?php if($row['popup_yn'] == "Y") {
    ?>
		<li>
			<span>팝업 관리</span>
			<ul class="submenu">
			<?php if($row['poplist_yn'] == "Y") {
	        ?>
				<li><a href="/aDmin/mu_popup/popup_list.php">팝업 리스트</a></li>
			<?php 
			}
			?>
			</ul>			
		</li>
	<?php 
	}
	?>
	</ul>
</div>