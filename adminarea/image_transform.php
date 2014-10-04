<?php
$__tree_show_image = 1;
$tree_index = 0;
//**************************************
$image = preg_replace("/simg_/", "", $_GET["img"]);

//**************************************
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
require_once("../__config.php");
require_once("../core/__functions.php");
require_once("../core/__functions_csv.php");
require_once("../core/__functions_tree_semantic.php");
require_once("../core/__functions_images.php");
require_once("../core/__functions_pages.php");
dbgo();
//**************************************
$table = "images";
$folder = $_GET["folder"];
if($folder && $folder!="loadimages") $table = "filemanager";
$query = "select * from $table where id=$image";
if(!$folder) $folder = "loadimages";
//echo $query;
$respi = mysql_query($query);
$rowi = mysql_fetch_assoc($respi);

//print_r($_GET);
//echo "../$folder/".$rowi["link"];

$image_in=imagecreatefromjpeg("../$folder/".$rowi["link"]); //Создаем объект $image_in, в который будет помещено исходящее изображение
$img_w = imagesx($image_in);  //Ширина изображения
$img_h = imagesy($image_in);
//**************************************
$outinfo = "";
//require_once("__class_csvToArray.php"); // Загрузка файла библиотеки
//$csv_class =& new csvToArray("csv_class"); //Объявление класса csv 
$__page_parent=$_GET["parent"];
//print_r($_POST);
//exit;
//Запись отредактированных данных о директории
$resize_x = $_GET["resize_x"];
$resize_y = $_GET["resize_y"];
$crop_x = $_GET["crop_x"];
$crop_y = $_GET["crop_y"];
$crop_fx = $_GET["crop_fx"];
$crop_fy = $_GET["crop_fy"];


if($resize_x) {
	$image = "../$folder/".$rowi["link"];
	$image_in=imagecreatefromjpeg($image); //Создаем объект $image_in, в который будет помещено исходящее изображение
	$img_w = imagesx($image_in);  //Ширина изображения
	$img_h = imagesy($image_in); //Высота изображения
	$new_w = $resize_x; // Определение ширины
	$new_h = $resize_y; // Определение высоты
	$image_out=imagecreatetruecolor($new_w,$new_h);
	//$bg = imagecolorallocate($image_out, 255,255,255);
	$bg = imagecolorallocatealpha($image_out, 255,255,255, 0);
	imagefilledrectangle($image_out, 0, 0, $new_w, $new_h, $bg);
	imagecopyresampled($image_out,$image_in, 0, 0, 0, 0, $new_w, $new_h, imagesx($image_in),imagesy($image_in));
	unlink($image);
	imagejpeg($image_out, $image, 100);
	if($crop_x && $crop_y){
		$image_in=imagecreatefromjpeg($image); //Создаем объект $image_in, в который будет помещено исходящее изображение
		$img_w = imagesx($image_in);  //Ширина изображения
		$img_h = imagesy($image_in); //Высота изображения
		$new_w = $crop_fx; // Определение ширины
		$new_h = $crop_fy; // Определение высоты
		$image_out=imagecreatetruecolor($new_w,$new_h);
		//$bg = imagecolorallocate($image_out, 255,255,255);
		$bg = imagecolorallocatealpha($image_out, 255,255,255, 0);
		imagefilledrectangle($image_out, 0, 0, $new_w, $new_h, $bg);
		
		$pad_x=0;
		$pad_y=0;
		if($crop_x<0) {
			$pad_x=$crop_x*-1;
			$crop_x=0;
		}
		if($crop_y<0) {
			$pad_y=$crop_y*-1;
			$crop_y=0;
		}
		imagecopyresampled($image_out,$image_in, $pad_x, $pad_y, $crop_x, $crop_y, imagesx($image_in), imagesy($image_in), imagesx($image_in),imagesy($image_in));
		unlink($image);
		$dir = "../$folder/";
		if (  is_dir($dir  )) {
			if (  $dh = opendir(  $dir  )  ) {
				while (  (  $file = readdir(  $dh  )  ) !== false  ) {
					if(  filetype(  $dir . $file  ) == "dir"  &&  $file != "."  &&  $file != ".."  ) {
						//echo "filename: $file : filetype: " . filetype(  $dir . $file  ) . "<br/>\n";
						if(  file_exists(  "../$folder/$file/".$rowi["link"]  )  ) unlink(  "../$folder/$file/".$rowi["link"]  );
					}
				}
				closedir(  $dh  );
			}
		}
		
	}
	//echo "crop_x=$crop_x; crop_y=$crop_y;";
	//header("Content-type: image/jpeg");
	imagejpeg($image_out, $image, 100);
	//echo "<script>top.images_get_images(); top.hide_edit_img_popup(); <"."/script>";
	exit;
	
}
?>

