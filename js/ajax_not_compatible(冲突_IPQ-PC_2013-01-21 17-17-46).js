/**
 * 创建一个XML对象
 */
function getXMLHTTPRequest(){
	var req = false;
	try{
		req = new XMLHttpRequest();	
	}catch(err){
		try{
			req = new ActiveXObject("Msxm12.XMLHTTP");	
		}catch(err){
			try{
				req = new ActiveXObject("Microsoft.XMLHTPP");	
			}catch(err){
				req = false;	
			}
		}
	}
	return req;
}
/**
 * 创建一个Xml对象
 */
function createXHR(){
	if(typeof XMLHttpRequest != "undefined"){
		return new XMLHttpRequest();	
	}else if(typeof ActiveXObject() != "undefined"){
		if(typeof arguments.callee.activeXString != "string"){
			var versions = ["MSXML2.XMLHttp.6.0", "MSXML2.XMLHttp.3.0","MSXML2.XMLHttp"];
			for(var i = 0,len = versions.length;i < len;i++){
				try{
					var xhr = new ActiveXObject(versions[i]);
					arguments.callee.activeXString = versions[i];
					return xhr;	
				}catch(ex){
					//跳过	
				}
			}	
		}
		return new ActiveXObject(arguments.callee.activeXString);
	}else{
		throw new Error("No XHR object available.");	
	}	
}
/**
 * 实现按钮按下，则与php/login.php交互
 */
var btn = document.getElementById("submit");	

function login_func(){
	var u_name = document.getElementById("username").value;
	var p_word = document.getElementById("password").value;	
	var params = "username="+u_name+"&password="+p_word;
	alert("params: "+params);
	makePostRequest("php/login.php",params,login_handy);	
}
function login_handy(xhr){
		alert("login_handy");
		alert("xhr.readyState");
		alert(typeof xhr.readyState);
		alert(xhr.readyState);
		alert("status");
		alert(typeof xhr.status);
		alert(xhr.status);
		if(xhr.readyState == 4){
			if((xhr.status >= 200 && xhr.status < 300) || xhr.status == 304){
						
				alert(xhr.responseText);	
	
			}else{
				alert("Request was unsuccessful: "+ xhr.status);	
			}
		}else{
			document.getElementById("showtime").innerHTML = '<img src = "image/ajax_loading.gif"/>'; 
			alert(xhr.readyStage);	
		}
}

function makePostRequest(url,params,handler){
	alert(1);
	var xhr = createXHR();
	alert(xhr);
	xhr.open("post",url,true);
	xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//xhr.setRequestHeader("Content-length",params.length);
	//xhr.setRequestHeader("Connection","close");
	xhr.onreadystatechange = function(){
		alert("login_handy");
		alert("xhr.readyState");
		alert(typeof xhr.readyState);
		alert(xhr.readyState);
		alert("status");
		alert(typeof xhr.status);
		alert(xhr.status);
		if(xhr.readyState == 4){
			if((xhr.status >= 200 && xhr.status < 300) || xhr.status == 304){
						
				alert(xhr.responseText);	
	
			}else{
				alert("Request was unsuccessful: "+ xhr.status);	
			}
		}else{
			document.getElementById("showtime").innerHTML = '<img src = "image/ajax_loading.gif"/>'; 
			alert(xhr.readyStage);	
		}
};	
	xhr.send(params);
}
EventUtil.addHandler(btn,"click",login_func);   //func2_login  login_func

/**
 * 下面为GET方法实现页面的交互
 */
function addURLParam(url,name,value){
	url += (url.indexOf("?") == -1 ? "?" : "&");
	url += encodeURIComponent(name) + "=" + encodeURIComponent(value);
	return url;	
}
function makeGetRequest(url,handler){
	var xhr = createXHR();
	var myRand = parseInt(Math.random() * 99999999999999);
	url = addURLParam(url,"rand",myRand);
	xhr.open("GET",url,true);
	xhr.onreadystatechange = function(){
		alert("handy");
		alert("xhr.readyState");
		alert(typeof xhr.readyState);
		alert(xhr.readyState);
		alert("status");
		alert(typeof xhr.status);
		alert(xhr.status);
		if(xhr.readyState == 4){
			if((xhr.status >= 200 && xhr.status < 300) || xhr.status == 304){
						
				alert(xhr.responseText);	
	
			}else{
				alert("Request was unsuccessful: "+ xhr.status);	
			}
		}else{
			document.getElementById("showtime").innerHTML = '<img src = "image/ajax_loading.gif"/>'; 
			alert(xhr.readyStage);	
		}
	};
	xhr.send(null);
}
function func2_login(){
	var u_name = document.getElementById("username").value;
	var p_word = document.getElementById("password").value;
	var url = "php/login.php";
	url = addURLParam(url,"username",u_name);
	url = addURLParam(url,"password",p_word);
	makeGetRequest(url,login_handy);
}