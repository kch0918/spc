<?php
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/admin_header.php");
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/admin_lnb.php");

$query = "select *,DATE_FORMAT(submit_date, '%Y.%m.%d') as submit_date2 from SPC_ADMIN where idx = {$_REQUEST['idx']}";
$result = sql_query($query);
$row = sql_fetch($result);
?>
<script type="text/javascript">
    $(document).ready(function(){
		var sel_chmod = "";
    	sel_chmod = "<?php echo $row['chmod']?>"
    	
    	$(".select-box .selectedOption").text(sel_chmod);

        $('body').addClass('admin');

        $( "#menu01-1" ).click( function() {
            $( "#menu01-2,#menu01-3,#menu01-4,#menu01-5" ).prop( 'checked', this.checked );
          } );

        $( "#menu02-1" ).click( function() {
            $( "#menu02-2,#menu02-3,#menu02-4,#menu02-5,#menu02-6" ).prop( 'checked', this.checked );
          } );

        $( "#menu04-1" ).click( function() {
            $( "#menu04-2,#menu04-3,#menu04-4" ).prop( 'checked', this.checked );
          } );

        $( "#menu05-1" ).click( function() {
            $( "#menu05-2,#menu05-3" ).prop( 'checked', this.checked );
          } );

        $( "#menu06-1" ).click( function() {
            $( "#menu06-2" ).prop( 'checked', this.checked );
          } );
    });

    var media_yn  = "<?php echo $row['media_yn']?>",
    news_yn 	  = "<?php echo $row['news_yn']?>",
    magazine_yn	  = "<?php echo $row['magazine_yn']?>",
    sns_yn 		  = "<?php echo $row['sns_yn']?>",
    cf_yn	 	  = "<?php echo $row['cf_yn']?>",
    csr_yn 		  = "<?php echo $row['csr_yn']?>",
    notice_yn 	  = "<?php echo $row['notice_yn']?>",
    financial_yn  = "<?php echo $row['financial_yn']?>",
    newsletter_yn = "<?php echo $row['newsletter_yn']?>",
    review_yn     = "<?php echo $row['review_yn']?>",
    social_yn 	  = "<?php echo $row['social_yn']?>",
    nagation_yn   = "<?php echo $row['nagation_yn']?>",
    type_yn 	  = "<?php echo $row['type_yn']?>",
    cate_yn 	  = "<?php echo $row['cate_yn']?>",
    brand_yn 	  = "<?php echo $row['brand_yn']?>",
    sub_yn 	 	  = "<?php echo $row['sub_yn']?>",
    manage_yn 	  = "<?php echo $row['manage_yn']?>",
    adlist_yn 	  = "<?php echo $row['adlist_yn']?>",
    iplist_yn 	  = "<?php echo $row['iplist_yn']?>",
    popup_yn 	  = "<?php echo $row['popup_yn']?>",  
    poplist_yn 	  = "<?php echo $row['poplist_yn']?>"


$(document).ready(function(){
	
	// ????????? ?????? ????????????
	$("input:checkbox[name='media_yn']:input[value='"+media_yn+"']").attr("checked", true);
	$("input:checkbox[name='news_yn']:input[value='"+news_yn+"']").attr("checked", true);
	$("input:checkbox[name='magazine_yn']:input[value='"+magazine_yn+"']").attr("checked", true);
	$("input:checkbox[name='sns_yn']:input[value='"+sns_yn+"']").attr("checked", true);
	$("input:checkbox[name='cf_yn']:input[value='"+cf_yn+"']").attr("checked", true);
	$("input:checkbox[name='notice_yn']:input[value='"+notice_yn+"']").attr("checked", true);
	$("input:checkbox[name='financial_yn']:input[value='"+financial_yn+"']").attr("checked", true);
	$("input:checkbox[name='csr_yn']:input[value='"+csr_yn+"']").attr("checked", true);
	$("input:checkbox[name='newsletter_yn']:input[value='"+newsletter_yn+"']").attr("checked", true);
	$("input:checkbox[name='review_yn']:input[value='"+review_yn+"']").attr("checked", true);
	$("input:checkbox[name='social_yn']:input[value='"+social_yn+"']").attr("checked", true);
	$("input:checkbox[name='nagation_yn']:input[value='"+nagation_yn+"']").attr("checked", true);
	$("input:checkbox[name='type_yn']:input[value='"+type_yn+"']").attr("checked", true);
	$("input:checkbox[name='cate_yn']:input[value='"+cate_yn+"']").attr("checked", true);
	$("input:checkbox[name='brand_yn']:input[value='"+brand_yn+"']").attr("checked", true);
	$("input:checkbox[name='sub_yn']:input[value='"+sub_yn+"']").attr("checked", true);
	$("input:checkbox[name='manage_yn']:input[value='"+manage_yn+"']").attr("checked", true);
	$("input:checkbox[name='adlist_yn']:input[value='"+adlist_yn+"']").attr("checked", true);
	$("input:checkbox[name='iplist_yn']:input[value='"+iplist_yn+"']").attr("checked", true);
	$("input:checkbox[name='popup_yn']:input[value='"+popup_yn+"']").attr("checked", true);
	$("input:checkbox[name='poplist_yn']:input[value='"+poplist_yn+"']").attr("checked", true);
});

