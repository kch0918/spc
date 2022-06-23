<?php
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/admin_header.php");
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/admin_lnb.php");
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");

?>
<script>
    // 카테고리 선택
    $(document).ready(function(){
        var cateLi = $('.cate_ch');
        var cateCont = $('.cate_1_box');
        var catelistBox = $('.cate_list_box');
        var catedescBox = $('.cate_desc_box');
        var cateBt = $('.catelist_bt');
        $.each(cateLi, function(index, item){
            $(this).click(function(){
                cateCont.removeClass('on');
                cateCont.eq(index).addClass('on');
                catelistBox.removeClass('on');
                catelistBox.eq(index).addClass('on');
                catedescBox.removeClass('on');
                catedescBox.eq(index).addClass('on');
                cateBt.hide();
                cateBt.eq(index).show();
            });
        });
        
		// 카테고리 조회
        getCate(); 
        // 처음 로딩시 첫번째 항목 체크상태
        $('input:radio[id="cate_name1"]').attr("checked", true);
		
        // 카테고리 선택에 따른 브랜드 리스트 불러오기
        getList();

        // 처음 로딩시 브랜드 추가 탭 체크상태             
        $('input:radio[id="radio-1-1-0"]').attr("checked", true);
        getList_dis(); 

        getCate_sub();
        // 브랜드 추가 첫번째 항목 체크상태
        $('input:radio[id="cate_name_sub1"]').attr("checked", true);

        // 브랜드 상세 리스트 불러오기

        // 카테고리 선택에 따른 계열사 리스트 불러오기
        getList_sub();

       	// 계열사 추가 첫번째 항목 체크상태
        $('input:radio[id="radio-2-1-0"]').attr("checked", true);
        
        // 계열사 상세 리스트 불러오기
        getList_dis_sub();   
    });

    // sort
    // $(document).ready(function(){
    //     var sortBt = $('.sort');

    //     $.each(sortBt, function(index, item){            
    //         $(this).click(function(){
    //             $(this).toggleClass('on');
    //         });
    //     });
    // });

	// 브랜드 카테고리 조회
	function getCate() 
	{
		$.ajax({
			type : "POST", 
			url : "/aDmin/cate/getCate.php",
			dataType : "text",
			async : false,
			error : function() 
			{
				console.log("AJAX ERROR");
			},
			success : function(data) 
			{
				console.log(data);
				var result = JSON.parse(data);
				for(var i = 0; i < result.length; i++) {
			 	var inner = "";

        		    	inner +=	'<li>';
        		    	inner +=		'<input type="radio" id="cate_name'+[i+1]+'" name="cate_name" value="'+result[i].idx+'" class="cate-radio" onclick="getList();"><label for="cate_name'+[i+1]+'"></label>';
        		    	inner +=  	    '<input type="hidden" id="idx" name="idx" value="'+result[i].idx+'">';
        		    	inner +=  	    '<input type="text" data-idx="'+result[i].idx+'" name="cate_brand_cn" value="'+result[i].cate_brand_cn+'">';
                        inner +=        '<a href="javascript:editcate_proc();" class="cate_bt">수정</a><a href="javascript:delcate_proc();" class="cate_bt cate_bt_clear">삭제</a>';
        		    	inner +=	'</li>';

        		    	$("#new_ul").append(inner);
				}
	    			
	    		
			}
		});	
	}

	// 계열사 카테고리 조회
	function getCate_sub() 
	{
		$.ajax({
			type : "POST", 
			url : "/aDmin/cate/getCate_sub.php",
			dataType : "text",
			async : false,
			error : function() 
			{
				console.log("AJAX ERROR");
			},
			success : function(data) 
			{
				console.log(data);
				var result = JSON.parse(data);
				for(var i = 0; i < result.length; i++) {
			 	var inner = "";

        		    	inner +=	'<li>';
        		    	inner +=		'<input type="radio" id="cate_name_sub'+[i+1]+'" name="cate_name_sub" value="'+result[i].idx+'" class="cate-radio" onclick="getList_sub();"><label for="cate_name_sub'+[i+1]+'"></label>';
        		    	inner +=  	    '<input type="hidden" id="idx" name="idx_sub" value="'+result[i].idx+'">';
        		    	inner +=  	    '<input type="text" data-sub-idx="'+result[i].idx+'" name="cate_brand_kr" value="'+result[i].cate_brand_cn+'">';
                        inner +=        '<a href="javascript:editcate_sub_proc();" class="cate_bt">수정</a><a href="javascript:delcate_sub_proc();" class="cate_bt cate_bt_clear">삭제</a>';
        		    	inner +=	'</li>';

        		    	$("#new_ul_sub").append(inner);
				}
	    			
	    		
			}
		});	
	}
    
    // 브랜드 카테고리 추가
    function addcate()
    {
    	document.querySelectorAll(".cate_bt_wrap a")[0].href = "#";

      	$.ajax({
			type : "POST", 
			url : "/aDmin/cate/addcate_proc.php",
			dataType : "text",
			async : false,
			error : function() 
			{
				console.log("AJAX ERROR");
			},
			success : function(data) 
			{
				$("#new_ul").empty();
				getCate();
				
			}
		});	
    	
    }

    // 계열사 카테고리 추가
    function addcate_sub()
    {
    	document.querySelectorAll(".cate_bt_wrap_sud a")[0].href = "#";

      	$.ajax({
			type : "POST", 
			url : "/aDmin/cate/addcate_sub_proc.php",
			dataType : "text",
			async : false,
			error : function() 
			{
				console.log("AJAX ERROR");
			},
			success : function(data) 
			{
				$("#new_ul_sub").empty();
				getCate_sub();
				
			}
		});	
    	
    }

    // 브랜드 카테고리 수정
    function editcate_proc() {
        
    	var chkidx = "";
		var cate_brand_kr = "";
    	
    	chkidx = $('input[name="cate_name"]:checked').val();
    	cate_brand_cn = $('input[data-idx='+chkidx+']').val(); 
    	
    	console.log(chkidx);
    	console.log(cate_brand_cn);
    	
    	if(chkidx == undefined)
    	{
    		alert("선택된 항목이 없습니다.");
    		return;
    	}
    	
    	$.ajax({
    			type : "POST", 
    			url : "/aDmin/cate/editcate_cn_proc.php",
    			dataType : "text",
    			async : false,
    			data : 
    			{
    				idx : chkidx,
    				cate_brand_cn : cate_brand_cn
    			},
    			error : function() 
    			{
    				console.log("AJAX ERROR");
    			},
    			success : function(data) 
    			{
    				console.log(data);
    				var result = JSON.parse(data);
    				if(result.isSuc == "success")
    	    		{
    	    			alert(result.msg);
    	    			location.reload();
    	    			
    	    		}
    	    		else
    	    		{
    	    			alert(result.msg);
    	    		}
    			}
    		});	
    }

    // 계열사 카테고리 수정
    function editcate_sub_proc() {
        
    	var chkidx = "";
		var cate_brand_kr = "";
    	
    	chkidx = $('input[name="cate_name_sub"]:checked').val();
    	cate_brand_cn = $('input[data-sub-idx='+chkidx+']').val(); 
    	
    	console.log(chkidx);
    	console.log(cate_brand_cn);
    	
    	if(chkidx == undefined)
    	{
    		alert("선택된 항목이 없습니다.");
    		return;
    	}
    	
    	$.ajax({
    			type : "POST", 
    			url : "/aDmin/cate/editcate_sub_cn_proc.php",
    			dataType : "text",
    			async : false,
    			data : 
    			{
    				idx : chkidx,
    				cate_brand_cn : cate_brand_cn
    			},
    			error : function() 
    			{
    				console.log("AJAX ERROR");
    			},
    			success : function(data) 
    			{
    				console.log(data);
    				var result = JSON.parse(data);
    				if(result.isSuc == "success")
    	    		{
    	    			alert(result.msg);
    	    			location.reload();
    	    			
    	    		}
    	    		else
    	    		{
    	    			alert(result.msg);
    	    		}
    			}
    		});	
    }

    // 브랜드 카테고리 삭제
    function delcate_proc() {
        
    	var chkidx = "";

    	chkidx = $('input[name="cate_name"]:checked').val();

    	if(chkidx == undefined)
    	{
    		alert("선택된 항목이 없습니다.");
    		return;
    	}
    if(confirm("정말 삭제하시겠습니까?"))
    {
    	$.ajax({
    			type : "POST", 
    			url : "/aDmin/cate/delcate_proc.php",
    			dataType : "text",
    			async : false,
    			data : 
    			{
    				idx : chkidx
    			},
    			error : function() 
    			{
    				console.log("AJAX ERROR");
    			},
    			success : function(data) 
    			{
    				console.log(data);
    				var result = JSON.parse(data);
    				if(result.isSuc == "success")
    	    		{
    	    			alert(result.msg);
    	    			location.reload();
    	    			
    	    		}
    	    		else
    	    		{
    	    			alert(result.msg);
    	    		}
    			}
    		});	
  	  }
    }

    // 계열사 카테고리 삭제
    function delcate_sub_proc() {
        
    	var chkidx = "";

    	chkidx = $('input[name="cate_name_sub"]:checked').val();

    	if(chkidx == undefined)
    	{
    		alert("선택된 항목이 없습니다.");
    		return;
    	}
    	
    if(confirm("정말 삭제하시겠습니까?"))
    {
    	$.ajax({
    			type : "POST", 
    			url : "/aDmin/cate/delcate_sub_proc.php",
    			dataType : "text",
    			async : false,
    			data : 
    			{
    				idx : chkidx
    			},
    			error : function() 
    			{
    				console.log("AJAX ERROR");
    			},
    			success : function(data) 
    			{
    				console.log(data);
    				var result = JSON.parse(data);
    				if(result.isSuc == "success")
    	    		{
    	    			alert(result.msg);
    	    			location.reload();
    	    			
    	    		}
    	    		else
    	    		{
    	    			alert(result.msg);
    	    		}
    			}
    		});	
  	  }
    }

    // 브랜드 추가
    function addbrand()
    {
    	var inner = "";

    	inner +=    '<tr>';
    	inner +=           '<td><a href="#" class="sort up"></a><a href="#" class="sort down"></a></td>';
    	inner +=         	'<td class="num"><input id="radio" type="radio" during="brand" name="brand_chk" onclick="getList_dis();" value="" class="regular-radio"><label for="radio"></label></td>';
    	inner +=            '<td><input type="text" name="brand_name_add" value=""></td>';
    	inner +=         	'<td><a href="javscript:editbrand_proc();" class="edit">수정</a></td>';
    	inner +=         	'<td><a href="javascript:delbrand_proc();" class="edit del">삭제</a></td>';
    	inner +=    '</tr>';

    	
    	$(".addbrand").append(inner);

    	// 카테고리 체크값 가져오기
		var parentidx = "";
		parentidx = $('input[name="cate_name"]:checked').val();
		console.log(parentidx);
    	
    	$.ajax({
			type : "POST", 
			url : "/aDmin/cate/addbrand_proc.php",
			dataType : "text",
			data : {
				cate_name : parentidx	
			}, 
			async : false,
			error : function() 
			{
				console.log("AJAX ERROR");
			},
			success : function(data) 
			{
				$("#new_ul").empty();
				getCate();
				location.reload();
				
			}
		});	
    }

    // 계열사 추가
    function addsub()
    {
    	var inner = "";

    	inner +=    '<tr>';
    	inner +=           '<td><a href="#" class="sort"></a></td>';
    	inner +=         	'<td class="num"><input id="radio" type="radio" during="brand" name="sub_chk" onclick="getList_dis();" value="" class="regular-radio"><label for="radio"></label></td>';
    	inner +=            '<td><input type="text" name="brand_name_add" value=""></td>';
    	inner +=         	'<td><a href="" class="edit">수정</a></td>';
    	inner +=         	'<td><a href="" class="edit del">삭제</a></td>';
    	inner +=    '</tr>';
    	
    	$(".addsub").append(inner);

    	// 카테고리 체크값 가져오기
		var parentidx = "";
		parentidx = $('input[name="cate_name_sub"]:checked').val();
		console.log(parentidx);
    	
    	$.ajax({
			type : "POST", 
			url : "/aDmin/cate/addsub_proc.php",
			dataType : "text",
			data : {
				cate_name : parentidx	
			}, 
			async : false,
			error : function() 
			{
				console.log("AJAX ERROR");
			},
			success : function(data) 
			{
				$("#new_ul_sub").empty();
				getCate_sub();
				location.reload();
			}
		});	
    }

    // 브랜드 수정
    function editbrand_proc() {
        
    	var brand_chk = "";
		var brand_name = "";
    	
		brand_chk = $('input[name="brand_chk"]:checked').val();
    	brand_name = $('input[data-idx2='+brand_chk+']').val(); 
    	
    	console.log("brand_chk : " + brand_chk);
    	console.log("brand_name : " + brand_name);

    	
    	if(brand_chk == undefined)
    	{
    		alert("선택된 항목이 없습니다.");
    		return;
    	}
    	
    	$.ajax({
    			type : "POST", 
    			url : "/aDmin/cate/editbrand_proc.php",
    			dataType : "text",
    			async : false,
    			data : 
    			{
    				brand_chk : brand_chk,
    				brand_name : brand_name
    			},
    			error : function() 
    			{
    				console.log("AJAX ERROR");
    			},
    			success : function(data) 
    			{
    				console.log(data);
    				var result = JSON.parse(data);
    				if(result.isSuc == "success")
    	    		{
    	    			alert(result.msg);
    	    			location.reload();
    	    		}
    	    		else
    	    		{
    	    			alert(result.msg);
    	    		}
    			}
    		});	
    }

    // 계열사 수정
    function editsub_proc() {
        
    	var sub_chk = "";
		var brand_name = "";
    	
		sub_chk = $('input[name="sub_chk"]:checked').val();
    	brand_name = $('input[data-sub-idx2='+sub_chk+']').val(); 
    	
    	console.log("sub_chk : " + sub_chk);
    	console.log("brand_name : " + brand_name);

    	
    	if(sub_chk == undefined)
    	{
    		alert("선택된 항목이 없습니다.");
    		return;
    	}
    	
    	$.ajax({
    			type : "POST", 
    			url : "/aDmin/cate/editsub_proc.php",
    			dataType : "text",
    			async : false,
    			data : 
    			{
    				sub_chk : sub_chk,
    				brand_name : brand_name
    			},
    			error : function() 
    			{
    				console.log("AJAX ERROR");
    			},
    			success : function(data) 
    			{
    				console.log(data);
    				var result = JSON.parse(data);
    				if(result.isSuc == "success")
    	    		{
    	    			alert(result.msg);
    	    			location.reload();
    	    		}
    	    		else
    	    		{
    	    			alert(result.msg);
    	    		}
    			}
    		});	
    }

    // 브랜드 삭제
    function delbrand_proc() {
        
    	var brand_chk = "";

    	brand_chk = $('input[name="brand_chk"]:checked').val();

    	console.log(brand_chk);
    	
    	if(brand_chk == undefined)
    	{
    		alert("선택된 항목이 없습니다.");
    		return;
    	}
    if(confirm("정말 삭제하시겠습니까?"))
    {
    	$.ajax({
    			type : "POST", 
    			url : "/aDmin/cate/delbrand_proc.php",
    			dataType : "text",
    			async : false,
    			data : 
    			{
    				brand_chk : brand_chk
    			},
    			error : function() 
    			{
    				console.log("AJAX ERROR");
    			},
    			success : function(data) 
    			{
    				console.log(data);
    				var result = JSON.parse(data);
    				if(result.isSuc == "success")
    	    		{
    	    			alert(result.msg);
    	    			location.reload();
    	    			
    	    		}
    	    		else
    	    		{
    	    			alert(result.msg);
    	    		}
    			}
    		});	
  	  }
    }

    // 계열사 삭제
    function delsub_proc() {
        
    	var sub_chk = "";

    	sub_chk = $('input[name="sub_chk"]:checked').val();

    	console.log(sub_chk);
    	
    	if(sub_chk == undefined)
    	{
    		alert("선택된 항목이 없습니다.");
    		return;
    	}
    if(confirm("정말 삭제하시겠습니까?"))
    {
    	$.ajax({
    			type : "POST", 
    			url : "/aDmin/cate/delsub_proc.php",
    			dataType : "text",
    			async : false,
    			data : 
    			{
    				sub_chk : sub_chk
    			},
    			error : function() 
    			{
    				console.log("AJAX ERROR");
    			},
    			success : function(data) 
    			{
    				console.log(data);
    				var result = JSON.parse(data);
    				if(result.isSuc == "success")
    	    		{
    	    			alert(result.msg);
    	    			location.reload();
    	    			
    	    		}
    	    		else
    	    		{
    	    			alert(result.msg);
    	    		}
    			}
    		});	
  	  }
    }

	// 카테고리 선택에 따른 브랜드 조회
    function getList() {

     	var chkidx = "";

    	chkidx = $('input[name="cate_name"]:checked').val();
        
    	$.ajax({
			type : "POST", 
			url : "/aDmin/cate/getList.php",
			dataType : "text",
			async : false,
			data : 
			{
				idx : chkidx
			},
			error : function() 
			{
				console.log("AJAX ERROR");
			},
			success : function(data) 
			{
				$(".addbrand").empty();
				console.log(data);
				var result = JSON.parse(data);
			 	
				for(var i = 0; i < result.length; i++) {
			 	var inner = "";
					if(result[i].expo_yn == "Y")
					{
        		    	inner +=    '<tr>';
        		    	inner +=           '<td></td>';
        		    	inner +=         	'<td class="num"><input type="radio" during="brand" id="radio-1-1-'+[i]+'" name="brand_chk" value="'+result[i].idx+'" class="regular-radio" onclick="getList_dis();"><label for="radio-1-1-'+[i]+'"></label></td>';
        		    	inner +=            '<td><input type="text" data-idx2='+result[i].idx+' name="brand_name" value="'+result[i].cate_name_cn+'"/></td>';
//         		    	inner +=         	'<td><a href="javascript:editbrand_proc()" class="edit">수정</a></td>';
        		    	inner +=         	'<td><a href="javascript:delbrand_proc()" class="edit del">삭제</a></td>';
        		    	inner +=    '</tr>';

        		    	$(".addbrand").append(inner);
					}
				}
			}
		});	
    } 

	// 카테고리 선택에 따른 계열사 조회
    function getList_sub() {

     	var chkidx = "";

    	chkidx = $('input[name="cate_name_sub"]:checked').val();

    	console.log("cate_name_sub :" + chkidx); 
        
    	$.ajax({
			type : "POST", 
			url : "/aDmin/cate/getList_sub.php",
			dataType : "text",
			async : false,
			data : 
			{
				idx_sub : chkidx
			},
			error : function() 
			{
				console.log("AJAX ERROR");
			},
			success : function(data) 
			{
				$(".addsub").empty();
				console.log(data);
				var result = JSON.parse(data);
			 	
				for(var i = 0; i < result.length; i++) {
			 	var inner = "";
    			 	if(result[i].expo_yn == "Y")
    				{
            		    	inner +=    '<tr>';
            		    	inner +=           '<td></td>';
            		    	inner +=         	'<td class="num"><input type="radio" during="brand" id="radio-2-1-'+[i]+'" name="sub_chk" value="'+result[i].idx+'" class="regular-radio" onclick="getList_dis_sub();"><label for="radio-2-1-'+[i]+'"></label></td>';
            		    	inner +=            '<td><input type="text" data-sub-idx2='+result[i].idx+' name="brand_name_cn" value="'+result[i].cate_name_cn+'"/></td>';
//             		    	inner +=         	'<td><a href="javascript:editsub_proc()" class="edit">수정</a></td>';
            		    	inner +=         	'<td><a href="javascript:delsub_proc()" class="edit del">삭제</a></td>';
            		    	inner +=    '</tr>';
    
    
            		    	$(".addsub").append(inner);
    				}
				}
			}
		});	
    } 

	// 카테고리 선택에 따른 브랜드 상세조회
    function getList_dis() {

     	var chkidx = "";

    	chkidx = $('input[name="brand_chk"]:checked').val();
    	console.log(chkidx);
        
    	$.ajax({
			type : "POST", 
			url : "/aDmin/cate/getList_dis.php",
			dataType : "text",
			async : false,
			data : 
			{
				idx : chkidx
			},
			error : function() 
			{
				console.log("AJAX ERROR");
			},
			success : function(data) 
			{
				$(".addDisc").empty();
				console.log(data);
				var result = JSON.parse(data);

				$(".addDisc").append("<colgroup class><col style='width:20%'><col style='width:80%'></colgroup>");
				for(var i = 0; i < result.length; i++) {
			 	var inner = "";

        			    inner = '<tr>';
        			    inner += 	'<th>카테고리 변경</th>';
        			    inner += 	'<td>';
        			    inner += 	   '<select id="brand_cate_type" name="brand_cate_type" value="" class="notit">';
        			    
        				if(result[i].parentidx == 1) {
                       		inner +=    '<option value="'+result[i].parentidx+'">面包店/甜点</option>';
        				} else if(result[i].parentidx == 2) {
        					inner +=    '<option value="'+result[i].parentidx+'">餐饮</option>';
        				} else if(result[i].parentidx == 3) {
        					inner +=    '<option value="'+result[i].parentidx+'">咖啡/饮料</option>';
        				} else if(result[i].parentidx == 4){
        					inner +=    '<option value="'+result[i].parentidx+'">流通/服务</option>';
        				} 
        
        	 			inner +=  changeCate();
        	 			
			 			
        		    	inner += '<tr>';
        		    	inner += 	'<th>브랜드명</th>';
        		    	inner += 		'<td><input type="text" name="brand_name2" value="'+nullChk(result[i].cate_name_cn)+'"/></td>';
        		    	inner +=  '</tr>';
        		    	
        		    	inner +=   '<tr>';
        		    	inner +=     '<th>브랜드 설명</th>';
        		    	inner +=          '<td><input type="text" name="brand_dis" value="'+nullChk(result[i].cate_dis_cn)+'"/></td>';
        		    	inner +=   '</tr>';
        		    	
        		    	inner +=    '<tr>';
        		    	inner +=       '<th>계열사명</th>';
        		    	inner +=           '<td><input type="text" name="sud_name" value="'+nullChk(result[i].sud_name)+'"/></td>';
        		    	inner +=    '</tr>';
        		    	
        		    	inner +=     '<tr>';
        		    	inner +=        '<th>브랜드 로고</th>';
        		    	inner +=           '<td><span id="logo_img" class="upload-name" placeholder="500MB 이내로 업로드">'+nullChk(result[i].cate_logo)+'</span>';
        		    	inner +=            '<input type="file" id="upload1" name="cate_logo" class="upload-hidden" value=""/><label for="upload1" class="edit file_bt">파일첨부</label></td>';
        		    	inner +=     '</tr>';
        		    	
        		    	$(".addDisc").append(inner);
				}
                        var fileTarget = $('.upload-hidden');
                        fileTarget.on('change', function() {
                            if (window.FileReader) {
                                filename = $(this)[0].files[0].name;

                            } else {
                                var filename = $(this).val().split('/').pop().split('\\').pop();
                            }
                            $(this).siblings('.upload-name').text(filename);
                        });

                     selectUlInit();
			}
		});	
	}

 	// 카테고리 선택에 따른 계열사 상세조회
    function getList_dis_sub() {

     	var chkidx = "";

    	chkidx = $('input[name="sub_chk"]:checked').val();
    	console.log("sub_chk : " + chkidx);
        
    	$.ajax({
			type : "POST", 
			url : "/aDmin/cate/getList_dis_sub.php",
			dataType : "text",
			async : false,
			data : 
			{
				idx_sub : chkidx
			},
			error : function() 
			{
				console.log("AJAX ERROR");
			},
			success : function(data) 
			{
				$(".addDisc_sub").empty();
				console.log(data);
				var result = JSON.parse(data);

				$(".addDisc_sub").append("<colgroup class><col style='width:20%'><col style='width:80%'></colgroup>");
				for(var i = 0; i < result.length; i++) {
			 	var inner = "";

        				inner = '<tr>';
          			    inner += 	'<th>카테고리 변경</th>';
          			    inner += 	'<td>';
          			    inner += 	   '<select id="sub_cate_type" name="sub_cate_type" value="">';
          			    
          				if(result[i].parentidx == 5) {
                         		inner +=    '<option value="'+result[i].parentidx+'">食品</option>';
          				} else if(result[i].parentidx == 6) {
          					inner +=    '<option value="'+result[i].parentidx+'">原料</option>';
          				} else if(result[i].parentidx == 7) {
          					inner +=    '<option value="'+result[i].parentidx+'">IT/服务</option>';
          				} else if(result[i].parentidx == 8){
          					inner +=    '<option value="'+result[i].parentidx+'">食品</option>';
          				} 
          				
        		 		inner +=  changeCate_sub();
        		 		
						console.log(inner);
			 			
        		    	inner += '<tr>';
        		    	inner += 	'<th>계열사명</th>';
        		    	inner += 		'<td><input type="text" name="sub_name2" value="'+nullChk(result[i].cate_name_cn)+'"/></td>';
        		    	inner +=  '</tr>';
        		    	
        		    	inner +=   '<tr>';
        		    	inner +=     '<th>계열사 설명</th>';
        		    	inner +=          '<td><input type="text" name="sub_dis" value="'+nullChk(result[i].cate_dis_cn)+'"/></td>';
        		    	inner +=   '</tr>';
        		    	
//         		    	inner +=    '<tr>';
//         		    	inner +=       '<th>계열사명</th>';
//         		    	inner +=           '<td><input type="text" name="sub_sud_name" value="'+nullChk(result[i].sud_name)+'"/></td>';
//         		    	inner +=    '</tr>';
        		    	
        		    	inner +=     '<tr>';
        		    	inner +=        '<th>계열사 로고</th>';
        		    	inner +=           '<td><span id="sub_img" class="upload-name-sub" placeholder="500MB 이내로 업로드" value="">'+nullChk(result[i].cate_logo)+'</span>';
        		    	inner +=            '<input type="file" id="upload2" name="cate_logo_sub" class="upload-hidden-sub" value=""/><label for="upload2" class="edit file_bt">파일첨부</label></td>';
        		    	inner +=     '</tr>';
        		    	
        		    	$(".addDisc_sub").append(inner);
				}
                        var fileTarget1 = $('.upload-hidden-sub');
                        fileTarget1.on('change', function() {
                            if (window.FileReader) {
                                filename1 = $(this)[0].files[0].name;

                            } else {
                                var filename1 = $(this).val().split('/').pop().split('\\').pop();
                            }
                            $(this).siblings('.upload-name-sub').text(filename1);
                        });
                        selectUlInit();
			}
		});	
	}

	// 브랜드 상세조회 카테고리 변경
	function changeCate() {
		var inner = "";
		$.ajax({
			type : "POST", 
			url : "/aDmin/cate/changeCate.php",
			dataType : "text",
			async : false,
			error : function() 
			{
				console.log("AJAX ERROR");
			},
			success : function(data) 
			{
					var result = JSON.parse(data);
    				for(var i = 0; i < result.length; i++) {

    				     inner +=   	  '<option value="'+result[i].idx+'">'+result[i].cate_brand_cn+'</option>';
    			 	
					}
    				     inner += 	   '</select>';
    				     inner += 	 '</td>';
    				     inner += '</tr>';
    				      	
    				     // $(".addDisc").append(inner);
			}
		});	
		return inner;
 	}     

	// 계열사 상세조회 카테고리 변경
	function changeCate_sub() {
		var inner = "";
		$.ajax({
			type : "POST", 
			url : "/aDmin/cate/changeCate_sub.php",
			dataType : "text",
			async : false,
			error : function() 
			{
				console.log("AJAX ERROR");
			},
			success : function(data) 
			{
					var result = JSON.parse(data);
					
    				for(var i = 0; i < result.length; i++) {

    				     inner +=   	  '<option value="'+result[i].idx+'">'+result[i].cate_brand_cn+'</option>';
    			 	
					}
    				     inner += 	   '</select>';
    				     inner += 	 '</td>';
    				     inner += '</tr>'; 	
			}
		});	
		return inner;

 	}    
 	
	// 브랜드 저장
	function cate_submit() {

		var brand_chk = "";
		var brand_name2 = "";
		var brand_dis = "";
		var sud_name = "";
		var brand_cate_type = "";

    	brand_chk  		= 	$('input[name="brand_chk"]:checked').val();
    	brand_name2		= 	$('input[name="brand_name2"]').val();
    	brand_dis 	    = 	$('input[name="brand_dis"]').val();
    	sud_name  		= 	$('input[name="sud_name"]').val();
    	cate_logo  		= 	$('input[name="cate_logo"]').val();
    	brand_cate_type = 	$('select[name="brand_cate_type"]').val();

    	var cate_logo = document.querySelector("input[name=cate_logo]").files;
    	console.log(cate_logo);
		var formData = new FormData();
		formData.append("brand_chk", brand_chk);
		formData.append("cate_logo[]", cate_logo[0]);
// 		formData.append("cate_logo[]", cate_logo[1]);
		formData.append("brand_name2", brand_name2);
		formData.append("brand_dis", brand_dis);
		formData.append("sud_name", sud_name);
		formData.append("brand_cate_type", brand_cate_type);

		$.ajax({
			type : "POST", 
			url : "/aDmin/cate/cate_submit_cn.php",
			enctype: 'multipart/form-data',
			processData: false,
            contentType: false,
			async : false,
			data : formData, 
			error : function() 
			{
				console.log("AJAX ERROR");
			},
			success : function(data) 
			{
				console.log(data);
				var result = JSON.parse(data);
				if(result.isSuc == "success")
	    		{
	    			alert(result.msg);
	    			location.reload();
	    		}
	    		else
	    		{
	    			alert(result.msg);
	    		}
			}
		});	
	}

	// 계열사 저장
	function cate_sub_submit() {

		var sub_chk = "";
		var sub_name2 = "";
		var sub_dis = "";
		var sub_sud_name = "";
		var sub_cate_type = "";

		sub_chk  		= 	$('input[name="sub_chk"]:checked').val();
		sub_name2		= 	$('input[name="sub_name2"]').val();
		sub_dis 	    = 	$('input[name="sub_dis"]').val();
		sub_sud_name  	= 	$('input[name="sub_sud_name"]').val();
    	cate_logo_sub   = 	$('input[name="cate_logo_sub"]').val();
    	sub_cate_type   = 	$('select[name="sub_cate_type"]').val();

    	var cate_logo_sub = document.querySelector("input[name=cate_logo_sub]").files;
		var formData = new FormData();
		formData.append("sub_chk", sub_chk);
		formData.append("cate_logo_sub[]", cate_logo_sub[0]);
// 		formData.append("cate_logo[]", cate_logo[1]);
		formData.append("sub_name2", sub_name2);
		formData.append("sub_dis", sub_dis);
		formData.append("sub_sud_name", sub_sud_name);
		formData.append("sub_cate_type", sub_cate_type);

		$.ajax({
			type : "POST", 
			url : "/aDmin/cate/cate_sub_submit_cn.php",
			enctype: 'multipart/form-data',
			processData: false,
            contentType: false,
			async : false,
			data : formData, 
			error : function() 
			{
				console.log("AJAX ERROR");
			},
			success : function(data) 
			{
				console.log(data);
				var result = JSON.parse(data);
				if(result.isSuc == "success")
	    		{
	    			alert(result.msg);
	    			location.reload();
	    		}
	    		else
	    		{
	    			alert(result.msg);
	    		}
			}
		});	
	}
