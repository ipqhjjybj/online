<?php
	session_start();
	$arr = $_POST;
	if(strcasecmp($arr['captcha'],$_SESSION['captcha']) == 0){
		$arr['answer'] = true;
	}else $arr['answer'] = false;
	$ans = json_encode($arr);
	echo $ans;
?>