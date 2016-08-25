<?php
error_reporting(0);
/*登陆密码*/
$key = "duan.1994~";
/*程序所在路径(指当前文件所在的 http 路径)*/
$url = "//qiniu.longsays.com/wp-content/uploads/";
/*图片保存文件夹路径(例如 img/up/ 这样，为空即为保存在根目录，图片保存文件夹需要自己手动创建。)*/
$URL_baocun = "";
/*文章页面所在宽度*/
$Blog_with = 600;
/*水印所在路径*/
$shuiyin = "sas.png";
/*水印距离图片边框位置*/
$shuiyin_X = 10;
$shuiyin_Y = 10;

/*默认是否启用水印（YES或NO）*/
$shuiying_QY_name = "NO";

/*水印默添加位置（zs或zx或ys或yx分别对应左上、左下、右上、右下）*/
$shuiying_weizhi_name = "yx";

/*以下为图片在不同版式下的ClassName，wordpress用户保持默认即可*/
/*图片居左Class*/
$class_zuo = "alignleft";
/*图片居中Class*/
$class_zhong = "aligncenter";
/*图片居右Class*/
$class_you = "alignright";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>图片上传页面</title>
<style type="text/css">
body {background-image:url(back.png);}
.aligncenter {display: block; margin-left: auto; margin-right: auto;}
.heard
{
	background-color:#F6F6F6;
	width:<?php echo $Blog_with ?>px;
	border-width : 5px;
	border-color : #F90;
	border-style : dotted;
	padding-bottom:10px;
	padding-left:10px;
	padding-right:20px;
	padding-top:10px;
	margin:auto;
	margin-top:20px;
}
.submit
{
	width:<?php echo $Blog_with ?>px;
	height:30px;
}
.aligncenter{
	background-color :#CCC;
	border-width : 1px;
	border-color : #999;
	border-style : solid;
	padding : 5px;
	margin:auto;
	margin-bottom:10px;
}
.dm{
	background-color :#FF9;
	border-width : 1px;
	border-color : #F90;
	border-style : solid;
	margin:auto;
	margin-left:2px;
	margin-right:2px;
	margin-bottom:0px;
	margin-top:10px;
	padding-bottom:5px;
	padding-left:5px;
	padding-right:5px;
	padding-top:5px;
	font-size:12px;
}
.dm:hover{
	font-size:14px;
	background-color:#F60;
	border:#F00;
}
.link{
	text-align:right;
}
.logo{
	margin:auto;
	width:194px;
	height:95px;
	background-image:url(logo.png);
}
.delete{
	width:<?php echo $Blog_with-5 ?>px;
}
</style>
</head>

<body>

