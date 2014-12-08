<?
//********************************************
function __ff_create_saveblock( $mass ){
	$ret  = "\n<tr><td colspan=\"2\" align=\"center\" style=\"height:35px;\">";
	//print_r($mass);
	$ret .= "<script>load_json=true;</script>";
	$ret .= "<a onclick=\"load_json=true; getiteminfo_save($mass[id]);\" href=\"javascript:\">";
	$ret .= "<img src=\"images/green/save.gif\" width=\"100\" height=\"18\" border=\"0\"></a>";
	$ret .= "<a href=\"javascript:getiteminfo_close($mass[id])\">";
	$ret .= "<img src=\"images/green/cancel.gif\" width=\"100\" height=\"18\" border=\"0\"></a><br/></td></tr>\n";
	return $ret;
}
//********************************************
function __ff_create_multiprice( $mass ){
	$ret  = "\n<tr><td width=\"200\" height=\"30\">Ценовой блок</td>";
	$ret .= "<td><textarea id=\"multiprice\" style=\"display:none;\"></textarea>".__ff_construct_multiprice($mass);
	$ret .= "</tr>\n";
	return $ret;
}
//********************************************
function __ff_create_selectfromitems_many( $mass, $index, $postname, $comm="", $table, $attrs="" ){
	global $dop_query;
	$query = "select * from $table where parent=$attrs $dop_query order by id asc  ";
	$ret  = "\n<tr>";
	$ret .= "<td width=\"200\" height=\"30\">$comm</td>";
	$ret .= "<td>";
	
	//print_r($mass);
	$tmass = explode(",", $mass[$postname]);
	//print_r($tmass);
	//echo $query;
	
	//print_r($mass);
	$ret .= "<select name=\"".$postname."\" id=\"$postname\" size=\"4\" multiple=\"multiple\" ";
	$ret .= " style=\"width:100%;\" >";
	//print_r($mass);
	$resp = mysql_query($query);
	while($row=mysql_fetch_assoc($resp)){
		$ret .= "<option value=\"$row[id]\" ";
		foreach($tmass as $tkey=>$tval)
			if($row["id"]==$tval)  $ret .= " selected ";
		$ret .= ">$row[name]</option>";
	}
	$ret .= "</select></td></tr>\n";
	return $ret;
}
//********************************************
function __ff_create_coder( $mass, $name ){
	if($name!=""){
		$ret  = "\n<tr><td width=\"200\" height=\"30\">$name</td>";
	}else{
		$ret  = "\n<tr><td width=\"200\" height=\"30\">Программный код</td>";
	}
	$ret .= "<td><textarea name=\"coder\" id=\"coder\" style=\"width:100%;height:250px;\" ";
	$ret .= " onClick=\"item_pop_up_init=false\" >$mass[coder]</textarea></td>";
	$ret .= "</tr>\n";
	return $ret;
}
//********************************************
function __ff_create_color( $mass ){
	$ret  = "\n<tr><td width=\"200\" height=\"30\">Цвет</td>";
	$ret .= "<td><input name=\"color\" id=\"color\" style=\"\" type=\"color\" ";
	$ret .= " onClick=\"item_pop_up_init=false\" value=\"$mass[color]\" ></td>";
	$ret .= "</tr>\n";
	return $ret;
}
//********************************************
function __ff_create_grabber( $mass ){
	$ret  = "\n<tr><td width=\"200\" height=\"30\">Выбор граббера</td>";
	$ret .= "<td><select name=\"grabber\" id=\"grabber\" onChange=\"__gbr_start_grabber(this.value)\" >";
	$ret .= "<option value=\"0\" "; 
	if($selected=="0") $ret .= " selected "; 
	$ret .=">Выберите граббер</option>";
	$query = "select * from grabber order by id asc  ";
	//echo $query;
	$resp = mysql_query($query);
	while($row=mysql_fetch_assoc($resp)){
		$ret .= "<option value=\"$row[id]\" ";
		if($row["id"]==$mass["grabber"])  $ret .= " selected ";
		$ret .= ">$row[name]</option>";
	}
	$ret .= "</select></td>";
	$ret .= "</tr>\n";
	return $ret;
}
//********************************************
function __ff_create_rec_to_folder( $mass, $name, $postname, $comm="", $table, $attrs="" ){
	$ret  = "\n<tr>";
	$ret .= "<td width=\"200\" height=\"30\">$comm</td>";
	$ret .= "<td><select name=\"$postname\" id=\"$postname\">";
	$ret .= "	<option value=\"0\" "; 
	if($selected=="0") $ret .= " selected "; 
	$ret .=">Директория не задана</option>";
	$query = "select * from $table where parent=$mass[parent] && folder=1 order by prior asc  ";
	$resp = mysql_query($query);
	while($row=mysql_fetch_assoc($resp)){
		$ret .= "<option value=\"$row[id]\" ";
		if($row["id"]==$mass[$name])  $ret .= " selected ";
		$ret .= ">$row[name]</option>";
	}
	$ret .= "</select></td></tr>\n";
	return $ret;
}

function __ff_create_inputcheckbox( $mass, $name, $postname, $comm="", $attrs="" ){
	$ret  = "\n<tr><td width=\"200\" height=\"30\">$comm</td>";
	$ret .= "<td><input $attrs name=\"$postname\" type=\"checkbox\" id=\"$postname\" value=\"1\"  ";
	if($mass[$name] == 1) $ret .= " checked ";
	$ret .= "  /></td>";
	$ret .= "</tr>\n";
	return $ret;
}

$show_once = true;
function __ff_create_inputtext( $mass, $name, $postname, $comm="", $attrs="", $events=false ){
	//echo $events;
	global $show_once;
	$events = explode(";", $events);
	$aEventArray = array();
	if( is_array($events) && count($events) > 0 ) {
		foreach($events as $eventVal){
			$eventVal = explode("=", $eventVal);
			$aEventArray[$eventVal[0]] = $eventVal[1];
		}
	}
	$events = $aEventArray;
	//*************************
	$ret  = "\n<tr>";
	$ret .= "<td width=\"200\" height=\"30\">$comm</td>";
	//echo "onChange=$onChange";
	$value = preg_replace('/"/', "&quote;", $mass[$name]);
	$value = preg_replace("/'/", "&rsquo;", $mass[$name]);
	//$value = preg_replace("/'/", "&rsquo;", $mass[$name]);
	$ret .= "<td>";
	$ret .= "<input $attrs name=\"$postname\" type=\"text\" id=\"$postname\" value='".$value."' ";
	if( is_array($events) && count($events) > 0 ) {
		foreach($events as $key=>$val){
			$ret .= " $key=\"$val\" ";
		}
	}
	$ret .= "  >";
	if($show_once){
		//$ret .= "<input id=\"_formid_city\" name=\"city\" onchange=\"unverifyCity()\" value=\"\" type=\"text\" placeholder=\"Город, Область\">";
		//$ret .= "<input id=\"_formid_verified_city\" name=\"verified_city\" value=\"0\" type=\"hidden\">";
		$show_once = false;
	}
	$ret .= "</td>";
	$ret .= "</tr>\n";
	return $ret;
}

function __ff_create_number( $mass, $name, $postname, $comm="", $attrs="" ){
	$ret  = "\n<tr>";
	$ret .= "<td width=\"200\" height=\"30\">$comm</td>";
	$value = preg_replace('/"/', "&quote;", $mass[$name]);
	$value = preg_replace("/'/", "&rsquo;", $mass[$name]);
	//$value = preg_replace("/'/", "&rsquo;", $mass[$name]);
	$ret .= "<td><input $attrs name=\"$postname\" type=\"number\" id=\"$postname\" value='".$value."' ></td>";
	$ret .= "</tr>\n";
	return $ret;
}

function __ff_create_double( $mass, $name, $postname, $comm="", $attrs="" ){
	$ret  = "\n<tr>";
	$ret .= "<td width=\"200\" height=\"30\">$comm</td>";
	$value = preg_replace('/"/', "&quote;", $mass[$name]);
	$value = preg_replace("/'/", "&rsquo;", $mass[$name]);
	//$value = preg_replace("/'/", "&rsquo;", $mass[$name]);
	$ret .= "<td><input $attrs name=\"$postname\" type=\"number\" id=\"$postname\" value='".$value."' ></td>";
	$ret .= "</tr>\n";
	return $ret;
}

function __ff_create_pricedigit( $mass ){
	$ret  = "\n<tr>";
	$ret .= "<td width=\"200\" height=\"30\">Цена</td>";
	$ret .= "<td><input $attrs name=\"pricedigit\" type=\"text\" id=\"pricedigit\" value='".$mass["pricedigit"]."' ></td>";
	$ret .= "</tr>\n";
	return $ret;
}

function __ff_create_ucblock( $mass ){
	$ret  = "\n<tr><td colspan=\"2\" align=\"left\" style=\"height:35px;\">";
	$ret .= "<a href=\"javascript:show_usercomments($mass[id])\">";
	$ret .= "<img src=\"images/green/button_comments.gif\" width=\"250\" height=\"18\" border=\"0\"></a></td></tr>\n";
	return $ret;
}

function __ff_create_selectgaltype( $mass, $name, $postname, $comm="", $table, $attrs="" ){
	$ret  = "\n<tr>";
	$ret .= "<td width=\"200\" height=\"30\">$comm</td>";
	$ret .= "<td><select name=\"$postname\" id=\"$postname\">";
	$ret .= "	<option value=\"0\" "; 
	if($selected=="0") $ret .= " selected "; 
	$ret .=">Галерея не задана</option>";
	$query = "select * from $table order by id asc  ";
	$resp = mysql_query($query);
	while($row=mysql_fetch_assoc($resp)){
		$ret .= "<option value=\"$row[id]\" ";
		if($row["id"]==$mass[$name])  $ret .= " selected ";
		$ret .= ">$row[name]</option>";
	}
	$ret .= "</select></td></tr>\n";
	return $ret;
}

function __ff_create_selectfromitems( $mass, $index, $postname, $comm="", $table, $attrs="" ){
	$ret  = "\n<tr>";
	$ret .= "<td width=\"200\" height=\"30\">$comm</td>";
	$ret .= "<td>";
	//print_r($mass);
	$ret .= "<select name=\"$postname\" id=\"$postname\">";
	//print_r($mass);
	$ret .= "	<option value=\"0\" "; 
	if($selected=="0") $ret .= " selected "; 
	$ret .=">Не задано</option>";
	global $dop_query;
	$aqrow = __fp_get_row_from_way(  explode(  "/", $attrs  ), "items"  );
	$query = "select * from $table where parent=$aqrow[id] order by id asc  ";
	//echo $query."</br>\n";
	//echo "index=$index</br>\n";
	$resp = mysql_query($query);
	$aaq = "select * from items where parent=".__filt_get_alisa_simple_id()." && folder=1 order by prior asc";
	$aar = mysql_query(  $aaq  );
	$aarow = mysql_fetch_assoc(  $aar  );
	while($row=mysql_fetch_assoc($resp)){
		$ret .= "<option value=\"$attrs/$row[href_name]\" ";
		if(  "$attrs/".$row["href_name"] == $mass["$postname"])  $ret .= " selected ";
		$ret .= ">$row[name]</option>";
	}
	$ret .= "</select></td></tr>\n";
	return $ret;
}

function __ff_create_selectassocfile( $mass, $name, $postname, $comm="", $table, $attrs="" ){
	$ret  = "\n<tr>";
	$ret .= "<td width=\"200\" height=\"30\">$comm</td>";
	$ret .= "<td><select name=\"$postname\" id=\"$postname\">";
	$ret .= "	<option value=\"0\" "; 
	if($selected=="0") $ret .= " selected "; 
	$ret .=">Файл не задан</option>";
	$query = "select * from $table order by id asc  ";
	$resp = mysql_query($query);
	while($row=mysql_fetch_assoc($resp)){
		$ret .= "<option value=\"$row[id]\" ";
		if($row["id"]==$mass[$name])  $ret .= " selected ";
		$ret .= ">$row[name]</option>";
	}
	$ret .= "</select></td></tr>\n";
	return $ret;
}

function __ff_create_selectparents( $mass, $name, $postname, $comm="", $table, $attrs="" ){
	//print_r($mass);
	$ret  = "\n<tr>";
	$ret .= "<td width=\"200\" height=\"30\">Родительская директория</td>";
	$ret .= "<td>";
	$ret .= "<select name=\"parent_folder\" id=\"parent_folder\">
                  <option value=\"0\">--Выберите родительскую группу--</option>";
	//if($edit_folder)
		//echo __fmt_rekursiya_show_items_for_select(0, $edit_mass, $edit_folder, 0);
	//else
		//print_r($mass);
		$ret .=  __fmt_rekursiya_show_items_for_select(0, 0, $mass, 0, 0, $mass["parent"]);
    $ret .= "</select>";
	
	return $ret;
}

