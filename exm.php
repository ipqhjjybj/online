
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>

<body>
<?php

	echo phpinfo();
	
	echo "<br/>";
?>
<?php
echo "技术部";
echo "<br/>".'技术部'."<br/>";
$ss = array("sd","dd","ww","hh");
print_r($ss);
$value = "('".pos($ss);
$t = count($ss);
echo "1 t = ".$t."<br/>";

print_r($ss);
for($i = 0;$i < $t - 1;$i++){
		$value .= "','".next($ss);
}
$t = count($ss);
echo "2 t = ".$t."<br/>";
$value .= "')";
$t = count($ss);
echo "3 t = ".$t."<br/>";
echo $value."<br/>";
?>
</body>
</html>