<?php
echo $logo_QDY = "<div class=\"logo\"><a href=\"http://www.longsays.com/\" target=\"_blank\"><img src=\"logo.png\" width=\"194\" height=\"95\" alt=\"logo\" /></a></div>";
if ($_POST['Logo']=="YES")
{
	$shuiying_qy_1 = "checked=\"checked\"";
	$shuiying_qy_2 = "";
}
else if ($_POST['Logo']=="NO")
{
	$shuiying_qy_1 = "";
	$shuiying_qy_2 = "checked=\"checked\"";
}
else
{
if ($shuiying_QY_name == "YES")
{
	$shuiying_qy_1 = "checked=\"checked\"";
	$shuiying_qy_2 = "";
}
else if($shuiying_QY_name == "NO")
{
	$shuiying_qy_1 = "";
	$shuiying_qy_2 = "checked=\"checked\"";
}
else
{
	$shuiying_qy_1 = "checked=\"checked\"";
	$shuiying_qy_2 = "";
}
}
if ($_POST['shuiyin']=="zs")
{
		$shuiying_weizhi_1="checked=\"checked\"";
		$shuiying_weizhi_2="";
		$shuiying_weizhi_3="";
		$shuiying_weizhi_4="";
}
else if($_POST['shuiyin']=="zx")
{
		$shuiying_weizhi_1="";
		$shuiying_weizhi_2="checked=\"checked\"";
		$shuiying_weizhi_3="";
		$shuiying_weizhi_4="";
}
else if($_POST['shuiyin']=="ys")
{
		$shuiying_weizhi_1="";
		$shuiying_weizhi_2="";
		$shuiying_weizhi_3="checked=\"checked\"";
		$shuiying_weizhi_4="";
}
else if($_POST['shuiyin']=="yx")
{
		$shuiying_weizhi_1="";
		$shuiying_weizhi_2="";
		$shuiying_weizhi_3="";
		$shuiying_weizhi_4="checked=\"checked\"";
}
else
{
if ($shuiying_weizhi_name=="zs")
{
	$shuiying_weizhi_1="checked=\"checked\"";
	$shuiying_weizhi_2="";
	$shuiying_weizhi_3="";
	$shuiying_weizhi_4="";
}
else if($shuiying_weizhi_name=="zx")
{
	$shuiying_weizhi_1="";
	$shuiying_weizhi_2="checked=\"checked\"";
	$shuiying_weizhi_3="";
	$shuiying_weizhi_4="";
}
else if($shuiying_weizhi_name=="ys")
{
	$shuiying_weizhi_1="";
	$shuiying_weizhi_2="";
	$shuiying_weizhi_3="checked=\"checked\"";
	$shuiying_weizhi_4="";
}
else if($shuiying_weizhi_name=="yx")
{
	$shuiying_weizhi_1="";
	$shuiying_weizhi_2="";
	$shuiying_weizhi_3="";
	$shuiying_weizhi_4="checked=\"checked\"";
}
else
{
	$shuiying_weizhi_1="";
	$shuiying_weizhi_2="";
	$shuiying_weizhi_3="";
	$shuiying_weizhi_4="checked=\"checked\"";
}
}

$logo = getimagesize ($shuiyin);
$logoWith = $logo['0'];
$logoHeight = $logo['1'];
if($logo['mime'] == "image/gif")
{
	$LogoImg = imagecreatefromgif($shuiyin);
}
else if($logo['mime'] == "image/jpeg")
{
	$LogoImg = imagecreatefromjpeg($shuiyin);
}
else if($logo['mime'] == "image/png")
{
	$LogoImg = imagecreatefrompng($shuiyin);
}


