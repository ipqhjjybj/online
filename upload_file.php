<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<script type="text/javascript" src="js/jquery-1.9.0.js"></script>
<script type="text/javascript" src="js/ajax_upload.js"></script>
</head>

<body>
<form method="post" id = "upload_pic" name = "upload_pic" action = "function/upload_pictue.php"  enctype="multipart/form-data">
    	<input type = "file" name = "upfile_pictue"  id = "upfile_pictue"/>
        <img  id = "upfile_one"src="image/upload_picture.png" width="30"  align="absmiddle"/>
        <div id = "file_after" >sb</div>
    </form>
</body>
<script>
$("#upfile_one").click(function(){
		upfile_js('upfile_pictue','file_after');
	});
</script>
</html>