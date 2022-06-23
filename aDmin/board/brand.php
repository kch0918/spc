<?php
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/admin_header.php");
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/admin_lnb.php");

$order_by = (isset($_REQUEST['order_by'])) ? $_REQUEST['order_by'] : "desc";

// if(isset($_REQUEST['order_by'])){
//     $order_by = $_REQUEST['order_by'];
// }else{
//     $order_by = "desc";
// }

$query = "SELECT distinct
                a.idx,
                b.idx AS board_idx,
                b.title,
                a.cate_name,
                DATE_FORMAT(b.submit_date, '%Y.%m.%d') as submit_date2,
                b.expo_yn,
                c.cate_brand_kr
          from SPC_MID_CATE a
                join SPC_BRAND_BOARD b
                	on a.idx = b.parentidx
                JOIN SPC_BIG_CATE c
	            ON a.parentidx = c.idx
          order by sort asc, submit_date {$order_by}";

$result_cnt = sql_query($query);
?>

<script>
function goBrand(idx)
{
	location.href="/aDmin/board/brand_edit.php?idx="+idx;
}

function changeFunc() {
	
 var selectBox = document.getElementById("selectBox");
 var selectedValue = selectBox.options[selectBox.selectedIndex].value;
 location.href = "/aDmin/board/brand.php?order_by="+selectedValue;
 
}
</script>
<script src="/aDmin/js/Sortable.js"></script>
<div id="container" class="report">	
	<div class="search">
		<p>브랜드 관리<strong>생성된 게시글을 관리합니다.</strong></p>
	</div>
	<div class="search_cont no_search">
	<span class="serch_cont_txt">전체  <?php echo sql_count($result_cnt);?> 개</span>
    <button onclick="sortProc();" class="sort_bt">현재순서저장</button>
    <select id="selectBox" class="serch_cont_sort" onchange="changeFunc();">
        <option value="desc">최신 등록 순</option>
        <option value="asc">오래된 순</option>
    </select>   
	<table class="table_tit">
		<tr>
        	<th>NO.</th>
        	<th>카테고리</th>
        	<th>브랜드명</th>
        	<th>제목</th>
        	<th>등록일</th>
        	<th>노출</th>
        	<th></th>
		</tr>
		<table class="tablecont">
			<tbody id="tableList">
				<?php
                    $result = sql_query($query);
                    for ($i=0; $i<sql_count($result); $i++)
                    {
                        $row = sql_fetch($result);
                        ?>
        					<tr class="drag-btn" data-idx="<?php echo $row['idx']?>">
    							<td><?php echo $i+1;?></td>
    							<td><?php echo $row['cate_brand_kr'];?></td>
    							<td><?php echo $row['cate_name'];?></td>
        						<td><?php echo $row['title'];?></td>
        						<td><?php echo $row['submit_date2'];?></td>
        						<?php if($row['expo_yn'] == "Y") {
            					    ?>
            						<td>노출</td>
            						 <?php 
        						}else {
        						    ?>
        						    <td>미노출</td>
        						    <?php 
        						}
            						  ?>
        						<td><a class="edit" onclick="goBrand(<?php echo $row['idx']?>)">수정</a></td>
        					</tr>
                        <?php 
                    }
                    ?>
            </tbody>
		</table>
	</table>
    	</div>
	</div>
</div>
<script>
var sort_arr = [];
var sortable = Sortable.create(document.querySelector("#tableList"), {
	//options
	handle: '.drag-btn',
	onSort: function(e){
		var target = e.to.children;
		console.log(target);
		var i = 0;
		sort_arr = [];
		for(i; i < target.length; i++){
			var obj = {
					idx: target[i].dataset.idx,
					sort: i+1
				}
			sort_arr.push(obj);
		}
	}
});

function sortProc(){

	console.log(sort_arr);
	
	var i = 0;
	var idx  = "";
    var sort = ""; 
    
	for(i; i < sort_arr.length; i++){
	    
       	 idx =  sort_arr[i].idx; 
    	 sort = sort_arr[i].sort; 
    	console.log("dd : " +idx);
    	console.log("dd : " +sort);
		
    	$.ajax({
    		type: "get",
    		url: "/aDmin/board/sortProc.php",
    		dataType:"text",
    		async: false,
    		data : {
    			idx : idx,
    			sort: sort 
    		},
    		success: function(data)
    		{
        		location.reload();
    // 			console.log(data);
    			
    // 			var result = JSON.parse(data);
    //     		if(result.isSuc == "success")
    //     		{
    //     			alert("저장되었습니다.");
    //     			location.href="/aDmin/board/brand.php";
    //     		}
    //     		else
    //     		{
    //     			alert(result.msg);
    //     		}
    		}
    	});
	}

}
</script>
<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/admin_footer.php");
?>