<html>
<head>
<title><?  echo $__page_title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<!--<meta http-equiv="Content-Type" content="text/html; charset=utf-8">-->
<link href="style.css" rel="stylesheet" type="text/css">
<link href="tree/seo_style_tree.css" rel="stylesheet" type="text/css"/>
<link href="styles/folders.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="styles/jquery-ui-1.7.3.custom.css">

<script type="text/javascript" src="js/jquery-1.7.1.js"></script>

<script src="js/jquery.ui.core.js"></script>
<script src="js/jquery.ui.widget.js"></script>
<script src="js/jquery.ui.mouse.js"></script>
<script src="js/jquery.ui.resizable.js"></script>

<script src="js/jquery.bgiframe-2.1.2.js"></script>
<script src="js/jquery.ui.draggable.js"></script>
<script src="js/jquery.ui.dialog.js"></script>

<script src="js/jquery.ui.slider.js"></script>


<script src="js/jquery.effects.core.js"></script>
<script src="js/jquery.effects.fade.js"></script>
<script src="js/jquery.effects.transfer.js"></script>


<script>
var mFolder=false;
<?  if($folder) { echo "mFolder='$folder';\n"; } ?>
	$(function() {
		$( "#par_hslider" ).slider({
			orientation: "vertical",
			range: "min",
			min: 20,
			max: 100,
			value: percent,
			slide: function( event, ui ) {
				//$( "#amount" ).val( ui.value );
				percent = ui.value;
				init_img_zoom();
			}
		});
		$( "#amount" ).val( $( "#par_hslider" ).slider( "value" ) );
	});
</script>

<!--<script src="js/jquery.ui.accordion.js"></script>
<link rel="stylesheet" href="http://jqueryui.com/themes/base/jquery.ui.all.css">-->

<style>
#par_hslider{
	z-index:4500;
	height: 450px;
	width: 10px;
	position:absolute;
	top: 30px;
	left: 30px;
}
#slider{
	z-index:5000;
}
#draggable {
	width: 800px;
	height: 600px;
	padding: 0px;
	top: 75px;
	left: 75px;
	filter:alpha(opacity=40);
    -moz-opacity: 0.4;
    -khtml-opacity: 0.4;
	opacity: 0.4;
	background-color: #00FFFF;
	border: 1px solid #FF0000;
	position:absolute;
}

#resizable { width: <? echo $img_w; ?>px; height: <? echo $img_h; ?>px;
	padding: 0px;
	filter:alpha(opacity=10);
    -moz-opacity: 0.1;
    -khtml-opacity: 0.1;
	opacity: 0.1;
}
	#resizable h3 { text-align: center; margin: 0; }
	#rimg{
	position: absolute;
	left: 0px;
	top: 0px;
}

#mycontrol{
	background-color: #CCCCCC;
	position: absolute;
	height: 30px;
	width: 500px;
	left: 200px;
	top: 20px;
	z-index: 5500;
	padding: 15px;
}
</style>


<style>
		.toggler { width: 500px; height: 200px; position: relative; }
		#button { padding: .5em 1em; text-decoration: none; }
		#effect { width: 240px; height: 135px; padding: 0.4em; position: relative; }
		#effect h3 { margin: 0; padding: 0.4em; text-align: center; }
		.ui-effects-transfer { border: 2px dotted gray; } 
</style>

</head>



<body>
<img style="display:;" src="../<?  echo $folder; ?>/<? echo $rowi["link"]; ?>" name="rimg"  style="width:<? echo $img_w; ?>px; height:<? echo $img_h; ?>px;" id="rimg">

<div id="resizable" class="ui-widget-content"></div>

<div id="draggable" title="Basic dialog" style="display:"></div>

<div id="mycontrol">
<select name="formats" size="1" id="formats" onChange="close_ieditor=true;init_mask(this.value);" onFocus="close_ieditor=false"><?
	$resp_f = mysql_query("select * from items where href_name='images_formates' order by prior asc  ");
	$row_f = mysql_fetch_assoc($resp_f);
	$resp_f = mysql_query("select * from items where parent=$row_f[id] $dop_query order by prior asc ");
	$count = 0;
	while($row_f=mysql_fetch_assoc($resp_f)){
		$t =  "<option value=\"$count\">$row_f[mtitle]x$row_f[mdesc] ";
		if($row_f["comm"]!="") $t .= "($row_f[comm])";
		$t .= "</option>\n";
		echo $t;
		$count++;
	}
?></select>
<select name="select" size="1" id="select" onChange="close_ieditor=true;percent=this.value; init_img_zoom();" onFocus="close_ieditor=false">
     <option value="100" selected="selected">100%</option>
     <option value="90">90%</option>
	 <option value="80">80%</option>
	 <option value="70">70%</option>
	 <option value="60">60%</option>
	 <option value="50">50%</option>
	 <option value="40">40%</option>
	 <option value="30">30%</option>
	 <option value="20">20%</option>
	 <option value="10">10%</option>
