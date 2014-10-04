<?
$tree_index = 0;
//**************************************
$parent = $_GET["parent"];
if(!$parent) $parent="0";
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
require_once("../__config.php");
require_once("../core/__functions.php");
require_once("../core/__functions_csv.php");
require_once("../core/__functions_tree_semantic.php");
require_once("../core/__functions_images.php");
require_once("../core/__functions_pages.php");
dbgo();
$resp = mysql_query("select * from images order by id desc limit 0,1");
	$row=mysql_fetch_assoc($resp);
	if($row["parent"]){
		$image = "../loadimages/$row[link]";
		//$image = "../images/__testres.jpg";
		$image_in=imagecreatefromjpeg($image);
		$img_w = imagesx($image_in);
		$img_h = imagesy($image_in);
		$sresp = mysql_query("select * from items where id=$row[parent]");
		$srow = mysql_fetch_assoc($sresp);
		$imgname = $srow["href_name"]."_.jpg";
		
		$res = copy("../loadimages/".$row["link"], "../loadimages/".$srow["href_name"]."_.jpg");
		
		
		echo "imgname=$imgname<br/>\n";
		
		$image1 = __images_load_and_convert($row["link"], $imgname, 8000000, "../tmp/", "../loadimages/", $img_w."x$img_h");
		
		unlink("../loadimages/".$row["link"]);
		unlink("../loadimages/".$srow["href_name"]."_.jpg");
		$respo = mysql_query("update images set link='$image1' where id=$row[id] ");
		
		echo "image1=$image1<br/>\n";
	}
?>