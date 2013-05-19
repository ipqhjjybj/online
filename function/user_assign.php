<?php
	session_start();
	include "../function/pre_deal.php";
	include "../class/onlineSQL.class.php";
if($_POST['infomation_submit'] == "ready")
{
			 $mysql = new OnlineSqlNew();
			 $school_number = deal($_POST[school_number]);
			 $username=deal($_POST[username]);
			 $password=$_POST[p_word];           // not deal
			 $password=$mysql->jiami($password);
			 $sex=deal($_POST[sex]);
			 $tel=deal($_POST[tel]);
			 $qq=deal($_POST[qq]);
			 $birthday=deal($_POST[birthday]);
			 $realname=deal($_POST[realname]);
			 $department=deal($_POST[department]);
			 $id = $mysql->select("user","school_number",$school_number)->fetch_object()->id;
			 echo "id = $id<br/>";
			 $del_user_res = $mysql->deleted("user","id",$id);
			 if(!$del_user_res){
				echo "updated error!<br/>";
				exit();	 
			 }
			 $student = array($id,$school_number,$username,$password,$sex,$tel,$qq,$birthday,$realname);
			 $departemtn_class_result = $mysql->select("department_class","department_name",$department);
			 $department_class_id = $departemtn_class_result->fetch_object()->id;
			 
			 $ins_user_res = $mysql->insert("user",$student);
			 if(!$ins_user_res){
					echo "updated error when insert!<br/>";	 
			 }
			 
			 $dep_up_res = $mysql->update("department","department_class_id",$department_class_id,"id",$id);
			 if(!$dep_up_res){
					echo "updated error when update department!<br/>";	 
					exit();
			 }
			 $mysql->sql_close();
			 echo "updated successily!<br/>";
			 echo '<script type="text/javascript">history.go(-1);</script>';
}else{
	echo "you enter a wrong place!";	
}

?>