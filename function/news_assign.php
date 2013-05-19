<?php
	session_start();
	echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
	include "../function/pre_deal.php";
	include "../class/onlineSQL.class.php";
	
	if(isset($_POST['news_submit']) && $_POST['news_submit'] == "submit"){
		if(isset($_GET['news_id'])){
			$id = url_id('news_id=');	
			echo "id = ".$id."<br/>";
		}
		else{
			echo "something wrong!";
			exit();	
		}
		$title = $_POST['title'];
		$content = $_POST['editor_id'];
		$news_summary = $_POST['news_summary'];
		$news_time = $_POST['news_time'];
		$n_classy = $_POST['n_classy'];
		echo "n_classy: ".$n_classy;
		$mysql = new OnlineSqlNew();
		$result =$mysql->select("news_class","class_name",$n_classy);
		$news_class_id = $result->fetch_object()->id;
		$username = $_SESSION['username'];
		$set_person_id = $mysql->get_id_by_user_name($username);
		$news_del_res = $mysql->deleted("news","id",$id);
		if(!$news_del_res){
			echo "deleted news wrong!<br/>";
			exit();	
		}
		$news_array = array($id,$news_class_id,$title,$content,$news_time,$set_person_id,$news_summary);
		print_r($news_array);
		$ans = $mysql->insert("news",$news_array);
		echo "ans = :".$ans."<br/>";
		$mysql->sql_close();
		if($ans){
			echo "successily update the infomation!<br/>";
			echo '<script type="text/javascript">history.go(-1);</script>';
		}else{
			echo "something wrong! in the news_insert";	
		}
	}else{
		echo "hasn't set submit!";	
	}
?>