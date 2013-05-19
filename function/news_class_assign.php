<?php
	session_start();
	echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
	include "../function/pre_deal.php";
	include "../class/onlineSQL.class.php";
	
	if(isset($_POST['news_submit']) && $_POST['news_submit'] == "submit"){
		if(isset($_GET['news_class_id'])){
			$id = url_id('news_class_id=');	
			echo "id = ".$id."<br/>";
		}
		else{
			echo "something wrong!";
			exit();	
		}
		$class_name = $_POST['title'];
		$summary = $_POST['editor_id'];
		$mysql = new OnlineSqlNew();
		$set_person_id = $mysql->get_id_by_user_name($_SESSION['username']);
		$time = date("Y-m-d");

		$del = $mysql->deleted("news_class","id",$id);	
		if(!$del){
			echo "deleted error!<br/>";
			exit();	
		}
		$class_arr = array($id,$class_name,$time,$set_person_id,$summary);
		$ans = $mysql->insert("news_class",$class_arr);
		$mysql->sql_close();
		if($ans){
			echo "successily update the infomation!<br/>";
			echo '<script type="text/javascript">window.location.href="../news_backstage.php"</script>';
		}else{
			echo "something wrong! in the news_insert";	
		}
	}else{
		echo "hasn't set submit!";	
	}
?>