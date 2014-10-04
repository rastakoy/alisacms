<?
//********************************************************************************
function __fjs_json_stringify($mass, $tabs=""){
	$rv = "$tabs{\r\n";
	foreach($mass as $key=>$val){
		if(is_array($val)){
			$rv .= "$tabs\"$key\":".__fjs_json_stringify($val, "$tabs  ").",\r\n";
		} else {
			$rv .= "$tabs\"$key\":\"$val\",\r\n";
		}
	}
	$rv = preg_replace("/,\\r\\n$/", "\r\n", $rv);
	$rv = preg_replace("/,$/", "", $rv);
	$rv .= "$tabs}";
	return $rv;
}
//********************************************************************************
function __fjs_recovery_images_from_array(  $mass, $id  ){
	//echo "<pre>"; print_r(  $mass  ); echo "</pre>";
	foreach(  $mass as $key=>$val  ){
		echo "image = ".$val."<br/>\n";
		$resp = mysql_query(  "select * from images where link='$val'"  );
		$row = mysql_fetch_assoc(  $resp  );
		if(  $row["link"]  ){
			$resp = mysql_query(  "update images set parent=$id where id=$row[id]  "  );
		} else {
			$resp = mysql_query(  "insert into images (name, parent, prior, link) values ('img', $id, ".(($key+1)*10).", '$val' ) "  );
			if(  file_exists(  "../loadimages/".$val  )  )   unlink(  "../loadimages/".$val  );
			$result = copy(  "../backup/".$val, "../loadimages/".$val  );
		}
	}
	//
}
//********************************************************************************
function __fjs_recovery_data_from_array(  $mass, $parent="0"  ){
	//if(  $parent != 0  )  echo "<pre>"; print_r(  $mass  ); echo "</pre>";
	if(  !$parent  ) $parent = "0";
	foreach(  $mass as $key=>$val  ){
		if(  isset(  $val["folder"]  )  &&  $val["folder"] == "1"  ){
			//if(  $parent == 0  ){
				$query = "select * from items where folder=1 && parent=$parent && name='$val[name]' ";
				echo $query."<br/>\n";
				//echo $val."Проверка папки<pre>"; print_r(  $val  ); echo "</pre>";
				$resp = mysql_query(  $query  );
				if(  mysql_num_rows(  $resp  ) > 0  ){
					$row = mysql_fetch_assoc(  $resp  );
					$my_parent = $row["id"];
				} else {
					$query = "insert into items (recc, page_show, tmp, name, parent ) 
					values ( 0, 1, 0, 'tester', $parent  )";
					$resp = mysql_query(  $query  );
					$resp = mysql_query(  "select * from items order by id desc"  );
					$row = mysql_fetch_assoc(  $resp  );
					$my_parent = $row["id"];
					//echo $query."<br/>\n";
					foreach(  $val as $k=>$v  ){
						//$qq = __ff_generate_update_query(  "items", $k  );
						$keyquery = __ff_generate_update_query(  "items", $k, $v, $row["id"]  );
						$keyquery = str_replace(  "~~~~~n~~~~~", "\n", $keyquery  );
						//echo $keyquery."<br/>\n";
						$resp = mysql_query(  $keyquery  );
						//$query = "update items set $k  "
					}
				}
				//**********************************
				//if(  is_array(  $val["foldercont"]  )  ){
					
				//}
				//**********************************
			//}
			//echo $val."Проверка папки<pre>"; print_r(  $val  ); echo "</pre>";
			__fjs_recovery_data_from_array(  $val["foldercont"], $my_parent  );
		}
		//***************************************************************
		if(  isset(  $val["folder"]  )  &&  $val["folder"] == "0"  ){
			//if(  $parent == 0  ){
				$query = "select * from items where folder=0 && parent=$parent && name='$val[name]' ";
				echo $query." 1 <br/>\n";
				//echo $val."Проверка записи<pre>"; print_r(  $val  ); echo "</pre>";
				$resp = mysql_query(  $query  );
				if(  mysql_num_rows(  $resp  ) > 0  ){
					$row = mysql_fetch_assoc(  $resp  );
					$my_parent = $row["id"];
				} else {
					$query = "insert into items (recc, page_show, tmp, name, parent ) 
					values ( 0, 1, 0, 'tester', $parent  )";
					echo $query." 2 <br/>\n";
					$resp = mysql_query(  $query  );
					$resp = mysql_query(  "select * from items order by id desc"  );
					$row = mysql_fetch_assoc(  $resp  );
					$my_parent = $row["id"];
					foreach(  $val as $k=>$v  ){
						if(  $k != "parent"  ){
							$keyquery = __ff_generate_update_query(  "items", $k, $v, $row["id"]  );
							$keyquery = str_replace(  "~~~~~n~~~~~", "\n", $keyquery  );
							echo $keyquery." 3 <br/>\n";
							$resp = mysql_query(  $keyquery  );
						}
					}
				}
			//}
		}
		//***************************************************************
		__fjs_recovery_images_from_array(  $val["images"], $my_parent  );
	}
}
//********************************************************************************
function __fjs_array_to_javascript(  $mass  ){
	foreach(  $mass as $key=>$val  ){
		if(  isset(  $val["folder"]  )  &&  $val["folder"] == "0"  ){
			echo $val."<pre>"; print_r(  $val  ); echo "</pre>";
		}
	}
}
//********************************************************************************
function __fjs_decode_data_array(  $code, $decode, $mass  ){
	$rmass = array();
	if(is_array(  $mass  )){
		foreach(  $mass as $key=>$val  ){
			if(  is_array(  $val  )  ){
				$rmass[$key] = __fjs_decode_data_array(  $code, $decode, $val  );
			} else {
				$rmass[$key] =  iconv(  $code, $decode, $val  );
			}
		}
	}
	return $rmass;
}
//********************************************************************************
function __fjs_make_arch(  $folder_to, $folder_from,  $file  ){
	
}
//********************************************************************************
function __fjs_copy_file_to_arch_folder(  $folder_to, $folder_from,  $file  ){
	if(  file_exists(  $folder_to.$file  )  )
		unlink(  $folder_to.$file  );
	if(  file_exists(  $folder_from.$file  )  )
		return false;
	$result = copy(  $folder_from.$file, $folder_to.$file  );
	return $result;
}
//********************************************************************************
function __fjs_get_images_json($id, $tabs){
	$ret = "";
	$query = "select * from images where parent=$id order by prior asc  ";
	$resp = mysql_query($query);
	$count = "0";
	while($row=mysql_fetch_assoc($resp)){
		if(  __fjs_copy_file_to_arch_folder(  "../backup/", "../loadimages/",  $row["link"]  )  ){
			$ret .= "         $tabs\"$count\": \"$row[link]\",\n";
			$count++;
		}
	}
	$ret = preg_replace("/,\n$/", "\n", $ret);
	return $ret;
}
//********************************************************************************
function __fjs_default_item_json(  $row, $tabs  ){
	$ret  = "      $tabs\"name\": \"$row[name]\",\n";
	$ret .= "      $tabs\"href_name\": \"$row[href_name]\",\n";
	$ret .= "      $tabs\"mtitle\": \"$row[mtitle]\",\n";
	$ret .= "      $tabs\"mdesc\": \"$row[mdesc]\",\n";
	$ret .= "      $tabs\"mh\": \"$row[mh]\",\n";
	$ret .= "      $tabs\"prior\": \"$row[prior]\",\n";
	$ret .= "      $tabs\"page_show\": \"$row[page_show]\",\n";
	$cont = $row["cont"];
	$cont = preg_replace(  "/\n/", "~~~~~n~~~~~", $cont  );
	$cont = str_replace(  '"', '\"', $cont  );
	$ret .= "      $tabs\"cont\": \"$cont\",\n";
	$ret .= "      $tabs\"images\": {\n";
	$ret .= __fjs_get_images_json($row["id"], $tabs);
	$ret .= "      $tabs}\n";
	return $ret;
}
//********************************************************************************
function __fjs_item_json_from_itemstypes(  $i_type, $row, $tabs  ){
	$ret = "";
	$query = "  select * from itemstypes where id=$i_type  ";
	$resp = mysql_query($query);
	$arow = mysql_fetch_assoc($resp);
	$vmass = explode(  "\n", $arow["pairs"]  );
	//print_r($row);
	foreach($vmass as $key=>$val){
		$mass = explode("===", $val);
		$mass[1] = trim($mass[1]);  $mass[0] = trim($mass[0]);
		if($mass[1]==""){
			if(  $mass[0] != "saveblock" && $mass[0] != "images" && $mass[0] != "usercomments" && $mass[0] != "parent"  ){
				if (  $mass[0] == "artikul"   )
					$ret  .= "      $tabs\"item_code\": \"".$row["item_code"]."\",\n      $tabs\"item_art\": \"".$row["item_art"]."\",\n      $tabs\"item_psevdoart\": \"".$row["item_psevdoart"]."\",\n";
				elseif (  $mass[0] == "coder"   ){
					$asd = $row["coder"];
					$asd = preg_replace(  "/\n/", "~~~~~n~~~~~", $asd  );
					$ret  .= "      $tabs\"coder\": \"".preg_replace( '/"/','\\"', $asd )."\",\n";
					
				}
				elseif (  $mass[0] == "pricedigit"   )
					$ret  .= "      $tabs\"pricedigit\": \"".$row["pricedigit"]."\",\n";
				elseif (  $mass[0] == "grabber"   )
					$ret  .= "      $tabs\"grabber\": \"".$row["grabber"]."\",\n";
				elseif(  $mass[0] == "textarea"   ){
					$row["cont"] = preg_replace("/\"/", '\\"', $row["cont"]);
					$ret  .= "      $tabs\"cont\": \"".preg_replace(  "/\n/", "~~~~~n~~~~~", $row["cont"]  )."\",\n";
				}
			}
		} else {
			$ret  .= "      $tabs\"$mass[1]\": \"".$row[$mass[1]]."\",\n";
		}
	}
	$ret .= "      $tabs\"images\": {\n";
	$ret .= __fjs_get_images_json($row["id"], $tabs);
	$ret .= "      $tabs},\n";
	//$prega = "/,\n$/";
	//$ret = preg_replace($prega, "\n", $ret);
	return $ret;
}
//********************************************************************************
function __fjs_tree_to_json($parent, $tabs){
	if(!$parent) $parent = "0";
	$count = "0";
	$ret = "$tabs{\n";
	//****************FOLDERS*************
	$resp = mysql_query("select * from items where parent=$parent && folder=1  order by prior asc " );
	while($row = mysql_fetch_assoc($resp)){
		$ret .= "   $tabs\"$count\": {\n";
		$ret .= "      $tabs\"name\": \"$row[name]\",\n";
		$ret .= "      $tabs\"itemadddate\": \"$row[itemadddate]\",\n";
		$ret .= "      $tabs\"itemeditdate\": \"$row[itemeditdate]\",\n";
		$ret .= "      $tabs\"folder\": \"$row[folder]\",\n";
		$ret .= "      $tabs\"href_name\": \"$row[href_name]\",\n";
		$ret .= "      $tabs\"prior\": \"$row[prior]\",\n";
		$ret .= "      $tabs\"cont\": \"".preg_replace(  "/\n/", "~~~~~n~~~~~", $row["cont"]  )."\",\n";
		$ret .= "      $tabs\"itemtype\": \"$row[itemtype]\",\n";
		$ret .= "      $tabs\"fassoc\": \"$row[fassoc]\",\n";
		$ret .= "      $tabs\"page_show\": \"$row[page_show]\",\n";
		$ret .= "      $tabs\"mtm\": \"$row[mtm]\",\n";
		
		$ret .= "      $tabs\"images\": {\n";
		$ret .= __fjs_get_images_json($row["id"], $tabs);
		$ret .= "      $tabs },\n";
		
		$ret .= "      $tabs\"foldercont\": ";
		$ret .= __fjs_tree_to_json($row["id"], "      $tabs");
		
		$count++;
		$ret .= "
		$tabs}";
		if($count != mysql_num_rows($resp)) $ret .= ",\n";
		//$ret .= "\n";
	}
	//****************ITEMS ПОДГОТОВКА*************
	$ocount = 0;
	$resp = mysql_query("select * from items where parent=$parent && folder=0  order by prior asc " );
	if(  mysql_num_rows($resp) > 0 && $count>0  ) $ret .= ",";
	$ret .= "\n";
	//****************ITEMS*************
	while($row = mysql_fetch_assoc($resp)){
		$ret .= "   $tabs\"$count\": {\n";
		$ret .= "      $tabs\"folder\": \"$row[folder]\",\n";
		$ret .= "      $tabs\"itemadddate\": \"$row[itemadddate]\",\n";
		$ret .= "      $tabs\"itemeditdate\": \"$row[itemeditdate]\",\n";
		$ret .= "      $tabs\"mtm\": \"$row[mtm]\",\n";
		$ret .= "      $tabs\"mtm_cont\": \"".preg_replace(  "/\n/", "~~~~~n~~~~~", $row["mtm_cont"]  )."\",\n";
		$ret .= "      $tabs\"recc\": \"$row[recc]\",\n";
		$ret .= "      $tabs\"tmp\": \"$row[tmp]\",\n";
		
		$i_type = get_item_type($row["id"]);
		if(  $i_type  ){
			$ret .= __fjs_item_json_from_itemstypes($i_type, $row, $tabs);
		} else {
			$ret .= __fjs_default_item_json($row, $tabs);
		}
		
		$ret = preg_replace("/,\n$/", "\n", $ret);
		//$ret .= __fjs_default_item_json($row, $tabs);
		
		//$ret .= "      $tabs\"name\": \"".iconv(  "CP1251", "UTF-8", $row["name"]  )."\",\n";
		//$ret .= "      $tabs\"folder\": \"$row[folder]\",\n";
		//$ret .= "      $tabs\"href_name\": \"$row[href_name]\",\n";
		//$ret .= "      $tabs\"prior\": \"$row[prior]\",\n";
		//$ret .= "      $tabs\"cont\": \"item content\",\n";
		//$ret .= "      $tabs\"itemtype\": \"$row[itemtype]\",\n";
		//$ret .= "      $tabs\"fassoc\": \"$row[fassoc]\",\n";
		//$ret .= "      $tabs\"page_show\": \"$row[page_show]\"\n";
		
		
		$ret .= "   $tabs}";
		$count++;
		$ocount++;
		if($ocount != mysql_num_rows($resp)) $ret .= ",";
		$ret .= "\n";
	}
	//**********************************
	$ret .= "$tabs}\n";
	return $ret;
}
//********************************************************************************
function __fjs_tree_to_assoc_array_from_itemstypes(  $i_type, $row  ){
	$masso = array();
	$query = "  select * from itemstypes where id=$i_type  ";
	$resp = mysql_query($query);
	$arow = mysql_fetch_assoc($resp);
	$vmass = explode(  "\n", $arow["pairs"]  );
	//print_r($row);
	foreach($vmass as $key=>$val){
		$mass = explode("===", $val);
		$mass[1] = trim($mass[1]);  $mass[0] = trim($mass[0]);
		if($mass[1]==""){
			if(  $mass[0] != "saveblock" && $mass[0] != "images" && $mass[0] != "usercomments" && $mass[0] != "parent"  ){
				if (  $mass[0] == "artikul"   ){
					$masso["item_code"] = $row["item_code"];
					$masso["item_art"] = $row["item_art"];
					$masso["item_psevdoart"] = $row["item_psevdoart"];
				} elseif (  $mass[0] == "coder"   )
					$masso["coder"] = $row["coder"];
				elseif (  $mass[0] == "pricedigit"   )
					$masso["pricedigit"] = $row["pricedigit"];
				elseif (  $mass[0] == "grabber"   )
					$masso["grabber"] = $row["grabber"];
				elseif(  $mass[0] == "textarea"   ){
					$row["cont"] = preg_replace("/\"/", '\\"', $row["cont"]);
					$masso["cont"] = preg_replace(  "/\n/", "~~~~~n~~~~~", $row["cont"]  );
				}
			}
		} else {
			$masso["$mass[1]"] = $row[$mass[1]];
		}
	}
	return $masso;
}
//********************************************************************************
function __fjs_tree_to_assoc_array(  $id, $table  ){
	$rmass = array();
	$i_type = get_item_type(  $id  );
	$query = "  select * from $table where parent=$id  ";
	$count = 0;
	$resp = mysql_query(  $query  );
	while(  $row = mysql_fetch_assoc(  $resp  )  ){
		$mass["folder"] = $row["folder"];
		$mass["itemadddate"] = $row["itemadddate"];
		$mass["itemeditdate"] = $row["itemeditdate"];
		$mass["mtm"] = $row["mtm"];
		$mass["mtm_cont"] = preg_replace(  "/\n/", "~~~~~n~~~~~", $row["mtm_cont"]  );
		$mass["recc"] = $row["recc"];
		$mass["tmp"] = $row["tmp"];
		$dmass = __fjs_tree_to_assoc_array_from_itemstypes(  $i_type, $row  );
		if(  count(  $dmass  ) > 0  )  $rmass[$count]= array_merge (  $mass, $dmass  );
		else $rmass[$count] = $mass;
		//echo "c dmass = ".count(  $dmass  )."<br/>";
		$dmass = __fjs_tree_to_assoc_array(  $row["id"], $table  );
		if(  count(  $dmass  ) > 0  )  $rmass[$count]["foldercont"] = $dmass;
		$count++;
	}
	return $rmass;
	//echo "<pre>"; print_r($rmass); echo "</pre>";
}
//********************************************************************************
function __fjs_tree_to_assoc_array_from_keys_from_row(  $keys, $row  ){
	$masso = array();
	//print_r($keys);
	foreach(  $keys as $key => $val  ){
		$masso[$val] = $row[$val];
	}
	return $masso;
}
//********************************************************************************
function __fjs_tree_to_assoc_array_from_keys(  $id, $table, $keys  ){
	$rmass = array();
	$i_type = get_item_type(  $id  );
	global $dop_query;
	$query = "  select * from $table where parent=$id $dop_query  order by folder asc, prior asc  ";
	$count = 0;
	$resp = mysql_query(  $query  );
	while(  $row = mysql_fetch_assoc(  $resp  )  ){
		$rmass[$count] = __fjs_tree_to_assoc_array_from_keys_from_row(  $keys, $row  );
		$dmass = __fjs_tree_to_assoc_array_from_keys(  $row["id"], $table, $keys  );
		if(  count(  $dmass  ) > 0  )  $rmass[$count]["foldercont"] = $dmass;
		$count++;
	}
	return $rmass;
	//echo "<pre>"; print_r($rmass); echo "</pre>";
}
//********************************************************************************

//******************************************************************************** 
?>