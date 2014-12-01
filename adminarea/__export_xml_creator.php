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
require_once("../core/__functions_pages.php");
require_once("../core/__functions_csv.php");
require_once("../core/__functions_mtm.php");
//require_once("../filter/__functions_filter.php");
require_once("../core/__functions_sitemap_0.1.php");
require_once("../core/__function_saver.php");
dbgo();
$items_allparent = "0";
$parents_mass = array();
//*********************************************************************************
function __fsm_generate_export_folders($table, $parent="0", $pref=""){
	global $dop_query, $site, $items_allparent, $parents_mass;
	//**********************************
	$rv = "";
	//**********************************
	$query = "select * from $table where parent=$parent && folder=1 $dop_query order by prior asc";
	$resp = mysql_query($query);
	while($row=mysql_fetch_assoc($resp)){
			$rv .= "   $pref<category id=\"$row[id]\"";
			if($row["parent"]!=0) $rv .= " parentID=\"$row[parent]\"";
			$rv .= ">$row[name]</category>\n";
			$rv .= __fsm_generate_export_folders($table, $row["id"], $pref."  ");
			$parents_mass[] = $row["id"];
	}
	//***********************
	return $rv;
}
//*********************************************************************************
function __fsm_generate_export_items($table, $parent="0"){
	global $dop_query, $site, $items_allparent, $parents_mass;
	//**********************************
	$rv = "";
	//**********************************
	$query = "select * from $table where folder=0 $dop_query order by prior asc";
	$resp = mysql_query($query);
	while($row=mysql_fetch_assoc($resp)){
		foreach($parents_mass as $key=>$val){
			if($row["parent"] == $val){
				$rv .= "<item id=\"$row[id]\">\n";
				$rv .= "<name>$row[name]</name>\n";
				$rv .= "<categoryId>$row[parent]</categoryId>\n";
				$rv .= "<price>$row[model_price]</price>\n";
				$rv .= "<priceuah>$row[model_price]</priceuah>";
				//$rv .= "<bnprice>1300</bnprice>\n";
				$rv .= "<url>http://www.snabtorg.com.ua/scatalog.php?item=$row[id]</url>\n";
				$mass = __fi_create_images_array($row["link"]);
				if($mass) { 
					$mass_link = explode("~", $row["link"]);
					$link = $mass_link[0];
					$rv .= "<image>http://www.snabtorg.com.ua/models_images/$link</image>\n";
				}
				//$querys = "select * from marks where id=$row[out_mark] order by id asc";
				//$resps = mysql_query($querys);
				//$rows=mysql_fetch_assoc($resps);
				$resp_dev = mysql_query("select * from items where id=$row[parent2]");
				$row_dev = mysql_fetch_assoc($resp_dev);
				$rv .=  $row_dev["name"];
				$rv .= "<vendor>$rows[name]</vendor>\n";
				
				$cont = $row["cont"];
				$cont = strip_tags($cont);
				$cont = str_replace("&nbsp;", " ", $cont);
				$cont = str_replace("&ndash;", "Ч", $cont);
				$cont = preg_replace("/&.*;/", "", $cont);
				$rv .= "<description>".$cont."</description>\n";
				//$rv .= "<warranty>12</warranty>\n";
				$rv .= "</item>\n";
			}
		}
	}
	//***********************
	return $rv;
}

//*********************************************************************************
$xml = "<?xml version=\"1.0\" encoding=\"windows-1251\"?>\n";
$xml .= "<price date=\"2008-09-19 12:55\"><name>»нтернет-магазин</name>\n";
$xml .= "<currency code=\"USD\">7.00</currency>\n";
$xml .= "<catalog>\n";
$xml .= __fsm_generate_export_folders("items");
$xml .= "</catalog>\n";
$xml .= "<items>\n";
$xml .= __fsm_generate_export_items("items");
$xml .= "</items>\n";
$xml .= "</price>";
//*********************************************************************************
echo $xml;
__fp_create_file("exportData.xml", $_SERVER['DOCUMENT_ROOT']."/", $xml);

?>