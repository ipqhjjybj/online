<?php
session_start();
include 'class/online_12.php';
include 'function/pre_deal.php';
if($_SESSION[username] && $_SESSION[password]){
	echo "your username is".$_SESSION[username]."<br/>".
		 "your password is".$_SESSION[password]."<br/>";	
}
else{
	echo "please login first<br/>";
	exit;	
}

if($_POST[creat] == 'creat'){
	$dep_name = deal($_POST[dep_name]);
	$dep_time = deal($_POST[dep_time]);
	$dep_c_name = deal($_SESSION[username]);
	$dep_pri_name = deal($_POST[principal_name]);
	$dep_summary = deal($_POST[d_summary]);
	if($Debug){
		echo "dep_name : ".$dep_name."<br/>";
		echo "dep_time : ".$dep_time."<br/>";
		echo "dep_c_name : ".$dep_c_name."<br/>";
		echo "dep_pri_name : ".$dep_pri_name."<br/>";
		echo "dep_summary : ".$dep_summary."<br/>";	
	}
	if($Debug){
		$department = new Department_Created($dep_name,$dep_time,$dep_c_name,$dep_pri_name,$dep_summary);
		$dep_name = $department -> get_department_name();
		$dep_time = $department -> get_set_time();
		$dep_c_name = $department -> get_set_person_name();
		$dep_pri_name = $department -> get_principal_name();
		$dep_summary = $department -> get_summary();	
	
		echo "dep_name : ".$dep_name."<br/>";
		echo "dep_time : ".$dep_time."<br/>";
		echo "dep_c_name : ".$dep_c_name."<br/>";
		echo "dep_pri_name : ".$dep_pri_name."<br/>";
		echo "dep_summary : ".$dep_summary."<br/>";	
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
<form action = "dep_man.php" method = "post" id = "dep_man_creat" name = "dep_man_creat">
部门名字<input name = "dep_name" id = "dep_name" type = "text"></input>
部门创立时间<input name = "dep_time" id = "dep_time" type = "text"></input>
部门创立人用户名<input name = "dep_c_name" id = "dep_c_name" type = "text" value = "<?=$_SESSION[username]?>" disabled = "true"></input>
部门负责人<input name = "principal_name" id = "principal_name" type = "text" ></input>
部门描述<input name = "d_summary" id = "d_summary" type = "text"></input>
<input name = "creat" id = "creat" value = "creat" type = "submit"></input>
</form>
</body>
</html>