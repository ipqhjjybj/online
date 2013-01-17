<?php
session_start();
include 'class/online_12.php';

include 'function/pre_deal.php'; // function deal()

if($_SESSION[username] && $_SESSION[password]){
	echo "your username is".$_SESSION[username]."<br/>".
		 "your password is".$_SESSION[password]."<br/>";	
}
else{
	echo "please login first<br/>";
	exit;	
}

if($_POST['infomation_submit'] == 'ready1')
{
	    
		$school_number = deal($_POST[school_number]);
		$old_password = $_POST[old_password];
		$new_password = $_POST[new_password];
		$check_password = $_POST[check_password];
		if($new_password != $check_password){
			echo "password wrong,please check it!<br/>";
			exit;	
		}
		$sex=deal($_POST[sex]);
		$tel=deal($_POST[tel]);
		$qq=deal($_POST[qq]);
		$birthday=deal($_POST[birthday]);
		$realname=deal($_POST[realname]);
		$department=deal($_POST[department]);
		
		$student = new User_Information_Edit($_SESSION[username]);
		
		$school_number = $student -> school_number_update($school_number);
		$change_password = $student -> password_update($new_password,$old_password);
		$sex= $student -> sex_update($sex);
		$tel= $student -> tel_update($tel);
		$qq= $student -> qq_update($qq);
		$birthday= $student -> birthday_update($birthday);
		$realname= $student -> realname_update($realname);
		$department= $student -> department_update($department);
		if($Debug){
			echo "school_number is :".$school_number."<br/>";
			echo "password is :".$change_password."<br/>";
			echo "sex is :".$sex."<br/>";
			echo "tel is :".$tel."<br/>";
			echo "qq is :".$qq."<br/>";
			echo "birthday is :".$birthday."<br/>";
			echo "realname is :".$realname."<br/>";
			echo "realname is :".$realname."<br/>";
			echo "department is :".$department."<br/>";
			
			$school_number = $student -> get_school_number();
			$change_password = $student -> get_password();
			$sex= $student -> get_sex();
			$tel= $student -> get_tel();
			$qq= $student -> get_qq();
			$birthday= $student -> get_birthday();
			$realname= $student -> get_realname();
			$department= $student -> get_department();
			echo "school_number is :".$school_number."<br/>";
			echo "password is :".$change_password."<br/>";
			echo "sex is :".$sex."<br/>";
			echo "tel is :".$tel."<br/>";
			echo "qq is :".$qq."<br/>";
			echo "birthday is :".$birthday."<br/>";
			echo "realname is :".$realname."<br/>";
			echo "realname is :".$realname."<br/>";
			echo "department is :".$department."<br/>";
		}
		$_SESSION[username] = $student -> get_username;
		$_SESSION[password] = $student -> get_password;
		$student -> db -> close();
}		
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>无标题文档</title>
</head>

<body>
<form action="infomation_change.php" method = "post" name = "infomation" onsubmit = "return onsubmit()">
<p>修改学号：
  <input name = "school_number" id = "school_number" type = "text"></input>
</p>
<p>修改生日：
  <input name = "birthday" id = "birthday" type = "text"></input>
  </p>
<p>用户名：
  <input name = "username" id = "username" type = "text" value = "<?=$_SESSION[username]?>" disabled = "true"></input>
  </p>
<p>性别:
  <input name = "sex" id = "sex" type = "text">
</p>
<p>
    </input>
  手机：<input name = "tel" id = "tel" type = "text"></input>
  </p>
<p>部门:
  <input name = "department" id = "department" type = "text"></input>
  </p>
<p>真实名字:  
  <input name = "realname" id = "realname" type = "text">
  </input></p>
qq:
<input name = "qq" id = "qq" type = "text">
</input>
<p>修改密码:</p>
<p>old_password:
  <input name = "old_password" id = "old_password" type = "password"></input>
</p>
<p>to what?
  <input name = "new_password" id = "new_password" type = "password"></input>
  提交：</p>
 check:
 <input name = "check_password" id = "check_password" type = "password"></input>
<p>
  <input name = "infomation_submit" id ="infomation_submit" type = "submit" value = "ready1">
</p> 
</input>
</form>
</body>
</html>