function __ff_create_datepicker( $mass, $name, $postname, $comm="", $attrs="" ){
	$ret  = "\n<tr>";
	$ret .= "<td width=\"200\" height=\"30\">$comm</td>";
	$ret .= "<td><input $attrs name=\"$postname\" type=\"date\" id=\"$postname\" value=\"".$mass[$name]."\" ></td>";
	$ret .= "</tr>\n";
	return $ret;
}

function __ff_create_hidden( $mass, $name, $postname, $comm="", $attrs="" ){
	$ret  = "\n<!-- $comm --><input $attrs name=\"$postname\" type=\"hidden\" id=\"$postname\" value=\"".$mass[$name]."\" >\n";
	return $ret;
}

function __ff_create_images( $mass, $name, $postname, $comm="", $attrs="" ){
	$ret  = "\n<tr><td valign=\"top\" style=\"padding-top: 5px;\">Изображения<hr size=\"1\"/ style=\"width: 180px;\">";
	$ret .= "<font color=\"#FF0000\">Все действия<br/>с изображениями<br/>сохраняются мгновенно</font></td>";
	$ret .= "<td valign=\"top\" style=\"padding: 5px; margin-bottom: 20px; min-height:220px;\"><div id=\"myDiv\">";
	$ret .= show_images_for_items($mass["id"])."</div><div style=\"float:none; clear:both\"></div>";
	$ret .= "<ul id=\"sortable\" style=\"display:none; margin-top:30px;\"></ul>";
	$ret .= "<div style=\"float:none; clear:both\"></div>";
	//********************
	$ret .= "<div id=\"div_up_iframe\"></div>";
	//********************
	$ret .= "</td></tr>\n";
	return $ret;
}

function __ff_create_artikul( $mass, $name ){
	$ret  = "\n<tr><td width=\"200\" height=\"30\">Код-Артикул-P/N</td>";
	$ret .= "<td><input name=\"item_code\" type=\"text\" id=\"item_code\" value=\"$mass[item_code]\" style=\"width:30%\">";
	$ret .= " - <input name=\"item_art\" type=\"text\" id=\"item_art\" value=\"$mass[item_art]\" style=\"width:30%\">";
	$ret .= " - <input name=\"item_psevdoart\" type=\"text\" id=\"item_psevdoart\" value=\"$mass[item_psevdoart]\" style=\"width:30%\"></td>";
	$ret .= "</tr>\n";
	return $ret;
}

function __ff_create_textarea( $mass, $name, $postname, $comm="", $attrs="" ){
	$ret  = "\n<tr><td colspan=\"2\" style=\"padding:5px;\" valign=\"top\" id=\"td_item_content\" style=\"display:none;\">".get_item_content($mass["id"])."</td></tr>\n";
	return $ret;
}

function __ff_create_selectmanytomany( $mass, $name, $postname, $comm="", $attrs="" ){
	$ret  = "\n<tr><td colspan=\"2\" style=\"padding:5px;\" valign=\"top\" id=\"td_item_content\" style=\"display:none;\">testtest</td></tr>\n";
	return $ret;
}

function __ff_create_semp( $mass, $name, $postname, $comm="", $attrs="" ){
	$ret  = "\n<tr><td colspan=\"2\" style=\"padding:5px;\" valign=\"top\" id=\"td_item_content\" style=\"display:none;\">";
	$ret .= "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"6\">\n";
	$ret .= "<tr><td class=\"inputtitle\" valign=\"middle\">Вместе с моделью покупают</td>\n";
	$ret .= "<td valign=\"top\" class=\"inputcomment\">";
	$ret .= "<a href=\"javascript:add_semp()\">Добавить</a><hr size=\"1\">\n";
	$ret .= "<div  id=\"semp_all\">\n";
	$masse = explode("\n", $mass["semp"]);
	foreach($masse as $key=>$val){
		if($val) {
			$respa = mysql_query("select * from items where id=$val");
			$rowa = mysql_fetch_assoc($respa);
			if($rowa["id"]) {
				//$ret .= "<div id=\"semp_$rowa[id]\"><a href=\"manage_models.php?parent=rowa[parent]&edit=$rowa[id]\">$rowa[name]</a> 
				//<a href=\"javascript:delete_semp($rowa[id])\"><img src=\"tree/delete_item.gif\"></a></div>"; 
				$ret .= "<div id=\"semp_$rowa[id]\">$rowa[name] <a href=\"javascript:delete_semp($rowa[id])\"><img src=\"tree/delete_item.gif\"></a></div>"; 
			}
		}
	}
	$ret .= "</div><div id=\"semp_as_frame\" style=\"display:none;\"></div>";
	//$ret .= "<input type=\"hidden\" name=\"model_assoc\"  id=\"model_assoc\" value=\"$row[model_assoc]\" />\n";
	$ret .= "<input type=\"hidden\" name=\"semp\"  id=\"semp\" value=\"$mass[semp]\" />\n";
	$ret .= "</td></tr></table>\n";
	$ret .= "</td></tr>\n";
	return $ret;
}

//***************************************************************


function __ff_querypostdata($item_type, $post){
	//print_r($post);
	//echo ">>$item_type select redirect from items where id=$post[parent]";
	//print_r($post);
	//if(!$post["parent"]) return false;
	$rrr=mysql_query("select * from items where id=$post[id]");
	$rr=mysql_fetch_assoc($rrr);
	$resptemp = mysql_query("select redirect from items where id=$rr[parent]");
	$rowtemp = mysql_fetch_assoc($resptemp);
	$redirect = $rowtemp["redirect"];
	if($redirect) if(!$post["parent"]) $post["parent"]="psevdoparent-1";
	//echo "redirect=$redirect";
	//$query = "select * from itemstypes where id=$item_type";
	//$resp = mysql_query($query);
	//$row = mysql_fetch_assoc($resp);
	//$mass = explode("\n", $row["pairs"]);
	$autohref = false;
	//*************
	print_r($post);
	foreach($post as $key=>$val){
		if($key=="item_cont") { $key="cont"; $post["cont"]=$val; }
		$query = "update items set tmp=0 where id=$post[id]";
		$respi = mysql_query($query);
		$resp = mysql_query("SHOW FIELDS FROM items where field='$key' ");
		while($row=mysql_fetch_assoc($resp)){
			
			if(preg_match('/^int/', $row["Type"]) && $key!="id" ){
				if($key=="parent"){
					//echo "k=par";
					if($redirect) $val = $redirect;
				}
				
				if($val!="psevdoparent-1"){
					$query = "update items set $key=$val where id=$post[id]";
					$respi = mysql_query($query);
				}
			} elseif(preg_match('/^double/', $row["Type"]) && $key!="id" ){
				$query = "update items set $key=$val where id=$post[id]";
				$respi = mysql_query($query);
			} else {
				if($key != "id" && $key != "saveblock" && $key != "usercomments"){
					$post[$key]       	= preg_replace("/'/", "&rsquo;", $post[$key] );
					$query = "update items set $key='".preg_replace("/~~~plus~~~/", "+", preg_replace("/~~~aspirand~~~/", "&", iconv("UTF-8", "CP1251", $post[$key]) ) )."' where id=$post[id]";
					if($key=="name") {
						
						//$query       	= preg_replace('/"/', "»", $query );
						//$query       	= preg_replace("/ »/", " «", $query );
						//$query       	= preg_replace("/'/", "asd", $query );
					}
					if($key=="href_name" && $post[$key]!=""){
						$autohref = false;
					}
					echo $query."\n";
					if($key == "sfmany"){
						$query = "update items set sfmany='".$_POST["sfmany"]."' where id=$post[id]";
						//print_r($_POST);
						echo "post[key]=".$_POST["sfmany"]."\n";
					}
					$respi = mysql_query($query);
				}
			}
		}
	}
	if(!$post["href_name"]){
		$autohref = __fp_rus_to_eng(iconv("UTF-8", "CP1251", $post["name"]) );
		$autohref = preg_replace("/\./", "", $autohref);
		$query = "update items set href_name='$autohref' where id=$post[id]";
		echo "autohref=$autohref  из $post[name]<br/>\n";
		$respi = mysql_query($query);
		//$query = "update items set href_name='asdqwe' where id=$post[id]";
	}
	//$folder_name = iconv("UTF-8", "CP1251", $_POST["efolder_name"]);
	//$query = "update items set name='$folder_name' where id=$pid";
	//$resp = mysql_query($query);
	//return $ret;
}

function __ff_getjsonpostdata($item_type, $pid=false, $mi=false){
	//print_r($mi);
	if($item_type < 2) return false;
	$ret  = "{";
	$query = "select * from itemstypes where id=$item_type";
	$resp = mysql_query($query);
	$row = mysql_fetch_assoc($resp);
	$mass = explode("\n", $row["pairs"]);
	$count =0;
	foreach($mass as $key=>$val){
		if($val!=""){
			$tmass = explode("===", $val);
			if($mi){
				foreach($mi as $mik=>$miv){
					$miv = explode("===", $miv);
					if($miv[0]==$tmass[0]){
						if($key!=0 && $tmass[0]!="images" && $tmass[0]!="saveblock" && $tmass[0]!="usercomments" && $ret!="{") {
							if($miv[1]){
								if($miv[1]==$tmass[1]) $ret .= ",\n";
							} else {
								$ret .= ",\n";
							} 
						}
						if($tmass[0]=="images"){
							$ret .= "";
						} else if($tmass[0]=="textarea"){
							$ret .= "$count: { 0: \"item_cont\", 1: \"item_cont\" } ";
							$count++;
						} else if($tmass[0]=="coder"){
							$ret .= "$count: { 0: \"coder\", 1: \"coder\" } ";
							$count++;
						} else if($tmass[0]=="color"){
							$ret .= "$count: { 0: \"color\", 1: \"color\" } ";
							$count++;
						} else if($tmass[0]=="pricedigit"){
							$ret .= "$count: { 0: \"pricedigit\", 1: \"pricedigit\" } ";
							$count++;
						} else if($tmass[0]=="multiprice"){
							$ret .= "$count: { 0: \"multiprice\", 1: \"multiprice\" } ";
							$count++;
						} else if($tmass[0]=="grabber"){
							$ret .= "$count: { 0: \"grabber\", 1: \"grabber\" } ";
							$count++;
						} else if($tmass[0]=="parent"){
							$ret .= "$count: { 0: \"parent\", 1: \"parent_folder\" } ";
							$count++;
						} else if($tmass[0]=="semp"){
							$ret .= "$count: { 0: \"semp\", 1: \"semp\" } ";
							$count++;
						} else if($tmass[0]=="saveblock"){
							$ret .= "";
						} else if($tmass[0]=="usercomments"){
							$ret .= "";
						} else if($tmass[0]=="artikul"){
							$ret .= "$count: { 0: \"item_code\", 1: \"item_code\" } , ";
							$count++;
							$ret .= "$count: { 0: \"item_art\", 1: \"item_art\" } , ";
							$count++;
							$ret .= "$count: { 0: \"item_psevdoart\", 1: \"item_psevdoart\" } ";
							$count++;
						} else {
							if($miv[1]==$tmass[1]){
								$ret .= "$count: { 0: \"$tmass[1]\", 1: \"$tmass[2]\" } ";
								$count++;
							}
						}
						//******************
					}
				}
			} else {
				if($key!=0 && $tmass[0]!="images" && $tmass[0]!="saveblock" && $tmass[0]!="usercomments") {
					$ret .= ",\n";
				}
				if($tmass[0]=="images"){
					$ret .= "";
				} else if($tmass[0]=="textarea"){
					$ret .= "$count: { 0: \"item_cont\", 1: \"item_cont\" } ";
					$count++;
				} else if($tmass[0]=="color"){
					$ret .= "$count: { 0: \"color\", 1: \"color\" } ";
					$count++;
				} else if($tmass[0]=="coder"){
					$ret .= "$count: { 0: \"coder\", 1: \"coder\" } ";
					$count++;
				} else if($tmass[0]=="pricedigit"){
					$ret .= "$count: { 0: \"pricedigit\", 1: \"pricedigit\" } ";
					$count++;
				} else if($tmass[0]=="multiprice"){
					$ret .= "$count: { 0: \"multiprice\", 1: \"multiprice\" } ";
					$count++;
				} else if($tmass[0]=="grabber"){
					$ret .= "$count: { 0: \"grabber\", 1: \"grabber\" } ";
					$count++;
				} else if($tmass[0]=="parent"){
					$ret .= "$count: { 0: \"parent\", 1: \"parent_folder\" } ";
					$count++;
				} else if($tmass[0]=="semp"){
					$ret .= "$count: { 0: \"semp\", 1: \"semp\" } ";
					$count++;
				} else if($tmass[0]=="saveblock"){
					$ret .= "";
				} else if($tmass[0]=="usercomments"){
					$ret .= "";
				} else if($tmass[0]=="artikul"){
					$ret .= "$count: { 0: \"item_code\", 1: \"item_code\" } , ";
					$count++;
					$ret .= "$count: { 0: \"item_art\", 1: \"item_art\" } , ";
					$count++;
					$ret .= "$count: { 0: \"item_psevdoart\", 1: \"item_psevdoart\" } ";
					$count++;
				} else {
					$ret .= "$count: { 0: \"$tmass[1]\", 1: \"$tmass[2]\" } ";
					$count++;
				}
			}
			//******************
		}
	}
	
	$resp_par2 = mysql_query("select * from items where id=$pid");
	$row_par2 = mysql_fetch_assoc($resp_par2);
	$resp_par2 = mysql_query("select * from items where id=$row_par2[parent]");
	$row_par2 = mysql_fetch_assoc($resp_par2);
	$parent_mass = $row_par2;
	
	//print_r($parent_mass);
	
	/*
	if($pid){
		if($parent_mass["cfg_file"]!=""){
		  $cfg_mass = __lc_find_data_from_loadconfig($parent_mass["cfg_file"], "../config/".$parent_mass["cfg_file"].".cfg", 1);
		  $cfg_mass = explode(",", $cfg_mass);
		  foreach($cfg_mass as $key=>$val){
				  $mass = __lc_find_data_from_loadconfig("$val", "../config/".$parent_mass["cfg_file"].".cfg", 1);  
				  $mass = explode("=", $mass);
				  //print_r($mass);
				  $mass[2]=trim($mass[2]);
				  if($mass[2]=="select"){
					//echo "<br/>edit_mass=".$edit_mass["$mass[3]"];
					$data = __lc_get_select_constructor($mass, $row["$mass[3]"]);
					//echo $data;
				  }
				  if($mass[2]=="list"){
					//echo "<br/>edit_mass=".$edit_mass["$mass[3]"];
					$data = __lc_get_list_constructor($mass, $row["$mass[3]"]);
					$ret .= ", $count: { 0: \"$mass[3]\", 1: \"$mass[3]\", 2: \"list\" } ";
					$count++;
				  }
			}
		}
	}
	*/
	
	$ret .= "}";
	return $ret;
}

