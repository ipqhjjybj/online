<?php
function do_header($title){
	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>'.$title.'</title>
</head>

<body>';	
}
function do_footer(){
	echo '</body>
</html>';	
}
	  do_header("exm");
	  $database = "exm";		//数据库名称
	  $host = "localhost";		//主机地址
	  $mysql_user = "root";		//数据库连接时的用户名
	  $mysql_password = "86458043";	//数据库连接时的密码
	  $db = new mysqli($host,$mysql_user
									 ,$mysql_password,$database);
	  $db -> query("SET NAMES UTF8");
	  $sql = "insert into ex values('"."沈卓亨"."')";
	  echo $sql."<br/>";
	  $db -> query($sql);
	  do_footer();
?>