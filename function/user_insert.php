<?php
	session_start();
	include "../function/pre_deal.php";
	include "../class/onlineSQL.class.php";
if($_POST['infomation_submit'] == "ready")
{
			 $mysql = new OnlineSqlNew();
			 $school_number = deal($_POST[school_number]);
			 $username=deal($_POST[username]);
			 $password=$_POST[password];           // not deal
			 $password=$mysql->jiami($password);
			 $sex=deal($_POST[sex]);
			 $tel=deal($_POST[tel]);
			 $qq=deal($_POST[qq]);
			 $birthday=deal($_POST[birthday]);
			 $realname=deal($_POST[realname]);
			 $department=deal($_POST[department]);
			 $id = NULL;
			 $student = array($id,$school_number,$username,$password,$sex,$tel,$qq,$birthday,$realname);
			 $departemtn_class_result = $mysql->select("department_class","department_name",$department);
			 $department_class_id = $departemtn_class_result->fetch_object()->id;
			 
			 $mysql->insert("user",$student);
			 $user_result = $mysql->select("user","school_number",$school_number);
			 $department_id = $user_result->fetch_object()->id;
			 $enter_time = date("ymd");
			 $department_array = array($department_id,$department_class_id,1,$enter_time);
			 
			 $mysql->insert("department",$department_array);
			 $_SESSION[username] = $username;
			 $_SESSION[password] = $password;
			 echo "Your username is :",$_SESSION[username]." !","<br/>Successily create your account!<br/>";
			 echo '<script type="text/javascript">window.location.href="../index.php"</script>';
}else{
	echo "you enter a wrong place!";	
}
?>