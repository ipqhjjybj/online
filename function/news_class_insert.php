<?php
	session_start();
	include "../function/pre_deal.php";
	include "../class/onlineSQL.class.php";

	if(isset($_POST['news_submit']) && $_POST['news_submit'] == "submit"){
		$class_name = $_POST['title'];
		$summary = $_POST['editor_id'];
		$news_time = date("ymd");
		$person_name = $_SESSION['username'];
		$mysql = new OnlineSqlNew();
		$username = $_SESSION['username'];
		$set_person_id = $mysql->get_id_by_user_name($username);
		$news_class_array = array(NULL,$class_name,$news_time,$set_person_id,$summary);
		$ans = $mysql->insert("news_class",$news_class_array);
		$mysql->sql_close();
		if($ans){
			echo "successily creat a news_class!<br/>";	
			echo '<script type="text/javascript">window.location.href="../news_backstage.php"</script>';
		}else{
			echo "there is something wrong in the database!<br/>";	
		}
	}else{
		echo "submit is not set!<br/>";	
	}
?>