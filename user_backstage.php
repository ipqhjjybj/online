<?php
	session_start();
	include "class/onlineSQL.class.php";
	include "function/pre_deal.php";
	include "function/back_power.php";
	include "class/PageMS.class.php";
	if(isset($_GET['user_id'])){
		$id = $_GET['user_id'];
		$mysql = new OnlineSqlNew();
		$result = $mysql->select("user","id",$id);
		if($result->num_rows == 0){
			echo "you enter a wrong place user_id";
			exit();	
		}	
	}
	
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
    <?php
		$sql = "select * from ".OnlineSqlNew::pre."user";
		$page = new PageMS($sql,5);
		$result = $page -> mysql -> sql_deal($page->sqlquery());
		
		while($info = $result -> fetch_object()){
			?>
            	<div id = "user_id<?php echo $info->id;?>" class = "user_display">
                	
                    <div class = "user_info">
                    <span><a href="user_display.php?user_id=<?php echo $info->id;?>"><?php echo $info->username;?></a></span>--------<?php echo $info->realname;?>-----------------------
					<strong><a href="user_assign_backstage.php?user_id=<?php echo $info->id;?>">[修改]</a></strong>
                    <strong><a href="function/user_deleted.php?user_id=<?php echo $info->id;?>">[删除]</a></strong>
                    </div>
                </div>
			<?
		}
        	?>
            <div id = "page_display">
            <?php
				echo $page->set_page_info();
				$page -> mysql -> sql_close();
			?>
            </div>
            <?
		?>
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