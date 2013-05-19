<?php
session_start();
include "../function/pre_deal.php";
include "../class/onlineSQL.class.php";

$mysql = new OnlineSqlNew();
		##author :Androidyue
		##sina @androidyue
		##Blog http://blog.csdn.net/BossDarcy
		##源码具体讲解  http://blog.csdn.net/BossDarcy/archive/2010/12/20/6086082.aspx
		//判断临时文件存放路径是否包含用户上传的文件

		if(isset($_POST['news_submit']) && $_POST['news_submit'] == "submit"){
		if(is_uploaded_file($_FILES["uploadfile"]["tmp_name"])){

		//为了更高效，将信息存放在变量中
		$upfile=$_FILES["uploadfile"];//用一个数组类型的字符串存放上传文件的信息
		//print_r($upfile);//如果打印则输出类似这样的信息Array ( [name] => m.jpg [type] => image/jpeg [tmp_name] => C:\WINDOWS\Temp\php1A.tmp [error] => 0 [size] => 44905 )
		$name=$upfile["name"];//便于以后转移文件时命名
		$type=$upfile["type"];//上传文件的类型
		$tmp_type=substr(strrchr($name,"."),1);//获取文件扩展名
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
			$rand = '';
for ($x=0;$x<12;$x++)
  $rand .= substr($string,mt_rand(0,strlen($string)-1),1);
$t=date("ymdHis").substr($gettime[0],2,6).$rand;
			//调用move_uploaded_file（）函数，进行文件转移
			$attdir="../file/".$mysql->getSchoolNumber($_SESSION['username'])."/";  
			
   			 if(!is_dir($attdir))   
   	 		 { 
			   mkdir($attdir);
			 }
			 $uploadfile=$attdir.$t.".".$tmp_type; 
			move_uploaded_file($tmp_name,$uploadfile);
			//下面为数据库操作！！！
			
				$id = "null";
				$dep_result = $mysql->select("department_class","department_name",$_POST['n_classy']);
				if(!$dep_result->num_rows){
					echo "<script language=\"javascript\">alert('no nclassy ! failed add to mysql')</script>";
					exit();
				}
				$department_id = $dep_result->fetch_object()->id;
				$tile = $_POST['title'];
				$provider_id = $mysql->get_id_by_user_name($_SESSION['username']);
				$date_shoot = $_POST['news_time'];
				$time = date("Ymd");
				$summary = $_POST['editor_id'];
				$filename = $name;
				$real_path = $uploadfile;
				$pic_arr = array($id,$department_id,$title,$provider_id,$date_shoot,$time,$summary,$filename,$real_path);
				$pic_ins = $mysql->insert("picture",$pic_arr);
				if(!$pic_ins){
					echo "<script language=\"javascript\">alert('insert to mysql failed!\n')</script>";
					exit();
				}
			//
			//操作成功后，提示成功
			echo "<script language=\"javascript\">alert('succeed')</script>";
			echo '<script type="text/javascript">history.go(-2);</script>';
		}else{
			//如果文件不符合类型或者上传过程中有错误，提示失败
			echo "<script language=\"javascript\">alert('failed')</script>";
		}
	}
		}
?>