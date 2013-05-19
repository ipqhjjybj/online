<?php
	session_start();
	include "../function/pre_deal.php";
	include "../class/onlineSQL.class.php";

	if(isset($_POST['news_submit']) && $_POST['news_submit'] == "submit"){
		$title = $_POST['title'];
		$content = $_POST['editor_id'];
		$news_summary = $_POST['news_summary'];
		$news_time = $_POST['news_time'];
		$n_classy = $_POST['n_classy'];
		$mysql = new OnlineSqlNew();
		$result =$mysql->select("news_class","class_name",$n_classy);
		if($result->num_rows )
			$news_class_id = $result->fetch_object()->id;
		else{
			echo "no such ".$n_classy."<br/>";
			exit();	
		}
		$username = $_SESSION['username'];
		$set_person_id = $mysql->get_id_by_user_name($username);
		$ins_res = $mysql->insert("news",array("null",$news_class_id,$title,$content,$news_time,$set_person_id,$news_summary));
		$mysql->sql_close();
		if($ins_res){
			echo "insert_perfect!";	
			echo '<script type="text/javascript">window.location.href="../news_backstage.php"</script>';
		}else{
			echo '<script language="javascript">alert("wrong!");</script>';	
		}
		echo '<script type="text/javascript">history.go(-1);</script>';
	}
	else{
		echo "no submit!<br/>";	
	}
?>