</select> 
<input type="button" name="Button" value="Сохранить" onClick="save_img()"> 
<input type="button" name="Submit2" value="Отмена" onClick="top.hide_edit_img_popup()">
</div>


<script>
$( "#resizable" ).resizable({
   resize: function(event, ui) {

		resimg_width  = resimg.style.width.replace("px", "");
		resimg_height = resimg.style.height.replace("px", "");
		
		userimg.style.width = resimg_width+"px";
		userimg.style.height = resimg_height+"px";
		
		img_width  = resimg_width  / percent * 100;
		img_height = resimg_height / percent * 100;
		
   }
});
</script>



<script>
$(function() {
		$( "#draggable").draggable({
		//$( "#draggable, #resizable" ).draggable({
			//cursorAt: { left: 50, top: 50 },
			drag: function(event, ui) {
				
				ubg_left  = bgimg.style.left.replace("px", "");
				ubg_top = bgimg.style.top.replace("px", "");
				
				resbg_left =  resimg.style.top.replace("px", "");
				resbg_right = resimg.style.left.replace("px", "");
				
				bg_left = ubg_left / percent * 100   -  resbg_left / percent * 100 ;
				bg_top = ubg_top / percent * 100   -  resbg_right / percent * 100 ;
				
				if(this.id=="resizable"){
					$(userimg).css("top", resbg_left );
					$(userimg).css("left", resbg_right );
				}
				
				//document.title = bg_left+":::"+bg_top;
				
			}
		});
	});
</script>


<script>
var resimg = document.getElementById("resizable");
var userimg = document.getElementById("rimg");
var bgimg = document.getElementById("draggable");

var ubg_width  	= 800;
var bg_width    	= 800;
var ubg_height 	= 600;
var bg_height   	= 600;

//*************************************

var bg_xy = new Array(<?
	$resp_f = mysql_query("select * from items where href_name='images_formates' order by prior asc  ");
	$row_f = mysql_fetch_assoc($resp_f);
	$resp_f = mysql_query("select * from items where parent=$row_f[id] $dop_query order by prior asc ");
	$count = 0;
	while($row_f=mysql_fetch_assoc($resp_f)){
		echo "new Array($row_f[mtitle], $row_f[mdesc])";
		$count++;
		if($count != mysql_num_rows($resp_f)) {  echo ","; }
		echo "\n";
	}
?>
);
var bg_left = 75;
var bg_top = 75;
var ubg_left = 75;
var ubg_top = 75;
 
var percent = 100;

var bg_xy_index = 1;

var resimg_width = <? echo $img_h; ?>;
var img_width = <? echo $img_w; ?>;
var resimg_height = <? echo $img_h; ?>;
var img_height = <? echo $img_h; ?>;

function init_img_zoom(){

	ubg_width  = bg_xy[bg_xy_index][0] / 100 * percent;
	ubg_height = bg_xy[bg_xy_index][1] / 100 * percent;
	
	bgimg.style.width  = ubg_width + "px";
	bgimg.style.height = ubg_height+ "px";
	
	ubg_left = bg_left  / 100 * percent;
	ubg_top = bg_top  / 100 * percent;
	
	bgimg.style.left = ubg_left + "px";
	bgimg.style.top = ubg_top + "px";
	
	//********************************************
	
	resimg_width  = img_width  / 100 * percent;
	resimg_height = img_height / 100 * percent;
	
	resimg.style.width  = resimg_width +"px";
	resimg.style.height = resimg_height+"px";
	
	userimg.style.width  = resimg_width +"px";
	userimg.style.height = resimg_height+"px";
	
}

function init_mask(maskval){
	
	bg_xy_index = maskval;
	
	ubg_width  = bg_xy[bg_xy_index][0] / 100 * percent;
	ubg_height = bg_xy[bg_xy_index][1] / 100 * percent;
	
	bgimg.style.width  = ubg_width + "px";
	bgimg.style.height = ubg_height+ "px";
	
	bg_width  = ubg_width  / percent * 100;
	bg_height = ubg_height / percent * 100;
	
}

function save_img(){
	var href="";
	href += "?crop_x="+bg_left+"&crop_y="+bg_top+"&resize_x="+img_width+"&resize_y="+img_height+"&img=<?  echo $image; ?>";
	href += "&crop_fx="+bg_xy[bg_xy_index][0]+"&crop_fy="+bg_xy[bg_xy_index][1];
	if(mFolder) href += "&folder="+mFolder;
	//alert(href);
	location.href=href;
}

</script>

<script>
$(function() {
	$( "#resizable" ).resizable();
});

//function start_res(){
//	$( "#resizable" ).resizable();
//}
//start_res();
</script>

<!--<p>
	<label for="amount">Minimum number of bedrooms:</label>
	<input type="text" id="amount" style="border:0; color:#f6931f; font-weight:bold;" />
</p>-->

</body>
</html>