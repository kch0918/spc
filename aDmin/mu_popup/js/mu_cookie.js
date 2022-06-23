const setCookie = function(id, val, day){
	if(!parseInt(day)){
		return false;
	}
	day = parseInt(day);
	const expire = day * 24 * 60 * 60 * 1000; 
	const date = new Date();
	date.setTime(date.getTime() + expire);
	const expires = date.toUTCString();
	document.cookie = id+val + '=' + val + ';expires=' + expires + ';path=/';
}
const getCookieCnt = function(){
	return document.cookie.split(";").length;
}

var getCookie = function(name) 
{
	var value = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)');
	return value? value[2] : null;
};

const delCookie = function(id){
	const date = new Date();
	const expires = date.toUTCString();
	document.cookie = id + "=;" + "expires=" + expires + ";path=/";
}