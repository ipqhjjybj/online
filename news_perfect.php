<?php
	session_start();
	include "class/onlineSQL.class.php";
	include "function/pre_deal.php";
	include "class/PageMS.class.php";
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


<title>news</title>
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
        	当前位置:新闻
        </div>
        <div id="news_content">
        
        <?php
		$sql = "select * from ".OnlineSqlNew::pre."news";
		$page = new PageMS($sql,2);
		$result = $page -> mysql -> sql_deal($page->sqlquery());
		
		while($info = $result -> fetch_object()){
			?>
            	<img class = "img_display" src="image/news_display1.png" />
            	<div id = "news_id<?php echo $info->id;?>" class = "news_display">
                	<div class = "time">
                    	<?php echo $info->set_time;?>
                    </div>
                    <div class = "news_summary">
                    	<?php echo $info->summary;?>
                    </div>
                    <div class = "news_info">
                    	by:<span><?php echo $page ->mysql->get_user_name_by_id($info->set_person_id);?></span>
                        below:<span><?php echo $page->mysql->get_it_father_name_from_id($info->news_class_id,"news_class","class_name");?></span>
                        <strong><a href="news_display.php?id=<?php echo $info->id;?>">阅读</a></strong><strong>评论</strong>
                    </div>
                </div>
			<?
		}
        	?>
            <div id = "page_display">
            <?php
				echo $page->set_page_info();
				$page -> mysql -> sql_close();
			?>
            </div>
            <?
		?>
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