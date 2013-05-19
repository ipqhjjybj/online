<?php
session_start();
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
include "../function/pre_deal.php";
include "../class/onlineSQL.class.php";
if(isset($_POST['username']) && isset($_POST['password'])){
			$mysql = new OnlineSqlNew();
			$u_name = $_POST['username'];
			$p_word = $mysql->jiami($_POST['password']);
			$result = $mysql -> select("user","username",$u_name);
			
			echo $result->num_rows."<br/>";
			
			if($result->num_rows)
			{
				$row = $result->fetch_object();
				$right_p_word = $row -> password;
				if(strcmp($right_p_word,$p_word) == 0){
					$_SESSION['username'] = $u_name;
					$_SESSION['password'] = $p_word;
					
					echo '<script type="text/javascript">history.go(-1);</script>';
				}
				else{
					echo "your password wrong!<br/>"	;
				}
			}
			else{
				echo "There is no such username!<br/>";	
			}
}
else{
	echo "why?<br/>";
	echo $_POST[username]."<br/>".$_POST[password]."<br/>";	
}
?>