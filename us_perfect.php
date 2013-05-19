<?php
	session_start();
	include "class/onlineSQL.class.php";
	include "function/pre_deal.php";
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--不进行缓存设置--> 
<meta http-equiv="pragma" content="no-cache" />
<meta http-equiv="Cache-Control" content="no-cache,must-revalidate" /> 
<meta http-equiv="expires" content="Wed,26 Feb 1997 08:21:57 GMT" /> 

<link href="css/basic.css" rel="stylesheet" type="text/css" />


<title>us</title>
</head>

<body>
<div id = "out" align="center">
	<?php
		include 'header.php';
	?>
    <div id = "content">
    	<?php
			do_mid_sign();
		?>
    	<div id = "cur_position">
        	当前位置:我们
        </div>
        <div id = "us_content">
        	<div id = "search_content">
 				<input name = "search_text" id="search_text" type="text" value = "你想查询的对象？此功能尚未实现"/>    
                <input type="submit" id="search_submit" name="search_submit" value="确定" />      
            </div>
            <div id = "us_display">
            	<div id = "us_display_fram">
            	<?php
					
					$mysql = new OnlineSqlNew();
					$result = $mysql -> select("department_class");
					while($row = $result->fetch_object()){
						?>
                        <div id = "<?php echo id_text;?>" class = "department_class_display">
                        	<a href="us_display.php?<?php echo "pic_id=",$row->id;?>"><img src="image/<?php echo $row->image_url;?>"/></a>
                            <a href="us_display.php?<?php echo "pic_id=",$row->id;?>"><span><?php echo $row -> department_name;?></span></a>
                        </div>
						<?	
					}
					$mysql->sql_close();
				?>
                </div>
            </div>
            <div id = "us_content_footer">
            </div>
        </div>
    </div>
  
  	<?php
		do_footer();
	?>
    
</div>
<script type="text/javascript" src="js/jquery-1.9.0.js"></script>
<script type="text/javascript" src="js/js_include.js"></script>

<script type="text/javascript" src="js/form_get.js"></script>
<script type="text/javascript" src="js/js_onchange.js"></script>
<script type="text/javascript" src="js/public_func.js"></script>
<script language="javascript">

</script>
</body>
</html>