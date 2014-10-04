<?
header("Content-type: text/plain; charset=windows-1251");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
require_once("../__config.php");
require_once("../core/__functions.php");
require_once("../core/__functions_tree_semantic.php");
require_once("../core/__functions_format.php");
require_once("../core/__functions_images.php");
require_once("../core/__functions_forms.php");
require_once("../core/__functions_loadconfig.php");
require_once("../core/__functions_full.php");
//require_once("__functions_register.php");
//require_once("__functions_rating.php");
//require_once("__functions_pages.php");
dbgo();
//*************************
$paction 	= $_POST["paction"];
$pid 			= $_POST["pid"]; 
//*************************
if($paction=="get_item_type"){
	$resp = mysql_query("select * from itemstypes where id=$pid");
	$row = mysql_fetch_assoc($resp);
	$mass = explode("\n", $row["pairs"]);
	foreach($mass as $key=>$val){
		$val = explode("===", $val);
		if($val[3]==""){
			
		} else {
			echo $val[3]." <a href=\"javascript:show_popup('$pid', '$key')\" onClick=\"\"><img class=\"itemstypes_img\" id=\"it_img_".$pid."_".$key."\" src=\"images/itemstypes/arrowbottom.gif\" border=\"0\"></a>
			<div id=\"div_it_pref_".$pid."_".$key."\"></div>";
		} 
	}
}
//*************************
if($paction=="get_it_pref"){
	$myitem = $_POST["myitem"];
	$myitem_sub = $_POST["myitem_sub"];
	//********************************
	$resp = mysql_query("select * from itemstypes where id=$myitem");
	$row = mysql_fetch_assoc($resp);
		//$resptypes = mysql_query("select * from itemstypes where id=$item_type");
		//$row_ty = mysql_fetch_assoc($resptypes);
		//echo "<pre>"; print_r($row_ty); echo "</pre>";
		//$mass = explode("\n", $row_ty["pairs"]);
	$mass = explode("\n", $row["pairs"]);
	//echo $mass[$myitem_sub];
	$selector = explode("===", $mass[$myitem_sub]);
	//$selector = $selector[0];
	//foreach($mass as $key=>$val){
	//	$val = explode("===", $val);
	//	if($val[3]==""){
	//		//
	//	} else {
	//		//echo $val[3]." <a href=\"javascript:show_popup('$pid', '$key')\" onClick=\"\"><img class=\"itemstypes_img\" id=\"it_img_".$pid."_".$key."\" src=\"images/itemstypes/arrowbottom.gif\" border=\"0\"></a>
	//		//<div id=\"div_it_pref_".$pid."_".$key."\"></div>";
	//	} 	
	//}
	echo __lc_create_mconf($selector);
}
//*************************
$myitem = $_POST["myitem"];
$myitem_sub = $_POST["myitem_sub"];
$mconf_val = $_POST["mconf_val"];
//***********
if($paction=="__lc_mconf_get_data"){
	echo __lc_mconf_get_data($myitem, $myitem_sub, $mconf_val);
}
?>