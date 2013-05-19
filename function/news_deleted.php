<?php
	session_start();
	include "../function/pre_deal.php";
	include "../class/onlineSQL.class.php";
	if(isset($_GET['news_id'])){
		$id = url_id('news_id=');
		$mysql = new OnlineSqlNew();
		$result = $mysql->deleted("news","id",$id);
		if($result){
			echo "successily deleted it";
			
		}
		$mysql->sql_close();
		
		echo '<script type="text/javascript">history.go(-1);</script>';	
	}
	else{
		echo "you enter a wrong place";
		exit();	
	}
?>
