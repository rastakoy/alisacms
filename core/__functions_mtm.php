<?
//**************************************************
function __mtm_test_item_in_row($smlevel_way, $row, $level){
	$sel_tmp = explode("\n", $row);
	//if($level==0) $atr = "/(^|-|\n)$smlevel_way/";
	//else 
	$atr = "/(^|-|\n)$smlevel_way/";
	foreach($sel_tmp as $key=>$val)
		$selec[] = $val;
	foreach($selec as $key => $val)
		if(preg_match($atr, $val))
			return true;
	return false;
}
//**************************************************
function __mtm_generate_level($smlevel_way, $smid, $smkey, $smlevel=false){
	//echo "smlevel_way=$smlevel_way";
	//echo "smid=$smid";
	$rv = "";
	$resp = mysql_query("select * from items where id=$smid");
	$row=mysql_fetch_assoc($resp);
	$my_filter = __mtm_has_mtm($row["id"]);
	if($my_filter){
		//**************************************************
		//$rv .= "smlevel_way=$smlevel_way";
		$wmass = explode("-", $smlevel_way);
		
		//**************************************************
		$query_filter = "select * from items where id=$my_filter   ";
		$resp_filt = mysql_query($query_filter);
		$row_filt = mysql_fetch_assoc($resp_filt);
		//**************************************************
		$fresp_nn = mysql_query("select * from mtm_filter where id=$row_filt[mtm] ");
		$frow_nn = mysql_fetch_assoc($fresp_nn);
		//**************************************************
		$level = count($wmass)-1;
		$level_way = "";
		$mquery = "select * from mtm_filter where parent=$row_filt[mtm] order by prior asc limit $level,1 ";
		//$rv .= "select * from mtm_filter where parent=$row_filt[mtm] order by prior asc limit $level,1 ";
		$mtm_resp = mysql_query($mquery);
		$row_level = mysql_fetch_assoc($mtm_resp);
		//while($row_level = mysql_fetch_assoc($mtm_resp)){
			//$rv .= "<div id=\"mtm_level_$level\" style=\"background-color: $row_level[fbg];\" ";
			//$rv .= "class=\"mtm_v2_level\" >";
			$rv .= "<b id=\"mtm_ftitle_$row_level[id]\">$row_level[name]</b>";
			if($level>0) {
				$level_prev = "";
				for($i=0; $i<count($wmass)-2; $i++){
					$level_prev .= $wmass[$i]."-";
				}
				//echo "level_prev=$level_prev";
				$rv .= "&nbsp;&nbsp;&nbsp;<a id=\"smwa-$smlevel_way\" href=\"javascript:mtm_hide_level";
				$rv .= "($smkey, ".($level-1).", $row[id], this, '$level_prev')\">Назад</a>";
			}
			$rv .= "<br/><br/>";
			$mtm_temp = explode("\n", $row_level["cont"]);
			//print_r($mtm_temp);
			foreach($mtm_temp as $key=>$val){
				$val = trim($val);
				$rv .= "<span class=\"span_mtm\" style=\"$row_level[fstyle]\" ";
				$rv .= "onClick=\"load_mtm($key, ".($level+1).", $row[id], this, this.id.replace(/smw-/gi , ''))\" ";  
				$rv .= "id=\"smw-$smlevel_way$key:$level-\" >";
				//$rv .= "$smlevel_way$key:$level-";
				$a = __mtm_test_item_in_row("$smlevel_way$key:$level-", $row["mtm_cont"], $level);
				$rv .= "<input type=\"checkbox\" style=\"float:;\" ";
				if($a)  $rv .= "  checked  ";
				$rv .= "onClick=\"set_mtm($key, $level, $row[id], this, '$smlevel_way$key:$level-')\" ";
				$rv .= " id=\"smlw-$smlevel_way$key:$level-\"  ";
				$rv .= "/> $val</span>";
			}
			//$rv .= "</div>\n\n";
		//}
	}
	$cc_cont = str_replace("\n", "\\n", $row_level["cont"]);
	$cc_cont = str_replace("\r", "", $cc_cont);
	//echo  "$cc_cont";
	$rv .= "<script>";
	$rv .= "document.getElementById('mtm_fname').value = \"$row_level[name]\";\n";
	$rv .= "document.getElementById('mtm_fstyle').value = \"$row_level[fstyle]\";\n";
	$rv .= "document.getElementById('mtm_fbg').value = \"$row_level[fbg]\";\n";
	//$rv .= "alert(\"$cc_cont\");\n";
	$rv .= "document.getElementById('mtm_cont').value = \"$cc_cont\";\n";
	$rv .= "all_mtm_level_id = $row_level[id];\n";
	$rv .= "</";
	$rv .= "script>";
	return $rv;
}
//**************************************************
function __mtm_convert_session_to_simple_filter($sess, $fid){
	$rv = "";
	//****************************
	$fquery = "select * from itemstypes where id=$fid  ";
	$fresp = mysql_query($fquery);
	$frow = mysql_fetch_assoc($fresp);
	//****************************
	$smass = explode("&", $sess);
	//echo "<pre>"; print_r($smass); echo "</pre>";
	//****************************
	//echo "<pre>"; print_r($frow); echo "</pre>";
	$mass = explode("\n", $frow["pairs"]);
	foreach ($mass as $key=>$val){
		$vmass = explode("===", $val);
		//echo "<pre>"; print_r($vmass); echo "</pre>";
		if($vmass[count($vmass)-1]=="alisa_activefilter"){
			$cc = 0;
			$fin = false;
			foreach($smass as $k=>$v){
				$mmass = explode("=", $v);
				if(  $mmass[0] == $vmass[6]  ){
					$ml_resp = mysql_query(  "select * from items where id=$mmass[1]"  );
					$ml_row = mysql_fetch_assoc(  $ml_resp  );
					$my_link = __fp_create_folder_way("items", $ml_row["id"], 1);
					$my_link = preg_replace(  "/\/$/", "", $my_link  );
					if($cc!=0) $rv .= "  || ";
					else $rv .= "  &&  (  ";
					$rv .= " $vmass[1]='$my_link'  ";
					$cc++;
					$fin = true;
				}
			}
			if($fin)  $rv .= "  )  ";
		}
		$rv .= "";
	}
	return $rv;
}
//**************************************************
function __mtm_show_item_mtm($fid, $id){
	$resp = mysql_query("select * from mtm_filter where parent=$fid  order by prior asc ");
	while($row = mysql_fetch_assoc($resp)){
		echo $row["name"]."<br/>\n";
		$mass = explode("\n", $row["cont"]);
		print_r($mass);
	}
}
//**************************************************
function __mtm_get_mtm_filter_type($id){
	$resp = mysql_query("select * from items where id=$id");
	$row = mysql_fetch_assoc($resp);
	//echo "<pre>"; print_r($row); echo "</pre>";
	if(!$row["mtm"] && $row["parent"]!=0){
		return 	__mtm_get_mtm_filter_type($row["parent"]);
	} else if ($row["mtm"]!="") {
		return $row["mtm"];
	}
	return false;
}
//*****************************************************
function __mtm_code_from_optionnames(  $id, $code){
	//echo "id = $id; code = $code<br/>\n";
	if(!$code) return false;
	$ret = "";
	$amass = explode("\n", $code);
	array_pop($amass);
	foreach($amass as $key=>$val)
		$smass[] = explode("-", $val);
	foreach($smass as $key=>$val)
		foreach($val as $k=>$v)
			$mass[$key][$k] = trim($v);
	//echo "<pre>"; print_r($mass); echo "</pre>";
	//**************************************
	$mtm_parent = __mtm_get_mtm_filter_type($id);
	$query = "select * from mtm_filter where parent=$mtm_parent order by prior asc  ";
	$fresp = mysql_query($query);
	$count = 0;
	while($frow = mysql_fetch_assoc($fresp)){
		foreach($mass as $key=>$val){
			if($frow["name"]==$mass[$key][0]){
				$fmass = explode("\n", $frow["cont"]);
				foreach($fmass as $fkey=>$fval){
					$fval = trim($fval);
					if($fval == $mass[$key][1]){
						$ret .= "$key:$fkey~";
					}
				}
			}	
		}
		$count++;
	}
	$ret = preg_replace("/~$/", "", $ret);
	return $ret;
}
?>