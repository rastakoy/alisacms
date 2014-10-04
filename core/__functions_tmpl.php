<?
//*******************************
function __tmpl_get_templates_js($tmpl){
	global $dop_query;
	$mass = __tmpl_template_items_to_array($tmpl);
	//print_r($mass);
	$ret = "\n";
	$query = "select * from items where href_name='$tmpl-javascript'  ";
	$resp = mysql_query($query);
	$row = mysql_fetch_assoc($resp);
	//print_r($row);
	//********
	$query = "select * from items where parent=$row[id] && folder=0 $dop_query order by prior asc   ";
	$resp = mysql_query($query);
	while ($row = mysql_fetch_assoc($resp)){
		$ret .= "<script type=\"text/javascript\" src=\"$row[name]\"></script>\n";
	}
	return $ret."\n";
}
//*******************************
function __tmpl_get_templates_folder_return_id(){
	$query = "select * from items where folder=1 && href_name='site_templates' limit 0,1   ";
	$resp = mysql_query($query);
	$row = mysql_fetch_assoc($resp);
	return $row["id"];
}
//*******************************
function __tmpl_template_items_to_array($tmpl){
	global $dop_query;
	$ret = array();
	$query = "select * from items where folder=1 && parent=".__tmpl_get_templates_folder_return_id()." 
	&& href_name='$tmpl'  $dop_query  limit 0,1   ";
	//echo $query;
	$resp = mysql_query($query);
	$row = mysql_fetch_assoc($resp);
	$query = "select * from items where parent=$row[id] $dop_query order by prior asc ";
	//echo $query;
	$resp = mysql_query($query);
	while($row = mysql_fetch_assoc($resp)){
		$ret[] = $row;
	}
	return $ret;
}
//*******************************
function __tmpl_tarray_to_styles($tmpl){
	$ret = "";
	$mass = __tmpl_template_items_to_array($tmpl);
	//print_r($mass);
	foreach($mass as $key => $val){
		if($val["href_name"] != "$tmpl-javascript")
		$ret .= "<link href=\"/styles/$tmpl/$val[href_name]\" rel=\"stylesheet\" type=\"text/css\" media=\"all\">\n";
	}
	return $ret;
}
//*******************************
function __tmpl_tarray_to_style_items($tmpl){
	global $dop_query;
	$ret = array();
	$mass = __tmpl_template_items_to_array($tmpl);
	//print_r($mass);
	foreach($mass as $key => $val){
		$squery = "select * from items where parent=".$val["id"]." && folder=0 $dop_query order by prior asc";
		//echo $squery."<br/>\n";
		//print_r($val);
		$file = "styles/".$tmpl."/".$val["href_name"];
		$sresp = mysql_query($squery);
		while($srow = mysql_fetch_assoc($sresp)){
			$ret["$val[href_name]"]["$srow[model_name]"] = __fa_css_to_array($file, $srow["model_name"]);
		}
		//__fa_clear_css($tmpl, $val["href_name"], $srow);
	}
	//******************************************
	return $ret;
}
//*******************************
function __tmpl_clear_css_from_tarray($style, $file, $tarray){
	$ret = "";
	//echo " tmpl=$style \n file=$file \n tarray:\n "; //print_r($tarray);
	$mass = $tarray[$style];
	//print_r($mass);
	foreach($mass as $key=>$val){
		$ret .= "$key{\n";
		foreach($val as $k=>$v){
			$ret .= trim($v)."\n";
		}
		$ret .= "}\n";
	}
	return $ret;
}
//*******************************
function __tmpl_items_from_css($tmpl){
	global $dop_query;
	$ret = "";
	$query = "select * from items where href_name='$tmpl' \n\n";
	//echo $query;
	$resp_tpl = mysql_query($query);
	$row_tpl = mysql_fetch_assoc($resp_tpl);
	$query = "select * from items where parent=$row_tpl[id] && folder=1 && href_name!='$tmpl-javascript' order by prior asc \n\n";
	//echo $query;
	$resp_tpl = mysql_query($query);
	while($row_tpl = mysql_fetch_assoc($resp_tpl)){
		//***********
		$squery = "select * from items where parent=$row_tpl[id] && folder=0 $dop_query order by prior asc  ";
		//echo "\n".$squery."\n";
		$sresp = mysql_query($squery);
		while($srow = mysql_fetch_assoc($sresp)){
			//echo "\n$srow[href_name]\n";
			$ret .= "$(\"$srow[model_name]\").click(function () {  \n";
			$ret .= "		if(sel_element_control) {  \n";
			$ret .= "			getelementproperties_light_element(\"$srow[model_name]\", this, '$row_tpl[href_name]');  \n";
			$ret .= "			return false;  \n";
			$ret .= "		}  \n";
			$ret .= "});  \n";
		}
	}
	return $ret;
}
//*******************************

//*******************************
?>