function fncSubmit()
{
	var sel_chmod = "";
	sel_chmod = $("#chmod option:selected").val();
    
	var validationFlag = "Y";
	$(".notempty").each(function()
	{ 
		if ($(this).val() == "" && ad_mod != "jino994" && ad_mod != "admin") 
		{
			alert(this.dataset.name+"???(???) ??????????????????.");
			$(this).focus();
			validationFlag = "N";
			return false;
		}
	});

	if(validationFlag == "Y" || ad_mod != "jino994" || ad_mod != "admin")
	{
		$("#fncForm").ajaxSubmit({
			data : {
				chmod : sel_chmod
			},
			success: function(data)
			{
				console.log(data);
				var result = JSON.parse(data);
	    		if(result.isSuc == "success")
	    		{
	    			alert("?????????????????????.");
	    			location.href="/aDmin/users/admin_list.php";
	    		}
	    		else
	    		{
	    			alert(result.msg);
	    		}

			}

		});

	}
}   
</script>

<div id="container" class="review write">
	<div class="search">
		<p>????????? ??????</p>		
	</div>
	<form id="fncForm"  method="post" action="admin_edit_proc.php" enctype="multipart/form-data" onSubmit="return false;">	
	<input type="hidden" name="idx" value="<?php echo $row["idx"]?>">

	<div class="write_cont_box">
		<div class="write_cont">
			<div>
				<div class="write_li_add">
					<p class="write_cont_tit">????????????</p>
                    <input type="text" id="" name="name" class="info_area" placeholder="????????????" value="<?php echo $row['name']?>">
				</div>
				<div class="write_li_file">
					<p class="write_cont_tit">????????? ??????</p>
					<input type="text" id="" name="tel" class="info_area r_margin" placeholder="????????? ??????" value="<?php echo $row['tel']?>">
                    <p class="write_cont_tit tit_margin">????????? ??????</p>
                    <input type="text" id="" name="corp_tel" class="info_area" placeholder="????????? ??????" value="<?php echo $row['corp_tel']?>">
				</div>
				<div class="write_li_file">
					<p class="write_cont_tit">?????????</p>
					<input type="text" id="id" name="id" class="info_area r_margin" placeholder="?????????" value="<?php echo $row['id']?>">
                    <p class="write_cont_tit tit_margin">?????????</p>
                    <input type="text" id="" name="email" class="info_area" placeholder="?????????" value="<?php echo $row['email']?>">
				</div>
