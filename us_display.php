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
        	当前位置:我们-><?php
				$id = $_GET['pic_id'];
				$mysql = new OnlineSqlNew();
				$result = $mysql -> select("department_class","id",$id);
				if($result->num_rows){
					if($row = $result->fetch_object()){
						?>
						<a href = "<?php echo url();?>"><?php echo $row->department_name;?></a>
						<?
					}
				}else{
					echo "you enter a wrong place!<br/>";
					exit();	
				}
									$mysql->sql_close();
				?>
                       
        </div>
        <div id = "us_content1">
     
            	<?php
				if($id){
					$sql = "select * from ".OnlineSqlNew::pre."picture"." where department_class_id=".$id;
				}
				else
					$sql = "select * from ".OnlineSqlNew::pre."picture";
				$page = new PageMS($sql,10);
				$result = $page -> mysql -> sql_deal($page->sqlquery());
				echo "<ul>";
				while($info = $result -> fetch_object()){
					echo '<li><a href = "'.substr($info->real_path,1,strlen($info->real_path)).'"><img src ="'.substr($info->real_path,1,strlen($info->real_path)).'"/></a></li>';		
				}
				echo "</ul>";
					?>
					
					<?
				?>
                
                
                
                <?php
				  //以下是页码
						echo $page->set_page_info();
						$page -> mysql -> sql_close();
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