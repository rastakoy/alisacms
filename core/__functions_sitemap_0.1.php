<?
function __fsm_generate_sm_items($table, $parent="0"){
	global $dop_query, $site, $items_allparent;
	//**********************************
	$rv = "";
	//**********************************
	if($parent=="0"){
		$rv .= "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
		$rv .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
		//**********************************************************
		$rv .= "	<url>\n";
		$rv .="		<loc>$site</loc>\n";
		$rv .="		<lastmod>".strftime("%Y-%m-%d", mktime (date("G") ,date("i") ,date("s") , date("m")  ,date("d"),date("Y")))."</lastmod>\n";
		$rv .="		<changefreq>weekly</changefreq>\n";
		$rv .="		<priority>0.5</priority>\n";
		$rv .= "	</url>\n";
		//**********************************************************
		}
	$query = "select * from $table where parent=$parent && folder=0 $dop_query order by prior asc ";
	$resp = mysql_query($query);
	while($row=mysql_fetch_assoc($resp)){
		if(  __fp_top_is_need($row["parent"], "items", "items")  ){
			$rv .= "	<url>\n";
			$rv .="		<loc>$site".__fp_create_folder_way("items", $row["id"], 1)."</loc>\n";
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
	}
	//***********************
	$query = "select * from $table where parent=$parent && folder=1 $dop_query order by prior asc";
	$resp = mysql_query($query);
	while($row=mysql_fetch_assoc($resp)){
		if(  __fp_top_is_need($row["parent"], "items", "items") || $row["id"] == $items_allparent  ){
			$rv .= "	<url>\n";
			$rv .="		<loc>$site".__fp_create_folder_way("items", $row["id"], 1)."</loc>\n";
			$rv .="		<lastmod>".strftime("%Y-%m-%d", mktime (date("G") ,date("i") ,date("s") , date("m")  ,date("d"),date("Y")))."</lastmod>\n";
			$rv .="		<changefreq>weekly</changefreq>\n";
			$rv .="		<priority>0.5</priority>\n";
			$rv .= "	</url>\n";
			$rv .= __fsm_generate_sm_items($table, $row["id"]);
		}
	}
	//***********************
	if($parent=="0"){
		$rv .= "</urlset>";
	}
	return $rv;
}
?>