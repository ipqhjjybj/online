<?php
	session_start();
	include "class/onlineSQL.class.php";
	include "function/pre_deal.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--不进行缓存设置--> 
<meta http-equiv="pragma" content="no-cache" />
<meta http-equiv="Cache-Control" content="no-cache,must-revalidate" /> 
<meta http-equiv="expires" content="Wed,26 Feb 1997 08:21:57 GMT" /> 

<link href="css/basic.css" rel="stylesheet" type="text/css" />


<title>register</title>
</head>

<body>
<div id = "out" align="center">
	<?php
		include 'header.php';
	?>
    <div id = "content">
    	<?php
			do_mid_sign();
		?>
    	以后如果社团出了一些其他的应用。可以在这里链接过去。如云传送之类的。。。。。。当然只是个想法
    </div>
  
  	<?php
		do_footer();
	?>
    
</div>
<script type="text/javascript" src="js/jquery-1.9.0.js"></script>
<script type="text/javascript" src="js/js_include.js"></script>

<script type="text/javascript" src="js/form_get.js"></script>
<script type="text/javascript" src="js/js_onchange.js"></script>
<script type="text/javascript" src="js/public_func.js"></script>
<script language="javascript">
var username = document.getElementById("username");
var c_empty = function(){this.value = "";this.style.color="black";EventUtil.removeHandler(this,"click",c_empty);};
EventUtil.addHandler(username,"click",c_empty);
var func = function(){
	var str = this.src;
	var arr = str.split(".",2);
	if(str.indexOf("1") == -1){
		var now = arr[0]+"1"+"."+arr[1];
		this.src = now;
	}else{
		var now = arr[0].slice(0,arr[0].indexOf("."))+"."+arr[1];
		this.src = now;	
	}
};
for(var i = 1;i <= 6;i++){
	var obj = document.getElementById("picture"+i);
	EventUtil.addHandler(obj,"mouseover",func);	
}
</script>
</body>
</html>