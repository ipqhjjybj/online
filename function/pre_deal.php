<?php
$Debug = 1;
function deal($string){
	return 	addslashes(trim($string));
}
function do_header($title){
	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>'.$title.'</title>
</head>

<body>';	
}
function do_mid_sign(){
	?>
    	<div id = "mid_sign" >
        	<div id = "index" class = "sign">
            	<a href="index_perfect.php"><img id = "picture1" src="image/index.png" /></a>
            </div>
            <div id = "news" class = "sign">
            	<a href="news_perfect.php"><img id = "picture2" src="image/news.png" /></a>
            </div>
            <div id = "photo" class = "sign">
            	<a href="PHP_swf/wall_example5.swf"><img id = "picture3" src="image/photo.png" /></a>
            </div>
            <div id = "us" class = "sign">
            	<a href="us_perfect.php"><img id = "picture4" src="image/us.png" /></a>
            </div>
            <div id = "link" class = "sign">
            	<a href="link_perfect.php"><img id = "picture5" src="image/link.png" /></a>
            </div>
            <div id = "others" class = "sign">
            	<a href="others_perfect.php"><img id = "picture6" src="image/others.png" /></a>
            </div>
        </div>
    <?	
}
function do_footer(){
	?>
	<div id = "footer">
    	Copyright?2004-2013 东北大学党委宣传部（新闻中心）版权所有，网络管理室编辑维护，技术支持："东大在线"网络传媒工作室
    </div>
    <?
}

function is_login(){
	//echo $_SESSION['username']."<br/>".$_SESSION['password']."<br/>";
	if(isset($_SESSION['username']) && isset($_SESSION['password'])){
		return true;	
	}else return false;
}

/**
 *	返回URL？后面的数字代码
 */
function url_id($string ="page_id="){
    	if($_SERVER['QUERY_STRING'] == ""){
    		return 1;		//第一页
    	}else if(substr_count($_SERVER['QUERY_STRING'],$string)==0){
    		return 1;		//第一页
    	}else{
    		return intval(substr($_SERVER['QUERY_STRING'],strlen($string)));
    	}
}
/**
 *	返回页面的绝对路径
 */
function url(){
	return $_SERVER['PHP_SELF'];
}

?>