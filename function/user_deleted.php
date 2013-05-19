<?php
	session_start();
	include "../function/pre_deal.php";
	include "../class/onlineSQL.class.php";
	if(isset($_GET['user_id'])){
		$id = url_id('user_id=');
		$mysql = new OnlineSqlNew();
		$result1 = $mysql->deleted("user","id",$id);
		$result2 = $mysql->deleted("department","id",$id);
		if($result1 && $result2){
			echo "successily deleted it";
			$mysql->sql_close();
			echo '<script type="text/javascript">history.go(-1);</script>';
			exit();	
		}
		else{
			echo "something error take place !<br/>";	
		}
	}
	else{
		echo "you enter a wrong place";
		exit();	
	}
?>
