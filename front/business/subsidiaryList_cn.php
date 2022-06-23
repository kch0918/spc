<?php
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");

?>

<script>
function goSub_Detail(idx)
{
	location.href="/business/subsidiary-detail/?idx="+idx + "&lang=zh-hans";
}
</script>

<div class="brand-list">
	<!-- 왼쪽 LNB 메뉴 -->
	<div class="lnb brand-cate">
		<div class="cate-ulwr">
			<h2 class="ft-48">SPC's Subsidiaries</h2>
			<ul class="lnb-ul">
				<li class="lnb-allbtn">
					<a href="/spc-brand/" class="en-txt">ALL subsidiary</a>
				</li>
				<?php 
                $query = "select * from SPC_BIG_CATE where cate_type = 'subsidiary'";
                $result = sql_query($query);
                for($i = 0; $i < sql_count($result); $i++){
                    $row = sql_fetch($result);
                ?>
                <li>
                	<a href="/"><?php echo $row['cate_brand_cn']?></a>
                	<ul class="lnb-dep">
                		<?php 
                		$query2 = "select * from SPC_MID_CATE where parentidx = '{$row['idx']}' order by sort asc";
                		$result2 = sql_query($query2);
                		for($n = 0; $n < sql_count($result2); $n++){
                		    $row2 = sql_fetch($result2);
                		?>
                			<li><a href="javascript:goSub_Detail(<?php echo $row2['idx']?>)"><?php echo $row2['cate_name_cn']?></a></li>
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
	</div>
	<!-- //왼쪽 LNB 메뉴 -->
	
	<!-- 오른쪽 리스트 -->
	<div class="blist-wr cardtype-list">
    	<?php 
    		$query = "select * from SPC_BIG_CATE where cate_type = 'subsidiary'";
    		$result = sql_query($query);
    		for($i2 = 0; $i2 < sql_count($result); $i2++){
    		    $row = sql_fetch($result);
		    ?>
    		<div class="blist-box">
				<?php 
					if($i2 == 0){
				?>
					<p class="blist-t en-txt">ALL subsidiary</p>
				<?php 
					}
				?>        		
    			<p class="blist-bgt"><?php echo $row['cate_brand_cn']?></p>
    			<div class="subslist-row">
				<ul>
				<?php 
					$query2 = "SELECT distinct
                                a.*,
                                a.cate_logo,
                                b.*,
                                DATE_FORMAT(b.submit_date, '%Y.%m.%d') as submit_date2,
                                c.cate_brand_cn
                                from SPC_MID_CATE a
                                join SPC_SUB_BOARD b
                                on a.idx = b.parentidx
                                JOIN SPC_BIG_CATE c
                                ON a.parentidx = c.idx
                                where a.parentidx = '{$row['idx']}'
                                and a.expo_yn='Y' order by sort asc";
					
					$result2 = sql_query($query2);
					
					for($n2 = 0; $n2 < sql_count($result2); $n2++){
					    $row3 = sql_fetch($result2);
					    ?>
        					<li class="slist" onclick="goSub_Detail(<?php echo $row3['parentidx']?>)">
        						<div class="thumb">
        							<img src="/aDmin/file/<?php echo $row3['top_img']?>" alt="계열사"/>
									<img class="de-img" src="/img/sub/card-thumb.png" alt="SPC그룹">
        							<?php 
        							if($row3['cont_img2'] != null) {
        							?>
        							<div class="slist-logo table">
										<div>
											<div class="slogo-slide">
												<div>
												<?php 
													$insert1 = explode("|",$row3['cont_img2']);                                    
													for ($i = 0; $i < count($insert1); $i ++) {
													?>
														<div class="slogo-img">
															<a><img src="/aDmin/file/<?php echo $insert1[$i]?>" alt='spc계열사'/></a>
														</div>
														<?php if(($i+1)/8 == 1){ ?>
														</div><div>
														<?php } ?>
													<?php 
														}
												 ?>
												 </div>
											 </div>
										</div>
        							</div>
        							<?php 
        							}
        							?>
        						</div>
        						<div class="cont">
        							<strong class="ft-24"><?php echo $row3['cate_name_cn']?></strong>
        							<p class="desc ft-16"><?php echo $row3['cate_dis_cn']?></p>
        							<div class="etc">
        								<a>MORE VIEW</a>
        							</div>
        						</div>
        					</li>
            		<?php 
            			}
            		?>
        			</ul>
    			</div>
			</div>
    		<?php 
    		}
    	   ?>
	</div>
</div>

<script>
// LNB
	$(function(){
		$("html").addClass("brand-html");
		
		$(".lnb-ul > li").each(function(){
			var $this = $(this),
				$box = $(this).find(".lnb-dep");
				
				if($box.length > 0 ){
					$this.children("a").removeAttr("href");
					$this.addClass("dep-li");
				}
				$this.click(function(){
					var chk = $(this).find(".lnb-dep").css("display");
					$(".lnb-ul > li").removeClass("on");
					$(".lnb-dep").slideUp();
					if(chk == "none"){
						$this.addClass("on");
						$box.slideDown();					
					}
				})
		});
		$('.slist').each(function(){
			var delayTime = $(this).parent().index() * 200 + 200;
			var $this = $(this);
			setTimeout(function(){
				$this.addClass('load');
			},delayTime);
		});
		$(".slogo-slide").slick({
			speed:500,
			dots:true,
			arrows:false
		})
//
//		$('.slist').each(function(){
//			var a = $(this).find("a").attr("href");
//			$(this).click(function(){
//				window.location.href=a;
//			})
//		});

	});
	/*
	$(function(){
		var fixTop = $(".lnb").offset().top;
		var footer = $("#footer").offset().top;
			var fixH = $(".lnb").height();
			var conH = $("body").height();
		cartFix();

		$(window).scroll(function(){
			cartFix();
		})
		function cartFix(){
			var top = $(window).scrollTop()+150;
			var H = $(window).height();
			var footH = conH-H-$("#footer").height()-240;
			//console.log(top-fixTop +"//"+ footH)
			if(top > fixTop && top-fixTop < footH){
				$(".lnb").addClass("fixed");
				//$(".lnb").css("top",top-fixTop)
				$(".lnb").removeClass("foot");
			}else if(top > fixTop && top-fixTop > footH){
				$(".lnb").addClass("fixed");
				//$(".lnb").css("top",footH);
				$(".lnb").addClass("foot");
			}else{
				$(".lnb").removeClass("fixed");
				$(".lnb").removeClass("foot");
			}
		}
	});
	*/
</script>