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


<title>nes_display</title>
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
        当前位置:新闻-><?
				$id = url_id("id=");
				$mysql = new OnlineSqlNew();
				$result = $mysql -> select("news","id",$id);
				if($row = $result->fetch_object()){
					?>
					<a href = "<?php echo url();?>"><?php echo $row->title;?></a>
                    <?
				}
			?>
        </div>
        <div id = "n_display">
        	<?php
				
				
				if($row){
				?>
					<div id = "news_title">
                    <h2><?php echo $row->title;?></h2>
            		</div>
					<div id = "news_c">
                    <span><?php echo  $row->content?></span>
            		</div>
                    <div class = "news_info1">
                    	by:<span><?php echo $mysql->get_user_name_by_id($row->set_person_id);?></span>
                        below:<span><?php echo $mysql->get_it_father_name_from_id($row->news_class_id,"news_class","class_name");?></span>
                        <strong><a href="news_dispaly.php?id=<?php echo $row->id;?>">阅读</a></strong><strong>评论</strong>
                    </div>
                <?
				}else{
					
				}
			?>
            
            
        </div>
    </div>
  
  	<?php
		do_footer();
	?>
    
</div>
<script type="text/javascript" src="js/jquery-1.9.0.js"></script>
<script type="text/javascript" src="js/js_include.js"></script>
<script type="text/javascript" src="js/form_check.js"></script>
<script type="text/javascript" src="js/form_get.js"></script>
<script type="text/javascript" src="js/public_func.js"></script>
</body>
</html>