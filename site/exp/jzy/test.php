<html>
<body>
<?php
$tomorrow=mktime(0,0,0,date("m"),date("d")+1,date("Y"));
echo date("Y.m.d");
echo "<br />";
echo "��ֲ�Ǹ���ɵ�ϡ�������";
echo "<br />";
echo date("Y.m.d",$tomorrow)."<br />�����Ǹ�ɵ��Ŷ����";
echo "<br />";
$file=fopen("something.txt","r") or exit("Unable to open this file");
while(!feof($file))
{
echo fgets($file)."<br />";
}
fclose($file);
$con=mysql_connect("localhost","tester","online");
if (!$con)
  {
  die("Could not connect: ". mysql_error());
  }
?>
</body>
</html>