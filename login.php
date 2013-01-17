<?php
session_start();
include 'class/online_12.php';
include 'function/pre_deal.php';
function login_check(){
		
}
if($_POST[submit] == 'submit'){
		$username = deal($_POST[username]);
		$password = $_POST[password];
		echo "username :".$username."<br/>";
		echo "password :".$password."<br/>";
		$student = new User($username);
		
		if($username == $student -> get_username() 
		&& $student -> jiami($password) == $student -> get_password()){
			$_SESSION[username]	= $username;
			$_SESSION[password] = $password;
			$s_stat = new User_Stat($username);
			$last_login_ip = $s_stat -> get_login_ip();
			echo "last_login_ip : ".$last_login_ip."<br/>";
			$s_stat -> update_stat();
			echo "now your ip is: ".$s_stat -> get_login_ip()."<br/>";
			echo "your login time is : ".$s_stat -> get_login_count()."<br/>";
			echo "you last login_time is: ".$s_stat -> get_login_time()."<br/>";
			echo "your account 's infomation is : ".$s_stat -> get_summary()."<br/>";
			
			if($Debug){
				echo "session username = ".$_SESSION[username]."<br>";
				echo "session password = ".$_SESSION[password]."<br>";
				echo "click there to visit!"."<a href=\"index.php\">index</a>";
			}
			echo "right!<br/>";
		}else{
			echo "your username or password wrong!<br/>";
			exit;	
		}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>

<body>
<form action="login.php" method="post" id="userLoginForm" name="userLoginForm">
<p>username:
  <input name = "username" id = "username" type = "text"></input>
  </p>
<p>password:
  <input name = "password" id = "password" type = "password">
</p>
<p>
  </input>
  <input name = "submit" id = "submit" value = "submit" type = "submit">
  </input>
</p>
</input>
</form>
</body>
</html>