<?php
session_start();
require_once '../class/onlineSQL.class.php';
require_once '../class/Uploader_picture.class.php';

$arr = $_POST;
print_r($arr);
$uploadfile = $arr['up_input'];
$tmp = $arr['tmp_name'];
print_r($_FILES);
print_r($_FILES[$uploadfile]);
if(is_uploaded_file($_FILES[$uploadfile][$tmp])){
		print_r($_FILES);
		$upfile = $_FILES[$uploadfile];
		$name=$upfile["name"];//便于以后转移文件时命名
		$type=$upfile["type"];//上传文件的类型
		$size=$upfile["size"];//上传文件的大小
		$tmp_name=$upfile["tmp_name"];//用户上传文件的临时名称
		echo "tmp_name:".$tmp_name."<br/>";
		$error=$upfile["error"];//上传过程中的错误信息
		//echo $name;
		//对文件类型进行判断，判断是否要转移文件,如果符合要求则设置$ok=1即可以转移
		switch($type){
			case "image/jpg": $ok=1;
			break;
			case "image/jpeg": $ok=1;
			break;
			case "image/gif" : $ok=1;
			break;
			default:$ok=0;
			break;
		}
		//如果文件符合要求并且上传过程中没有错误
		if($ok&&$error=='0'){
			//调用move_uploaded_file（）函数，进行文件转移
			move_uploaded_file($tmp_name,'../up/'.$name);
			//操作成功后，提示成功
			echo "Oh.It's successily.<br/>";
		}else{
			//如果文件不符合类型或者上传过程中有错误，提示失败
			echo "ok:",$ok,"error",$error."<br/>";
		}
}else{
	echo "something wrong!<br/>";	
}
?>