<?
//*****************************************************
function __filt_get_alisa_simple_id(){
	$query = "select * from items where href_name='alisa_filters' && folder=1 && parent=0 ";
	$resp = mysql_query(  $query  );
	$row = mysql_fetch_assoc(  $resp  );
	return $row["id"];
}
//*****************************************************
function __filt_get_simple_filters_keys(  $id  ){
	$retmass = false;
	$fmass = __filt_get_simple_filters();
	$item_type = get_item_type(  $id  );
	$itquery = "select * from itemstypes where id=$item_type";
	//echo "item_type=$item_type<br/>$itquery<br/>\n";
	$itresp = mysql_query(  $itquery  );
	$itrow = mysql_fetch_assoc(  $itresp  );
	$itmass = explode(  "\n", $itrow["pairs"]  );
	$count = 0;
	foreach(  $itmass as $key=>$val  ){
		$sitmass = explode(  "===", $val  );
		//echo "<pre>"; print_r(  $sitmass  ); echo "</pre>";
		if(  $sitmass[7] == "alisa_activefilter"  ){
			$retmass[$count][0] = $sitmass[1];
			$retmass[$count][1] = $sitmass[3];
			$retmass[$count][2] = $sitmass[5];
			$count++;
		}
	}
	return $retmass;
}
//*****************************************************
function __filt_get_simple_filters(){
	global $dop_query;
	$ret = false;
	$query = "select * from items where href_name='alisa_filters' && folder=1 && parent=0  ";
	$resp = mysql_query(  $query  );
	$row = mysql_fetch_assoc(  $resp  );
	$query = "select * from items where parent=$row[id] && folder=1 $dop_query order by prior asc  ";
	//echo $query;
	$resp = mysql_query(  $query  );
	while(  $row = mysql_fetch_assoc(  $resp  )  ){
		$ret[] = $row;
	}
	return $ret;
}
//*****************************************************
function get_json_filter($parent, $smtm){
	$ret = "";
	$ds = generate_mtm_sql($smtm);
	$query = "select id,name,mtm_cont from items where parent=$parent && $ds  $dop_query order by prior asc ";
	$resp=mysql_query($query);
	$ret .= "{\n";
	$c = 0;
	while($row=mysql_fetch_assoc($resp)){
		if($c>0)  $ret .= " ,\n";
		$ret .= "\"$c\": \"$row[id]\" ";
		$c++;
	}
	$ret .= "}\n";
	return $ret;
}
//*****************************************************
function generate_mtm_sql($data){
	$ret = "";
	$mass = explode(",",  $data);
	foreach($mass as $key=>$val){
		$val = explode("-", $val);
		if($val[0]=="0"){
			$level_1[] = $val[1];
		}
		if($val[0]=="1"){
			$level_2[] = $val[1];
		}
	}
	if($level_1 && $level_2){
		foreach($level_1 as $key=>$val){
			if($key>0) $ret .= "  ||  ";
			foreach($level_2 as $k=>$v){
				if($k>0) $ret .= "  ||  ";
				$ret .= "  mtm_cont like('%,$val-$v,%')  ";
			}
		}
		if($ret!="") $ret = "  (  $ret  )  ";
	}
	if($level_1 && !$level_2){
		foreach($level_1 as $key=>$val){
			if($key>0) $ret .= "  ||  ";
			$ret .= "  mtm_cont like('%:$val->%')   ";
		}
		if($ret!="") $ret = "  (  $ret  )  ";
	}
	if(!$level_1 && $level_2){
		foreach($level_2 as $key=>$val){
			if($key>0) $ret .= "  ||  ";
			$ret .= "   mtm_cont like('%-$val,%')   ";
		}
		if($ret!="") $ret = "  (  $ret  )  ";
	}
	return $ret;
}
//*****************************************************
function __mtm_show_select_mtm($id, $level, $parent, $selected=false){
	$ret = "";
	if($level==0) $level="0";
	if($level==1 && $parent==-1) return "";
	$my_filter = __mtm_has_mtm($id);
	$query = "select * from items where id=$id";
	//echo $query;
	$resp = mysql_query($query);
	$row = mysql_fetch_assoc($resp);
	$mtm_cont = $row["mtm_cont"];
	//echo "my_filter = $my_filter<br/>";
	if($my_filter){
		$query_filter = "select * from items where id=$my_filter   ";
		//echo $query_filter;
		$resp_filt = mysql_query($query_filter);
		$row_filt = mysql_fetch_assoc($resp_filt);
		//print_r($row_filt);
		
		$fresp_nn = mysql_query("select * from mtm_filter where id=$row_filt[mtm] ");
		$frow_nn = mysql_fetch_assoc($fresp_nn);
		
		$query = "select * from mtm_filter where parent=$row_filt[mtm] order by prior asc  ";
		
		//echo $query."<br/>\n";
		
		$count = 0;
		$fresp = mysql_query($query);
		while($frow = mysql_fetch_assoc($fresp)){
			if($count==$level){
				//echo "<strong>".$frow["name"]."</strong><br/>\n";
				$ret .= "<span>$frow[name]:</span><br/>
				<select";
				//if($level==0) 
				$ret .= " onChange=\"mtm_get_select($id, $level, $parent)\" ";
				//else 
				$ret .= " id=\"mtm_sel_$level\"><option value=\"-1\">--Выберите $frow[name]--</option>";
				$mass = explode("\n", $frow["cont"]);
				foreach($mass as $key=>$val){
					$foo = false;
					$mfoo = explode("\n", $mtm_cont);
					//echo "mfoo:<pre>"; print_r($mfoo); echo "</pre>";
					foreach($mfoo as $k=>$v){
						$smfoo = explode("-", $v);
						foreach($smfoo as $smkey=>$smval){
							$ssmfoo = explode(":", $smval);
							if($ssmfoo[0] == $key && $ssmfoo[1]==$level)
								$foo = true;
						}
						//echo "<pre>"; print_r($smfoo); echo "</pre>";
						//$smfoo = $smfoo[0];
						//$smfoo = preg_replace("/:/", "", $smfoo);
						//if($smfoo == $key) $foo = true;
					}
					//echo "val = $val<br/>";
					if($foo)  	$ret .=  "<option value=\"$key\">".trim($val)."</option>";
					
				}
				$ret .=  "</select><br/>";
			}
			$count++;
		}
	}
	return $ret;
}
//*****************************************************
function __mtm_show_select_mtm_all(  $id, $level, $selected  ){
		//echo $selected;
		//echo "level=$level<br/>\n";
		$aselmass = explode("~", $selected);
		foreach($aselmass as $key=>$val)
			$selmass[] = explode(":", $val);
		//echo "<pre>"; print_r($selmass); echo "</pre>";
		$mtm_cont = __mtm_get_mtm_cont($id);
		$mtm_parent = __mtm_get_mtm_filter_type($id);
		$query = "select * from mtm_filter where parent=$mtm_parent order by prior asc  ";
		$count = 0;
		$fresp = mysql_query($query);
		while($frow = mysql_fetch_assoc($fresp)){
				//echo "<strong>".$frow["name"]."</strong><br/>\n";
				$ret .= "<span class=\"filtername\" id=\"filter_name_$count\">$frow[name]</span>
				<select onChange=\"mtm_get_select($id, $count)\" style=\"width:100%; margin-top:5px; margin-bottom: 5px;\" ";
				$ret .= " id=\"mtm_sel_$count\"><option value=\"-1\">-- Не выбрано --</option>";
				$mass = explode("\n", $frow["cont"]);
				//echo "mass:<pre>"; print_r($mass); echo "</pre>";
				foreach($mass as $key=>$val){
					$val = trim($val);
					$foo = false;
					$mfoo = explode("\n", $mtm_cont);
					//echo "mfoo:<pre>"; print_r($mfoo); echo "</pre>";
					foreach($mfoo as $k=>$v){
						
						$smfoo = explode("-", $v);
						array_pop($smfoo);
						foreach($smfoo as $smkey=>$smval){
							//echo "smval = $smval<br/>";
							$ssmfoo = explode(":", $smval);
							//echo "<pre>"; print_r($ssmfoo); echo "</pre>";
							//if($ssmfoo[0] == 0) $ssmfoo[0]="0";
							//if($ssmfoo[1] == 0) $ssmfoo[1]="0";
							//echo "ssmfoo[1]=$ssmfoo[1]::count=$count<br/>";
							if($ssmfoo[0] == $key && $ssmfoo[1]==$count){
								$sa_test = true;
								foreach($selmass as $selkey=>$selval){
									if($selval[0] == 0) $selval[0]="0";
									if($selval[1] == 0) $selval[1]="0";
									if(  $selval[1] > -1  &&  $selval[0] != $count  ){
										$v = trim($v);
										//if($selval[0]==0) echo "$v<br/>selval:<pre>"; print_r($selval); echo "</pre>";
										$satr = "/(^|-)$selval[1]:$selval[0]-/";
										$sa = preg_match($satr, $v);
										//if($selval[0]==0) echo "sa = $sa<br/>";
										if(!$sa) $sa_test = false;
										//if($val=="белый" && $sa==1) 
										//	echo "sa=$sa :: ($v :: astr=".$satr.") :: $val :: $selkey => ($selval[0] , $selval[1]) :: c=$count<br/>\n";
										//if( $ssmfoo[1] == 0  &&  $ssmfoo[0] == 0) $sa_test = false;
									}
								
								}
								if($sa_test) $foo = true;
							}
						}
					}
					//echo "val = $val<br/>";
					if($foo){
					  	$ret .=  "<option value=\"$key\" ";
						foreach($selmass as $selkey=>$selval){
							if(  $selval[0] == $count  &&  $selval[1]==$key  ){
								$ret .=  " selected ";
							}
						}
						$ret .=  " >".trim($val)."</option>";
					}
				}
				$ret .=  "</select><br/>";
			$count++;
		}
	//$ret .= __mtm_show_options_from_code(  $id, $selected  )."<br/>\n";
	//$ret .= __mtm_code_from_optionnames(  $id, __mtm_show_options_from_code(  $id, $selected  )  );
	return $ret;
}
//*****************************************************
function __mtm_show_options_from_code(  $id, $code){
		$ret = "";
		$aselmass = explode("~", $code);
		foreach($aselmass as $key=>$val)
			$selmass[] = explode(":", $val);
		$mtm_cont    = __mtm_get_mtm_cont($id);
		$mtm_parent = __mtm_get_mtm_filter_type($id);
		//return "mtm_parent=$mtm_parent<br/>\n";
		$query = "select * from mtm_filter where parent=$mtm_parent order by prior asc  ";
		//return $query;
		$count = 0;
		$fresp = mysql_query($query);
		while($frow = mysql_fetch_assoc($fresp)){
				$mass = explode("\n", $frow["cont"]);
				foreach($mass as $key=>$val){
					$val = trim($val);
					$foo = false;
					$mfoo = explode("\n", $mtm_cont);
					foreach($mfoo as $k=>$v){
						$smfoo = explode("-", $v);
						array_pop($smfoo);
						foreach($smfoo as $smkey=>$smval){
							$ssmfoo = explode(":", $smval);
							if($ssmfoo[0] == $key && $ssmfoo[1]==$count){
								$foo = true;
							}
						}
					}
					if($foo){
						foreach($selmass as $selkey=>$selval)
							if(  $selval[0] == $count  &&  $selval[1]==$key  )
								$ret .=  "$frow[name] - $val\n ";
					}
				}
			$count++;
		}
	$ret = preg_replace("/\n$/", "", $ret);
	return $ret;	
}
//*****************************************************
function __mtm_get_mtm_cont($id){
	$query = "select * from items where id=$id";
	$resp = mysql_query($query);
	$row = mysql_fetch_assoc($resp);
	return $row["mtm_cont"];
}
//*****************************************************
function __mtm_has_mtm($id){
	if(!$id) return false;
	$resp = mysql_query("select * from items where id=$id");
	$row = mysql_fetch_assoc($resp);
	if($row["mtm"]){
		return $row["id"];
	} else {
		$resp = mysql_query("select * from items where id=$row[parent]");
		$row = mysql_fetch_assoc($resp);
		return __mtm_has_mtm($row["id"]);
	}
}
//*****************************************************
function __mtm_get_values($id){
	
}
//*****************************************************
function __mtm_convert_session($sess, $tomass=false){
	$rmass = false;
	$rv = "";
	$mass = explode("-", $sess);
	foreach($mass as $key=>$val){
		$wmass = explode(":", $val);
		if($wmass[1]!="") $rmass[$wmass[1]][] = trim($wmass[0]);
	}
	if(is_array($rmass)){
		asort($rmass);
		ksort($rmass);
		if($tomass) return $rmass;
		//print_r($rmass);
		foreach($rmass as $key=>$val){
			foreach($val as $k=>$v){
				$rv .= "$v:$key-";
			}
			$rv .= "\n";
		}
	}
	return $rv;
}
//*****************************************************
function __mtm_gen_pregs(  $mass  ){
	if(!is_array($mass)) return false;
	foreach($mass as $key=>$val){
		$wmass[$key] = count($val);
	}
	//print_r($wmass);
	//***********************************
	$count=1;
	foreach($wmass as $key=>$val)
		$count = $count*$val;
	//echo "count=$count\n";
	//***********************************
	foreach($wmass as $key=>$val){
		$min_level=$key; break;
	}
	//echo "min_level=$min_level\n\n";
	$test = __mtm_gen_indexes($wmass, 0, "", $min_level);
	//echo $test;
	$tmass = explode("\n", $test);
	//***********************************
	//print_r($mass);
	//print_r($tmass);
	$retmass = array();
	foreach($tmass as $key=>$val){
		//echo $val."\n";
		$val = explode("-", $val);
		foreach($val as $k=>$v){
			if($v){
				$vm = explode(":", $v);
				$retmass[$key][$k] = $mass[$vm[1]][$vm[0]].":$vm[1]";
			}
			//echo "rm=".$mass[$vm[1]][$vm[0]].":$vm[1]\n";
		}
	}
	//print_r($retmass);
	return $retmass;
	//***********************************
}
//*****************************************************
function __mtm_gen_indexes($mass, $level, $prev_str, $index){
	$str = "";
	foreach($mass as $key=>$val){
		if(  $key == $index ) {
			$index = $key;
			break;
		} else {
			if($key>$index) {
				$index=$key;
				break;
			}
			//echo "key=$key  ::  index=$index\n";
		}
	}
	//print_r($mass);
	//echo "count(mass)=".count($mass)."::index=$index::mass[$index]=".$mass[$index]."::level=$level\n";
	if($level < count($mass)){
		for(  $count=0; $count<$mass[$index]; $count++  ){
			if($level == count($mass)-1) $str .= "$prev_str$count:$index\n";
			if($level < count($mass)) $str .=  __mtm_gen_indexes($mass, $level+1, "$prev_str$count:$index-", $index+1);
		}
	}
	return $str;
}
//*****************************************************
function __mtm_gen_key($mass, $indexes, $row, $cell){
	//echo "$row-$cell\n";
	$rv = "";
	$wmass = explode("-", $indexes);
	$wmass[$row] = $cell;
	foreach($wmass as $key=>$val){
		if($key>0) $rv .= "-";
		$rv .= "$val";
	}
	return $rv;
	//print_r($mass);
}
//*****************************************************
function __mtm_gen_pregs_from_way($mass, $way){
	
}
//*****************************************************
function __mtm_test_row_has_item($row, $pregmass){
	if(!is_array($pregmass)) return true;
	$show_row = false;
	$mass = explode("\n", $row["mtm_cont"]);
	foreach( $mass as $key=>$val ){
		//echo "val=".$val."\n";
		foreach($pregmass as $pkey=>$pval){
			//echo "pval = $pval--";
			if($pval){
				//$pvm = explode("-", $pval);
				$pvm = $pval;
				$prega = "/";
				foreach($pval as $spkey=>$spval){
					$prega .= ".*(?:^|[^0-9])$spval";
				}
				$prega .= ".*/";
				//echo "\n\n$prega  ::  $val";
				if(  preg_match($prega, $val)  )  {
					//echo "  - совпадение найдено\n";
					$show_row = true;
				}
				//echo "<br/>";
				//.*(?:^|[^0-9])0:0-.*(?:^|[^0-9])0:1-.*/ :: 0:0-0:1-
				//.*(?:^|[^0-9])0:0.*(?:^|[^0-9])0:1.*/
			}
		}
	}
	return $show_row;
}
//**************************************************
function __mtm_is_this_item_checked(  $fdigit, $fid, $mtmcont  ){
	$resp = mysql_query("select * from items where id=$fid");
	$mass = false;
	if($resp){
		$row = mysql_fetch_assoc($resp);
		$resp = mysql_query("select * from mtm_filter where parent=$row[mtm] order by prior asc");
		$level = "0";	
		while($row = mysql_fetch_assoc($resp)){
			$masss = explode("\n", $row["cont"]);
			foreach($masss as $key=>$val){
				$prega = "/$key:$level-/";
				if(preg_match($prega, $mtmcont)){
					$mass[$row["name"]][$key] = $val;
				}
			}
			$level++;
		}
	}
	return $mass;
}
//**************************************************
function __mtm_get_item_names_from_indexes(  $mass, $key  ){
	$rv = "";
	foreach($mass[$key] as $k=>$v){
		if($k!=0) $rv .= ", ";
		$rv .= $v;
	}
	return $rv;
}
//**************************************************
function __mtm_get_item_keys_from_indexes(  $mass, $key  ){
	$rv = "";
	//print_r($mass);
	if(is_array($mass[$key])){
		$cc = 0;
		foreach($mass[$key] as $k=>$v){
			if($cc!=0) $rv .= ", ";
			$rv .= $v;
			$cc++;
		}
	}
	return $rv;
}
//**************************************************
?>