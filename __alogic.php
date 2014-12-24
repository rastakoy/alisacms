<?
session_start();
//print_r($_SESSION);
require_once($_SERVER['DOCUMENT_ROOT']."/__config.php");
dbgo();
$db_table = 0;
//echo $_REQUEST["do"];
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
$items = preg_replace("/\//", "", $_REQUEST["do"]);

if($_SERVER['REQUEST_URI']=="/adminarea/") {
	header("Location: ".$site."adminarea/admin.php"); exit; 
}

$gets=false;
$ways = preg_replace("/^\//", "", $_SERVER["REQUEST_URI"]);
$ways = explode("/", $ways);
if($ways[count($ways)-1]=="") array_pop($ways);
if(substr($ways[count($ways)-1], 0, 1) == "[") { 
	$gets =  substr(    $ways[count($ways)-1],    1,     strlen($ways[count($ways)-1])-2    );
	echo "gets=$gets";
	$ways[count($ways)-1] = "";
	array_pop($ways);
	$getsm  =explode("=", $gets);
	if(count($getsm)>1){
		if($getsm[0]=="g_login") $g_login = $getsm[1];
	}
	$gets=explode(";", $gets);
	$getsTmp = array();
	foreach ($gets as $key=>$val){
		$a = explode("=", $val);
		$getsTmp[$a[0]] = $a[1];
	}
	$gets = $getsTmp;
}
//echo "gets=$gets";
//echo "<pre>"; print_r($gets); echo "</pre>";


//print_r($way_mass); exit;
//print_r($_SERVER);

require_once("core/__functions.php");
require_once("core/__functions_tree_semantic_user.php");
require_once("core/__functions_images.php");
require_once("core/__functions_csv.php");
require_once("core/__functions_pages.php");
require_once("core/__functions_date.php");
require_once("core/__functions_templates.php");
require_once("core/__functions_format.php");
require_once("core/__functions_register.php");
require_once("core/__functions_post.php");
require_once("core/__functions_prices.php");
require_once("core/__functions_forms.php");
require_once("core/__function_saver.php");
require_once("core/__functions_zakaz.php");
require_once("core/__functions_tmpl.php");
require_once("core/__functions_auto.php");
require_once("core/__functions_mtm.php");
require_once("core/__functions_constructor.php");
require_once("filter/__functions_filter.php");
require_once("core/__functions_order.php");

require_once("__register.php"); //Ðåãèñòðàöèÿ âïåðåäè êîðçèíû ÎÁßÇÀÒÅËÜÍÎ!!!
require_once("__torec.php");
require_once("filter/__filter_head.php");


if(count($ways) == 0 || $ways[0]==""){
	$sresp = mysql_query("select * from items where href_name='start' limit 0,1  ");
	$srow = mysql_fetch_assoc($sresp);
	$way = __fp_create_folder_way("items", $srow["id"], 1);
	header("Location: $way");
	//$ways = explode("/", $way);
}
$current = __fp_get_row_from_way(  $ways, "items"  );
if(__fp_test_item_for_show($current["id"])) header("Location: /start/");
if($current['parent']!=0){
	$parentResp = mysql_query("select * from items where id=$current[parent] ");
	$parent = mysql_fetch_assoc($parentResp);
}
//print_r($current);
//print_r($ways);

?>