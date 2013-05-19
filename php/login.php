<?php
	header("Content-Type:text/html; charset=utf-8");
	$username = urldecode($_POST['username']);
	$password = urldecode($_POST['password']);
	echo $username."<br/>".$password."<br/>";
	echo "why!!!!!1<br/>";
?>