</script>

<div id="container" class="category">
    <div class="search">
        <p>카테고리 관리(중문)</p>
        <div class="catelist_bt">          
            <a href="javascript:cate_submit();" class="bt_cont cate_bt_add">저장</a>
        </div>
        <div class="catelist_bt">          
            <a href="javascript:cate_sub_submit();" class="bt_cont cate_bt_add">저장</a>
        </div>
    </div>
    <div class="cate_box">
        <div class="cate_add">
            <div>
                <div class="cate_tit">카테고리선택</div>
                <div>
                    <ul class="cate_check_wrap">
                        <li><input type="radio" id="cate_brand" name="during" value="" checked="checked" class="cate-radio cate_ch"><label for="cate_brand"><span>브랜드</span></label></li>
                        <li><input type="radio" id="cate_sub" name="during" value="" class="cate-radio cate_ch"><label for="cate_sub"><span>계열사</span></label></li>
                    </ul>
                </div>
              	<div class="cate_1_box on">
                    <ul id="new_ul" class="cate_check_wrap cate_check_li">
                    </ul>
                    <div class="cate_bt_wrap">
                <a href="javascript:addcate();" class="cate_bt">추가</a>
            </div>
                </div>
                <div class="cate_1_box">
                    <ul id="new_ul_sub" class="cate_check_wrap cate_check_li">
                    </ul>
                    <div class="cate_bt_wrap cate_bt_wrap_sud">
                <a href="javascript:addcate_sub();" class="cate_bt">추가</a>
            </div>
                </div>
            </div>
        </div>
        
        <!-- 브랜드 추가 -->
        <div class="cate_list_box on">
            <div class="cate_list">
                <a href="javascript:addbrand();" class="cate_bt">브랜드 추가</a>
                <table class="tablecont addbrand">
                    <colgroup>
                        <col style="width:10%">
                        <col style="width:10%">
                        <col>
                        <col style="width:20%">
                        <col style="width:20%">
                    </colgroup>
                </table>
            </div>      
        </div>
        
         <!-- 게열사 추가 -->
        <div class="cate_list_box">
            <div class="cate_list">
                <a href="javascript:addsub();" class="cate_bt">계열사 추가</a>
                <table class="tablecont addsub">
                    <colgroup>
                        <col style="width:10%">
                        <col style="width:10%">
                        <col>
                        <col style="width:20%">
                        <col style="width:20%">
                    </colgroup>
                </table>
            </div>      
        </div>   
             
        <!-- 브랜드 -->
        <div class="cate_desc_box on">
            <div class="cate_list cate_desc">  
                   <table class="tablecont addDisc">
                        <colgroup class="">
                            <col style="width:20%">
                            <col style="width:80%">
                        </colgroup>
                        <tbody>
                        </tbody>
                    </table>
            </div>      
        </div>
        
        <!-- 게열사 -->
        <div class="cate_desc_box">
            <div class="cate_list cate_desc">  
                <table class="tablecont addDisc_sub">
                      <colgroup class="">
                            <col style="width:20%">
                            <col style="width:80%">
                        </colgroup>
                        <tbody>
                        </tbody>
                </table>
            </div>      
        </div>
    </div>
</div>
<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/admin_footer.php");
?>