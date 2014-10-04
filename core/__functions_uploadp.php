<?
//*******************************

//*******************************
function __of_up_delete_codes_from_str($str, $del_index=false){
	$vmass = explode("=", $str);
	foreach($vmass as $vkey=>$vval){
		if(preg_match("/^[0-9]+$/", $vval)){
			$query = "delete from uploadp_codes where id=$vval ";
			//echo $query;
			$vresp = mysql_query($query);
		}
	}
}
//*******************************
function __of_up_get_items($id){
	
}
//*******************************
function __of_up_convert_csv_to_db($file, $provider){
	global $csv_class;
	$resp = mysql_query("select * from providers where id=$provider  ");
	$row_provider = mysql_fetch_assoc($resp);
	$provider_prefix = $row_provider["pref"];
		
	$resp = mysql_query("select * from providers where id=$provider");
	$row = mysql_fetch_assoc($resp);
	$mass = explode("\n", $row["uploadp_info"]);
	$index_key = -1;
	foreach($mass as $k=>$v){
		$smass = explode("=", $v);
		if($smass[0]=="item_code")  $index_key = $k;
	}
	//echo "index_key = $index_key<br/>\n";
	//***********************************
	$mass_csv = $csv_class->parse($file);
	foreach($mass_csv as $key=>$val){
		$cont = "";
		foreach($val as $k=>$v){
			if($k!=0) $cont .= "~~~separator~~~";
			if($index_key==$k) {	
				$v = trim($v);
				$cont .= $provider_prefix.$v;
				$code = $provider_prefix.$v;
				if($row_provider["endpref"]!="") $code.=$row_provider["endpref"];
			} else {
				$cont .= trim($v);
			}
		}
		echo "cont = $cont<br/>\n";
		echo "code=$code<br/>\n";
		//echo __of_up_get_upload_event($code)." - $code<br>\n";
		$cont = preg_replace("/'/", "\'", $cont);
		$tmass = __of_up_get_upload_event($code);
		if(!$tmass[1]) $tmass[1] = "0";
		$qq = "INSERT INTO csvtmp (rowcont, rowevent, outid) VALUES ('$cont', '".$tmass[0]."', $tmass[1])";
		if($row_provider["codeupload"]!="") eval($row_provider["codeupload"]);
		echo "query = $qq<br/>--------<br/><br/>\n";
		$resp = mysql_query($qq);
	}
	echo "Данные из файла перемещены в базу данных<br/>\n";
}
//*******************************
function __of_up_get_upload_event($code){
	$code = preg_replace("/'/", "\'", $code);
	$query = "select * from items where item_code='$code' ";
	//echo "ofquery = $query<br/>\n";
	if(!$code) return array("add");
	$resp = mysql_query($query);
	if(mysql_num_rows($resp)>0){
		$row = mysql_fetch_assoc($resp);
		return array("replace", $row["id"]);
	}
	return array("add");
}
//*******************************
function __of_up_get_field_type($field){
	if($field){
		$query = "SHOW FIELDS FROM items where Field='$field' ";
		$resp = mysql_query($query);
		$row = mysql_fetch_assoc($resp);
		if(preg_match('/^int/', $row["Type"]) || preg_match('/^double/', $row["Type"])){
			return "int";
		} else {
			return "txt";
		}
	}
}
//*******************************
function __of_up_get_name_from_index($index, $provider){
	$ret_mass = false;
	$resp = mysql_query("select * from providers where id=$provider");
	$row = mysql_fetch_assoc($resp);
	$mass = explode("\n", $row["uploadp_info"]);
	foreach($mass as $k=>$v){
		if($k == $index){
			$smass = explode("=", $v);
			foreach($smass as $key=>$val){
				if($key==0) {
					return $val;
				}
			}
		}
	}
	return false;
}
//*******************************
function __of_up_get_codes_from_index($index, $provider){
	$ret_mass = false;
	$resp = mysql_query("select * from providers where id=$provider ");
	$row = mysql_fetch_assoc($resp);
	$mass = explode("\n", $row["uploadp_info"]);
	foreach($mass as $k=>$v){
		if($k == $index){
			$smass = explode("=", $v);
			foreach($smass as $key=>$val){
				if($key==0) {
					$myfield = $val;
				} else {
					if($val!=0){
						$resp = mysql_query("select * from uploadp_codes where id=$val ");
						$row = mysql_fetch_assoc($resp);
						$code = $row["phpcode"];
						$code = preg_replace("/{field}/", "$myfield", $code);
						$ret_mass[] = $code;
					}
				}
			}
		}
	}
	return $ret_mass;
}
//*******************************
function __of_up_get_convert_str_to_code($str){
	$ret = "";
	$mass = explode("=", $str);
	foreach($mass as $key=>$val){
		if($key==0){
			$myindex = $val;
		} else {
			if($val!=0){
				$ret .= "<img src=\"images/green/icons/phpcode.gif\" style=\"cursor:pointer;\"  align=\"absmiddle\"
				onClick=\"__of_up_get_code($val)\" /> ";
				$ret .= "<img src=\"images/green/icons/arrow_whitebg.gif\" align=\"absmiddle\" /> ";
			}
		}
	}
	//**************************************
	$ret .= "<img src=\"images/green/icons/plus_whitebg.gif\" align=\"absmiddle\"  style=\"cursor:pointer;\"
	onClick=\"__of_up_add_code(this)\" /> ";
	//**************************************
	$ret .= "<select class=\"folder_select\" onChange=\"__of_up_save_sfield(this)\" 
	style=\"height:20px; width:200px;\">
		  <option value=\"0\" >-Виртуальное поле-</option>";
	$resp = mysql_query("SHOW FIELDS FROM items");
	while($row=mysql_fetch_assoc($resp)){
		$ret .= "<option name=\"$row[Field]\" ";
		if($myindex == $row["Field"]) $ret .= "selected";
		$ret .= " >$row[Field]</option>";
	}
	$ret .= "</select> ";
	//**************************************
	$ret .= "<img src=\"images/green/icons/delete.gif\" align=\"absmiddle\"  
	style=\"cursor:pointer; margin-left:20px;\"
	onClick=\"__of_up_delete_field(this)\" /> ";
	//**************************************
	return $ret;
}
//*******************************
?>