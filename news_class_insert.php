<?php
	session_start();
	include_once "class/onlineSQL.class.php";
	include "function/pre_deal.php";
	include "function/back_power.php";

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
<link href="kindeditor/themes/default/default.css" rel="stylesheet" />
<script charset="utf-8" src="kindeditor/kindeditor-min.js"></script>
<script charset="utf-8" src="kindeditor/lang/en.js"></script>
<script>
    KindEditor.ready(function(K) {
        window.editor = K.create('#editor_id', {
            langType : 'en'
        });
    });
</script>
<title>backstage</title>
</head>


<body>
<div id = "out" align="center">
	<?php
		include 'header.php';
	?>
    <?php
		include 'backmenu.php';
	?>
    <div id = "content">
    	<div id = "cur_position">
        	当前位置:后台主页   
        </div>
        <div id = "news_backstage_content">
    <form action="function/news_class_insert.php" method="post" onSubmit="return check_class_news()">
    <table width="883" border="0">
      <tr>
        <td width="37">类名</td>
        <td colspan="2"><textarea name="title" id= "title" type="text"></textarea></td>
        <td width="90">不能为空哦</td>
      </tr>
      <tr>
        <td><p>注释</p>
          <p>功能概要</p></td>
        <td colspan="2"><textarea id="editor_id" name="editor_id" cols="100" rows="10"></textarea></td>
        <td>不能为空哦</td>
      </tr>
      <tr>
        <td>提交</td>
        <td width="123"><input type = "submit" id = "news_submit" name = "news_submit" value="submit"></input></td>
        <td width="615">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
    </form>
    <button id = "check" name = "check" ></button>
        </div>
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

var func_editor = function(){
var html = editor.html();
alert(html);
editor.sync();
html = document.getElementById('editor_id').value;
alert(html);
editor.html('HTML code');
alert(editor.html());
};
var check = document.getElementById("check");
EventUtil.addHandler(check,"click",func_editor);
</script>
</body>
</html>