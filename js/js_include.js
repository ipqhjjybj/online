// JavaScript Documentvar 
EventUtil = {
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