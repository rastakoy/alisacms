<?
function __format_txt_format($output){
	$color_red = "#C7131F";	
	$color_green = "#009900";
	$color_blue = "#1F2663";
	$color_yelow = "#FFFF00";
	
	$output = eregi_replace("\n", "<br/>\n", $output);
	$output = eregi_replace("жир\]", "</strong>", eregi_replace("\[жир", "<strong>", $output));
	$output = eregi_replace("\[абзац\]", "&nbsp;&nbsp;&nbsp;", $output);
	$output = eregi_replace("кур\]", "</i>", eregi_replace("\[кур", "<i>", $output));
	$output = eregi_replace("красный\]", "</font>", eregi_replace("\[красный", "<font color=\"$color_red\">", $output));
	$output = eregi_replace("зеленый\]", "</font>", eregi_replace("\[зеленый", "<font color=\"$color_green\">", $output));
	$output = eregi_replace("синий\]", "</font>", eregi_replace("\[синий", "<font color=\"$color_blue\">", $output));
	$output = eregi_replace("желтый\]", "</font>", eregi_replace("\[желтый", "<font color=\"$color_yelow\">", $output));
	$output = eregi_replace("ICQ", "<img src=\"images/icq.gif\" width=\"16\" height=\"17\" align=\"absmiddle\" /> ICQ", $output);
	
	return $output;

}
//********************************************
function __format_txt_is_digit($param){
	$ret_val = true;
	for($i=0; $i<strlen($param); $i++){
		$a = substr($param, $i, 1);
		if( $a != "1" && $a!="2" && $a!="3" && $a!="4" && $a!="5" && $a!="6" && $a!="7" && $a!="8" && $a!="9" && $a!="0"){
			$ret_val = false;
			//echo "Несовпадение в -$a-";
		}
	}
	return $ret_val;
}
//*******************************************
function __format_txt_price_format($out){
	//$out = round($out, 2); 
	$out_t="";
	for($i=0; $i<strlen($out); $i++){
		if(__format_txt_is_digit(substr($out, $i, 1)) || substr($out, $i, 1)=="." || substr($out, $i, 1)==",")
			$out_t.=substr($out, $i, 1);
	}
	$out=$out_t;
	$out = preg_replace("/ /", "", $out);
	$out = trim($out);
	$out = preg_replace("/\./", ",", $out);
	//echo substr($out, strlen($out)-1, 1)."<br/>\n";
	//echo substr($out, strlen($out)-2, 1)."<br/>\n";
	//echo substr($out, strlen($out)-3, 1)."<br/>\n";
	if(substr($out, strlen($out)-2, 1)!="," && substr($out, strlen($out)-3, 1)!=",")
		$out .= ",00";
	if(substr($out, strlen($out)-2, 1)==",")
		$out .= "0";
	
	return $out;
}
//*******************************************
function __format_txt_price_format2($out){
	//$out = round($out, 2); 
	$out_t="";
	for($i=0; $i<strlen($out); $i++){
		if(__format_txt_is_digit(substr($out, $i, 1)) || substr($out, $i, 1)=="." || substr($out, $i, 1)==",")
			$out_t.=substr($out, $i, 1);
	}
	$out=$out_t;
	$out = eregi_replace(" ", "", $out);
	$out = trim($out);
	$out = eregi_replace(",", ".", $out);
	//echo substr($out, strlen($out)-1, 1)."<br/>\n";
	//echo substr($out, strlen($out)-2, 1)."<br/>\n";
	//echo substr($out, strlen($out)-3, 1)."<br/>\n";
	if(substr($out, strlen($out)-2, 1)!="." && substr($out, strlen($out)-3, 1)!=".")
		$out .= ".00";
	if(substr($out, strlen($out)-2, 1)==".")
		$out .= "0";
	
	return $out;
}
//*******************************************
?>