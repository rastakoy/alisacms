<?
function __lc_find_data_from_loadconfig($data, $configfile, $rebuild=0){
	$command = "$data:";
	$txt_lines = "";
	$lines = file ("$configfile"); //Преобразование  строк файла в массив
	foreach ($lines as $line_num => $line)
		$txt_lines.=$line;
	$txt_lines = preg_replace("/End_data\r\n/", "End_data", $txt_lines);
	$txt_lines = preg_replace("/End_data\n/", "End_data", $txt_lines);
	$lc_mass = explode("End_data", $txt_lines);
	//echo "<pre>"; print_r($lc_mass); echo "</pre>";
	$ret_val = "";
	foreach($lc_mass as $key=>$val){
		$vars_mass = explode("\n", $val);
		foreach($vars_mass as $k=>$v){
			$v = trim($v);
			if(preg_match("/^".$command."/", $v) && $k==0){
				$ret_val = $vars_mass;
				unset($ret_val[0]);
			}
		}
	}
	//***************************
	if($ret_val=="") return false;
	//***************************
	if($rebuild){
		$tmp=false;
		foreach($ret_val as $key=>$val) 
			$tmp .= $val;
		$ret_val = $tmp;
	}
	return $ret_val;
}
//*********************************************
function __lc_get_count_data_from_loadconfig($data, $configfile, $rebuild=0){
	$txt_lines = "";
	$lines = file ("$configfile"); //Преобразование  строк файла в массив
	foreach ($lines as $line_num => $line)
		$txt_lines.=$line;
	$lc_mass = explode("End_data", $txt_lines);
	return count($lc_mass) - 1;
}
//*********************************************
function __lc_get_select_constructor($data, $value=false){
	//print_r($data);
	$ret_val = "";
	$ret_val .= "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"6\">
            <tr>
              <td class=\"inputtitle\" valign=\"middle\">$data[0]</td>
              <td class=\"inputinput\" valign=\"middle\"><select name=\"$data[3]\" id=\"$data[3]\">
                  <option value=\"0\">$data[4]</option>";
	$mass = explode("~", $data[1]);
	//print_r($mass);
	foreach($mass as $key=>$val){
		$submass = explode(":", $val);
		$ret_val .= "<option value=\"$submass[0]\" ";
		if($value == $submass[0])
			$ret_val .= " selected ";
		$ret_val .= ">$submass[1]</option>";
	}
    $ret_val .= "</select>
              </td>
              <td class=\"inputcomment\" valign=\"middle\"><strong>Пример введения информации :<br>
              </strong>$data[4]</td>
            </tr>
          </table>";
	return $ret_val;
}
//*********************************************
function __lc_get_list_constructor($data, $value=false){
	//print_r($data);
	$mass = explode("~", $data[1]);
	$ret_val = "";
	$ret_val .= "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"6\">
            <tr>
              <td class=\"inputtitle\" valign=\"middle\">$data[0]</td>
              <td class=\"inputinput\" valign=\"middle\"><b>$data[4]:</b><br/>
			  <select name=\"".$data[3]."[]\" id=\"$data[3]\" size=\"".count($mass)."\" multiple 
			  style=\"width:200px; padding:5px;\">";
	
	//print_r($mass);
	foreach($mass as $key=>$val){
		$submass = explode(":", $val);
		$val_mass = explode("~", $value);
		$ret_val .= "<option value=\"$submass[0]\" ";
		foreach($val_mass as $k=>$v)
			if($v == $submass[0])
				$ret_val .= " selected ";
		$ret_val .= ">$submass[1]</option>";
	}
    $ret_val .= "</select>
              </td>
              <td class=\"inputcomment\" valign=\"middle\"><strong>Пример введения информации :<br>
              </strong>$data[4]</td>
            </tr>
          </table>";
	return $ret_val;
}
//*********************************************
function __lc_get_wselect_constructor($data, $value=false){
	//print_r($data);
	$mass = explode("~", $data[1]);
	$ret_val = "";
	//$ret_val .= "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"6\">
    //        <tr>
    //          <td class=\"inputtitle\" valign=\"middle\">$data[0]</td>
    //         <td class=\"inputinput\" valign=\"middle\"><b>$data[4]:</b><br/>
	//		  <select name=\"".$data[3]."[]\" id=\"$data[3]\" size=\"".count($mass)."\" multiple 
	//		  style=\"width:200px; padding:5px;\">";
	
	//print_r($mass);
	foreach($mass as $key=>$val){
		$submass = explode(":", $val);
		//$ret_val .= "<option value=\"$submass[0]\" ";
		//$val_mass = explode("~", $value);
		//foreach($val_mass as $k=>$v)
			//if($v == $submass[0])
				//$ret_val .= " selected ";
		//$ret_val .= ">$submass[1]-$submass[0]-$value</option>";
	}
    $ret_val .= "</select>
              </td>
              <td class=\"inputcomment\" valign=\"middle\"><strong>Пример введения информации :<br>
              </strong>$data[4]</td>
            </tr>
          </table>";
	return $ret_val;
}
//*********************************************
function __lc_get_config_params_edit($row, $post, $root_link="../"){
	$ret_val = "";
	if($row["cfg_file"]!=""){
		$cfg_mass = __lc_find_data_from_loadconfig($row["cfg_file"], $root_link."config/".$row["cfg_file"].".cfg", 1);
		$cfg_mass = explode(",", $cfg_mass);
		foreach($cfg_mass as $key=>$val){
			//print_r($post);
			if(is_array($post[$val])){
				$post[$val] = "'".implode("~", $post[$val])."'";
			}
			if($key!=count($cfg_mass)-1) $ret_val .= "$val=".$post[$val].",";
		}
	}
	return $ret_val;
}
//**********************************************
function __lc_create_select_search($s_mass, $page, $query_new_string, $query_string, $mass){
	foreach($s_mass as $key => $val){
	  $sw_mass = explode(":", $val);
	  echo "<input type=\"checkbox\" ";
	  if(__filter_config($sw_mass[0], $_GET[$mass[6]])){
			echo " checked ";
			echo " onClick=\"window.location.href='?".__filter_config_unset($sw_mass[0], $query_string, $mass[6])."'\" "; 
	  } else {
			if($page>1){
				$ere = "&page=$page";
				$query_new_string = eregi_replace($ere, "&page=1", $query_string);
				echo " onClick=\"window.location.href='?$query_new_string&".$mass[6]."[]=$sw_mass[0]'\" ";
			} else {
				echo " onClick=\"window.location.href='?$query_string&".$mass[6]."[]=$sw_mass[0]'\" "; 
			}
	  } echo ">";
	  //echo "<pre>";  print_r($_GET["pc"]); echo "</pre>";
	  //echo "get_mass=".$sw_mass[0]."<br/>";
	  if(__filter_config($sw_mass[0], $_GET[$mass[6]])){
			echo "<a rel=\"nofollow\" href=\"?".__filter_config_unset($sw_mass[0], $query_string, $mass[6])."\">".$sw_mass[1]."</a><br/>";
		} else {
			if($page>1){
				$ere = "&page=$page";
				$query_new_string = eregi_replace($ere, "&page=1", $query_string);
				echo "<a rel=\"nofollow\" href=\"?$query_new_string&".$mass[6]."[]=$sw_mass[0]\">".$sw_mass[1]."</a><br/>";
			} else {
				echo "<a rel=\"nofollow\" href=\"?$query_string&".$mass[6]."[]=$sw_mass[0]\">".$sw_mass[1]."</a><br/>";
			}
		}
  }
}
//**********************************************
function __lc_create_list_search($s_mass, $page, $query_new_string, $query_string, $mass, $index=false){
	echo "<span id=\"filter_$mass[6]\"><script>itemsBlocks_indexes[$index]='$mass[6]';</script>";
	foreach($s_mass as $key => $val){
	
	  $sw_mass = explode(":", $val);
	  
	  echo "<input type=\"checkbox\" class=\"myItemsBlocks_checkbox\" id=\"mibs_".$mass[6]."_$sw_mass[0]\"   ";
	  if(__filter_config($sw_mass[0], $_GET[$mass[6]])){
			echo " checked ";
			echo " onClick=\"window.location.href='?".__filter_config_unset($sw_mass[0], $query_string, $mass[6])."'\" "; 
	  } else {
			if($page>1){
				$ere = "&page=$page";
				$query_new_string = eregi_replace($ere, "&page=1", $query_string);
				echo " onClick=\"window.location.href='?$query_new_string&".$mass[6]."[]=$sw_mass[0]'\" ";
			} else {
				//echo " onClick=\"window.location.href='?$query_string&".$mass[6]."[]=$sw_mass[0]'\" "; 
				echo "  "; 
			}
	  } echo ">";
	  //echo "<pre>";  print_r($_GET["pc"]); echo "</pre>";
	  //echo "get_mass=".$sw_mass[0]."<br/>";
	  if(__filter_config($sw_mass[0], $_GET[$mass[6]])){
			echo "<a rel=\"nofollow\" href=\"?".__filter_config_unset($sw_mass[0], $query_string, $mass[6])."\">asd".$sw_mass[1]."</a><br/>";
		} else {
			if($page>1){
				$ere = "&page=$page";
				$query_new_string = eregi_replace($ere, "&page=1", $query_string);
				echo "<a onclick=\"alert(\"OK\")\" rel=\"nofollow\" href=\"\">qwe".$sw_mass[1]."</a><br/>";
				//echo "<a rel=\"nofollow\" href=\"?$query_new_string&".$mass[6]."[]=$sw_mass[0]\">qwe".$sw_mass[1]."</a><br/>";
			} else {
				//echo "<a rel=\"nofollow\" href=\"?$query_string&".$mass[6]."[]=$sw_mass[0]\">".$sw_mass[1]."</a><br/>";
				echo "<a onClick=\"myItemsBlock_showfilter('$mass[6]', '$sw_mass[0]')\" rel=\"nofollow\" >".$sw_mass[1]."</a><br/>";
			}
		}
		
  }echo "<script>itemsBlocks_indexes_c[$index]=".($key+1).";</script></span>";
}
//**********************************************
function __lc_create_select_sql($mass){
	foreach($mass as $k=>$v) $mass[$k]=trim($v);
	$q_config = "";
	if(is_array($_GET[$mass[6]])) {
		$q_config .= " && (";
		$s_mass = explode("~", $mass[1]);
		//echo "<pre>";  print_r($_GET[$mass[6]]); echo "</pre>";
		foreach($_GET[$mass[6]] as $k => $v){
			if($k == 0) $q_config .= " $mass[3]=$v ";
			else $q_config .= " || $mass[3]=$v ";
		}
		$q_config .= ")";
	}
	return $q_config;
}
//**********************************************
function __lc_create_list_sql($mass){
	foreach($mass as $k=>$v) $mass[$k]=trim($v);
	$q_config = "";
	if(is_array($_GET[$mass[6]])) {
		$q_config .= " && (";
		$s_mass = explode("~", $mass[1]);
		//echo "<pre>";  print_r($_GET[$mass[6]]); echo "</pre>";
		foreach($_GET[$mass[6]] as $k => $v){
			if($k == 0) $q_config .= " $mass[3] like('$v~%')  ||  $mass[3] like('%~$v~%')  ||  $mass[3] like('%~$v')   ||  $mass[3] like('$v')  ";
			else $q_config .= " || $mass[3] like('$v~%')  ||  $mass[3] like('%~$v~%')  ||  $mass[3] like('%~$v') ||  $mass[3] like('$v')";
		}
		$q_config .= ")";
	}
	return $q_config;
}
//**********************************************
function __lc_create_mconf($selector=false){
	$ret = "";
	$resp = mysql_query("select * from items_config where folder=1 order by prior asc");
	if(is_array($selector)) $selector_s=$selector[0];
	while($row=mysql_fetch_assoc($resp)){
		if($row["name"]=="seleсttype"){
			$ret .= "<b>$row[rus_name]:</b><br/><select name=\"$row[name]\" onChange=\"__lc_mconf_get_data(this.value)\">\n";
			$sresp = mysql_query("select * from items_config where parent=$row[id] && folder=0");
			$ret .= "<option value=\"$srow[name]\">-Выберите тип поля-</option>\n";
			while($srow = mysql_fetch_assoc($sresp)){
				$ret .= "<option value=\"$srow[name]\"  ";
				if($srow["name"] == $selector_s) $ret .= "selected";
				$ret .= " >$srow[rus_name]</option>\n";
			}
			$ret .= "</select><br/>------------------------------------<br/>";
		}
		/*if($row["name"]=="mysql_name"){
			$ret .= "<b>$row[rus_name]:</b><br/><select name=\"$row[name]\">\n";
			$sresp = mysql_query("SHOW FIELDS FROM items");
			while($srow = mysql_fetch_assoc($sresp)){
				//print_r($srow);
				if($srow["Field"]!="id" && $srow["Field"]!="parent" && $srow["Field"]!="itemtype"  && $srow["Field"]!="itemadddate" && $srow["Field"]!="itemeditdate" && $srow["Field"]!="tmp" && $srow["Field"]!="recc")
				$ret .= "<option value=\"$srow[name]\">$srow[Field]</option>\n";
			}
			$ret .= "</select><br/>------------------------------------<br/>";
		}
		if($row["name"]=="rusname"){
			$ret .= "<b>$row[rus_name]:</b><br/><input type=\"textfield\" style=\"width:350px;\" />
			<br/>------------------------------------<br/>";
		}
		if($row["name"]=="config_css"){
			$ret .= "<b>$row[rus_name]:</b><br/><input type=\"textfield\" style=\"width:350px;\" />
			<br/>------------------------------------<br/>";
		}*/
	}
	if($selector[0] == "inputtext"){
		$mass = __lc_get_sconfig(1, $selector[0]);
		//foreach($mass as $key=>$val){
		$ret .= __lc_gen_varchar($mass[0][0], $mass[0][1], $mass[0][2], $selector[1]);
		$ret .= __lc_gen_varchar($mass[1][0], $mass[1][1], $mass[1][2], $selector[3]);
		$ret .= __lc_gen_varchar($mass[2][0], $mass[2][1], $mass[2][2], $selector[4]);
		//}
		$ret .= "<input type=\"button\" value=\"Сохранить\" onClick=\"alert('ok')\"  ><br/>------------------------------------";
	}
	//$ret .= "	<input type=\"button\" value=\"Сохранить\" onClick=\"save_mconf()\" />
	//<input type=\"button\" value=\"Отменить\" onClick=\"cancel_mconf()\" />
	//<br/>------------------------------------<br/>";
	return $ret;
}
//**********************************************
function __lc_mconf_get_data($myitem, $myitem_sub, $mconf_val){
	$ret = "";
	echo $myitem."::".$myitem_sub."::".$mconf_val;
	//$resp = mysql_query("select * from items_config where folder=1 order by prior asc");
	//while($row=mysql_fetch_assoc($resp)){
	//	if($row["name"]=="seleсttype"){
	//		$ret .= "<b>$row[rus_name]:</b><br/><select name=\"$row[name]\" onChange=\"__lc_mconf_get_data(this.value)\">\n";
	//		$sresp = mysql_query("select * from items_config where parent=$row[id] && folder=0");
	//		$ret .= "<option value=\"$srow[name]\">-Выберите тип поля-</option>\n";
	//		while($srow = mysql_fetch_assoc($sresp)){
	//			$ret .= "<option value=\"$srow[name]\">$srow[rus_name]</option>\n";
	//		}
	//		$ret .= "</select><br/>------------------------------------<br/>";
	//	}
	//}
}
//**********************************************
function __lc_get_sconfig($parent, $type){
	$resp = mysql_query("select * from items_config where name='$type' && parent=$parent  ");
	$row = mysql_fetch_assoc($resp);
	$ret_mass = false;
	$mass = explode("\n", $row["config"]);
	foreach($mass as $key=>$val){
		$val = explode("===", $val);
		$ret_mass[] = $val;
	}
	return $ret_mass;
}
//**********************************************
function __lc_gen_varchar($type, $name, $rus_name, $value){
	$ret = "$rus_name<br/><input type=\"text\" name=\"varchar_$name\" id=\"varchar_$name\" value='$value'   /><br/>---<br/>";
	return $ret;
}
?>