<?php
	session_start();
	include "class/onlineSQL.class.php";
	include "function/pre_deal.php";
	include "function/back_power.php";
	if(!isset($_GET['news_id'])){
		echo "you enter a wrong place,no such id";
		exit();
	}
	else{
		$id = $_GET['news_id'];
		$mysql = new OnlineSqlNew();
		$result = $mysql->select("news","id",$id);
		if($result->num_rows == 0){
			echo "you enter a wrong place,there is no such news in database!";
			exit();	
		}	
		$row = $result->fetch_object();
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
    <form action="function/news_assign.php?<?php echo "news_id=".$row->id;?>" method="post" onSubmit="return check_news()">
    <table width="883" border="0">
      <tr>
        <td width="37">标题</td>
        <td colspan="2"><textarea name="title" id= "title" type="text"><?php echo $row->title;?></textarea></td>
        <td width="115">不能为空哦</td>
      </tr>
      <tr>
        <td>内容</td>
        <td colspan="2"><textarea id="editor_id" name="editor_id" cols="100" rows="10"><?php echo $row->content;?></textarea></td>
        <td>不能为空哦</td>
      </tr>
      <tr>
        <td height="35">概要</td>
        <td colspan="2"><textarea id="news_summary" name = "news_summary"><?php echo $row->summary;?></textarea></td>
        <td>不要为空哦</td>
      </tr>
      <tr>
        <td>时间</td>
        <td colspan="2"><textarea type = "text" id="news_time" name = "news_time" ><?php echo $row->set_time?></textarea></td>
        <td>不要为空哦</td>
      </tr>
      <tr>
        <td>类别</td>
        <td><select name = "n_classy" id = "nclassy" type = "text">
        <option><?php $res = $mysql->select("news_class","id",$row->news_class_id);
					  echo $res->fetch_object()->class_name;?></option>
        <?php
		$sql = "select * from ".$mysql->get_pre()."news_class order by id";
		$result2 = $mysql->sql_deal($sql);
		while($row = mysqli_fetch_assoc($result2)){
			?>
        <option value = "<?php echo $row[class_name];?>"><?php echo $row[class_name];?></option>
        <?	
		}
		$mysql -> sql_close();
   		?>
      	</select>
     	</td>
        <td>&nbsp;</td>
        <td>额。请选择啦</td>
      </tr>
      <tr>
        <td>提交</td>
        <td width="138"><input type = "submit" id = "news_submit" name = "news_submit" value="submit"></input></td>
        <td width="575">&nbsp;</td>
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