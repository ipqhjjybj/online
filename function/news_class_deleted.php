<?php
	session_start();
	include "../function/pre_deal.php";
	include "../class/onlineSQL.class.php";
	if(isset($_GET['news_class_id'])){
		$id = url_id('news_class_id=');
		$mysql = new OnlineSqlNew();
		$result = $mysql->deleted("news_class","id",$id);
		if($result){
			echo "successily deleted it";
			$mysql->sql_close();
			echo '<script type="text/javascript">history.go(-1);</script>';
			exit();	
		}else{
			echo "something wrong!";	
		}
		$mysql->sql_close();
	}
	else{
		echo "you enter a wrong place";
		exit();	
	}
?>
