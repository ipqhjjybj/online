<?php
?>
<div id = "login_id" >
<?php
	if(is_login()){
		?>
        <div id = "has_login">
        	username:<?php echo $_SESSION[username];?>
            <a href = "backstage.php">后台管理</a>
        </div>
        <?
	}else if(substr_count($_SERVER['PHP_SELF'],"register_perfect.php") == 1){
		
	}
	else{
		?>

	<form id = "login" name="login" method = "post"  action = "function/login.php">
    		username:<input name = "username" type = "text" class = "username" id = "username"  style="color:gray"  value = "usernamne"></input>
    	    password:<input name = "password" id = "password" class = "password" type = "password" value = "123456" ></input>
    		<a href="javascript:document.login.submit()"><img  src="image/submit.png" align="absmiddle"/></a> 
            <a href = "register_perfect.php">注册</a>
            </form>
    <div id = "showtime"></div>
    	<?
	}
?>
	</div>
	<div id = "logo">
    	<img src="image/logo.png"/>
	</div>
<?
	
?>