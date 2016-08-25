<?php
error_reporting(0);
/*程序所在路径(指当前文件所在的 http 路径)*/
$url = "https://blog.egsa.pub/wp-content/uploads/";
/*图片保存文件夹路径(例如 img/up/ 这样，为空即为保存在根目录，图片保存文件夹需要自己手动创建。)*/
$URL_baocun = "";
/*页面显图片数量*/
$BigID = "100";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>图床</title>
<style type="text/css">
.img {
	width:200px;
	height:200px;
	background-color : #DCDCDC;
	border-width : 1px;
	border-color : #B6B6B6;
	border-style : solid;
	padding : 8px;
	margin : 8px;
	float:left;
}

</style>
</head>

<body>

<?php
$A = getcwd();
$urld = $URL_baocun.date("Y/m");
$id = 1;
if ($handle = opendir($A."/".$urld)) {
    while ($file = readdir($handle)) {
       if (($file == ".")||($file==".."))
	   {
	   }
	   else
	   {
			$id++;
			echo "<img class=\"img\" title=\"".$file."\" src=\"".$url.$urld."/".$file."\" alt=\"".$file."\" width=\"200\" height=\"200\" />";
			if ($id>$BigID)
			{
				exit("");
			}
	   }
    }
}
?>
</body>
</html>