<!-- 				<div class="write_li_file"> -->
<!-- 					<p class="write_cont_tit">????????????</p> -->
<!-- 					<input type="password" id="pw" name="pw" class="info_area r_margin" placeholder=""><br><br> -->
<!-- 					<p class="write_cont_tit mar_top">???????????? ??????</p> -->
<!-- 					<input type="password" id="re_pw" name="re_pw" class="info_area r_margin" placeholder=""><br> -->
<!-- 					<span class="pass_desc">* ????????? ?????? ????????? ?????? ??????????????? ????????? ?????????.<br> -->
<!-- 							??????+?????? 10???~20?????? ??????????????????, ???????????? !@#$%^&*()_+|[]{}'";:/?.>,< ??? ????????? ??????????????????.<br> -->
<!-- 							???????????? 3??? ?????? ???????????????, 3??? ?????? ?????? ?????? ???????????? ??????, ????????? ????????? ??? ?????????, ????????? ????????? ??? ????????????.<br> -->
<!-- 							??????(???????????? ??????), ??????????????? ???????????? ??????????????? ????????????, ?????? ????????? ??????????????? ????????? ??? ????????????.</span> -->
<!-- 				</div>    -->
					<?php 
					if($_SESSION['chmod'] == "?????????") {
					?>
        				<div class="write_li_file">
        					<p class="write_cont_tit">????????????</p>
        					<select id="chmod" name="chmod" class="serch_cont_sort">
        				        <option value="?????????">?????????</option>
        				        <option value="???????????????">???????????????</option>
        				    </select> 
        				</div>  
				    <?php 
					} 
					?>       
				<div class="write_li_file write_check">
					<p class="write_cont_tit">?????? ??????</p>
					<div class="menu_check">
						<input type="checkbox" id="menu01-1" name="media_yn" value="Y" class="regular-radio"><label for="menu01-1"><span>MEDIA HUB</span></label><br>
						<input type="checkbox" id="menu01-2" name="news_yn" value="Y" class="regular-radio"><label for="menu01-2"><span>????????????</span></label><br>
						<input type="checkbox" id="menu01-3" name="magazine_yn" value="Y" class="regular-radio"><label for="menu01-3"><span>SPC?????????</span></label><br>
						<input type="checkbox" id="menu01-4" name="sns_yn" value="Y" class="regular-radio"><label for="menu01-2"><span>SNS</span></label><br>
						<input type="checkbox" id="menu01-5" name="cf_yn" value="Y" class="regular-radio"><label for="menu01-3"><span>CF</span></label>
					</div>		
					<div class="menu_check">
						<input type="checkbox" id="menu02-1" name="csr_yn" value="Y" class="regular-radio"><label for="menu02-1"><span>ESG</span></label><br>
						<input type="checkbox" id="menu02-2" name="notice_yn" value="Y" class="regular-radio"><label for="menu02-2"><span>????????????</span></label><br>
						<input type="checkbox" id="menu02-3" name="financial_yn" value="Y" class="regular-radio"><label for="menu02-3"><span>????????????</span></label><br>
						<input type="checkbox" id="menu02-4" name="newsletter_yn" value="Y" class="regular-radio"><label for="menu02-4"><span>????????????</span></label><br>
						<input type="checkbox" id="menu02-5" name="review_yn" value="Y" class="regular-radio"><label for="menu02-5"><span>????????????</span></label><br>
						<input type="checkbox" id="menu02-6" name="social_yn" value="Y" class="regular-radio"><label for="menu02-6"><span>????????????</span></label>
					</div>	
					<div class="menu_check">
						<input type="checkbox" id="menu03" name="nagation_yn" value="Y" class="regular-radio"><label for="menu03"><span>???????????? ??????</span></label>
					</div>	
					<div class="menu_check">
						<input type="checkbox" id="menu04-1" name="type_yn" value="Y" class="regular-radio"><label for="menu04-1"><span>?????????&????????? ??????</span></label><br>
						<input type="checkbox" id="menu04-2" name="cate_yn" value="Y" class="regular-radio"><label for="menu04-2"><span>???????????? ??????</span></label><br>
						<input type="checkbox" id="menu04-3" name="brand_yn" value="Y" class="regular-radio"><label for="menu04-3"><span>????????? ??????</span></label><br>
						<input type="checkbox" id="menu04-4" name="sub_yn" value="Y" class="regular-radio"><label for="menu04-4"><span>????????? ??????</span></label>
					</div>	
					<div class="menu_check">
						<input type="checkbox" id="menu05-1" name="manage_yn" value="Y" class="regular-radio"><label for="menu05-1"><span>?????? ??????</span></label><br>	
						<input type="checkbox" id="menu05-2" name="adlist_yn" value="Y" class="regular-radio"><label for="menu05-2"><span>????????? ?????????</span></label><br>	
						<input type="checkbox" id="menu05-3" name="iplist_yn" value="Y" class="regular-radio"><label for="menu05-3"><span>IP ??????</span></label>
					</div>		
					<div class="menu_check">
						<input type="checkbox" id="menu06-1" name="popup_yn" value="Y" class="regular-radio"><label for="menu06-1"><span>?????? ??????</span></label><br>
						<input type="checkbox" id="menu06-2" name="poplist_yn" value="Y" class="regular-radio"><label for="menu06-2"><span>?????? ?????????</span></label><br>	
					</div>				
				</div>
			</div>
		</div>
		</form>
		<div class="write_bt">
			<ul>
				<li><a href="/aDmin/users/admin_list.php" class="bt_cont">??????</a></li>
		        <li><a href="javascript:fncSubmit();" class="bt_cont">??????</a></li>
			</ul>
		</div>
	</div>

</div>
<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/admin_footer.php");
?>