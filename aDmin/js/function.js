function isEmpty(field) {
	return (!field);
}

/* 특정 파일 업로드 */
function checkFile(f){

	var file = f.files;

	if(!/\.(gif|jpg|jpeg|png)$/i.test(file[0].name)) alert('gif, jpg, png 파일만 선택해 주세요.\n\n현재 파일 : ' + file[0].name);

	else return;
	
	f.outerHTML = f.outerHTML;
	
} 

//특수문자 유효성
function checkSpecial(str) { 
		var special_pattern = /[`~!@#$%^&*|\\\'\";:\/?]/gi; 
		if(special_pattern.test(str) == true) { 
			return true; 
		} else {
			return false; 
		} 
}

//숫자 유효성
function isNotNumber(field){
	return isNaN(field);
}

function containsHS(field) {
	var str = "@_.123456890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM";
	for (var i = 0; i < field.length; i++) {
		if (str.indexOf(field[i]) == -1) {
			return true;
		}
	}
	return false;
}


function containsNum(field) {
	var numflag=false;
	for (var i = 0; i < field.length; i++) {
		if (!isNaN(field[i])) {
			numflag = true;
		}
	}
	return numflag;
}


function get_label(fld) {
	var id = fld;
	var labels = document.getElementsByTagName('label');
	var el = null;
	var text = '';
	for (i = 0; i < labels.length; i++) {
		if (id == labels[i].htmlFor) {
			el = labels[i];
			break;
		}
	}
	if (el != null) {
		text = el.innerHTML;
	}
	return text;
}
function excuteEnter(excuteFunc)
{
	if(event.keyCode == 13){
		excuteFunc();
		return;
	}
}
function lengthCheck(val, max)
{
	var len = $("#"+val).val().length;
	$("#"+val+"_length").html(len+"/"+max+"자");
}
function nullChk(d)
{
	if(d == "" || d == null || d == 'null' || d == undefined)
	{
		return "";
	}
	else
	{
		return d;
	}
}
var setCookie = function(name, value, exp) 
{
	var date = new Date();
	date.setTime(date.getTime() + exp*24*60*60*1000);
	document.cookie = name + '=' + value + ';expires=' + date.toUTCString() + ';path=/';
};
var getCookie = function(name) 
{
	var value = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)');
	return value? value[2] : null;
};
function trim(stringToTrim) {
    return nullChk(stringToTrim).toString().replace(/^\s+|\s+$/g,"");
}
function cutDate(dd)
{
	if(dd == "" || dd == null || dd == 'null' || dd == undefined)
	{
		return "";
	}
	else
	{
		if(trim(dd).length == 6)
		{
			var year = dd.substring(0,4);
			var month = dd.substring(4,6);
			return year+"-"+month;
		}
		else if(trim(dd).length == 8)
		{
			var year = dd.substring(0,4);
			var month = dd.substring(4,6);
			var day = dd.substring(6,8);
			return year+"-"+month+"-"+day;
		}
		else if(trim(dd).length == 14)
		{
			var year = dd.substring(0,4);
			var month = dd.substring(4,6);
			var day = dd.substring(6,8);
			var hour = dd.substring(8,10);
			var min = dd.substring(10,12);
			var sec = dd.substring(12,14);
			return year+"-"+month+"-"+day;
//			+" "+hour+":"+min+":"+sec;
		}
		else
		{
			return dd;
		}
	}
}
function comma(x) {
    return nullChkZero(x).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
function nullChkZero(d)
{
	if(d == "" || d == null || d == 'null' || d == undefined)
	{
		return "0";
	}
	else
	{
		var ret = d.toString().replace(/,/gi, ""); 
		return ret;
	}
}
function repWord(dd)
{
	dd = dd.replace(/&amt;/gi, "&");
	dd = dd.replace(/&lt;/gi, "<");
	dd = dd.replace(/&gt;/gi, ">");
	dd = dd.replace(/&quot;/gi, "\"");
	dd = dd.replace(/&#039;/gi, "\'");
	dd = dd.replace(/<br>/gi, "\n");
	
	return dd;
	
}

//문자열 검색해서 중간 글자 *로 만들기
//2글자면 마지막 글자만
function repName(dd) {
	if (dd.length > 2) {
	 var originName = dd.split('');
	 originName.forEach(function(name, i) {
	   if (i === 0 || i === originName.length - 1) 
		   return; originName[i] = '*';
	 });
	 var joinName = originName.join();
	 return joinName.replace(/,/g, '');
	} else {
	 var pattern = /.$/; // 정규식
	 return dd.replace(pattern, '*');
	}
};

//마스킹 처리 (이메일)
function repEmail(dd) {
	
	var len = dd.split('@')[0].length-4 ;  // das****@gmail.com
	
	dd = dd.replace(new RegExp('.(?=.{0,' + len + '}@)', 'g'), '*');

	return dd;
	
}
// 마스킹 처리 (핸드폰번호) 
function repTel(dd) {
	
	dd = dd.replace(/(\d{3})(\d{4})(\d{4})/gi,'$1****$3');
	
	return dd;
}

//마스킹 처리 (핸드폰번호) 
function repTel2(dd) {
	
	dd = dd.replace(/(\d{3})-(\d{4})-(\d{4})/gi,'$1****$3');
	
	return dd;
}


