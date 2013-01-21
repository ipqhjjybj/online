<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="css/basic.css" rel="stylesheet" type="text/css" />
<script language="javascript">

</script>
<title>注册页面</title>
</head>

<body>
<div id = "out" align="center">
	<div id = "login_id" style="position:absolute;left:expression(self.document.body.clientWidth / 2 - this.clientWidth / 2 )">
	<form id = "login">
    		<input name = "username" type = "text" class = "u_name" id = "username" value = "12号字体"></input>
    	    <input name = "password" id = "password" class = "p_word" type = "password" ></input>
   <input name = "submit" id = "submit" class = "submit" type = "submit" ></input>
            </form>
     <div id = "showtime">aaaaa</div>
         <input name = "reg" id = "reg" class = "reg" type = "text"> </input>

	</div>
	<div id = "logo">
    	
	</div>
    <div id = "content">
    <p>学号：
  <input name = "school_number" id = "school_number" type = "text">
</p>
<p>
    </input>
  用户名：<input name = "username" id = "username" type = "text"></input>
  </p>
<p>密码：
  <input name = "password" id = "password" type = "password">
</p>
<p>
    </input>
  密码确认：<input name = "passwordCheck" id = "passwordCheck" type = "password">
</p>
<p>
    </input>
  真实名字:<input name = "realname" id = "realname" type = "text">
</p>
<p>
    </input>
  性别: <input name = "sex" id = "sex" type = "text">
</p>
<p>
    </input>
  手机：<input name = "tel" id = "tel" type = "text"></input>
  </p>
<p>QQ：
  <input name = "qq" id = "qq" type = "text"></input>
  </p>
<p>生日:
  <input name = "birthday" id = "birthday" type = "text">
</p>
<p>
    </input>
  部门:<input name = "department" id = "department" type = "text"></input>
  </p>
<p>提交：
  <input name = "infomation_submit" id ="infomation_submit" type = "submit" value = "ready">
</p> 
    </div>
    <div id = "footer">
    
    </div>
</div>
<script language="javascript">

var EventUtil = {
	addHandler:function(element,type,handler){
		if(element.addEventListener){
			element.addEventListener(type,handler,false);	
		}else if(element.attachEvent){
			element.attachEvent("on" + type,handler);	
		}else{
			element["on"+type] = handler;	
		}
	},
	getEvent:function(event){
		return event ? event:window.event;
	},
	getTarget:function(event){
		return event.target||event.srcElement;
	},
	getButton:function(event){
		if(document.implementation.hasFeature("MouseEvents","2.0")){
			return event.button;	
		}else{
			switch(event.button){
				case 0:
				case 1:
				case 3:
				case 5:
				case 7:
					return 0;
				case 2:
				case 6:
					return 2;
				case 4:
					return 1;
			}
		}	
	},
	preventDefault: function(event){
		if(event.preventDefault){
			event.preventDefault();	
		}else{
			event.returnValue = false;	
		}	
	},
	getCharCode: function(event){
		if(typeof event.charCode == "number"){
			return event.charCode;	
		}else{
			return event.keyCode;	
		}
	},
	removeHandler:function(element,type,handler){
		if(element.removeEventListener){
			element.removeEventListener(type,handler,false);	
		}else if(element.detachEvent){
			element.detachEvent("on" + type,handler);	
		}else{
			element["on" + type] = null;	
		}
	},
	stopPropagation: function(event){
		if(event.stopPropagation){
			event.stopPropagation();
		}else{
			event.cancelBubble = true;	
		}
	}
};
/**
 *     处理浏览器event事件兼容
 *     btn.onclick = function(event){
 *	 		event = EventUtil.getEvent(event);
 *	   }
 */
var u_login = document.getElementById("username");
var p_login = document.getElementById("password");
var c_empty = function(){this.value = " ";EventUtil.removeHandler(u_login,"click",c_empty);};

EventUtil.addHandler(u_login,"click",c_empty);



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
var btn = document.getElementById("submit");	

function login_func(){
	var u_name = document.getElementById("username").value;
	var p_word = document.getElementById("password").value;	
	var params = "username="+u_name+"&password="+p_word;
	alert("params"+params);
	makePostRequest("login.php",params,login_handy);	
}
function login_handy(){
		alert("login_handy");
		if(xhr.readyState == 4){
			if((xhr.status >= 200 && xhr.status < 300) || xhr.status == 304){
							alert(33333);
				alert(xhr.responseText);	
	
			}else{
				alert("Request was unsuccessful: "+ xhr.status);	
			}
		}else{
			document.getElementById("showtime").innerHTML = '<img src = image/ajax-loading.gif/>';
			alert(xhr.readyStage);	
		}
}
function makePostRequest(url,params,handler){
	alert(1);
	var xhr = createXHR();
	alert(xhr);
	xhr.open("post",url,true);
	xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	xhr.setRequestHeader("Content-length",params.length);
	xhr.setRequestHeader("Connection","close");
	xhr.onreadystatechange = handler;	
	xhr.send(params);
}
EventUtil.addHandler(btn,"click",login_func);


var thePage = "login.php";
function addURLParam(url,name,value){
	url += (url.indexOf("?") == -1 ? "?" : "&");
	url += encodeURIComponent(name) + "=" + encodeURIComponent(value);
	return url;	
}
function getfunc(url,handler){
	var myReq = getXMLHTTPRequest();
	var myRand = parseInt(Math.random() * 99999999999999);
	url = addURLParam(url,"rand",myRand);
	myReq.open("GET",url,true);
	myReq.onreadystatechange = handler;
	myReq.send(null);
}

/**
	一下专门为此页面设计
 */
var myLogin = getXMLHTTPRequest();
var thePage = "php/login.php";
 
/**
 * 	到此结束
 */
</script>
</body>

</html>
