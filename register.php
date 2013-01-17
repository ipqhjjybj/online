<?php
session_start();
include 'class/online_12.php';
if($_SESSION[username] && $_SESSION[password]){
	echo "your username is".$_SESSION[username]."<br/>".
		 "your password is".$_SESSION[password]."<br/>";	
}
function check()             //未实现的check功能
{
		return 1;	
}
include 'function/pre_deal.php'; // function deal()
if($_POST['infomation_submit'] == "ready")
{
	do_header("debug now");
			 $school_number = deal($_POST[school_number]);
			 echo "school_number: ".$school_number."<br/>";
			 $username=deal($_POST[username]);
			 echo "username: ".$username."<br/>";
			 $password=$_POST[password];           // not deal
			 echo "password: ".$password."<br/>";
			 $sex=deal($_POST[sex]);
			 echo "sex: ".$sex."<br/>";
			 $tel=deal($_POST[tel]);
			 echo "tel: ".$tel."<br/>";
			 $qq=deal($_POST[qq]);
			 echo "qq: ".$qq."<br/>";
			 $birthday=deal($_POST[birthday]);
			 echo "birthday".$birthday."<br/>";
			 $realname=deal($_POST[realname]);
			 echo "realname".$realname."<br/>";
			 $department=deal($_POST[department]);
			 echo "department: ".$department."<br/>";
	 if(check()){                     // 如果检查合格     , 检查也可以由JS 或AJAX 完成 
			 $student = new User_Created($school_number,$username,$password,$sex,$tel,$qq,$birthday,$realname,$department);
			 $_SESSION[username] = $student -> get_username();
			 $_SESSION[password] = $student -> get_password();
			 echo $_SESSION[username]."<br/>".$_SESSION[password];
	 }
	do_footer();
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>

<body>
<form action = "register.php" method = "post" name = "infomation" onsubmit = "return onsubmit()">
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
</input>
</form>
</body>
</html>