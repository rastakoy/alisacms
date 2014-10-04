<?
require_once($_SERVER['DOCUMENT_ROOT']."/__config.php");
dbgo();
$db_table = 0;

//echo $_REQUEST["do"];
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
$items = preg_replace("/\//", "", $_REQUEST["do"]);
$way_mass = explode("/", $_REQUEST["do"]);


if($way_mass[0]=="adminarea") {
	header("Location: http://$site/adminarea/admin.php"); exit; 
}

//print_r($way_mass);
if($way_mass[count($way_mass)-1] == "") { array_pop($way_mass); }

if(!$way_mass) {		$index_page=true; $way_mass = array("about","start");	}

//print_r($way_mass); exit;
//print_r($_SERVER);

require_once($_SERVER['DOCUMENT_ROOT']."/core/__functions.php");
require_once($_SERVER['DOCUMENT_ROOT']."/core/__functions_tree_semantic_user.php");
require_once($_SERVER['DOCUMENT_ROOT']."/core/__functions_images.php");
require_once($_SERVER['DOCUMENT_ROOT']."/core/__functions_csv.php");
require_once($_SERVER['DOCUMENT_ROOT']."/core/__functions_pages.php");
require_once($_SERVER['DOCUMENT_ROOT']."/core/__functions_date.php");
require_once($_SERVER['DOCUMENT_ROOT']."/core/__functions_templates.php");
require_once($_SERVER['DOCUMENT_ROOT']."/core/__functions_format.php");



function __sm_create_map($table, $parent){
	if($parent=="0"){
		$rv .= "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
		$rv .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
		//**********************************************************
		$rv .= "	<url>\n";
		$rv .="		<loc>http://www.sad-dom.kiev.ua</loc>\n";
		$rv .="		<lastmod>".strftime("%Y-%m-%d", mktime (date("G") ,date("i") ,date("s") , date("m")  ,date("d"),date("Y")))."</lastmod>\n";
		$rv .="		<changefreq>weekly</changefreq>\n";
		$rv .="		<priority>0.5</priority>\n";
		$rv .= "	</url>\n";
		//**********************************************************
		}
	$query = "select * from $table where parent=$parent && folder=0";
	$resp = mysql_query($query);
	while($row=mysql_fetch_assoc($resp)){
		$rv .= "	<url>\n";
		$rv .="		<loc>http://www.sad-dom.kiev.ua/".__fp_create_folder_way("items", $row["id"], 1)."</loc>\n";
		if($row["itemeditdate"]!=""){
			$rv.="		<lastmod>".strftime("%Y-%m-%d", $row["itemeditdate"])."</lastmod>\n";
			$rv.="		<changefreq>weekly</changefreq>\n";
			if($row["hot_item"]==1) $rv.="		<priority>0.8</priority>\n";
			else $rv.="		<priority>0.5</priority>\n";
		} else {
			if($row["itemadddate"]!=""){
				$rv .="		<lastmod>".strftime("%Y-%m-%d", $row["itemadddate"])."</lastmod>\n";
				$rv .="		<changefreq>weekly</changefreq>\n";
				if($row["hot_item"]==1) $rv.="		<priority>0.8</priority>\n";
				else $rv .="		<priority>0.5</priority>\n";
			}
		}
		$rv .= "	</url>\n";
	}
	//***********************
	$query = "select * from $table where parent=$parent && folder=1";
	$resp = mysql_query($query);
	while($row=mysql_fetch_assoc($resp)){
		$rv .= "	<url>\n";
		$rv .="		<loc>http://www.sad-dom.kiev.ua/".__fp_create_folder_way("items", $row["id"], 1)."</loc>\n";
		$rv .="		<lastmod>".strftime("%Y-%m-%d", mktime (date("G") ,date("i") ,date("s") , date("m")  ,date("d"),date("Y")))."</lastmod>\n";
		$rv .="		<changefreq>weekly</changefreq>\n";
		$rv .="		<priority>0.5</priority>\n";
		$rv .= "	</url>\n";
		$rv .= __sm_create_map($table, $row["id"]);
	}
	//***********************
	if($parent=="0"){
		$rv .= "</urlset>";
	}
	return $rv;
}
//****************************************************************
//echo __sm_create_map("items", 0);
$sitemap_name = $_SERVER['DOCUMENT_ROOT']."/sitemap.xml";
$rsp = mysql_query("select * from items where itemeditdate=0 ");
while($ro=mysql_fetch_assoc($rsp)){
	$itemeditdate = mktime (date("G") ,date("i") ,date("s") , date("m")  ,date("d"),date("Y"));
	$query = "update items SET 	itemeditdate = $itemeditdate 	where id = $ro[id]";
	$rsp_=mysql_query($query);
}
if(file_exists($sitemap_name)) unlink ($sitemap_name);
if(file_exists($_SERVER['DOCUMENT_ROOT']."/sitemap2.xml")) unlink ($_SERVER['DOCUMENT_ROOT']."/sitemap2.xml");
__fp_create_file("sitemap.xml", $_SERVER['DOCUMENT_ROOT']."/", __sm_create_map("items", 0));

$smtxt = __sm_create_map("items", 0);
$smtxt = preg_replace("/www./", "", $smtxt);
$smtxt = preg_replace("/sitemaps.org/", "www.sitemaps.org", $smtxt);

//__fp_create_file("sitemap2.xml", $_SERVER['DOCUMENT_ROOT']."/", $smtxt);

$file = "http://www.google.com/webmasters/tools/ping?sitemap=http://www.sad-dom.kiev.ua/sitemap.xml ";
$lines = file($file);
?>