if ($_COOKIE['KEY_img']=="")
{
	echo "<div class=\"heard\">";
	echo "<form action=\"#\" method=\"POST\">";
	echo "记住登陆：<input type=\"checkbox\" name=\"Key_name\" value=\"YES\" />";
	echo "密码:<input type=\"password\" name=\"Key\" />";
	echo "<input type=\"submit\" value=\"登陆\" />";
	echo "</form>";
	echo "</div>";
	if ($_POST['Key']=="")
	{
	}
	else if(md5($_POST['Key'])==md5($key))
	{
		if($_POST['Key_name']=="YES")
		{
			setcookie("KEY_img",md5($_POST['Key']),time()+9999999);
		echo "<div class=\"heard\">";
		echo "<form action=\"#\" method=\"post\" enctype=\"multipart/form-data\">";
		echo "<input type=\"file\" name=\"file\" id=\"file\" /><br />";
		echo "有水印：<input type=\"radio\" ".$shuiying_qy_1." name=\"Logo\" value=\"YES\" />";
		echo "无水印：<input type=\"radio\" ".$shuiying_qy_2." name=\"Logo\" value=\"NO\" /><br />";
		echo "左上：<input type=\"radio\" ".$shuiying_weizhi_1." name=\"shuiyin\" value=\"zs\" />";
		echo "左下：<input type=\"radio\" ".$shuiying_weizhi_2." name=\"shuiyin\" value=\"zx\" />";
		echo "右上：<input type=\"radio\" ".$shuiying_weizhi_3." name=\"shuiyin\" value=\"ys\" />";
		echo "右下：<input type=\"radio\" ".$shuiying_weizhi_4." name=\"shuiyin\" value=\"yx\" /><br />";
		echo "<input type=\"submit\" class=\"submit\" name=\"submit\" value=\"上传\" />";
		echo "</form>";
		
		if (!$_POST['Logo'])
		{
			echo "<form action=\"#\" method=\"post\">";
			echo "<input type=\"text\" class=\"delete\" value=\"在此处输入文件路径可以删除文件\" name=\"delete\" /><br />";
			echo "<input type=\"submit\" class=\"submit\" value=\"删除\" />";
			echo "</form>";
		}
		
		echo "</div>";
		}
		else
		{
			setcookie("KEY_img",md5($_POST['Key']));
		echo "<div class=\"heard\">";
		echo "<form action=\"#\" method=\"post\" enctype=\"multipart/form-data\">";
		echo "<input type=\"file\" name=\"file\" id=\"file\" /><br />";
		echo "有水印：<input type=\"radio\" ".$shuiying_qy_1." name=\"Logo\" value=\"YES\" />";
		echo "无水印：<input type=\"radio\" ".$shuiying_qy_2." name=\"Logo\" value=\"NO\" /><br />";
		echo "左上：<input type=\"radio\" ".$shuiying_weizhi_1." name=\"shuiyin\" value=\"zs\" />";
		echo "左下：<input type=\"radio\" ".$shuiying_weizhi_2." name=\"shuiyin\" value=\"zx\" />";
		echo "右上：<input type=\"radio\" ".$shuiying_weizhi_3." name=\"shuiyin\" value=\"ys\" />";
		echo "右下：<input type=\"radio\" ".$shuiying_weizhi_4." name=\"shuiyin\" value=\"yx\" /><br />";
		echo "<input type=\"submit\" class=\"submit\" name=\"submit\" value=\"上传\" />";
		echo "</form>";
		
		if (!$_POST['Logo'])
		{
			echo "<form action=\"#\" method=\"post\">";
			echo "<input type=\"text\" class=\"delete\" value=\"在此处输入文件路径可以删除文件\" name=\"delete\" /><br />";
			echo "<input type=\"submit\" class=\"submit\" value=\"删除\" />";
			echo "</form>";
		}
		
		echo "</div>";
		}
		
	}
	else
	{
		echo "<div class=\"heard\">";
		echo "密码错误";
		echo "</div>";
	}
}
else
{
	if ($_COOKIE['KEY_img']==md5($key))
	{
		echo "<div class=\"heard\">";
		echo "<form action=\"#\" method=\"post\" enctype=\"multipart/form-data\">";
		echo "<input type=\"file\" name=\"file\" id=\"file\" /><br />";
		echo "有水印：<input type=\"radio\" ".$shuiying_qy_1." name=\"Logo\" value=\"YES\" />";
		echo "无水印：<input type=\"radio\" ".$shuiying_qy_2." name=\"Logo\" value=\"NO\" /><br />";
		echo "左上：<input type=\"radio\" ".$shuiying_weizhi_1." name=\"shuiyin\" value=\"zs\" />";
		echo "左下：<input type=\"radio\" ".$shuiying_weizhi_2." name=\"shuiyin\" value=\"zx\" />";
		echo "右上：<input type=\"radio\" ".$shuiying_weizhi_3." name=\"shuiyin\" value=\"ys\" />";
		echo "右下：<input type=\"radio\" ".$shuiying_weizhi_4." name=\"shuiyin\" value=\"yx\" /><br />";
		echo "<input type=\"submit\" class=\"submit\" name=\"submit\" value=\"上传\" />";
		echo "</form>";
		
		if (!$_POST['Logo'])
		{
			echo "<form action=\"#\" method=\"post\">";
			echo "<input type=\"text\" class=\"delete\" value=\"在此处输入文件路径可以删除文件\" name=\"delete\" /><br />";
			echo "<input type=\"submit\" class=\"submit\" value=\"删除\" />";
			echo "</form>";
		}
		
		echo "</div>";
		if (!$_POST['Logo'])
		{
		}
		else
		{
			if (($_FILES["file"]["type"] == "image/gif")
			|| ($_FILES["file"]["type"] == "image/jpeg")
			|| ($_FILES["file"]["type"] == "image/png"))
			{
				if ($_FILES["file"]["error"] > 0)
				{
					echo "<div class=\"heard\">";
					echo "出现内部错误，错误代码".$_FILES["file"]["error"];
					echo "</div>";
				}
				else 
				{
					if ($_FILES["file"]["type"] == "image/gif")
					{
						$type = "gif";
					}
					else if ($_FILES["file"]["type"] == "image/jpeg")
					{
						$type = "jpg";
					}
					else if ($_FILES["file"]["type"] == "image/png")
					{
						$type = "png";
					}
							
					$math = rand(rand(0,1000000000),9999999999).date("Ymd");
					
					$tmp_img = getimagesize($_FILES["file"]["tmp_name"]);
					$tmp_img_with = $tmp_img['0'];
					$tmp_img_heigh = $tmp_img['1'];
			
					
					if (file_exists($URL_baocun.date("Y")."/"))
					{
						if (file_exists($URL_baocun.date("Y")."/".date("m")))
						{
							if($_POST["Logo"]=="YES")
							{
								$img_virtue_shuiyin = getimagesize($_FILES["file"]["tmp_name"]);
								
								if (($img_virtue_shuiyin['0']<$logoWith)||($img_virtue_shuiyin['1']<$logoHeight))
								{
									$X = $shuiyin_X;
									$Y = $shuiyin_Y;
								}
								else
								{
									if($_POST['shuiyin'] == "zx")
									{
										$X = $shuiyin_X;
										$Y = $img_virtue_shuiyin['1']-$logoHeight-$shuiyin_Y;
									}
									else if($_POST['shuiyin'] == "ys")
									{
										$X = $img_virtue_shuiyin['0']-$logoWith-$shuiyin_X;
										$Y = $shuiyin_Y;
									}
									else if($_POST['shuiyin'] == "yx")
									{
										$X = $img_virtue_shuiyin['0']-$logoWith-$shuiyin_X;
										$Y = $img_virtue_shuiyin['1']-$logoHeight-$shuiyin_Y;
									}
									else
									{
										$X = $shuiyin_X;
										$Y = $shuiyin_Y;
									}
								}
								
								if($type == "gif")
								{							
								$FileImg = imagecreatefromgif($_FILES["file"]["tmp_name"]);
								imagecopy ($FileImg,$LogoImg,$X,$Y,0,0,$logoWith,$logoHeight);
								imagegif($FileImg,$URL_baocun.date("Y")."/".date("m")."/".$math.".".$type);
								}
								else if($type == "jpg")
								{
								$FileImg = imagecreatefromjpeg($_FILES["file"]["tmp_name"]);
								imagecopy ($FileImg,$LogoImg,$X,$Y,0,0,$logoWith,$logoHeight);
								imagejpeg($FileImg,$URL_baocun.date("Y")."/".date("m")."/".$math.".".$type);
								}
								else if($type == "png")
								{
								$FileImg = imagecreatefrompng($_FILES["file"]["tmp_name"]);
								imagecopy ($FileImg,$LogoImg,$X,$Y,0,0,$logoWith,$logoHeight);
								imagepng($FileImg,$URL_baocun.date("Y")."/".date("m")."/".$math.".".$type);
								}
			
							}
							else if ($_POST["Logo"]=="NO")
							{				
								move_uploaded_file($_FILES["file"]["tmp_name"],$URL_baocun.date("Y")."/".date("m")."/".$math.".".$type);
							}
							$img_virtue = getimagesize($url.$URL_baocun.date("Y")."/".date("m")."/".$math.".".$type);
							if ($img_virtue['0'] >= $Blog_with)
							{
								$img_virtue_with = $img_virtue['0']*(1-(($img_virtue['0']-$Blog_with)/$img_virtue['0']));
								$img_virtue_heigh = $img_virtue['1']*(1-(($img_virtue['0']-$Blog_with)/$img_virtue['0']));
							}
							else
							{
								$img_virtue_with = $img_virtue['0'];
								$img_virtue_heigh = $img_virtue['1'];
							}
							echo "<div class=\"heard\">";
							echo "<img class=\"aligncenter\" src=\"".$url.$URL_baocun.date("Y")."/".date("m")."/".$math.".".$type."\" width=\"".$img_virtue_with."\" height=\"".$img_virtue_heigh."\" />";
							echo "图片居左代码：<br />"."<div class=\"dm\">".filter_var("<a href=\"".$url.$URL_baocun.date("Y")."/".date("m")."/".$math.".".$type."\"><img class=\"".$class_zuo."\" src=\"".$url.$URL_baocun.date("Y")."/".date("m")."/".$math.".".$type."\" width=\"".$img_virtue_with."\" height=\"".$img_virtue_heigh."\" /></a>",FILTER_SANITIZE_SPECIAL_CHARS)."</div><br />";
							echo "图片居中代码：<br />"."<div class=\"dm\">".filter_var("<a href=\"".$url.$URL_baocun.date("Y")."/".date("m")."/".$math.".".$type."\"><img class=\"".$class_zhong."\" src=\"".$url.$URL_baocun.date("Y")."/".date("m")."/".$math.".".$type."\" width=\"".$img_virtue_with."\" height=\"".$img_virtue_heigh."\" /></a>",FILTER_SANITIZE_SPECIAL_CHARS)."</div><br />";
							echo "图片居右代码：<br />"."<div class=\"dm\">".filter_var("<a href=\"".$url.$URL_baocun.date("Y")."/".date("m")."/".$math.".".$type."\"><img class=\"".$class_you."\" src=\"".$url.$URL_baocun.date("Y")."/".date("m")."/".$math.".".$type."\" width=\"".$img_virtue_with."\" height=\"".$img_virtue_heigh."\" /></a>",FILTER_SANITIZE_SPECIAL_CHARS)."</div><br />";
							
							echo "<form action=\"#\" method=\"post\">";
							echo "<input type=\"text\" class=\"delete\" value=\"".$URL_baocun.date("Y")."/".date("m")."/".$math.".".$type."\" name=\"delete\" /><br />";
							echo "<input type=\"submit\" class=\"submit\" value=\"删除\" />";
							echo "</form>";
							echo "</div>";
							
						}
						else
						{
							if(!mkdir($URL_baocun.date("Y")."/".date("m")))
							{
								echo "<div class=\"heard\">创建“月”文件夹失败，可能没有权限创建文件夹。</div>";
							}
							else
							{
								if($_POST["Logo"]=="YES")
							{
								$img_virtue_shuiyin = getimagesize($_FILES["file"]["tmp_name"]);
								
								if (($img_virtue_shuiyin['0']<$logoWith)||($img_virtue_shuiyin['1']<$logoHeight))
								{
									$X = $shuiyin_X;
									$Y = $shuiyin_Y;
								}
								else
								{
									if($_POST['shuiyin'] == "zx")
									{
										$X = $shuiyin_X;
										$Y = $img_virtue_shuiyin['1']-$logoHeight-$shuiyin_Y;
									}
									else if($_POST['shuiyin'] == "ys")
									{
										$X = $img_virtue_shuiyin['0']-$logoWith-$shuiyin_X;
										$Y = $shuiyin_Y;
									}
									else if($_POST['shuiyin'] == "yx")
									{
										$X = $img_virtue_shuiyin['0']-$logoWith-$shuiyin_X;
										$Y = $img_virtue_shuiyin['1']-$logoHeight-$shuiyin_Y;
									}
									else
									{
										$X = $shuiyin_X;
										$Y = $shuiyin_Y;
									}
								}
								
								if($type == "gif")
								{							
								$FileImg = imagecreatefromgif($_FILES["file"]["tmp_name"]);
								imagecopy ($FileImg,$LogoImg,$X,$Y,0,0,$logoWith,$logoHeight);
								imagegif($FileImg,$URL_baocun.date("Y")."/".date("m")."/".$math.".".$type);
								}
								else if($type == "jpg")
								{
								$FileImg = imagecreatefromjpeg($_FILES["file"]["tmp_name"]);
								imagecopy ($FileImg,$LogoImg,$X,$Y,0,0,$logoWith,$logoHeight);
								imagejpeg($FileImg,$URL_baocun.date("Y")."/".date("m")."/".$math.".".$type);
								}
								else if($type == "png")
								{
								$FileImg = imagecreatefrompng($_FILES["file"]["tmp_name"]);
								imagecopy ($FileImg,$LogoImg,$X,$Y,0,0,$logoWith,$logoHeight);
								imagepng($FileImg,$URL_baocun.date("Y")."/".date("m")."/".$math.".".$type);
								}
			
							}
							else if ($_POST["Logo"]=="NO")
							{				
								move_uploaded_file($_FILES["file"]["tmp_name"],$URL_baocun.date("Y")."/".date("m")."/".$math.".".$type);
							}
							$img_virtue = getimagesize($url.$URL_baocun.date("Y")."/".date("m")."/".$math.".".$type);
							if ($img_virtue['0'] >= $Blog_with)
							{
								$img_virtue_with = $img_virtue['0']*(1-(($img_virtue['0']-$Blog_with)/$img_virtue['0']));
								$img_virtue_heigh = $img_virtue['1']*(1-(($img_virtue['0']-$Blog_with)/$img_virtue['0']));
							}
							else
							{
								$img_virtue_with = $img_virtue['0'];
								$img_virtue_heigh = $img_virtue['1'];
							}
							echo "<div class=\"heard\">";
							echo "<img class=\"aligncenter\" src=\"".$url.$URL_baocun.date("Y")."/".date("m")."/".$math.".".$type."\" width=\"".$img_virtue_with."\" height=\"".$img_virtue_heigh."\" />";
							echo "图片居左代码：<br />"."<div class=\"dm\">".filter_var("<a href=\"".$url.$URL_baocun.date("Y")."/".date("m")."/".$math.".".$type."\"><img class=\"".$class_zuo."\" src=\"".$url.$URL_baocun.date("Y")."/".date("m")."/".$math.".".$type."\" width=\"".$img_virtue_with."\" height=\"".$img_virtue_heigh."\" /></a>",FILTER_SANITIZE_SPECIAL_CHARS)."</div><br />";
							echo "图片居中代码：<br />"."<div class=\"dm\">".filter_var("<a href=\"".$url.$URL_baocun.date("Y")."/".date("m")."/".$math.".".$type."\"><img class=\"".$class_zhong."\" src=\"".$url.$URL_baocun.date("Y")."/".date("m")."/".$math.".".$type."\" width=\"".$img_virtue_with."\" height=\"".$img_virtue_heigh."\" /></a>",FILTER_SANITIZE_SPECIAL_CHARS)."</div><br />";
							echo "图片居右代码：<br />"."<div class=\"dm\">".filter_var("<a href=\"".$url.$URL_baocun.date("Y")."/".date("m")."/".$math.".".$type."\"><img class=\"".$class_you."\" src=\"".$url.$URL_baocun.date("Y")."/".date("m")."/".$math.".".$type."\" width=\"".$img_virtue_with."\" height=\"".$img_virtue_heigh."\" /></a>",FILTER_SANITIZE_SPECIAL_CHARS)."</div><br />";
							
							echo "<form action=\"#\" method=\"post\">";
							echo "<input type=\"text\" class=\"delete\" value=\"".$URL_baocun.date("Y")."/".date("m")."/".$math.".".$type."\" name=\"delete\" /><br />";
							echo "<input type=\"submit\" class=\"submit\" value=\"删除\" />";
							echo "</form>";
							echo "</div>";
							}
						}		
					}
					else
					{
						if(!mkdir($URL_baocun.date("Y")))
						{
							echo "<div class=\"heard\">创建“年”文件夹失败，可能没有权限创建文件夹。</div>";
						}
						else
						{
							if(!mkdir($URL_baocun.date("Y")."/".date("m")))
							{
								echo "<div class=\"heard\">创建“月”文件夹失败，可能没有权限创建文件夹。</div>";
							}
							else
							{
							if($_POST["Logo"]=="YES")
							{
								$img_virtue_shuiyin = getimagesize($_FILES["file"]["tmp_name"]);
								
								if (($img_virtue_shuiyin['0']<$logoWith)||($img_virtue_shuiyin['1']<$logoHeight))
								{
									$X = $shuiyin_X;
									$Y = $shuiyin_Y;
								}
								else
								{
									if($_POST['shuiyin'] == "zx")
									{
										$X = $shuiyin_X;
										$Y = $img_virtue_shuiyin['1']-$logoHeight-$shuiyin_Y;
									}
									else if($_POST['shuiyin'] == "ys")
									{
										$X = $img_virtue_shuiyin['0']-$logoWith-$shuiyin_X;
										$Y = $shuiyin_Y;
									}
									else if($_POST['shuiyin'] == "yx")
									{
										$X = $img_virtue_shuiyin['0']-$logoWith-$shuiyin_X;
										$Y = $img_virtue_shuiyin['1']-$logoHeight-$shuiyin_Y;
									}
									else
									{
										$X = $shuiyin_X;
										$Y = $shuiyin_Y;
									}
								}
								
								if($type == "gif")
								{							
								$FileImg = imagecreatefromgif($_FILES["file"]["tmp_name"]);
								imagecopy ($FileImg,$LogoImg,$X,$Y,0,0,$logoWith,$logoHeight);
								imagegif($FileImg,$URL_baocun.date("Y")."/".date("m")."/".$math.".".$type);
								}
								else if($type == "jpg")
								{
								$FileImg = imagecreatefromjpeg($_FILES["file"]["tmp_name"]);
								imagecopy ($FileImg,$LogoImg,$X,$Y,0,0,$logoWith,$logoHeight);
								imagejpeg($FileImg,$URL_baocun.date("Y")."/".date("m")."/".$math.".".$type);
								}
								else if($type == "png")
								{
								$FileImg = imagecreatefrompng($_FILES["file"]["tmp_name"]);
								imagecopy ($FileImg,$LogoImg,$X,$Y,0,0,$logoWith,$logoHeight);
								imagepng($FileImg,$URL_baocun.date("Y")."/".date("m")."/".$math.".".$type);
								}
			
							}
							else if ($_POST["Logo"]=="NO")
							{				
								move_uploaded_file($_FILES["file"]["tmp_name"],$URL_baocun.date("Y")."/".date("m")."/".$math.".".$type);
							}
							$img_virtue = getimagesize($url.$URL_baocun.date("Y")."/".date("m")."/".$math.".".$type);
							if ($img_virtue['0'] >= $Blog_with)
							{
								$img_virtue_with = $img_virtue['0']*(1-(($img_virtue['0']-$Blog_with)/$img_virtue['0']));
								$img_virtue_heigh = $img_virtue['1']*(1-(($img_virtue['0']-$Blog_with)/$img_virtue['0']));
							}
							else
							{
								$img_virtue_with = $img_virtue['0'];
								$img_virtue_heigh = $img_virtue['1'];
							}
							echo "<div class=\"heard\">";
							echo "<img class=\"aligncenter\" src=\"".$url.$URL_baocun.date("Y")."/".date("m")."/".$math.".".$type."\" width=\"".$img_virtue_with."\" height=\"".$img_virtue_heigh."\" />";
							echo "图片居左代码：<br />"."<div class=\"dm\">".filter_var("<a href=\"".$url.$URL_baocun.date("Y")."/".date("m")."/".$math.".".$type."\"><img class=\"".$class_zuo."\" src=\"".$url.$URL_baocun.date("Y")."/".date("m")."/".$math.".".$type."\" width=\"".$img_virtue_with."\" height=\"".$img_virtue_heigh."\" /></a>",FILTER_SANITIZE_SPECIAL_CHARS)."</div><br />";
							echo "图片居中代码：<br />"."<div class=\"dm\">".filter_var("<a href=\"".$url.$URL_baocun.date("Y")."/".date("m")."/".$math.".".$type."\"><img class=\"".$class_zhong."\" src=\"".$url.$URL_baocun.date("Y")."/".date("m")."/".$math.".".$type."\" width=\"".$img_virtue_with."\" height=\"".$img_virtue_heigh."\" /></a>",FILTER_SANITIZE_SPECIAL_CHARS)."</div><br />";
							echo "图片居右代码：<br />"."<div class=\"dm\">".filter_var("<a href=\"".$url.$URL_baocun.date("Y")."/".date("m")."/".$math.".".$type."\"><img class=\"".$class_you."\" src=\"".$url.$URL_baocun.date("Y")."/".date("m")."/".$math.".".$type."\" width=\"".$img_virtue_with."\" height=\"".$img_virtue_heigh."\" /></a>",FILTER_SANITIZE_SPECIAL_CHARS)."</div><br />";
							
							echo "<form action=\"#\" method=\"post\">";
							echo "<input type=\"text\" class=\"delete\" value=\"".$URL_baocun.date("Y")."/".date("m")."/".$math.".".$type."\" name=\"delete\" /><br />";
							echo "<input type=\"submit\" class=\"submit\" value=\"删除\" />";
							echo "</form>";
							echo "</div>";
							}
						}
					}
				}
			}
			else
			{
				echo "<div class=\"heard\">";
				echo "文件类型错误！";
				echo "</div>";
			}
		}
	}
	else
	{
		setcookie("KEY_img","",time()-9999999);
		echo "<div class=\"heard\">";
		echo "<form action=\"#\" method=\"POST\">";
		echo "记住登陆：<input type=\"checkbox\" name=\"Key_name\" value=\"YES\" />";
		echo "密码:<input type=\"password\" name=\"Key\" />";
		echo "<input type=\"submit\" value=\"登陆\" />";
		echo "</form>";
		echo "</div>";
	}
}

if (!$_COOKIE['KEY_img']=="")
{
	if ($_COOKIE['KEY_img']==md5($key))
	{
		if (!str_ireplace("../","",$_POST['delete']))
		{
		}
		else
		{
			if (!unlink(str_ireplace("../","",$_POST['delete'])))
			{
				echo "<div class=\"heard\">";
				echo "文件删除失败，您输入的文件路径可能错误或不存在此文件，文件路径应该为“".$URL_baocun.date("Y")."/".date("m")."/test.png”这样。";
				echo "</div>";
			}
			else
			{
				echo "<div class=\"heard\">";
				echo "文件删除成功";
				echo "</div>";
			}
		}
	}
	else
	{
		echo "<div class=\"heard\">";
		echo "对不起，内部错误，请重新登陆";
		echo "</div>";
	}
}
if ($URL_baocun == "")
{
}
else
{
	if (file_exists($URL_baocun))
	{
	}
	else
	{
		echo "<div class=\"heard\">";
		echo "对不起了“图片保存文件夹路径”可能不存在，你需要手动创建“图片保存文件夹路径”，否则无法正常上传图片。";
		echo "</div>";
	}
}
?>
</body>
</html>