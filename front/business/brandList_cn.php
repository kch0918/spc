<?php
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");

?>
<script>

function goBrand_Detail(idx)
{
	location.href="/business/brand-detail/?idx=" +idx + "&lang=zh-hans";
}
</script>
<div class="brand-list">
	<!-- 왼쪽 LNB 메뉴 -->
	<div class="lnb brand-cate">
		<div class="cate-ulwr">
			<h2>SPC BRAND</h2>
			<ul class="lnb-ul">
				
				<li class="lnb-allbtn">
					<a href="/spc-brand/" class="en-txt">ALL BRAND</a>
				</li>
                <?php 
                $query = "select * from SPC_BIG_CATE where cate_type = 'brand'";
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
                			<li><a href="javascript:goBrand_Detail(<?php echo $row2['idx']?>);"><?php echo $row2['cate_name_cn']?></a></li>
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
	<div class="blist-wr">
			<?php 
        		$query = "select * from SPC_BIG_CATE where cate_type = 'brand'";
        		$result = sql_query($query);
        		for($i = 0; $i < sql_count($result); $i++){
        		    $row = sql_fetch($result);
    		    ?>
            		<div class="blist-box">
						<?php 
						if($i == 0){
						?>
							<p class="blist-t en-txt">ALL BRAND</p>
						<?php 
							}
						?>        		
            			<p class="blist-bgt"><?php echo $row['cate_brand_cn']?></p>
            			<div class="blist-row">
						<?php 
						$query2 = "select * from SPC_MID_CATE where parentidx = '{$row['idx']}' and expo_yn='Y' order by sort asc";
						$result2 = sql_query($query2);
						
						for($n = 0; $n < sql_count($result2); $n++){
						    $row2 = sql_fetch($result2);
						    ?>
            		
            				<div class="blist">
        					<a href="javascript:goBrand_Detail(<?php echo $row2['idx']?>)">
        						<input type="hidden" id="idx" name="idx" value="<?php echo $row['idx']?>">
        						<input type="hidden" id="idx2" name="idx2" value="<?php echo $row2['idx']?>">
								<img class="blist-img" src="/aDmin/file/<?php echo $row2['cate_logo']?>" alt="<?php echo $row2['cate_logo']?>">
    							<div class="back">
									<div class="table">
										<div class="ft-16">
											<strong class="ft-20"><?php echo $row2['cate_name_cn']?></strong>
											<?php echo $row2['cate_dis_cn']?>
											<span class="ft-14"><?php echo $row2['sud_name_en']?></span>
										</div>
									</div>
    							</div>
								<img class="def-img" src="/img/brand/brand-bg.png" alt="spc브랜드"/>
    						</a>
        					</div>
						<?php 
						}
						?>
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
		$('.blist > a').each(function(){
			var delayTime = $(this).parent().index() * 200 + 200;
			var $this = $(this);
			setTimeout(function(){
				$this.addClass('load');
			},delayTime);
		});

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
	})
	*/
</script>