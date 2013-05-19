<?php
require_once '../class/onlineSQL.class.php';
$mysql = new OnlineSqlNew();
$arr = $_POST;
$table = $_POST['table_name'];
$value = $_POST['value_name'];
$attribute = $_POST['attribute_name'];
if($attribute == "password"){
	$value = $mysql -> jiami($value);	
}
$result = $mysql -> select($table,$attribute,$value);

if($result -> num_rows > 0){
	$arr['answer'] = true;
}
else $arr['answer'] = false;
$ans = json_encode($arr);

$mysql->sql_close();
echo $ans;
?>