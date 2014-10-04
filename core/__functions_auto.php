<?
//***************************************
$background_prop[0] = "background-color";
$background_prop[1] = "background-image";
$background_prop[2] = "background-repeat";
$background_prop[3] = "background-position";
$background_prop[4] = "background-attachment";
//***************************************
$box_prop[0] = "width";
$box_prop[1] = "height";
$box_prop[2] = "float";
$box_prop[3] = "clear";
$box_prop[4] = "padding-top";
$box_prop[5] = "padding-right";
$box_prop[6] = "padding-bottom";
$box_prop[7] = "padding-left";
$box_prop[8] = "margin-top";
$box_prop[9] = "margin-right";
$box_prop[10] = "margin-bottom";
$box_prop[11] = "margin-left";
//***************************************
$pos_prop[0] = "overflow";
$pos_prop[1] = "position";
$pos_prop[2] = "visibility";
$pos_prop[3] = "z-index";
$pos_prop[4] = "left";
$pos_prop[5] = "top";
$pos_prop[6] = "right";
$pos_prop[7] = "bottom";
$pos_prop[8] = "clip";
//***************************************
$txt_prop[0] = "font-family";
$txt_prop[1] = "font-size";
$txt_prop[2] = "font-style";
$txt_prop[3] = "line-height";
$txt_prop[4] = "font-weight";
$txt_prop[5] = "text-transform";
$txt_prop[6] = "color";
$txt_prop[7] = "text-decoration";
//***************************************
$bor_prop[0] = "border-top-width";
$bor_prop[1] = "border-right-width";
$bor_prop[2] = "border-bottom-width";
$bor_prop[3] = "border-left-width";
$bor_prop[4] = "border-top-style";
$bor_prop[5] = "border-right-style";
$bor_prop[6] = "border-bottom-style";
$bor_prop[7] = "border-left-style";
$bor_prop[8] = "border-top-color";
$bor_prop[9] = "border-right-color";
$bor_prop[10] = "border-bottom-color";
$bor_prop[11] = "border-left-color";
//***************************************
function __fa_is_in_array($mass, $val=false, $key=false){
	if($key && !$val){
		foreach($mass as $k=>$v)
			if($key=="$v") return true;
	} else if($val && !$key){
		foreach($mass as $k=>$v)
			if($val=="$v") return true;
	}
	return false;
}
//***************************************
function __fa_get_bg_styles($mass){
	//print_r($mass);
	global $background_prop;
	foreach($mass as $key=>$val){
		$tmass = explode("\n", $val);
		foreach($tmass as $k=>$v){
			$t = explode(":", $v);
			//echo "test:".__fa_is_in_array($background_prop, false, $t[0])."--\n";
			if(__fa_is_in_array($background_prop, false, $t[0])){
				$style_val[] = explode(":", $v);
			}
		}
	}
	return $style_val;
}
//***************************************
function __fa_get_box_styles($mass){
	//print_r($mass);
	global $box_prop;
	foreach($mass as $key=>$val){
		$tmass = explode("\n", $val);
		foreach($tmass as $k=>$v){
			$t = explode(":", $v);
			//echo "test:".__fa_is_in_array($background_prop, false, $t[0])."--\n";
			if(__fa_is_in_array($box_prop, false, $t[0])){
				$style_val[] = explode(":", $v);
			}
		}
	}
	return $style_val;
}
//***************************************
function __fa_get_pos_styles($mass){
	//print_r($mass);
	global $pos_prop;
	foreach($mass as $key=>$val){
		$tmass = explode("\n", $val);
		foreach($tmass as $k=>$v){
			$t = explode(":", $v);
			//echo "test:".__fa_is_in_array($background_prop, false, $t[0])."--\n";
			if(__fa_is_in_array($pos_prop, false, $t[0])){
				$style_val[] = explode(":", $v);
			}
		}
	}
	return $style_val;
}
//***************************************
function __fa_get_txt_styles($mass){
	//print_r($mass);
	global $txt_prop;
	foreach($mass as $key=>$val){
		$tmass = explode("\n", $val);
		foreach($tmass as $k=>$v){
			$t = explode(":", $v);
			//echo "test:".__fa_is_in_array($background_prop, false, $t[0])."--\n";
			if(__fa_is_in_array($txt_prop, false, $t[0])){
				$style_val[] = explode(":", $v);
			}
		}
	}
	return $style_val;
}
//***************************************
function __fa_get_bor_styles($mass){
	//print_r($mass);
	global $bor_prop;
	foreach($mass as $key=>$val){
		$tmass = explode("\n", $val);
		foreach($tmass as $k=>$v){
			$t = explode(":", $v);
			//echo "test:".__fa_is_in_array($background_prop, false, $t[0])."--\n";
			if(__fa_is_in_array($bor_prop, false, $t[0])){
				$style_val[] = explode(":", $v);
			}
		}
	}
	return $style_val;
}
//***************************************
function __fa_get_element_in_array_by_key($mass, $key_attr){
	if(is_array($mass)){
		foreach($mass as $key=>$val){
			if($val[0]==$key_attr){
				return $val[1];
			}
		}
	}
	return false;
}
//***************************************
function __fa_css_to_array($file, $elname){
	$fh = fopen($file, 'r+'); 
	$cont = fread($fh, filesize($file)); 
	fclose($fh); 
	//**************
	//$pattern = "/$elname{/";
	//$cont = preg_replace($pattern, "nnnnnnnnnnn{", $cont);
	//echo $cont;
	//**************/
	$rmass = array();
	$count=0;
	$emass = explode(",", $elname);
	//echo $elname;
	foreach($emass as $ekey=>$eval){
		$mass = explode("$eval{", $cont);
		foreach($mass as $key=>$val){
			if($key>0){
				$nmass = explode("}", $val);
				$rmass[$count] = $nmass[0];
				$count++;
			}
		}
	}
	//print_r($mass);
	//**************/
	//$mass = explode("$elname{", $cont);
	//$rmass = array();
	//$count=0;
	//foreach($mass as $key=>$val){
	//	if($key>0){
	//		$nmass = explode("}", $val);
	//		$rmass[$count] = $nmass[0];
	//		$count++;
	//	}
	//}
	//**************
	$mass = array();
	foreach($rmass as $key=>$val){
		$nmass = explode("\n", $val);
		$str = "";
		foreach($nmass as $k=>$v)
			$str .= preg_replace("/;/", "", trim($v))."\n";
		$rmass[$key]=$str;
	}
	return $rmass;
}
//***************************************
function __fa_test_to_add_style_to_css($mass, $styles, $start, $stop){
	$ret_mass = array();
	$ret_str = "";
	foreach($styles as $key=>$val){
		$val[1] = trim($val[1]);
		if($val[1]!="false" && $val[1]!=""){
			
			$add = true;
			for($i=$start; $i<$stop; $i++){
				$smass = explode(":", $mass[$i]);
				$smass[0] = trim($smass[0]);
				if($smass[0] == $val[0]){
					
					$add = false;
					break;
				}
			}
			if($add){
				echo "add = $val[0]: $val[1]\n";
				$ret_str .= "\n$val[0]: $val[1];";
			}
		}
	}
	return $ret_str;
}
//***************************************
function  __fa_clear_css($tmpl, $file, $mass){
	echo " tmpl=$tmpl \n file=$file \n mass:\n "; print_r($mass);
	$file = "styles/".$tmpl."/".$file;
	//$fh = fopen($file, 'r+'); 
	//$cont = fread($fh, filesize($file)); 
	//fclose($fh); 
	//echo $cont;
	$cmass = array();
	//$mm = 
	return $mm;
	print_r($mm);
}
//***************************************
?>