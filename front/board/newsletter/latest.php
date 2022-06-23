<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");
?>
<script>
//조회
function goDetail(idx)
{
	location.href="/csr/society/newsletter/detail/?idx="+idx;
}
</script>
<div class="magazine-latest">
	<ul class="tranDelayList">
    <?php 
            $query = "select *,DATE_FORMAT(submit_date, '%Y.%m.%d') as submit_date2 from SPC_NEWS order by submit_date DESC limit 4";
            $result = sql_query($query);
            for($i = 0; $i < sql_count($result); $i++){
            $row = sql_fetch($result);
                ?>
            		<li>
            			<div class="img">
            				<div class="img-hov"><a href="javascript:goDetail(<?php echo $row['idx']?>);"><img src="/aDmin/file/<?php echo $row['thumb']?>" alt=""></a></div> 
            			</div>
            			<div class="cont">
            				<!-- <a href="#">
                				<small>SPC MAGAZINE</small>
                				<strong>2021.01</strong>
            				</a> -->
            				<time class="date"><?php echo $row['submit_date2']?></time>
            			</div>
            		</li>
    		<?php 
            }
            ?>
	</ul>
</div>