function get_item_type($id, $self=false){
	//echo "self=".$self."<br/>";
	if(!$id) return "0";
	$resp = mysql_query("select * from items where id=$id");
	$row = mysql_fetch_assoc($resp);
	if($row["parent"]==0) return $row["itemtype"];
	else if($row["itemtype"]) return $row["itemtype"];
	//else if($row["multi_config"] && $self==false) return "multiitem";
	else return get_item_type($row["parent"]);
}

function get_item_multiitem($id, $self=false){
	//echo "self=".$self."<br/>";
	if(!$id) return "0";
	$resp = mysql_query("select * from items where id=$id");
	$row = mysql_fetch_assoc($resp);
	if($row["folder"]==1) return false;
	//else if($row["itemtype"]) return $row["itemtype"];
	else if($row["is_multi"] && $self==false ) { if($row["multi_config"]=="") return "saveblock"; else return $row["multi_config"];   }
	else return get_item_multiitem($row["parent"]);
}

function __ff_reload_single_item( $id, $multidiv=false ){
	$ret = "";
	//$ret .= "<table><tr><td>";
	//********************************
	$globalRestsResp = mysql_query("select * from pages where name='rests'");
	$globalRestsRow = mysql_fetch_assoc($globalRestsResp);
	$globalRests = $globalRestsRow['cont'];
	//********************************
	$resp = mysql_query("select * from items where id=$id");
	$row = mysql_fetch_assoc($resp);
	$rowpp=$row;
	$respi = mysql_query("select * from images where parent=$row[id] order by prior asc limit 0,1");
	$rowi = mysql_fetch_assoc($respi);
	$img = $rowi["link"];

		$eltype = get_item_type($rowpp["id"], "true"); 
		$respelquery = "select * from itemstypes where id=$eltype";
		//echo "respelquery=$respelquery<br/>";
		$respeltype = mysql_query("select * from itemstypes where id=$eltype");
		$roweltype = mysql_fetch_assoc($respeltype);
		
		$ret .= "<div class=\"item_idc\" id=\"idc_$row[id]\" style=\"display:none;\">"; //item advanced control
		//*****************
		$ret .= "<a href=\"javascript:\" title=\"Свернуть дополнительные опции\"><img 
		src=\"images/green/myitemname_popup/more_options_left.gif\" id=\"imgoptions_$row[id]\" 
		width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\"
		style=\"margin-right:5px;margin-left:10px;cursor:pointer;\" onClick=\"hide_idc($row[id])\" ></a>";
		//*****************
		$ret .= "</div>";
		//*****************
		
		//*****************
		
		//*****************
		if($multidiv){
			$ret .=  "<div>";
		} else {
			$ret .=  "<div id=\"div_myitemname_$row[id]\" class=\"div_myitemname";
			if($roweltype["name"] == "orders" || $roweltype["name"] == "alisagoo") $ret .= " dmnoover";
			$ret .= "\" style=\"";
			if($row["is_multi"] == 1){
				$aaresp = mysql_query("select * from items where recc!=1  && parent=$row[id] order by prior asc   ");
				$ret .= "height:".(mysql_num_rows($aaresp)*36+36)."px;";
			}
			if($roweltype["name"] == "alisagoo"){
				$ret .= "height:200px;overflow:normal;";
			}
			if($roweltype["name"] == "orders"){
				if(  $row["orderstatus"] == "ordersstatuses/ok"  )	
					$ret .= "background-color:#DDE3DD;padding-top:10px;height:auto";
				if(  $row["orderstatus"] == "ordersstatuses/take"  ||  $row["orderstatus"] == ""  )	
					$ret .= "background-color:#FD7373;";
				if(  $row["orderstatus"] == "ordersstatuses/sended"  )	
					$ret .= "background-color:#BBFFFF;color:#333333;";
				if(  $row["orderstatus"] == "ordersstatuses/cancel"  )	
					$ret .= "background-color:#EFD1D1;color:#333333;";
				if(  $row["orderstatus"] == "ordersstatuses/working"  )	
					$ret .= "background-color:#FFE79D;";
			}
			$ret .= "\"  >";
		}
		//*********************
		if(  $row["recc"] == 1  ){ 
			$ret .= "<a href=\"javascript:\" title=\"Удалить запись из корзины\"><img 
			src=\"images/green/myitemname_popup/delete_item.gif\" id=\"imgoptions_$row[id]\" 
			width=\"16\" height=\"16\" border=\"0\"  align=\"right\" 
			style=\"margin-right:5px;cursor:pointer;margin-top:5px;\" onClick=\"clear_item_recc($row[id])\" ></a>";
		}
		//*********************
		if(  $row["recc"] != 1  ){ 
			$ret .= "<a href=\"javascript:\" title=\"Удалить запись\"><img 
			src=\"images/green/myitemname_popup/delete_item.gif\" id=\"imgoptions_$row[id]\" 
			width=\"16\" height=\"16\" border=\"0\"  align=\"right\" 
			style=\"margin-right:5px;cursor:pointer;margin-top:5px;\" onClick=\"delete_item($row[id])\" ></a>";
			if($roweltype["name"] != "alisagoo"){
				$ret .= "<a href=\"javascript:\" title=\"Редактировать запись\"><img 
				src=\"images/green/myitemname_popup/edit_item.gif\" id=\"imgoptions_$row[id]\" 
				width=\"16\" height=\"16\" border=\"0\"  align=\"right\" 
				style=\"margin-right:5px;cursor:pointer;margin-top:5px;\" 
				onClick=\"show_myitemblock('div_myitemname_$row[id]');hide_idc($row[id])\" ></a>";
			}
			$a = __ff_test_item_for_all_data(  $row  );
			if(  $a != "true"  &&  $roweltype["name"] != "orders" && $roweltype["name"] != "alisagoo"  ){
				$ret .= "<div class=\"items_nodatafield\" id=\"items_nodatafield_$row[id]\" style=\"display:none;\">
				<span class=\"ndf_span_1\">$a</span>
				<span class=\"ndf_span_2\"></span></div>";
				if($multidiv) {
					$ret .= "<img src=\"images/green/myitemname_popup/spacer16x16.gif\" width=\"16\" height=\"16\" border=\"0\"  align=\"right\" 
					style=\"margin-right:5px;margin-top:5px;\">";
				} else {
					$ret .= "<a href=\"javascript:\" title=\"Внимание: незаполненные поля\">";
					$ret .= "<img src=\"images/green/myitemname_popup/warning.gif\" id=\"imgwarning_$row[id]\" 
					width=\"16\" height=\"16\" border=\"0\"  align=\"right\" style=\"margin-right:5px;margin-top:5px;\"
					onmouseover=\"show_items_warning($row[id])\" onmouseout=\"hide_items_warning($row[id])\">";
					$ret .= "</a>";
				}
			} else {
				$ret .= "<div style=\"float:right;width:16px;margin-right:5px;margin-left:3px;\">&nbsp;</div>";
			}
			//if($roweltype["name"] == "items"){
			if(preg_match("/^items-?/", $roweltype["name"]) && $globalRests=='1'){
				//*****************
				$ret .= "<div style=\"float:right;width:40px;margin-right:5px;margin-top:8px;\"><b>".round($row["kolvov"], 2)."</b></div>";
				$ret .= "<div style=\"float:right;width:16px;margin-right:5px;margin-top:5px;\"><img src=\"images/green/myitemname_popup/rests_basket.gif\"
					width=\"16\" height=\"16\" border=\"0\"  align=\"left\" /></div>";
				//*****************
				$ret .= "<div style=\"float:right;width:40px;margin-right:5px;margin-top:8px;\"><b>$row[kolvo]</b></div>";
				$ret .= "<div style=\"float:right;width:16px;margin-right:5px;margin-top:5px;\"><img src=\"images/green/myitemname_popup/rests.gif\"
					width=\"16\" height=\"16\" border=\"0\"  align=\"left\" /></div>";
			}
		}
		//*********************
		//if($roweltype["name"] != "orders" && $row["recc"]!=1 && $qwertys){
			//if($row["hot_item"]==1){
			if($multidiv) {
				$ret .= "<img src=\"images/green/myitemname_popup/spacer16x16.gif\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
			} else {
				$ret .= "<img src=\"images/green/myitemname_popup/checkbox.gif\" id=\"imgcheck_$row[id]\" 
				width=\"16\" height=\"16\" border=\"0\"  class=\"items_select_all\" 
				style=\"margin-right:5px;cursor:pointer;";
				if($roweltype["name"] == "alisagoo") $ret .= "float:left;";
				$ret .= "\" align=\"absmiddle\" 
				onClick=\"toggle_item_check($row[id])\" >";
			}
			//} else {
			//	$ret .= "<img src=\"images/green/myitemname_popup/more_options_no.gif\" id=\"imgoptions_$row[id]\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
			//}
		//}
		//*********************
		if(  $row["recc"] == 1  ){ 
			$ret .= "<a href=\"javascript:resc_item($row[id])\" title=\"Восстановить запись\">";
			$ret .= "<img src=\"images/green/myitemname_popup/restore_item.gif\" id=\"imgoptions_$row[id]\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
			$ret .= "</a>";
		}
		//*********************
		if($roweltype["name"] != "orders" && $row["recc"]!=1 && $qwertys){  //ДОПОЛНИТЕЛЬНЫЙ МОДУЛЬ
			$ret .= "<a href=\"javascript:show_idc($row[id])\" title=\"Дополнительные опции\">";
			//if($row["hot_item"]==1){
				$ret .= "<img src=\"images/green/myitemname_popup/more_options.gif\" id=\"imgoptions_$row[id]\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
			//} else {
			//	$ret .= "<img src=\"images/green/myitemname_popup/more_options_no.gif\" id=\"imgoptions_$row[id]\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
			//}
			$ret .= "</a>";
		}
		//*********************
		//if($roweltype["name"] == "items" || $roweltype["name"] == "news"){
		if(preg_match("/^items-?/", $roweltype["name"]) || $roweltype["name"] == "news"){
			if($multidiv) {
				$ret .= "<img src=\"images/green/myitemname_popup/spacer16x16.gif\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
			} else {
				$ret .= "<a href=\"javascript:toggle_spec_show($row[id])\" title=\"Спецпоказ\">";
				if($row["hot_item"]==1){
					$ret .= "<img src=\"images/green/myitemname_popup/specpred.gif\" id=\"imgspecpred_$row[id]\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
				} else {
					$ret .= "<img src=\"images/green/myitemname_popup/specpred_no.gif\" id=\"imgspecpred_$row[id]\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
				}
				$ret .= "</a>";
			}
		}
		//*********************
		//if($roweltype["name"] == "items"){
		if(preg_match("/^items-?/", $roweltype["name"])){
			if($multidiv) {
				$ret .= "<img src=\"images/green/myitemname_popup/spacer16x16.gif\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
			} else {
				$ret .= "<a href=\"javascript:toggle_akc_show($row[id])\" title=\"Акция\">";
				if($row["is_akc"]==1){
					$ret .= "<img src=\"images/green/myitemname_popup/akc.gif\" id=\"imgakc_$row[id]\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
				} else {
					$ret .= "<img src=\"images/green/myitemname_popup/akc_no.gif\" id=\"imgakc_$row[id]\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
				}
				$ret .= "</a>";
			}
		}
		//*********************
		//if($roweltype["name"] == "items"){
		if(preg_match("/^items-?/", $roweltype["name"])){
			if($multidiv) {
				$ret .= "<img src=\"images/green/myitemname_popup/spacer16x16.gif\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
			} else {
				$ret .= "<a href=\"javascript:toggle_new_show($row[id])\" title=\"Новинка\">";
				if($row["is_new"]==1){
					$ret .= "<img src=\"images/green/myitemname_popup/new.gif\" id=\"imgnew_$row[id]\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
				} else {
					$ret .= "<img src=\"images/green/myitemname_popup/new_no.gif\" id=\"imgnew_$row[id]\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
				}
				$ret .= "</a>";
			}
		}
		//*********************
		//if($roweltype["name"] == "items"){
		if(preg_match("/^items-?/", $roweltype["name"])){
			if($multidiv) {
				$ret .= "<img src=\"images/green/myitemname_popup/spacer16x16.gif\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
			} else {
				$ret .= "<a href=\"javascript:toggle_sale_show($row[id])\" title=\"Распродажа\">";
				if($row["is_sale"]==1){
					$ret .= "<img src=\"images/green/myitemname_popup/sale.gif\" id=\"imgsale_$row[id]\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
				} else {
					$ret .= "<img src=\"images/green/myitemname_popup/sale_no.gif\" id=\"imgsale_$row[id]\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
				}
				$ret .= "</a>";
			}
		}
		//**********************************************************************************
		if($roweltype["name"] == "items" && $globalRests=='0'){ 
			$ret .= "<a href=\"javascript:toggle_rests_show($row[id])\" title=\"Товар в наличие\">";
			if($row["is_rests"]==1){
				$ret .= "<img src=\"images/green/myitemname_popup/rests.gif\" id=\"rests_$row[id]\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
			} else {
				$ret .= "<img src=\"images/green/myitemname_popup/rests_no.gif\" id=\"rests_$row[id]\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
			}
			$ret .= "</a>";
		}
		//**********************************************************************************
		if($roweltype["name"] != "orders" && $roweltype["name"] != "alisagoo"){ 
			$ret .= "<a href=\"javascript:toggle_page_show($row[id])\" title=\"Отображение страницы в сайте\">";
			if($row["page_show"]==1){
				$ret .= "<img src=\"images/green/myitemname_popup/glaz.gif\" id=\"glaz_$row[id]\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
			} else {
				$ret .= "<img src=\"images/green/myitemname_popup/glaz_no.gif\" id=\"glaz_$row[id]\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
			}
			$ret .= "</a>";
		}
		//**********************************************************************************
		if($roweltype["name"] == "alisagowww"){ 
			$ret .= "<a href=\"javascript:toggle_page_show($row[id])\" title=\"Отображение страницы в сайте\">";
			if($row["page_show"]==1){
				$ret .= "<img src=\"images/green/myitemname_popup/glaz.gif\" id=\"glaz_$row[id]\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
			} else {
				$ret .= "<img src=\"images/green/myitemname_popup/glaz_no.gif\" id=\"glaz_$row[id]\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
			}
			$ret .= "</a>";
		}
		//**********************************************************************************
		if($multidiv) {
				$ret .= "<img src=\"images/green/myitemname_popup/spacer16x16.gif\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
		} else {	
			if($roweltype["name"] != "alisagoo"){
				$ret .= "<a href=\"javascript:\" title=\"Описание записи\">";
				if($row["cont"]!=""){
					$ret .= "<img class=\"istext_hover_img\" src=\"images/green/myitemname_popup/istext.gif\" id=\"istext_$row[id]\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
				} else {
					$ret .= "<img class=\"istext_hover_img\" src=\"images/green/myitemname_popup/istext_no.gif\" id=\"istext_$row[id]\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
				}
				$ret .= "</a>";
			}
		}
		//**********************************************************************************
		//$ret .= "<a href=\"javascript:\" title=\"Редактор таблиц\">";
		//$tabresp = mysql_query("select * from files_csv where parent = $row[id]");
		//if(mysql_num_rows($tabresp) > 0){
		//	$ret .= "<img class=\"istable_hover_img\" src=\"images/green/myitemname_popup/istable.gif\" id=\"istable_$row[id]\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
		//} else {
		//	$ret .= "<img class=\"istable_hover_img\" src=\"images/green/myitemname_popup/istable_no.gif\" id=\"istable_$row[id]\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
		//}
		//$ret .= "</a>";
		//**********************************************************************************
		$my_filter = __mtm_has_mtm($row["id"]);
		if($my_filter){
			if($multidiv) {
				$ret .= "<img src=\"images/green/myitemname_popup/spacer16x16.gif\" width=\"17\" height=\"17\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
			} else {
				$ret .= "<a href=\"javascript:filter_mtm_show($row[id])\" title=\"Управление mtm-фильтром\">";
				if($row["mtm_cont"]!=""){
					$ret .= "<img src=\"images/green/icons/mtm_filter.gif\" id=\"mtm_filter_$row[id]\" width=\"17\" height=\"17\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
				} else {
					$ret .= "<img src=\"images/green/icons/mtm_filter_no.gif\" id=\"mtm_filter_$row[id]\" width=\"17\" height=\"17\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
				}
				$ret .= "</a>";
			}
		}
		//**********************************************************************************
		//if($roweltype["name"] == "items"){
		if(preg_match("/^items-?/", $roweltype["name"])){
			if($multidiv) {
				$ret .= "<a href=\"javascript:\" title=\"Добавить блок мультизаписи\">";
				$ret .= "<img src=\"images/green/myitemname_popup/add_record.gif\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" 
				onClick=\"start_multiitem($row[parent], this)\" style=\"margin-right:5px;cursor:pointer\">";
				$ret .= "</a>";
			} else {
				$ret .= "<a onClick=\"";
				if($row["is_multi"]==1) $ret .= "show_myitemblock_mi_config($row[id], this)";
				else $ret .= "start_multiitem($row[id], this)";
				$ret .= "\" href=\"javascript:\" title=\"Мультизапись\">";
				$ret .= "<img src=\"images/green/myitemname_popup/multiitem";
				if($row["is_multi"]==1) $ret .= "_active";
				$ret .= ".gif\" id=\"imgrests_$row[id]\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
				$ret .= "</a>";
			}
			//$a = explode("\n", $row["multiprice"]){
			//	$ret .= "<div class=\"items_nodatafield\" id=\"items_rests_$row[id]\" style=\"display:none;\">
			//	<span class=\"ndf_span_1\"><b>Остатки:</b><br/></span>
			//	<span class=\"ndf_span_2\"></span></div>";
			//}
		}
		//**********************************************************************************
		if($roweltype["name"] == "orders"){ 
			if(file_exists("../orders/".__fp_rus_to_eng($row["name"]).".docx")){ 
				$ret .= "<a href=\"../orders/".__fp_rus_to_eng($row["name"]).".docx\" title=\"Скачать Word\">";
				$ret .= "<img class=\"istext_hover_img\" src=\"images/green/myitemname_popup/word.gif\" 
				id=\"istext_$row[id]\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
				$ret .= "</a>";
				$ret .= "<a href=\"javascript:delete_order_docx($row[id])\" title=\"Удалить этот файл Word\"><img src=\"images/green/myitemname_popup/mini_delete.gif\"  width=\"9\" height=\"9\" 
				style=\"position:relative;top:-9px;left:-9px;margin-right:-10px;\"  ></a>";
			} else {
				$ret .= "<a href=\"javascript:order_to_docx($row[id])\" title=\"Создать счет в формате Word\">";
				$ret .= "<img src=\"images/green/myitemname_popup/word_na.gif\" 
				width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
				$ret .= "</a>";
			}
			
		}
		//**********************************************************************************
		if($roweltype["name"] != "orders" && $roweltype["name"] != "alisagoo"){ 
			if(  $rowi["link"]  ){
				$lnk = __fi_create_img_tumbs("../loadimages", "44x33", $rowi["link"]);
				//echo $lnk;
				$ret .= "<img src=\"$lnk\" width=\"44\" height=\"33\" border=1 class=\"imggal\" align=\"absmiddle\" style=\"margin-right:5px;\">";
			} else {
				$ret .= "<img src=\"images/green/myitemname_popup/no_img.gif\" width=\"44\" height=\"33\" border=1 class=\"imggal\" align=\"absmiddle\" style=\"margin-right:5px;\">";
			}
		}
		
		if($roweltype["name"] != "alisagoo"){
			$ret .= "<span id=\"span_myitemname_$row[id]\" ";
			if($row["page_show"]!=1){   $ret .= "style=\"color:#666666\"";  }
			$ret .= " >$row[name] ";
		} else {
			$ret .= "<div style=\"width: 300px;float:left;font-weight:normal;margin-right:10px;white-space:normal;\">";
			$ret .= "<span id=\"span_myitemname_$row[id]\" style=\"display:inline;\">Комментерий $row[name]</span>:";
			$ret .= "<br/><div id=\"agq_$row[id]\" ";
			$ret .= " style=\"background-color:#CACACA;padding:10px;\" ";
			$ret .= ">".$row["cont"]."</div><hr size=1/><a href=\"javascript:edit_agq($row[id])\">Изменить</a></div>";
			$ret .= "<div style=\"width: 200px;float:left;font-weight:normal;\">Ответ:<br/><div id=\"agr_$row[id]\" ";
			$ret .= " style=\"background-color:#CACACA;padding:10px;\" ";
			$ret .= ">$row[minicont]</div><hr size=1/><a href=\"javascript:edit_agr($row[id])\">Изменить</a></div>";
		}
		
		//****************
		if($roweltype["name"] == "orders"){
			if($row["orderstatus"] == "ordersstatuses/ok"){
				$ret .= "&nbsp;&nbsp;&nbsp;Заказ выполнен";
			} elseif($row["orderstatus"] == "ordersstatuses/cancel"){
				$ret .= "&nbsp;&nbsp;&nbsp;<a href=\"javascript:\">Восстановить заказ</a>";
			} else {
				$ret .= "<select style=\"width: 150px;margin-left:20px;margin-right:5px; \" onChange=\"setOrderStatus(this, $row[id])\" >";
				$ordrespp = mysql_query(" select id from items where parent=0 && folder=1 &&  href_name='ordersstatuses' ");
				$ordrowp = mysql_fetch_assoc($ordrespp);
				$ordresp = mysql_query(" select * from items where parent=$ordrowp[id] && folder=0 && tmp=0 && page_show=1 &&  recc=0 order by prior asc ");
				while($ordrow = mysql_fetch_assoc($ordresp)){
					$ret .= "<option value=\"".__fp_create_folder_way("items", $ordrow["id"], 1)."\" ";
					if(  __fp_create_folder_way("items", $ordrow["id"], 1) == $row["orderstatus"]."/"  )  $ret .= " selected ";
					$ret .= " >$ordrow[name]</option>";
				}
				$ret .= "</select>";
				if($row["orderstatus"] == "ordersstatuses/working"){
					$ret .= "<a class=\"ordesr_sendorder";
					if(preg_match("/order-send-1/", $row["cont"]))
						$ret .= "_sended";
					$ret .= "\" href=\"javascript:orders_sendOrder($row[id])\">Отправить счет";
					if(preg_match("/order-send-1/", $row["cont"]))
						$ret .= " повторно";
					$ret .= "</a>";
				}
			}
			
		}
		//****************
		if($row["pricedigit"]) {
			$ret .= "(<span id=\"item_price_$row[id]\" class=\"item_fastpricedigit\">$row[pricedigit]</span> / <font color=red>$row[zakprice]</font>)";
		}
		//****************
		if($roweltype["name"] != "alisagoo"){
			$ret .= "</span>";
		}
		if($row["is_multi"] == 1){
			while($aarow = mysql_fetch_assoc($aaresp)){
				$ret .=  __ff_reload_single_item( $aarow["id"], true );
			}
		}
		$ret .= "</div>";
	
	//$ret .= "</td></tr></table>";
	return $ret;
}
//**********************************************
function __ff_get_textfield_fields( $field, $key ){
	$ret  = "<select name=\"fm_fields\" id=\"1_prm_$key\">";
	$ret .= "	<option value=\"0\" "; 
	if($selected=="0") $ret .= " selected "; 
	$ret .=">Выберите поле</option>";
	//$ret .= "</select>\n";
	$query = "SHOW FIELDS FROM items";
	$resp = mysql_query($query);
	while($row=mysql_fetch_assoc($resp)){
		//print_r($row);
		if(preg_match("/varchar/", $row["Type"])){
			//$ret .= "$row[Type] ";
			$ret .= "<option value=\"$row[Field]\" ";
			if($row["Field"]==$field)  $ret .= " selected ";
			$ret .= ">$row[Field]</option>";
		}
	}
	$ret .= "</select>\n";
	return $ret;
}
//**********************************************
function __ff_get_numfield_fields( $field, $key ){
	$ret  = "<select name=\"fm_fields\" id=\"1_prm_$key\">";
	$ret .= "	<option value=\"0\" "; 
	if($selected=="0") $ret .= " selected "; 
	$ret .=">Выберите поле</option>";
	//$ret .= "</select>\n";
	$query = "SHOW FIELDS FROM items";
	$resp = mysql_query($query);
	while($row=mysql_fetch_assoc($resp)){
		//print_r($row);
		if(preg_match("/int/", $row["Type"])){
			//$ret .= "$row[Type] ";
			$ret .= "<option value=\"$row[Field]\" ";
			if($row["Field"]==$field)  $ret .= " selected ";
			$ret .= ">$row[Field]</option>";
		}
	}
	$ret .= "</select>\n";
	return $ret;
}
//**********************************************
function __ff_get_double_fields( $field, $key ){
	$ret  = "<select name=\"fm_fields\" id=\"1_prm_$key\">";
	$ret .= "	<option value=\"0\" "; 
	if($selected=="0") $ret .= " selected "; 
	$ret .=">Выберите поле</option>";
	//$ret .= "</select>\n";
	$query = "SHOW FIELDS FROM items";
	$resp = mysql_query($query);
	while($row=mysql_fetch_assoc($resp)){
		//print_r($row);
		if(preg_match("/double/", $row["Type"])){
			//$ret .= "$row[Type] ";
			$ret .= "<option value=\"$row[Field]\" ";
			if($row["Field"]==$field)  $ret .= " selected ";
			$ret .= ">$row[Field]</option>";
		}
	}
	$ret .= "</select>\n";
	return $ret;
}
//**********************************************
function __ff_get_checkbox_fields( $field, $key ){
	$ret  = "<select name=\"fm_fields\" id=\"1_prm_$key\">";
	$ret .= "	<option value=\"0\" "; 
	if($selected=="0") $ret .= " selected "; 
	$ret .=">Выберите поле</option>";
	//$ret .= "</select>\n";
	$query = "SHOW FIELDS FROM items";
	$resp = mysql_query($query);
	while($row=mysql_fetch_assoc($resp)){
		//print_r($row);
		if(preg_match("/int\(1\)/", $row["Type"])){
			//$ret .= "$row[Type] ";
			$ret .= "<option value=\"$row[Field]\" ";
			if($row["Field"]==$field)  $ret .= " selected ";
			$ret .= ">$row[Field]</option>";
		}
	}
	$ret .= "</select>\n";
	return $ret;
}
//**********************************************
function __ff_get_selectfromitems_many_fields( $field, $key ){
	$ret  = "<select name=\"fm_fields\" id=\"1_prm_$key\">";
	$ret .= "	<option value=\"0\" "; 
	if($selected=="0") $ret .= " selected "; 
	$ret .=">Выберите поле</option>";
	//$ret .= "</select>\n";
	$query = "SHOW FIELDS FROM items";
	$resp = mysql_query($query);
	while($row=mysql_fetch_assoc($resp)){
		//print_r($row);
		if(preg_match("/varchar/", $row["Type"])){
			$ret .= "<option value=\"$row[Field]\" ";
			if($row["Field"]==$field)  $ret .= " selected ";
			$ret .= ">$row[Field]</option>";
		}
	}
	$ret .= "</select>\n";
	return $ret;
}
//**********************************************
function __ff_get_selectfromitems_fields( $field, $key ){
	$ret  = "<select name=\"fm_fields\" id=\"1_prm_$key\">";
	$ret .= "	<option value=\"0\" "; 
	if($selected=="0") $ret .= " selected "; 
	$ret .=">Выберите поле</option>";
	//$ret .= "</select>\n";
	$query = "SHOW FIELDS FROM items";
	$resp = mysql_query($query);
	while($row=mysql_fetch_assoc($resp)){
		//print_r($row);
		if(preg_match("/varchar/", $row["Type"])){
				$ret .= "<option value=\"$row[Field]\" ";
				if($row["Field"]==$field)  $ret .= " selected ";
				$ret .= ">$row[Field]</option>";
		}
	}
	$ret .= "</select>\n";
	return $ret;
}
//**********************************************
function __ff_get_itemstypes_rus_name_from_index($name, $item_id){
	$my_filter = get_item_type($item_id);
	$mass = __ff_get_itemstypes_to_mass_by_id($my_filter);
	foreach($mass as $k=>$v){
		$vmass = explode("===", $v);
		if(  is_array($name)  ){
			//echo "<pre>"; print_r($name); echo "</pre>";
			if($name[0]==$vmass[0] && $name[1]==$vmass[1])
				return $vmass[3];
		} else {
			$prega = "/^$name/";
			if(  preg_match($prega, $v)  ){
				if($vmass[3]) return $vmass[3];
			}
		}
	}
}
//**********************************************
function __ff_get_itemstypes_name_from_rus_name($rusname, $itemtype){
	if(!$itemtype) return false;
	$mass = __ff_get_itemstypes_to_mass_by_id($itemtype);
	foreach($mass as $key=>$val){
		$mmm = explode("===", $val);
		//print_r($mmm);
		if($rusname=="Артикул") return "item_art";
		//*********************************************************
		if($mmm[0]=="textarea" && $rusname=="Текстовое поле") return "cont";
		if($mmm[0]=="pricedigit" && $rusname=="Цена") return "pricedigit";
		if($mmm[0]=="inputtext" && $rusname=="Гиперссылка" && $mmm[1]=="href_name") return "id";
		if($mmm[0]=="images" && $rusname=="Изображение") return "image";
		if($mmm[0]=="selectfromitems" && $mmm[3]==$rusname) {
			return $mmm[1].":selectfromitems";
		}
		if($mmm[3]==$rusname) return $mmm[1];
	}
}
//**********************************************
function __ff_get_itemstypes_to_mass_by_id($id){
	$fquery = "select * from itemstypes where id=$id  ";
	//echo $fquery;
	$fresp = mysql_query($fquery);
	$frow = mysql_fetch_assoc($fresp);
	$mass = explode("\n", $frow["pairs"]);
	return $mass;
}
//**********************************************
function __ff_generate_simple_filter_sql($str, $id){
	$mass = __ff_generate_simple_filter_mass($str, $id);
	$ret = "&&  ( ";
	$count = 0;
	foreach($mass as $key=>$val){
		if($count) $ret .= " && ";
		$ret .= " ( ";
		foreach($val as $k=>$v){
			if($k!=0) $ret .= " || ";
			$ret .= "$key=$v";
		}
		$ret .= " ) ";
		$count++;
	}
	$ret .= " ) ";
	return $ret;
	//echo $ret."<br/>\n";
	//echo "<pre>"; print_r($mass); echo "</pre>";
}
//**********************************************
function __ff_get_itemstypes_filter($mass){
	$rmass = false;
	foreach ($mass as $key=>$val){
		$vmass = explode("===", $val);
		if($vmass[count($vmass)-1]=="alisa_activefilter"){
			$rmass[] = $vmass;
		}
	}
	//echo "<pre>"; print_r($rmass); echo "</pre>";
	return $rmass;
}
//**********************************************
function __ff_get_itemstypes_mass_from_sess($str){
	$qmass = explode("&", $str);
	$smass = false;
	foreach($qmass as $key=>$val){
		$val = explode("=", $val);
		$smass[$val[0]][]=$val[1];
	}
	array_splice($smass, count($smass)-1, 1);
	return $smass;
}
//**********************************************
function __ff_generate_simple_filter_mass($str, $id){
	$r_mass = false;
	$smass = __ff_get_itemstypes_mass_from_sess($str);
	//echo "<pre>"; print_r($smass); echo "</pre>";
	$mass = __ff_get_itemstypes_to_mass_by_id($id);
	$mass = __ff_get_itemstypes_filter($mass);
	//print_r($mass);
	foreach($smass as $key=>$val){
		if($key!=""){
			foreach($mass as $k=>$v){
				if($v[6]==$key){
					$r_mass[$v[1]] = $val;
				}
			}
		}
	}
	return $r_mass;
}
//**********************************************
function __ff_test_simple_filter_active($str, $id){
	$ret = false;
	$mass = __ff_get_itemstypes_mass_from_sess($str);
	foreach($mass as $key=>$val){
		foreach($val as $k=>$v){
			if($v == $id){
				$ret = true;
			}
		}
	}
	return $ret;
}
//**********************************************
function __ff_generate_update_query(  $table, $key, $val, $id  ){
	$query = "";
	$querya = "SHOW FIELDS FROM $table where field='$key' ";
	//echo $query;
	$resp = mysql_query(  $querya  );
	$row = mysql_fetch_assoc(  $resp  );
	if(  mysql_num_rows(  $resp  ) > 0  ){
		//echo "<pre>"; print_r(  $row  ); echo "</pre>";
		if(  preg_match(  '/^int/', $row["Type"]  ) && $key!="id"  ){
			$query = "update $table set $key=$val where id=$id";
		} elseif(  preg_match(  '/^double/', $row["Type"]  )  &&  $key!="id"  ){
			$query = "update $table set $key=$val where id=$id";
		} else {
			$query = "update items set $key='$val' where id=$id";
		}
	}
	return $query;
}
//**********************************************
function __ff_test_item_for_all_data(  $row  ){
	$ret_val = "<b>Незаполненные поля:</b><br/>\n";
	$errors = false;
	$it =  get_item_type(  $row["id"]  );
	if(  $it == 0  ) return "true";
	$smass = __ff_get_itemstypes_to_mass_by_id(  $it  );
	foreach(  $smass as $key=>$val  ){
		$mass = explode(  "===", $val  );
		//echo "<pre>"; print_r(  $mass  ); echo "</pre>";
		if(  $mass[0] == "grabber"  ){
		
		} elseif(  $mass[0] == "pricedigit"  ){
			if(  $row["pricedigit"] == "" || $row["pricedigit"] == 0  ){
				$ret_val .= "Цена<br/>\n";
				$errors = true;
			}
		} elseif(  $mass[0] == "artikul"  ){
			if(  trim(  $row["item_code"]  ) == ""  ){
				$ret_val .= "Код товара<br/>\n";
				$errors = true;
			}
		} elseif(  $mass[0] == "datepicker"  ){
			if(  trim(  $row["datepicker"]  ) == ""  ){
				$ret_val .= "Дата<br/>\n";
				$errors = true;
			}
		} elseif(  $mass[0] == "textarea"  ){
			if(  trim(  $row["cont"]  ) == ""  ){
				$ret_val .= "Описание<br/>\n";
				$errors = true;
			}
		} else {
			if(  $mass[0] != "inputcheckbox"  &&  $mass[0] != "saveblock"  &&  $mass[0] != "images"  &&  $mass[0] != "parent"
			&&  $mass[0] != "selectgaltype"  &&  $mass[0] != "usercomments"  &&  $mass[0] != "selectrectofolder"
			&&  $mass[0] != "selectmanytomany"  &&  $mass[0] != "coder"   ) {
			if(  !$row[$mass[1]]  ) {
				if(  $mass[1] != "discount"  &&  $mass[1] != "hot_item"  ){
					$ret_val .= "$mass[3]<br/>\n";
					$errors = true;
				}
			}  }
		}
	}
	if(  $errors  ) {  
		//echo $ret_val; 
		return $ret_val;  
	}
	return "true";
}
//**********************************************
function __ff_construct_multiprice($mp){
	$ret = "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" id=\"tablemultiprice\" style=\"background-color:#EBEBEB;\">";
	$ret .= "<tr><td width=\"100\" style=\"height:40px;\">Цена</td><td width=\"100\">Параметр</td><td width=\"100\">Значение</td>";
	$ret .= "<td width=\"100\" style=\"padding-left:10px;\">Изображение</td><td width=\"100\">Остатки</td><td width=\"120\">Остатки с корзиной</td><td>&nbsp;</td></tr>";
	$mass = explode("\n", $mp["multiprice"]);
	foreach($mass as $key => $val){
		$val = trim($val);
		$val = explode("~", $val);
		$ret .= "<tr>";
		$ret .= "<td width=\"100\" style=\"height:40px;\"><input type=\"text\" style=\"width:80px\" value=\"$val[0]\" /></td>";
		$ret .= "<td width=\"100\"><input type=\"text\" style=\"width:80px\" value=\"$val[1]\" /></td>";
		$ret .= "<td width=\"100\"><input type=\"text\" style=\"width:100%\" value=\"$val[2]\" /></td>";
		if($val[3] && $val[3]!=""){
			$resp = mysql_query(" select * from filemanager where id=".str_replace("fileid=", "", $val[3])." && prior=$key ");
			$row = mysql_fetch_assoc($resp);
			$ret .= "<td width=\"100\" style=\"padding-left:10px;\"><img id=\"mtpi_".str_replace("fileid=", "", $val[3])."_$key\" ";
			$ret .= "src=\"../userupload/$row[link]\" style=\"margin:2px;width:30px;height:30px;border: 1px solid #961B1F;\" align=\"absmiddle\" />";
			$ret .= "<img src=\"images/green/myitemname_popup/edit_item.gif\" style=\"margin-left: 3px;cursor:pointer;\" align=\"absmiddle\" ";
			$ret .= "onClick=\"show_edit_img_popup($val[3], 'userupload')\"  />";
			$ret .= "<img src=\"images/green/myitemname_popup/delete_item.gif\" style=\"margin-left: 5px;cursor:pointer;\" align=\"absmiddle\" ";
			$ret .= "onClick=\"delete_filemanager_item($val[3], 'Удалить иконку?', 'clear_multiprice_img($key, $mp[id])')\"  /></td>";
		}else{
			$ret .= "<td width=\"100\" style=\"padding-left:10px;\"><div id=\"multiprice_img_".$mp["id"]."_"."$key\"></div></td>";
			$ret .= "<script>init_multiprice_img('multiprice_img_".$mp["id"]."_$key', $mp[id], $key)</script>";
		}
		$ret .= "<td width=\"100\"><input type=\"text\" style=\"width:80px\" value=\"$val[4]\" /></td>";
		$ret .= "<td width=\"120\">&nbsp;</td>";
		$ret .= "<td>&nbsp;</td>";
		$ret .= "</tr>";
	}
	$ret .= "</table>";
	$ret .= "<a href=\"javascript:add_multiprice_block($mp[id])\"><img border=\"0\" src=\"images/green/myitemname_popup/multiprice.gif\" style=\"margin:5px\" /></a>";
	return $ret;
}
//**********************************************
function __ff_get_($mp){

}
//**********************************************
function __ff_reload_single_user( $id ){
	$ret = "";
	//$ret .= "<table><tr><td>";
	$query = "select * from users where id=$id";
	//echo $query;
	$resp = mysql_query($query);
	$row = mysql_fetch_assoc($resp);
	$rowpp=$row;
	//$respi = mysql_query("select * from images where parent=$row[id] order by prior asc limit 0,1");
	//$rowi = mysql_fetch_assoc($respi);
	//$img = $rowi["link"];

		//$eltype = get_item_type($rowpp["id"], "true"); 
		//$respelquery = "select * from itemstypes where id=$eltype";
		//echo "respelquery=$respelquery<br/>";
		//$respeltype = mysql_query("select * from itemstypes where id=$eltype");
		//$roweltype = mysql_fetch_assoc($respeltype);
		
		//*****************
		$ret .= "<div id=\"div_myitemname_$row[id]\" class=\"div_myitemname\" ";
		$ret .= "\" style=\"height:45px;";
		if($row["reg"]==1 && $row["most_delete"]==0)
			$ret .= "background-color:#DDE3DD;";
		if($row["reg"]==2 && $row["most_delete"]==0)
			$ret .= "background-color:#FFE9A4;";
		if($row["most_delete"]==1)
			$ret .= "background-color:#FFAAAA;";
		$ret .= "\">";
			$ret .= "<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">";
				$ret .= "<tr>";
					//**************************************
					//$ret .= "<td height=\"35\" width=\"22\">";
					//	$ret .= "<img src=\"images/green/myitemname_popup/checkbox.gif\" id=\"imgcheck_$row[id]\" 
					//	width=\"16\" height=\"16\" border=\"0\"  class=\"items_select_all\" 
					//	style=\"margin-right:5px;cursor:pointer;";
					//	if($roweltype["name"] == "alisagoo") $ret .= "float:left;";
					//	$ret .= "\" align=\"absmiddle\" 
					//	onClick=\"toggle_item_check($row[id])\" >";
					//$ret .= "</td>";
					//**************************************
					//$ret .= "<td width=\"22\">";
					//	$ret .= "<a href=\"javascript:toggle_user_ban($row[id])\" title=\"Заблокировать пользователя\">";
					//	//if($row["page_show"]==1){
					//		$ret .= "<img src=\"images/green/myitemname_popup/zamok.gif\" id=\"zamok_$row[id]\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
					//	//} else {
					//	//	$ret .= "<img src=\"images/green/myitemname_popup/glaz_no.gif\" id=\"glaz_$row[id]\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
					//	//}
					//	$ret .= "</a>";
					//$ret .= "</td>";
					//**************************************
					$ret .= "<td width=\"22\" >";
						$ret .= "<a href=\"javascript:toggle_user_spam($row[id])\" title=\"Выключить из рассылки новостей\">";
						if($row["isnews"]==1  &&  $row["email"]!=""){
							$ret .= "<img src=\"images/green/myitemname_popup/dog.gif\" id=\"dog_$row[id]\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
						} else {
							$ret .= "<img src=\"images/green/myitemname_popup/dog_no.gif\" id=\"dog_$row[id]\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
						}
						$ret .= "</a>";
					$ret .= "</td>";
					//**************************************
					$ret .= "<td width=\"250\"  height=\"35\"  >";
						if($row["fio"]=="" || $row["fio"]=="Гость") {
							$ret .= "<span  class=\"user_fio\" id=\"edit_fio_$row[id]\">Гость</span>";
						} else {
							$ret .= "<span  class=\"user_fio\" id=\"edit_fio_$row[id]\">$row[fio]</span>";
							$ret .= "<br/><span  class=\"user_email\" id=\"edit_email_$row[id]\">($row[email])</span>";
							$ret .= "<br/><span  class=\"user_phone\" id=\"edit_phone_$row[id]\">$row[phone]</span>";
						}
					$ret .= "</td>";
					//******************  Пароль  ********************
					$ret .= "<td width=\"70\" align=\"center\">";
						if($row["reg"]==2) $ret .= "<span  class=\"user_pass\" id=\"edit_pass_$row[id]\">пароль</span>";
						elseif($row["reg"]==1) $ret .= "<span  class=\"user_pass\" id=\"edit_pass_$row[id]\">****</span>";
						elseif($row["pass"]=="0" || $row["pass"]=="unreg") $ret .= "Нет";
						else $ret .= "<span  class=\"user_pass\" id=\"edit_pass_$row[id]\">****</span>";
					$ret .= "</td>";
					//**************************************
					$ret .= "<td width=\"130\" align=\"center\" >";
						$ret .= strftime("%d.%m.%Y %H:%M:%S", $row["reg_time"]);
					$ret .= "</td>";
					//**************************************
					$ret .= "<td width=\"70\" align=\"center\" >";
						$ret .= "$row[count_zak]";
					$ret .= "</td>";
					//**************************************
					$ret .= "<td width=\"70\" align=\"center\" >";
						$ret .= __fo_getUserAllSum($row["id"]);
					$ret .= "</td>";
					//******************  Скидка  ********************
					$ret .= "<td width=\"70\" align=\"center\">";
						if($row["reg"] > 0) $ret .= "<span  class=\"user_discount\" id=\"edit_discount_$row[id]\">$row[discount]%</span>";
						else $ret .= "&nbsp;";
					$ret .= "</td>";
					//**************************************
					$ret .= "<td width=\"\">";
						$ret .= "test";
					$ret .= "</td>";
					//**************************************
					$ret .= "<td width=\"22\">";
						if($row["reg"]==2){
							$ret .= "<a href=\"javascript:\" title=\"Зарегистрировать пользователя\"><img 
								src=\"images/green/myitemname_popup/ok_item.gif\" id=\"regi_$row[id]\" 
								width=\"16\" height=\"16\" border=\"0\"  align=\"right\" onClick=\"registering_user($row[id])\" ></a>";
						}
					$ret .= "</td>";
					//**************************************
					$ret .= "<td width=\"22\">";
						if($row["most_delete"]==1){
							$ret .= "<a href=\"javascript:\" title=\"Отменить удаление\"><img 
								src=\"images/green/myitemname_popup/restore_item.gif\" id=\"imgoptions_$row[id]\" 
								width=\"16\" height=\"16\" border=\"0\"  align=\"right\" onClick=\"cancel_delete_user($row[id])\" ></a>";
						} else {
							$ret .= "<a href=\"javascript:\" title=\"Удалить пользователя\"><img 
								src=\"images/green/myitemname_popup/delete_item.gif\" id=\"imgoptions_$row[id]\" 
								width=\"16\" height=\"16\" border=\"0\"  align=\"right\" onClick=\"delete_user($row[id])\" ></a>";
						}
					$ret .= "</td>";
					//**************************************
				$ret .= "</tr>";
			$ret .= "</table>";
		$ret .= "</div>";
		//*****************
		//	$ret .=  "<div id=\"div_myitemname_$row[id]\" class=\"div_myitemname";
		//	if($roweltype["name"] == "orders" || $roweltype["name"] == "alisagoo") $ret .= " dmnoover";
		//	$ret .= "\" style=\"";
		//	if($row["is_multi"] == 1){
		//		$aaresp = mysql_query("select * from items where recc!=1  && parent=$row[id] order by prior asc   ");
		//		$ret .= "height:".(mysql_num_rows($aaresp)*36+36)."px;";
		//	}
		//	if($roweltype["name"] == "alisagoo"){
		//		$ret .= "height:200px;overflow:normal;";
		//	}
		//	if($roweltype["name"] == "orders"){
		//		if(  $row["orderstatus"] == "ordersstatuses/ok"  )	
		//			$ret .= "background-color:#DDE3DD;padding-top:10px;height:auto";
		//		if(  $row["orderstatus"] == "ordersstatuses/take"  ||  $row["orderstatus"] == ""  )	
		//			$ret .= "background-color:#FD7373;";
		//		if(  $row["orderstatus"] == "ordersstatuses/sended"  )	
		//			$ret .= "background-color:#BBFFFF;color:#333333;";
		//		if(  $row["orderstatus"] == "ordersstatuses/cancel"  )	
		//			$ret .= "background-color:#EFD1D1;color:#333333;";
		//		if(  $row["orderstatus"] == "ordersstatuses/working"  )	
		//			$ret .= "background-color:#FFE79D;";
		//	}
		//	$ret .= "\"  >";
		//*********************
		//if(  $row["recc"] != 1  ){ 
			//$ret .= "<a href=\"javascript:\" title=\"Удалить запись\"><img 
			//src=\"images/green/myitemname_popup/delete_item.gif\" id=\"imgoptions_$row[id]\" 
			//width=\"16\" height=\"16\" border=\"0\"  align=\"right\" 
			//style=\"margin-right:5px;cursor:pointer;margin-top:5px;\" onClick=\"delete_item($row[id])\" ></a>";
			//if($roweltype["name"] != "alisagoo"){
			//	$ret .= "<a href=\"javascript:\" title=\"Редактировать запись\"><img 
			//	src=\"images/green/myitemname_popup/edit_item.gif\" id=\"imgoptions_$row[id]\" 
			//	width=\"16\" height=\"16\" border=\"0\"  align=\"right\" 
			//	style=\"margin-right:5px;cursor:pointer;margin-top:5px;\" 
			//	onClick=\"show_myitemblock('div_myitemname_$row[id]');hide_idc($row[id])\" ></a>";
			//}
			//$a = __ff_test_item_for_all_data(  $row  );
			//if(  $a != "true"  &&  $roweltype["name"] != "orders" && $roweltype["name"] != "alisagoo"  ){
			//	$ret .= "<div class=\"items_nodatafield\" id=\"items_nodatafield_$row[id]\" style=\"display:none;\">
			//	<span class=\"ndf_span_1\">$a</span>
			//	<span class=\"ndf_span_2\"></span></div>";
			//	if($multidiv) {
			//		$ret .= "<img src=\"images/green/myitemname_popup/spacer16x16.gif\" width=\"16\" height=\"16\" border=\"0\"  align=\"right\" 
			//		style=\"margin-right:5px;margin-top:5px;\">";
			//	} else {
			//		$ret .= "<a href=\"javascript:\" title=\"Внимание: незаполненные поля\">";
			//		$ret .= "<img src=\"images/green/myitemname_popup/warning.gif\" id=\"imgwarning_$row[id]\" 
			//		width=\"16\" height=\"16\" border=\"0\"  align=\"right\" style=\"margin-right:5px;margin-top:5px;\"
			//		onmouseover=\"show_items_warning($row[id])\" onmouseout=\"hide_items_warning($row[id])\">";
			//		$ret .= "</a>";
			//	}
			//} else {
			//	$ret .= "<div style=\"float:right;width:16px;margin-right:5px;margin-left:3px;\">&nbsp;</div>";
			//}
			//if($roweltype["name"] == "items"){
			//	//*****************
			//	$ret .= "<div style=\"float:right;width:40px;margin-right:5px;margin-top:8px;\"><b>$row[kolvov]</b></div>";
			//	$ret .= "<div style=\"float:right;width:16px;margin-right:5px;margin-top:5px;\"><img src=\"images/green/myitemname_popup/rests_basket.gif\"
			//		width=\"16\" height=\"16\" border=\"0\"  align=\"left\" /></div>";
			//	//*****************
			//	$ret .= "<div style=\"float:right;width:40px;margin-right:5px;margin-top:8px;\"><b>$row[kolvo]</b></div>";
			//	$ret .= "<div style=\"float:right;width:16px;margin-right:5px;margin-top:5px;\"><img src=\"images/green/myitemname_popup/rests.gif\"
			//		width=\"16\" height=\"16\" border=\"0\"  align=\"left\" /></div>";
			//}
		//}
		//*********************
		//if($roweltype["name"] != "orders" && $row["recc"]!=1 && $qwertys){
			//if($row["hot_item"]==1){
				//$ret .= "<img src=\"images/green/myitemname_popup/checkbox.gif\" id=\"imgcheck_$row[id]\" 
				//width=\"16\" height=\"16\" border=\"0\"  class=\"items_select_all\" 
				//style=\"margin-right:5px;cursor:pointer;";
				//if($roweltype["name"] == "alisagoo") $ret .= "float:left;";
				//$ret .= "\" align=\"absmiddle\" 
				//onClick=\"toggle_item_check($row[id])\" >";
			//} else {
			//	$ret .= "<img src=\"images/green/myitemname_popup/more_options_no.gif\" id=\"imgoptions_$row[id]\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
			//}
		//}
		//*********************
		//if(  $row["recc"] == 1  ){ 
		//	$ret .= "<a href=\"javascript:resc_item($row[id])\" title=\"Восстановить запись\">";
		//	$ret .= "<img src=\"images/green/myitemname_popup/restore_item.gif\" id=\"imgoptions_$row[id]\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
		//	$ret .= "</a>";
		//}
		//*********************
		//if($roweltype["name"] != "orders" && $row["recc"]!=1 && $qwertys){  //ДОПОЛНИТЕЛЬНЫЙ МОДУЛЬ
		//	$ret .= "<a href=\"javascript:show_idc($row[id])\" title=\"Дополнительные опции\">";
		//	//if($row["hot_item"]==1){
		//		$ret .= "<img src=\"images/green/myitemname_popup/more_options.gif\" id=\"imgoptions_$row[id]\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
		//	//} else {
		//	//	$ret .= "<img src=\"images/green/myitemname_popup/more_options_no.gif\" id=\"imgoptions_$row[id]\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
		//	//}
		//	$ret .= "</a>";
		//}
		//*********************
		//if($roweltype["name"] == "items" || $roweltype["name"] == "news"){
		//	if($multidiv) {
		//		$ret .= "<img src=\"images/green/myitemname_popup/spacer16x16.gif\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
		//	} else {
		//		$ret .= "<a href=\"javascript:toggle_spec_show($row[id])\" title=\"Спецпоказ\">";
		//		if($row["hot_item"]==1){
		//			$ret .= "<img src=\"images/green/myitemname_popup/specpred.gif\" id=\"imgspecpred_$row[id]\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
		//		} else {
		//			$ret .= "<img src=\"images/green/myitemname_popup/specpred_no.gif\" id=\"imgspecpred_$row[id]\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
		//		}
		//		$ret .= "</a>";
		//	}
		//}
		//*********************
		//if($roweltype["name"] == "items"){
		//	if($multidiv) {
		//		$ret .= "<img src=\"images/green/myitemname_popup/spacer16x16.gif\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
		//	} else {
		//		$ret .= "<a href=\"javascript:toggle_akc_show($row[id])\" title=\"Акция\">";
		//		if($row["is_akc"]==1){
		//			$ret .= "<img src=\"images/green/myitemname_popup/akc.gif\" id=\"imgakc_$row[id]\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
		//		} else {
		//			$ret .= "<img src=\"images/green/myitemname_popup/akc_no.gif\" id=\"imgakc_$row[id]\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
		//		}
		//		$ret .= "</a>";
		//	}
		//}
		//*********************
		//if($roweltype["name"] == "items"){
		//	if($multidiv) {
		//		$ret .= "<img src=\"images/green/myitemname_popup/spacer16x16.gif\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
		//	} else {
		//		$ret .= "<a href=\"javascript:toggle_new_show($row[id])\" title=\"Новинка\">";
		//		if($row["is_new"]==1){
		//			$ret .= "<img src=\"images/green/myitemname_popup/new.gif\" id=\"imgnew_$row[id]\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
		//		} else {
		//			$ret .= "<img src=\"images/green/myitemname_popup/new_no.gif\" id=\"imgnew_$row[id]\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
		//		}
		//		$ret .= "</a>";
		//	}
		//}
		//**********************************************************************************
		//if($roweltype["name"] != "orders" && $roweltype["name"] != "alisagoo"){ 
		//	$ret .= "<a href=\"javascript:toggle_page_show($row[id])\" title=\"Отображение страницы в сайте\">";
		//	if($row["page_show"]==1){
		//		$ret .= "<img src=\"images/green/myitemname_popup/glaz.gif\" id=\"glaz_$row[id]\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
		//	} else {
		//		$ret .= "<img src=\"images/green/myitemname_popup/glaz_no.gif\" id=\"glaz_$row[id]\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
		//	}
		//	$ret .= "</a>";
		//}
		//**********************************************************************************
		//if($roweltype["name"] == "alisagowww"){ 
		//	$ret .= "<a href=\"javascript:toggle_page_show($row[id])\" title=\"Отображение страницы в сайте\">";
		//	if($row["page_show"]==1){
		//		$ret .= "<img src=\"images/green/myitemname_popup/glaz.gif\" id=\"glaz_$row[id]\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
		//	} else {
		//		$ret .= "<img src=\"images/green/myitemname_popup/glaz_no.gif\" id=\"glaz_$row[id]\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
		//	}
		//	$ret .= "</a>";
		//}
		//**********************************************************************************
		//if($multidiv) {
		//		$ret .= "<img src=\"images/green/myitemname_popup/spacer16x16.gif\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
		//} else {	
		//	if($roweltype["name"] != "alisagoo"){
		//		$ret .= "<a href=\"javascript:\" title=\"Описание записи\">";
		//		if($row["cont"]!=""){
		//			$ret .= "<img class=\"istext_hover_img\" src=\"images/green/myitemname_popup/istext.gif\" id=\"istext_$row[id]\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
		//		} else {
		//			$ret .= "<img class=\"istext_hover_img\" src=\"images/green/myitemname_popup/istext_no.gif\" id=\"istext_$row[id]\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
		//		}
		//		$ret .= "</a>";
		//	}
		//}
		//**********************************************************************************
		//$ret .= "<a href=\"javascript:\" title=\"Редактор таблиц\">";
		//$tabresp = mysql_query("select * from files_csv where parent = $row[id]");
		//if(mysql_num_rows($tabresp) > 0){
		//	$ret .= "<img class=\"istable_hover_img\" src=\"images/green/myitemname_popup/istable.gif\" id=\"istable_$row[id]\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
		//} else {
		//	$ret .= "<img class=\"istable_hover_img\" src=\"images/green/myitemname_popup/istable_no.gif\" id=\"istable_$row[id]\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
		//}
		//$ret .= "</a>";
		//**********************************************************************************
		//$my_filter = __mtm_has_mtm($row["id"]);
		//if($my_filter){
		//	if($multidiv) {
		//		$ret .= "<img src=\"images/green/myitemname_popup/spacer16x16.gif\" width=\"17\" height=\"17\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
		//	} else {
		//		$ret .= "<a href=\"javascript:filter_mtm_show($row[id])\" title=\"Управление mtm-фильтром\">";
		//		if($row["mtm_cont"]!=""){
		//			$ret .= "<img src=\"images/green/icons/mtm_filter.gif\" id=\"mtm_filter_$row[id]\" width=\"17\" height=\"17\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
		//		} else {
		//			$ret .= "<img src=\"images/green/icons/mtm_filter_no.gif\" id=\"mtm_filter_$row[id]\" width=\"17\" height=\"17\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
		//		}
		//		$ret .= "</a>";
		//	}
		//}
		//**********************************************************************************
		//if($roweltype["name"] == "items"){
		//	if($multidiv) {
		//		$ret .= "<a href=\"javascript:\" title=\"Добавить блок мультизаписи\">";
		//		$ret .= "<img src=\"images/green/myitemname_popup/add_record.gif\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" 
		//		onClick=\"start_multiitem($row[parent], this)\" style=\"margin-right:5px;cursor:pointer\">";
		//		$ret .= "</a>";
		//	} else {
		//		$ret .= "<a onClick=\"";
		//		if($row["is_multi"]==1) $ret .= "show_myitemblock_mi_config($row[id], this)";
		//		else $ret .= "start_multiitem($row[id], this)";
		//		$ret .= "\" href=\"javascript:\" title=\"Мультизапись\">";
		//		$ret .= "<img src=\"images/green/myitemname_popup/multiitem";
		//		if($row["is_multi"]==1) $ret .= "_active";
		//		$ret .= ".gif\" id=\"imgrests_$row[id]\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
		//		$ret .= "</a>";
		//	}
		//	//$a = explode("\n", $row["multiprice"]){
		//	//	$ret .= "<div class=\"items_nodatafield\" id=\"items_rests_$row[id]\" style=\"display:none;\">
		//	//	<span class=\"ndf_span_1\"><b>Остатки:</b><br/></span>
		//	//	<span class=\"ndf_span_2\"></span></div>";
		//	//}
		//}
		//**********************************************************************************
		//if($roweltype["name"] == "orders"){ 
		//	if(file_exists("../orders/".__fp_rus_to_eng($row["name"]).".docx")){ 
		//		$ret .= "<a href=\"../orders/".__fp_rus_to_eng($row["name"]).".docx\" title=\"Скачать Word\">";
		//		$ret .= "<img class=\"istext_hover_img\" src=\"images/green/myitemname_popup/word.gif\" 
		//		id=\"istext_$row[id]\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
		//		$ret .= "</a>";
		//		$ret .= "<a href=\"javascript:delete_order_docx($row[id])\" title=\"Удалить этот файл Word\"><img src=\"images/green/myitemname_popup/mini_delete.gif\"  width=\"9\" height=\"9\" 
		//		style=\"position:relative;top:-9px;left:-9px;margin-right:-10px;\"  ></a>";
		//	} else {
		//		$ret .= "<a href=\"javascript:order_to_docx($row[id])\" title=\"Создать счет в формате Word\">";
		//		$ret .= "<img src=\"images/green/myitemname_popup/word_na.gif\" 
		//		width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
		//		$ret .= "</a>";
		//	}
		//	
		//}
		//**********************************************************************************
		//if($roweltype["name"] != "orders" && $roweltype["name"] != "alisagoo"){ 
		//	if(  $rowi["link"]  ){
		//		$lnk = __fi_create_img_tumbs("../loadimages", "44x33", $rowi["link"]);
		//		//echo $lnk;
		//		$ret .= "<img src=\"$lnk\" width=\"44\" height=\"33\" border=1 class=\"imggal\" align=\"absmiddle\" style=\"margin-right:5px;\">";
		//	} else {
		//		$ret .= "<img src=\"images/green/myitemname_popup/no_img.gif\" width=\"44\" height=\"33\" border=1 class=\"imggal\" align=\"absmiddle\" style=\"margin-right:5px;\">";
		//	}
		//}
		//
		//$ret .= "<span id=\"span_myitemname_$row[id]\" ";
		//if($row["page_show"]!=1){   $ret .= "style=\"color:#666666\"";  }
		//$ret .= " >$row[fio] ";
		
		//****************
		//if($roweltype["name"] == "orders"){
		//	if($row["orderstatus"] == "ordersstatuses/ok"){
		//		$ret .= "&nbsp;&nbsp;&nbsp;Заказ выполнен";
		//	} elseif($row["orderstatus"] == "ordersstatuses/cancel"){
		//		$ret .= "&nbsp;&nbsp;&nbsp;<a href=\"javascript:\">Восстановить заказ</a>";
		//	} else {
		//		$ret .= "<select style=\"width: 150px;margin-left:20px;margin-right:5px; \" onChange=\"setOrderStatus(this, $row[id])\" >";
		//		$ordrespp = mysql_query(" select id from items where parent=0 && folder=1 &&  href_name='ordersstatuses' ");
		//		$ordrowp = mysql_fetch_assoc($ordrespp);
		//		$ordresp = mysql_query(" select * from items where parent=$ordrowp[id] && folder=0 && tmp=0 && page_show=1 &&  recc=0 order by prior asc ");
		//		while($ordrow = mysql_fetch_assoc($ordresp)){
		//			$ret .= "<option value=\"".__fp_create_folder_way("items", $ordrow["id"], 1)."\" ";
		//			if(  __fp_create_folder_way("items", $ordrow["id"], 1) == $row["orderstatus"]."/"  )  $ret .= " selected ";
		//			$ret .= " >$ordrow[name]</option>";
		//		}
		//		$ret .= "</select>";
		//		if($row["orderstatus"] == "ordersstatuses/working"){
		//			$ret .= "<a class=\"ordesr_sendorder";
		//			if(preg_match("/order-send-1/", $row["cont"]))
		//				$ret .= "_sended";
		//			$ret .= "\" href=\"javascript:orders_sendOrder($row[id])\">Отправить счет";
		//			if(preg_match("/order-send-1/", $row["cont"]))
		//				$ret .= " повторно";
		//			$ret .= "</a>";
		//		}
		//	}
		//	
		//}
		//****************
		//if($row["pricedigit"]) {
		//	$ret .= "(<span id=\"item_price_$row[id]\" class=\"item_fastpricedigit\">$row[pricedigit]</span> / <font color=red>$row[zakprice]</font>)";
		//}
		//****************
		//if($roweltype["name"] != "alisagoo"){
		//	$ret .= "</span>";
		//}
		//if($row["is_multi"] == 1){
		//	while($aarow = mysql_fetch_assoc($aaresp)){
		//		$ret .=  __ff_reload_single_item( $aarow["id"], true );
		//	}
		//}
		//$ret .= "</div>";
	
	//$ret .= "</td></tr></table>";
	return $ret;
}
//**********************************************
function __ff_reload_single_order( $id, $page, $orderStatus ){
	$ret = "";
	//$ret .= "<table><tr><td>";
	$query = "select * from orders where id=$id";
	//echo $query;
	$resp = mysql_query($query);
	$row = mysql_fetch_assoc($resp);
	$rowpp=$row;
		
		
		$ret .= "<div id=\"div_myitemname_$row[id]\" class=\"div_myitemname\" ";
		$ret .= "\" style=\"";
		//*****************
		global $dop_query;
		$respOrderHeader = mysql_query("select * from items where parent=0 && href_name='ordersstatuses'   ");
		$rowOrderHeaderParent=mysql_fetch_assoc($respOrderHeader);
		$respOrderHeader = mysql_query("select * from items where parent=$rowOrderHeaderParent[id]  $dop_query order by prior asc  ");
		while($rowOrderHeader=mysql_fetch_assoc($respOrderHeader)){
			if($rowOrderHeader["href_name"]==$row["orderStatus"]){
				$ret .= "background-color:$rowOrderHeader[color];";
			}
		}
		$ret .= "\">";
			$ret .= "<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">";
				$ret .= "<tr>";
					//**************************************
					//$ret .= "<td height=\"35\" width=\"22\">";
					//	$ret .= "<img src=\"images/green/myitemname_popup/checkbox.gif\" id=\"imgcheck_$row[id]\" 
					//	width=\"16\" height=\"16\" border=\"0\"  class=\"items_select_all\" 
					//	style=\"margin-right:5px;cursor:pointer;";
					//	if($roweltype["name"] == "alisagoo") $ret .= "float:left;";
					//	$ret .= "\" align=\"absmiddle\" 
					//	onClick=\"toggle_item_check($row[id])\" >";
					//$ret .= "</td>";
					//**************************************
					//$ret .= "<td width=\"22\">";
					//	$ret .= "<a href=\"javascript:toggle_user_ban($row[id])\" title=\"Заблокировать пользователя\">";
					//	//if($row["page_show"]==1){
					//		$ret .= "<img src=\"images/green/myitemname_popup/zamok.gif\" id=\"zamok_$row[id]\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
					//	//} else {
					//	//	$ret .= "<img src=\"images/green/myitemname_popup/glaz_no.gif\" id=\"glaz_$row[id]\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
					//	//}
					//	$ret .= "</a>";
					//$ret .= "</td>";
					//**************************************
					$ret .= "<td width=\"22\" >";
						//$ret .= "<a href=\"javascript:toggle_user_spam($row[id])\" title=\"Выключить из рассылки новостей\">";
						//if($row["isnews"]==1  &&  $row["email"]!=""){
						//	$ret .= "<img src=\"images/green/myitemname_popup/dog.gif\" id=\"dog_$row[id]\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
						//} else {
						//	$ret .= "<img src=\"images/green/myitemname_popup/dog_no.gif\" id=\"dog_$row[id]\" width=\"16\" height=\"16\" border=\"0\"  align=\"absmiddle\" style=\"margin-right:5px;\">";
						//}
						//$ret .= "</a>";
					$ret .= "</td>";
					//**************************************
					$ret .= "<td width=\"100\"  height=\"35\" align=\"left\"  >";
						$ret .= __fo_SetOrderName($row["id"]);
						//if($row["fio"]=="" || $row["fio"]=="Гость") {
						//	$ret .= "<span  class=\"user_fio\" id=\"edit_fio_$row[id]\">Гость</span>";
						//} else {
						//	$ret .= "<span  class=\"user_fio\" id=\"edit_fio_$row[id]\">$row[fio]</span>";
						//	$ret .= "<br/><span  class=\"user_email\" id=\"edit_email_$row[id]\">($row[email])</span>";
						//}
					$ret .= "</td>";
					//**************************************
					$ret .= "<td width=\"100\"  height=\"35\" align=\"center\"  >";
						$ret .= "<a href=\"javascript:__ao_showOrder($row[id])\">Смотреть</a>";
					$ret .= "</td>";
					//**************************************
					$ret .= "<td width=\"250\" align=\"center\" >";
						$ret .= "<select style=\"width:240px;height:26px;\" onChange=\"__ao_cangeOrderStatus($row[id], this.value, '$orderStatus', '$page')\">";
						$respOrderHeader = mysql_query("select * from items where parent=$rowOrderHeaderParent[id]  $dop_query order by prior asc  ");
						while($rowOrderHeader=mysql_fetch_assoc($respOrderHeader)){
							$ret .= "<option value=\"$rowOrderHeader[href_name]\" ";
							if($rowOrderHeader["href_name"]==$row["orderStatus"]) $ret .= " selected ";
							$ret .= " >$rowOrderHeader[name]</option>";
						}
						$ret .= "</select>";
					$ret .= "</td>";
					//**************************************
					$ret .= "<td width=\"230\">";
						$userResp = mysql_query("select * from users where id=$row[userId]");
						$user = mysql_fetch_assoc($userResp);
						if($user["fio"]=="" || $user["fio"]=="Гость") {
							$ret .= "Гость";
						} else {
							$ret .= "$user[fio]";
							$ret .= "<br/>($user[email])";
						}
					$ret .= "</td>";
					//**************************************
					$ret .= "<td width=\"130\" align=\"center\" >";
						//$ret .= $row["addDate"];
						$ret .= str_replace(" ", "<br/>", $row["addDate"]);
					$ret .= "</td>";
					//**************************************
					$ret .= "<td width=\"100\" align=\"center\" >";
						$ret .= "$row[orderSum] грн.";
					$ret .= "</td>";
					//******************  Скидка  ********************
					$ret .= "<td width=\"70\" align=\"center\" >";
						$ret .= "$row[orderDiscount]%";
					$ret .= "</td>";
					//**************************************
					$ret .= "<td  align=\"center\">";
						$ret .= "&nbsp;";
					$ret .= "</td>";
					//**************************************
					$ret .= "<td width=\"22\">";
						if($row["reg"]==2){
							$ret .= "<a href=\"javascript:\" title=\"Зарегистрировать пользователя\"><img 
								src=\"images/green/myitemname_popup/ok_item.gif\" id=\"regi_$row[id]\" 
								width=\"16\" height=\"16\" border=\"0\"  align=\"right\" onClick=\"registering_user($row[id])\" ></a>";
						}
					$ret .= "</td>";
					//**************************************
					$ret .= "<td width=\"22\">";
						if($row["most_delete"]==1){
							$ret .= "<a href=\"javascript:\" title=\"Отменить удаление\"><img 
								src=\"images/green/myitemname_popup/restore_item.gif\" id=\"imgoptions_$row[id]\" 
								width=\"16\" height=\"16\" border=\"0\"  align=\"right\" onClick=\"cancel_delete_user($row[id])\" ></a>";
						} else {
							$ret .= "<a href=\"javascript:\" title=\"Удалить заказ\"><img 
								src=\"images/green/myitemname_popup/delete_item.gif\" id=\"imgoptions_$row[id]\" 
								width=\"16\" height=\"16\" border=\"0\"  align=\"right\" onClick=\"delete_order($row[id])\" ></a>";
						}
					$ret .= "</td>";
					//**************************************
				$ret .= "</tr>";
			$ret .= "</table>";
		$ret .= "</div>";
		//*****************
	return $ret;
}
//**********************************************
function __ff_findValuesFromKey($type, $key=false, $param=false){
	$respeltype = mysql_query("select * from itemstypes where id=$type");
	$roweltype = mysql_fetch_assoc($respeltype);
	if(!$key) return $roweltype["pairs"];
	$mass = explode("\n", $roweltype["pairs"]);
	foreach($mass as $value){
		$val = explode("===", $value);
		if($val[1]==$key && $param==false){
			return $val;
		} elseif($val[1]==$key && $param){
			$ppmass = explode(" ", $val[4]);
			foreach($ppmass as $pp){
				$pval = explode("=", $pp);
				$pkey = trim($pval[0]);
				if($pkey == $param){
					$pval = trim(str_replace('"', "", $pval[1]));
					return $pval;
				}
			}
		}
	}
	return false;
}
//**********************************************

//**********************************************

//**********************************************
?>