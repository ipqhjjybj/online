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

<script type="text/javascript">
/*
 * 单独为这一页面设计 
 */
function $(id){return document.getElementById(id);}
window.onload = function(){
 $("con_left").onclick = function(e){
  var src = e?e.target:event.srcElement;
  
  if(src.tagName == "H3"){
	  alert(1);
   var next = $(src.id+"_department");
   alert(1);
   next.style.display = (next.style.display =="block")?"none":"block";
  }
 }
}
</script>
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
        	当前位置:<a href="index_perfect.php">主页</a>
        </div>
    	<div id = "index_content">
        	<div id = "con_left">
                <div id="online_dep" class = "department">
                <h3>东大在线</h3>
                </div>
                <div id="dep_office" class = "department">
                <h3>办公室</h3>
                </div>
                <div id="dep_press" class = "department">
                <h3>记者团</h3>
                </div>
                <div id="dep_plan" class = "department">
                <h3>策划部</h3>
                </div>
                <div id="dep_technique" class = "department">
                <h3>技术部</h3>
                </div>
                <div id="dep_design" class = "department">
                <h3>设计部</h3>
                </div>
                <div id="dep_maintain" class = "department">
                <h3>维护部</h3>
                </div>
                <div id="dep_propagate" class = "department">
                <h3>网宣部</h3>
                </div>
                
			</div>
            <div id = "con_right">
            <?php
				$mysql = new OnlineSqlNew();
				$result = $mysql ->select("department_class");
				while($row = $result->fetch_object()){
					?>
                    	<div id = "<?php echo $row->id_text."_display";?>" class = "content_decorate" >
                        	<?php echo $row->department_name,":",$row->summary,"<br/>";?>
                            <strong>创建人:</strong> <span><?php echo $mysql->get_user_name_by_id($row->set_person_id);?></span>
                            <strong>负责人:</strong> <span><?php echo $mysql->get_user_name_by_id($row->principal_id);?></span>
                            <strong>创建时间:</strong> <span><?php echo $row->set_time;?></span>
                        </div>
                    <?
				}
                $mysql->sql_close();
			?>
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

/*
 * 单独为这一页面设计 
 */
var online_obj = document.getElementById("online_dep_display");
if(online_obj != null)
	online_obj.style.display="block";
var obj_arr = new Array("online_dep","dep_office","dep_press","dep_plan","dep_technique","dep_design","dep_maintain","dep_propagate");
var func_append = function(){
	var obj_arr = new Array("online_dep","dep_office","dep_press","dep_plan","dep_technique","dep_design","dep_maintain","dep_propagate");
	for(var i = 0;i < 8;i++)
	{
		var obj_curr = document.getElementById(obj_arr[i]+"_display");
		if(obj_curr != null)
			obj_curr.style.display = "none";
	}

	var next = this.id+"_display";
	var next_obj = document.getElementById(next);
	if(next_obj != null)
		next_obj.style.display = "block";
};
for(var i = 0;i < 8;i++){
	var obj = document.getElementById(obj_arr[i]);
	EventUtil.addHandler(obj,"mouseover",func_append);
}
</script>
</body>
</html>