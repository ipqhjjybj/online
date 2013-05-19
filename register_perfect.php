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

<script type="text/javascript" src="js/form_check.js"></script>

<title>register</title>
</head>

<body>
<div id = "out" align="center">
	<?php
		include "header.php";
	?>
    <div id = "content">
    <?php
	if(is_login()){
		echo 'you had already login!please click <a href="index_perfect.php">here</a>!';
	}
	else{
		
?>
<form action = "function/user_insert.php" method = "post" name = "register" id = "register" onSubmit="return check_all()">
 
  <table width="472" border="0">
    <tr>
      <td width="87" height="26"><div class = "left_name">学号：</div></td>
      <td colspan="2"><input name = "school_number" id = "school_number" type = "text" onBlur="javascript:check_school_number(this,'school_number1','check_success','check_fail')"   /></td>
      <td width="24"><font color="red">*</font></td>
      <td width="161"><div id="school_number1" class="check_before">纯数字</div></td>
    </tr>
    <tr>
      <td><div class="left_name">用户名：</div></td>
      <td colspan="2"><input name = "username" id = "username" type = "text"  onBlur="javascript:check_username(this,'username1','check_success','check_fail')"  /></td>
      <td><font color="red">*</font></td>
      <td><div id="username1" class="check_before">英文，数字，字母</div></td>
    </tr>
    <tr>
      <td><div class="left_name">密码：</div></td>
      <td colspan="2"><input name = "password" id = "password" type = "password"  onBlur="javascript:check_password(this,'password1','check_success','check_fail')" /></td>
      <td><font color="red">*</font></td>
      <td><div id="password1" class="check_before">11</div></td>
    </tr>
    <tr>
      <td> <div class="left_name">密码确认：</div></td>
      <td colspan="2"><input name = "passwordCheck" id = "passwordCheck" type = "password" onBlur="javascript:check_password_same(this,'password','passwordCheck1','check_success','check_fail')" /></td>
      <td><font color="red">*</font></td>
      <td><div id="passwordCheck1" class="check_before">11</div></td>
    </tr>
    <tr>
      <td><div class="left_name">真实名字:</div> </td>
      <td colspan="2"><input name = "realname" id = "realname" type = "text" /></td>
      <td><font color="red">*</font></td>
      <td></td>
    </tr>
    <tr>
      <td><div class="left_name">性别: </div></td>
      <td colspan="2"><select name = "sex" id = "sex" type = "text">
        <option>男</option>
        <option>女</option>
      </select></td>
      <td>&nbsp;</td>
      <td></td>
    </tr>
    <tr>
      <td><div class="left_name">手机：</div> </td>
      <td colspan="2"><input name = "tel" id = "tel" type = "text"  onBlur="javascript:check_tel(this,'tel1','check_success','check_fail')" /></td>
      <td><font color="red">*</font></td>
      <td><div id="tel1" class="check_before">11</div></td>
    </tr>
    <tr>
      <td><div class="left_name">QQ:</div></td>
      <td colspan="2"><input name = "qq" id = "qq" type = "text" /></td>
      <td>&nbsp;</td>
      <td></td>
    </tr>
    <tr>
      <td><div class="left_name">生日:</div></td>
      <td colspan="2"><input name = "birthday" id = "birthday" type = "text" /></td>
      <td>&nbsp;</td>
      <td></td>
    </tr>
    <tr>
      <td><div class="left_name">部门:</div></td>
      <td colspan="2"><select name = "department" id = "department" type = "text">
        <option>请选择部门</option>
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
      <td><div class="left_name">验证码:</div></td>
      <td width="73"><input name = "captcha_id" id = "captcha_id" type="text" size = "8" align="absmiddle" onBlur="javascript:check_captcha(this,'captcha_id1','check_success','check_fail')"/></td>
      <td width="105"><img id = "captcha" height = "30px" src="captcha.php?<?php echo rand();?>"/></td>
      <td><font color="red">*</font></td>
      <td ><div class="check_before" id = "captcha_id1">必须的哦</div></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2"><input name = "infomation_submit" id ="infomation_submit" type = "submit" value = "ready"  />
      </td>
        <td colspan="2"></td>
    </tr>
  </table>
</form>
	<?
    }
?>
  </div>
    <?php
		do_footer();
	?>
</div>
<script type="text/javascript" src="js/jquery-1.9.0.js"></script>
<script type="text/javascript" src="js/js_include.js"></script>

<script type="text/javascript" src="js/form_get.js"></script>
<script type="text/javascript" src="js/js_onchange.js"></script>
<script language="javascript">
var username = document.getElementById("username");
var c_empty = function(){this.value = "";this.style.color="black";EventUtil.removeHandler(this,"click",c_empty);};
EventUtil.addHandler(username,"click",c_empty);
var new_click = function(){this.src = "captcha.php?"+Math.random();};
var captcha = document.getElementById("captcha");
EventUtil.addHandler(captcha,"click",new_click);
</script>
</body>
</html>