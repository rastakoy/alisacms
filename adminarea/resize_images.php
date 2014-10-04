<?php
$res_perc = $_POST["perc"];
$max_size = $_GET["max_size"];
if(!$max_size) $max_size = $_POST["max_size"];
$max = $_GET["show_maxx"];
if(!$max) $max = $_POST["maxxx"];
$show_maxx = $_GET["show_maxx"];
if(!$show_maxx) $show_maxx = $_POST["show_maxx"];
if(!$show_maxx) $show_maxx = 1200;
//print_r($_GET);
//print_r($_POST);
//******************************************
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
require_once("../__config.php");
require_once("../core/__functions.php");
require_once("../core/__functions_csv.php");
require_once("../core/__functions_tree.php");
require_once("../core/__functions_images.php");
require_once("../core/__functions_prices.php");
require_once("../core/__functions_post.php");
require_once("../core/__functions_format.php");
require_once("../core/__functions_pages.php");
dbgo();
require_once("__class_csvToArray.php"); // Загрузка файла библиотеки
$csv_class = new csvToArray("csv_class"); //Объявление класса csv 
$__page_name = "index";
$__page_title = "Обжимка изображений";
?>
<html>
<?  require_once("__head.php"); ?>
<?  //require_once("__js_show_block.php"); ?>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.8.3.js"></script>
<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css" />
<script>
var resmass = new Array();
//*************
function get_selected_elements(){
	mobj = document.getElementById("selectable");
	objs = mobj.getElementsByTagName("img");
	sendval = "";
	for(i=0; i<objs.length; i++){
		obj = objs[i];
		if(obj.className == "ui-state-default ui-selectee ui-selected"){
			//alert(obj.src+":: index="+i+":: massindex="+resmass[i]);
			sendval += resmass[i]+",";
		}
	}
	document.getElementById("tfimages").value = sendval;
}
//*************
function show_maxxxx(){
	window.location.href="?show_maxx="+document.getElementById("maxxx").value;
}
//*************
$(function() {
	$("#selectable").selectable({
		stop: function(event, ui) {
			get_selected_elements();
		}
	});
});
//*************
</script>
<style>
	#feedback { font-size: 1.4em; }
	#selectable .ui-selecting { background: #FECA40; }
	#selectable .ui-selected { background: #F39814; color: white; }
	#selectable { list-style-type: none; margin: 0; padding: 0; width: 450px; }
	#selectable li { margin: 3px; padding: 1px; float: left; width: 100px; height: 80px; font-size: 2em; text-align: center; }
	#selectable img { margin: 0px; padding: 3px; float: left; text-align: center; }
	#behavior { margin: 0px; padding: 3px; float: left; text-align: left; height: 300px; width: 270px; background-color:#CCCCCC; }
</style>
<!--  ------------------------------------------------------------------------------------------- -->
<body style="font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif; line-height: 18px; padding: 14px;"><?

//PROGRAM CODE HERE
//****************
if($_POST["tfimages"]){
	$query = "select * from images where ";
	$mass = explode(",",$_POST["tfimages"]);
	//print_r($mass);
	foreach($mass as $key=>$val){
		if($val){
			$resp = mysql_query("select * from images where id=$val  ");
			$row = mysql_fetch_assoc($resp);
			transform_image($row["link"], $max, $res_perc);
		}
	}
	//$resp = mysql_query("select * from images where link!=''      ");
	//$count=0;
	//while($row=mysql_fetch_assoc($resp)){
		//transform_image($row["link"], $max, $res_perc);
		//if($count==0){
		//}
		//$count++;
	//}
}
//****************
//-----------------------------------------------------------------------
//****************
function proportional($a, $a1, $b){
	$b1 = $a1* $b / $a;
	return $b1; 
}
//****************
function transform_image($link, $max, $res_perc){
	//echo "$link ::  ";
	$image_in=imagecreatefromjpeg("../loadimages/".$link); 
	$img_w = imagesx($image_in);
	$img_h = imagesy($image_in);
	//echo "$img_w"."x$img_h<br/>\n";
	if($img_w > $max && $img_w > $img_h){
		echo "<img width=\"40\" style=\"display:none\"  ";
		echo "src=\"../imgres.php?link=$link&resize_x=$max&perc=$res_perc&saver=loadimages/$link";
		echo "&resize_y=".proportional($img_w, $max, $img_h)."\">";
	}
	if($img_h > $max && $img_h > $img_w){
		echo "<img height=\"40\"  style=\"display:none\"  ";
		echo "src=\"../imgres.php?link=$link&resize_y=$max&perc=$res_perc&saver=loadimages/$link";
		echo "&resize_x=".proportional($img_h, $max, $img_w)."\">";
	}
}
//****************
?>
<h2>Обжимка изображений</h2>
<?
//echo "show_max=$show_maxx<br/>";
?>
<ul id="selectable" style="float:left;">
<?
$resp = mysql_query("select * from images where link!=''      ");
$count="0";
while($row=mysql_fetch_assoc($resp)){
	if(file_exists("../loadimages/".$row["link"])){
		$image_in=imagecreatefromjpeg("../loadimages/".$row["link"]); 
		$img_w = imagesx($image_in);
		$img_h = imagesy($image_in);
		$fsize = filesize("../loadimages/".$row["link"]);
			if($img_w>$show_maxx || $img_h>$show_maxx || $fsize>$max_size){
				echo "<img width=\"100\" class=\"ui-state-default\" ";
				echo "src=\"../imgres.php?link=$row[link]&resize_x=100&resize_y=100\">";
				echo "<script>resmass[$count] = $row[id]</script>";
				$count++;
			}
		
	}
}
?>
</ul>
<div id="behavior">
<form action="<?  echo $form_link; ?>?<? if($edit) echo "edited=$edit"; ?>"  
method="post" enctype="multipart/form-data" name="form1">
<b>Правило обжимки:</b>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="70" height="30">Размер</td>
    <td><input name="maxxx" type="text" id="maxxx" style="width:97%" value="<?  if($max) echo $max; else echo "1200"; ?>"></td>
  </tr>
  <tr>
    <td width="70" height="30">Объем</td>
    <td><input name="max_size" type="text" id="max_size" style="width:97%" value="<?  echo $max_size;  ?>"></td>
  </tr>
  <tr>
    <td width="70" height="30">Качество</td>
    <td><input name="perc" type="text" id="perc" style="width:97%" value="80"></td>
  </tr>
  <tr>
    <td height="30" colspan="2" align="center"><textarea name="tfimages" rows="5" id="tfimages" style="width:94%"></textarea></td>
    </tr>
  <tr>
    <td width="70" height="30"><input name="show_maxx" type="hidden" id="show_maxx" value="<?  echo $show_maxx; ?>"></td>
    <td><input type="submit" name="Submit" value="Обжать">
	<input type="button" name="button_max" value="Показать соответствующие" onClick="show_maxxxx()"></td>
  </tr>
</table>
</form>
</div>
</body>
</html>
