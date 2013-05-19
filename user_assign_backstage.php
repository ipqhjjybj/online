<?php
	session_start();
	include "class/onlineSQL.class.php";
	include "function/pre_deal.php";
	include "function/back_power.php";
	if(!isset($_GET['user_id'])){
		echo "you enter a wrong place,no such id";
		exit();
	}
	else{
		$id = $_GET['user_id'];
		$mysql_user = new OnlineSqlNew();
		$result_user = $mysql_user->select("user","id",$id);
		if($result_user->num_rows == 0){
			echo "you enter a wrong place,there is no such user in database!";
			exit();	
		}	
		$row = $result_user->fetch_object();
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
<script type="text/javascript" src="js/form_get.js"></script>
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
        <div id = "user_backstage_content">
    <form action="function/user_assign.php?<?php echo "user_id=".$row->id;?>" method="post" onSubmit="return check_users_updates()">
    
  <table width="472" border="0">
    <tr>
      <td width="87" height="26"><div class = "left_name">学号：</div></td>
      <td width="178"><input name = "school_number" id = "school_number" type = "text" onBlur="javascript:check_school_number(this,'school_number1','check_success','check_fail')"   value = "<?php echo $row->school_number;?>"/></td>
      <td width="24"><font color="red">*</font></td>
      <td width="161"><div id="school_number1" class="check_before">纯数字</div></td>
    </tr>
    <tr>
      <td><div class="left_name">用户名：</div></td>
      <td><input name = "username" id = "username" type = "text"  onBlur="javascript:check_username(this,'username1','check_success','check_fail')" value = "<?php echo $row->username;?>" /></td>
      <td><font color="red">*</font></td>
      <td><div id="username1" class="check_before">英文，数字，字母</div></td>
    </tr>
    <tr>
      <td><div class="left_name">密码：</div></td>
      <td><input name = "p_word" id = "p_word" type = "password"  onBlur="javascript:check_password(this,'password1','check_success','check_fail')" /></td>
      <td><font color="red">*</font></td>
      <td><div id="password1" class="check_before">11</div></td>
    </tr>
    <tr>
      <td> <div class="left_name">密码确认：</div></td>
      <td><input name = "passwordCheck" id = "passwordCheck" type = "password" onBlur="javascript:check_password_same(this,'password','passwordCheck1','check_success','check_fail')" /></td>
      <td><font color="red">*</font></td>
      <td><div id="passwordCheck1" class="check_before">11</div></td>
    </tr>
    <tr>
      <td><div class="left_name">真实名字:</div> </td>
      <td><input name = "realname" id = "realname" type = "text" value = "<?php echo $row->realname;?>"/></td>
      <td><font color="red">*</font></td>
      <td></td>
    </tr>
    <tr>
      <td><div class="left_name">性别: </div></td>
      <td><select name = "sex" id = "sex" type = "text">
      	<option><?php echo $row->sex;?></option>
        <option>男</option>
        <option>女</option>
      </select></td>
      <td>&nbsp;</td>
      <td></td>
    </tr>
    <tr>
      <td><div class="left_name">手机：</div> </td>
      <td><input name = "tel" id = "tel" type = "text" value = "<?php echo $row->school_number;?>" onBlur="javascript:check_tel(this,'tel1','check_success','check_fail')" /></td>
      <td><font color="red">*</font></td>
      <td><div id="tel1" class="check_before">11</div></td>
    </tr>
    <tr>
      <td><div class="left_name">QQ:</div></td>
      <td><input name = "qq" id = "qq" type = "text" value = "<?php echo $row->qq;?>" /></td>
      <td>&nbsp;</td>
      <td></td>
    </tr>
    <tr>
      <td><div class="left_name">生日:</div></td>
      <td><input name = "birthday" id = "birthday" type = "text" value = "<?php echo $row->birthday;?>"/></td>
      <td>&nbsp;</td>
      <td></td>
    </tr>
    <tr>
      <td><div class="left_name">部门:</div></td>
      <td><select name = "department" id = "department" type = "text">
        <option>
		<?php $dep_result = $mysql_user -> select("department","id",$id);
					  $dep_class_result = $mysql_user -> select("department_class","id",$dep_result->fetch_object()->department_class_id);		
					  echo $dep_class_result->fetch_object()->department_name;	
		?>
        </option>
        <?php
		$mysql = new OnlineSqlNew();
		$sql = "select * from ".$mysql->get_pre()."department_class order by id";
		$result = $mysql->sql_deal($sql);
		while($row = mysqli_fetch_assoc($result)){
			?>
        <option id = "department{<?php echo $row[id];?>}"><?php echo $row[department_name];?></option>
        <?	
		}
		$mysql -> sql_close();
    ?>
        <option>游客</option>
      </select></td>
      <td><font color="red">*</font></td>
      <td><div class="check_before">这里我们将会审核</div></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input name = "infomation_submit" id ="infomation_submit" type = "submit" value = "ready"  />
        </td>
      <td colspan="2"></td>
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