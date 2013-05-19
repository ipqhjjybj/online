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


<title>register</title>
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
        	当前位置:照片
        </div>
        <div id = "photo_content">
        	<div id = "photo_head">
            </div>
            <div id = "photo_mid">
            	<div id = "photo_mid_fram">
            		<div id = "photo_class_name">
                    <?php
						$mysql = new OnlineSqlNew();
						$result = $mysql->select("picture_class");
						while($row = $result -> fetch_object()){
						?>
                          <div id = "<?php echo id_text;?>" class = "picture_class_display">
							<a href="<?php echo url(),"?id=",$row->id;?>"><img src="image/<?php echo $row->image_url;?>" /></a>
                            <a href="<?php echo url(),"?id=",$row->id;?>"><span><?php echo $row -> department_name;?></span></a>
						  </div>	
						<?
                        }
						$mysql->sql_close();
					?>
                	</div>
                </div>
            </div>
            <div id = "photo_bottom">
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