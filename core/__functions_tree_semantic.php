<?
//*****************************************************
function __fts_get_assoc_item($id, $select){
	$ret = "";
	$query = "select * from items where parent=$id && folder=0 && tmp!=1 && recc!=1 order by prior asc";
	$resp = mysql_query($query);
	while($row=mysql_fetch_assoc($resp)){
		$ret .= "<option value=\"$row[id]\"  ";
		if($row["id"]==$select)  $ret .= " selected ";
		$ret .= ">$row[name]</option>";
	}
	return $ret;
}
//*****************************************************
function get_item_content($id){
	$query = "select * from items where id=$id";
	$resp = mysql_query($query);
	$row = mysql_fetch_assoc($resp);
	$ret  = "<div id=\"div_item_content_but\">";
	$ret .= "<a href=\"javascript:edit_text_block($row[id])\"><img src=\"images/green/edit_txtblock.gif\" width=\"250\" height=\"18\" border=\"0\"></a>";
	$ret .= "<hr size=\"1\"></div><div id=\"div_item_content\" style=\"height:300px; overflow: auto; display:none;\">$row[cont]</div>";
	$ret .= "<textarea name=\"item_cont\" cols=\"65\" rows=\"7\" id=\"item_cont\" style=\"display:none;\">$row[cont]</textarea>";
	return $ret;
}
//*****************************************************
function show_images_for_items_sort($id, $siteimg=false){
	$ret = "";
	if($siteimg)
		$respi = mysql_query("select * from images where name='site-img' order by prior asc");
	else
		$respi = mysql_query("select * from images where parent=$id order by prior asc");
	while($rowi = mysql_fetch_assoc($respi)){
		$ret .= "<li class=\"ui-state-default\" id=\"li_images_sort_$rowi[id]\">
		<img src=\"../imgres.php?resize=60&link=loadimages/$rowi[link]\" width=\"60\" height=\"45\" border=\"0\"></li>";
	}
	$ret .= "<li class=\"save-sort-images\" onclick=\"save_sort()\" id=\"li_images_sort_ok\"></li>";
	return $ret;
}
//*****************************************************
function show_images_for_items($id, $siteimg=false){
	$ret = "<ul id=\"images_items\">";
	if($siteimg)
		$respi = mysql_query("select * from images where name='site-img' order by prior asc");
	else
		$respi = mysql_query("select * from images where parent=$id order by prior asc");
	while($rowi = mysql_fetch_assoc($respi)){
		//print_r($rowi);
		$ret .= "<li class=\"ui-state-default\"  ";
		if($rowi["useintext"]==0)
			$ret .= "  style=\"background-image: url(images/green/icons/pic_in_gal.gif);background-repeat: no-repeat; background-position: left top;\" ";
		if($rowi["useintext"]==1)
			$ret .= "  style=\"background-image: url(images/green/icons/pic_in_text.gif);background-repeat: no-repeat; background-position: left top;\" ";
		$ret .= ">
		<img src=\"../imgres.php?resize=60&link=loadimages/$rowi[link]\" width=\"60\" height=\"45\" border=\"0\" 
		alt=\"$rowi[link]\" id=\"simg_$rowi[id]\" class=\"simgclass\"></li>";
	}
	$ret .= "<li class=\"ui-state-default\" style=\"padding-top:0px; height:80px;\" id=\"li_load_images\" ><div  id=\"file-uploader\"><noscript><p>Please enable JavaScript to use file uploader.</p></noscript></div>
	</li></ul>";
	return $ret;
}
//*****************************************************
function show_files_fmanager(){
	$ret = "<ul id=\"files_items\">";
	$respi = mysql_query("select * from filemanager order by link asc");
	while($rowi = mysql_fetch_assoc($respi)){
		$ret .= "<li class=\"ui-state-default\" style=\"width:200px; height: 100px;\" id=\"$rowi[link]\" >
		<img src=\"images/green/icons/file.jpg\" width=\"60\" height=\"45\" border=\"0\" 
		alt=\"$rowi[link]\" id=\"sfiles_$rowi[id]\" class=\"simgclass\"><br/>$rowi[link]</li>";
	}
	$ret .= "<li class=\"ui-state-default\" style=\"padding-top:0px; height:80px;\" id=\"li_load_images\" ><div  id=\"file-uploader\"><noscript><p>Please enable JavaScript to use file uploader.</p></noscript></div>
	</li></ul>";
	return $ret;
}
//*****************************************************
function create_folderinfo_item($id, $db_table=0){
	$rv = "";
	$query="select * from ".__tree_get_tree_name_from_index($db_table)." where id=$id";
	$resp = mysql_query($query);
	$row=mysql_fetch_assoc($resp);
	$rv .= "<table width=\"502\" border=\"0\" cellpadding=\"2\" cellspacing=\"0\" bgcolor=\"#CCCCCC\"
		style=\"border-top-width: 1px; border-top-style: solid; border-top-color: #009933;
		border-left-width: 1px; border-left-style: solid; border-left-color: #009933;
		border-right-width: 1px; border-right-style: solid; border-right-color: #009933;\">
		<tr bgcolor=\"#C9DDC8\">
		<td width=\"20\" align=\"center\"><input type=\"checkbox\" id=\"items_cb_$row[id]\"></td>
		<td width=\"43\" height=\"33\"><div align=\"center\">
		<img src=\"../imgres.php?resize=40&link=models_images/HK_01770-20-S-002.jpg\" width=\"40\" height=\"30\" class=\"imggal\">
		</div></td>
		<td width=\"250\"><div align=\"left\">$row[name]</div></td>
		<td width=\"40\"><div align=\"center\"><strong>$row[prior]</strong></div></td>
		<td>
		<a href=\"javascript:getiteminfo($row[id])\"><img src=\"images/green/__top_edit.gif\" width=\"23\" height=\"23\" border=\"0\"></a>
		<a href=\"javascript:delete_item($row[id])\"><img src=\"images/green/__top_delete.gif\" width=\"23\" height=\"23\" border=\"0\"></a>
		</td>
		</tr></table><div id=\"item_$row[id]\" class=\"itembox\">asdqwe qweqsad<br/>asdasdasd aasd<br>asdasdasd aasd<br>asd</div>";
	return $rv;
}
//*****************************************************
function __fts_is_item_goo(  $row, $table  ){
	global $goo_folders;
	foreach(  $goo_folders as $key=>$val  ){
		if(  $val == $row["href_name"]  ) return true;
	}
	if(  $row["parent"] != "0"  ){
		$resp = mysql_query(  "select * from $table where id=$row[parent]"  );
		$srow = mysql_fetch_assoc(  $resp  );
		return __fts_is_item_goo(  $srow, $table  );
	}
	return false;
}
//*****************************************************
function __fts_is_item_admin(  $row, $table  ){
	global $admin_folders;
	foreach(  $admin_folders as $key=>$val  ){
		if(  $val == $row["href_name"]  ) return true;
	}
	if(  $row["parent"] != "0"  ){
		$resp = mysql_query(  "select * from $table where id=$row[parent]"  );
		$srow = mysql_fetch_assoc(  $resp  );
		return __fts_is_item_admin(  $srow, $table  );
	}
	return false;
}
//*****************************************************
function __fts_is_item_useradmin(  $row, $table  ){
	global $useradmin_folders;
	foreach(  $useradmin_folders as $key=>$val  ){
		if(  $val == $row["href_name"]  ) return true;
	}
	if(  $row["parent"] != "0"  ){
		$resp = mysql_query(  "select * from $table where id=$row[parent]"  );
		$srow = mysql_fetch_assoc(  $resp  );
		return __fts_is_item_useradmin(  $srow, $table  );
	}
	return false;
}
//*****************************************************
function __fts_is_item_order(  $row, $table  ){
	global $orders_folders;
	foreach(  $orders_folders as $key=>$val  ){
		if(  $val == $row["href_name"]  ) return true;
	}
	if(  $row["parent"] != "0"  ){
		$resp = mysql_query(  "select * from $table where id=$row[parent]"  );
		$srow = mysql_fetch_assoc(  $resp  );
		return __fts_is_item_order(  $srow, $table  );
	}
	return false;
}
//*****************************************************
function __farmmed_rekursiya_show_semantik_tree($db_table, $all_parent, $edit_mass, $edit, $count, $most_show=false){
	$ret_val="";
	$query="select * from ".__tree_get_tree_name_from_index($db_table)." where parent=$all_parent and folder=1 && tmp!=1 && recc!=1 ORDER BY prior, name ASC";
	//echo $query."<br/>\n";
	$resp=mysql_query($query);
	if($all_parent==0) $ret_val.= "<ul class=\"top_ul\">"; else $ret_val.= "<ul>";
	while($row=mysql_fetch_assoc($resp)){
			
			if(__marabu_tree_test_for_child($row["id"], $db_table)) {
				$ret_val .= "<li id=\"li_item_$row[id]\">";
			} else {  $ret_val .= "<li>"; }
			if(__marabu_tree_test_for_child($row["id"], $db_table)) {
					if($row["id"] == $most_show[0]){
					$ret_val.= "<a href=\"javascript:show_li_item($db_table, $row[id])\">
					<img src=\"tree/minus.jpg\" align=\"absmiddle\"></a>";
				}
				else{
					$ret_val.= "<a href=\"javascript:show_li_item($db_table, $row[id])\">
					<img src=\"tree/plus.jpg\" align=\"absmiddle\"></a>";
				}
			}
			else {
				//if($all_parent!=0) {
					if($edit==$row["id"])
						$ret_val.= "<img src=\"tree/4x4_red.gif\" align=\"absmiddle\">";
					else
						$ret_val.= "<img src=\"tree/4x4_blue.gif\" align=\"absmiddle\">";
				//}
			}
			if(  __fts_is_item_admin(  $row, "items"  )  ){
				$ret_val.= "<a class=\"novisible_admin\" href=\"javascript:show_ritems($row[id])\">$row[name]</a>";
			} elseif (  __fts_is_item_useradmin(  $row, "items"  )  ){
				$ret_val.= "<a class=\"novisible_useradmin\" href=\"javascript:show_ritems($row[id])\">$row[name]</a>";
			} elseif (  __fts_is_item_order(  $row, "items"  )  ){
				$ret_val.= "<a class=\"novisible_orders\" href=\"javascript:show_ritems($row[id])\">$row[name]</a>";
			} elseif (  __fts_is_item_goo(  $row, "items"  )  ){
				$ret_val.= "<a class=\"novisible_goo\" href=\"javascript:show_ritems($row[id])\">$row[name]</a>";
			}else {
				if($row["page_show"]==1){
					$ret_val.= "<a href=\"javascript:show_ritems($row[id])\">$row[name]</a>";
				} else {
					$ret_val.= "<a class=\"novisible\" href=\"javascript:show_ritems($row[id])\">$row[name]</a>";
				}
			}
			//***********************************
				if(__marabu_tree_test_for_child($row["id"], $db_table)){
					if($row["id"] == $most_show[0]){
						//$ret_val.= "<ul>";
						$new_most_show = false;
						for($i=1; $i<count($most_show); $i++)
							$new_most_show[] = $most_show[$i];
						$ret_val.= __farmmed_rekursiya_show_semantik_tree($db_table, $row["id"], $edit_mass, $edit, $count+1, $new_most_show);
						//$ret_val .= "</ul>";
					}
					
				}
			//***********************************
			$ret_val.="</li>\n"; 
	}
	$ret_val.= "</ul>\n";
	return $ret_val;
}
//*******************************************
//*****************************************************
function __farmmed_rekursiya_show_semantik_tree_start($db_table, $all_parent, $edit_mass, $edit, $count, $most_show=false){
	$ret_val="";
	$query="select * from ".__tree_get_tree_name_from_index($db_table)." where parent=$all_parent and folder=1 ORDER BY prior, name ASC";
	for($i=0; $i<$count; $i++) $tabs.= " ";
	$resp=mysql_query($query);
	$ret_val.= "$tabs<ul>\n";
	while($row=mysql_fetch_assoc($resp)){
			
			$ret_val .= "$tabs<li>"; 
			$ret_val.= "<a href=\"?parent=$row[id]\">$row[name]</a>";
			$ret_val.="</li>\n"; 
			//***********************************
				if(__marabu_tree_test_for_child($row["id"], $db_table)){
					if($row["id"] == $most_show[0]){
						//$ret_val.= "<ul>";
						$new_most_show = false;
						for($i=1; $i<count($most_show); $i++)
							$new_most_show[] = $most_show[$i];
						$ret_val.= __farmmed_rekursiya_show_semantik_tree_start($db_table, $row["id"], $edit_mass, $edit, $count+1, $new_most_show);
						//$ret_val .= "</ul>";
					}
					
				}
			//***********************************
	}
	$ret_val.= "$tabs</ul>\n";
	return $ret_val;
}
//*****************************************************
function __farmmed_rekursiya_show_semantik_tree_json($db_table, $all_parent, $edit_mass, $edit, $count, $most_show=false){
	$ret_val="";
	$query="select * from ".__tree_get_tree_name_from_index($db_table)." where parent=$all_parent and folder=1 ORDER BY prior, name ASC";
	$resp=mysql_query($query);
	$tabs = "";
	for($i=0; $i<$count; $i++) $tabs.= "	";
	$ret_val.= "$tabs{\n";
	$r_count = 0;
	while($row=mysql_fetch_assoc($resp)){
			$ret_val .= "$tabs	\"$r_count\": {\n";
			if(__marabu_tree_test_for_child($row["id"], $db_table)) {
				$ret_val .= "$tabs		\"id\": \"$row[id]\",\n";
			} 
			if(__marabu_tree_test_for_child($row["id"], $db_table)) {
				if($row["id"] == $most_show[0]){
					$ret_val.= "$tabs		\"img\": \"minus.jpg\",\n";
				} else {
					$ret_val.= "	$tabs	\"img\": \"plus.jpg\",\n";
				}
			}
			else {
				//if($all_parent!=0) {
					if($edit==$row["id"])
						$ret_val.= "	$tabs	\"img\": \"4x4_red.gif\",\n";
					else
						$ret_val.= "	$tabs	\"img\": \"4x4_blue.gif\",\n";
				//}
			}
			$ret_val.= "$tabs		\"link\": \"".__fp_create_folder_way(__tree_get_tree_name_from_index($db_table), $row["id"], 1)."\",\n";
			if($edit){
				//print_r($most_show); echo $row["id"];
				if(__marabu_tree_test_for_child($row["id"], $db_table) && $row["id"] == $most_show[0])
					$ret_val.= "	$tabs	\"name\": \"$row[name]\",\n";
				else
					$ret_val.= "	$tabs	\"name\": \"$row[name]\"\n";
			} else  {
				$ret_val.= "	$tabs	\"name\": \"$row[name]\"\n";
			}
			//***********************************
				if(__marabu_tree_test_for_child($row["id"], $db_table)){
					
					if($row["id"] == $most_show[0]){
						$ret_val.= "$tabs		\"child\": \n";
						$new_most_show = false;
						for($i=1; $i<count($most_show); $i++)
							$new_most_show[] = $most_show[$i];
						$ret_val.= __farmmed_rekursiya_show_semantik_tree_json($db_table, $row["id"], 
						$edit_mass, $edit, $count+1, $new_most_show);
						//if($r_count != mysql_num_rows($resp)-1) $ret_val.= ",";
						//$ret_val.= "	$tabs	}\n";
					}
					
				}
			//***********************************
		$ret_val .= "$tabs	}"; if($r_count != mysql_num_rows($resp)-1) $ret_val.= ",";
		$ret_val .= "\n";
		$r_count++;
	}
	$ret_val.= "$tabs}\n";
	return $ret_val;
}
//*******************************************
//*******************************************
function __fmt_rekursiya_show_items_for_select($db_table, $all_parent, $edit_mass, $edit, $count, $most_sel=0){
	//echo "<script>alert('$all_parent')";<script>";
	$ret_val="";
	$query = "select * from ".__tree_get_tree_name_from_index($db_table)." where parent=$all_parent and folder=1 and tmp!=1 order by prior asc, name asc";
	//echo $query;
	$resp=mysql_query($query);
	while($row=mysql_fetch_assoc($resp)){
		if($edit_mass["id"]!=$row["id"]){
			$ret_val.= "<option value=\"$row[id]\"  ";
			if($most_sel!=0){
				if($row["id"]==$most_sel) $ret_val.= "selected";
			}
			else{
				if($row["id"]==$edit_mass["parent"] && $edit) $ret_val.= "selected";
				/*echo "<script>alert(\"$edit_mass[parent]\");</script>";*/
			}
			$ret_val.= "  >";
			if($all_parent!=0) for($i=0; $i<$count; $i++) $ret_val.= " > ";
			$ret_val.= "$row[name]</option>\n";
			if($most_sel!=0)
				$ret_val.= __fmt_rekursiya_show_items_for_select($db_table, $row["id"], $edit_mass, $edit, $count+1, $most_sel);
			else
				$ret_val.= __fmt_rekursiya_show_items_for_select($db_table, $row["id"], $edit_mass, $edit, $count+1);
		}
	}
	return $ret_val;
}
//*******************************************
function __fmt_find_item_parent_name($child, $mass=false){
	if($child==0) return false;
	$resp = mysql_query("select * from items where id=$child and folder=1");
	if(mysql_num_rows($resp)<1) return false;
	$row = mysql_fetch_assoc($resp);
	if(!$mass) $mass = array($row["name"]);
	else $mass[] = $row["name"];
	//echo "<br/>mass:<br/>"; print_r($mass);
	if($row["parent"]=="0") return $mass;
	$resp = mysql_query("select * from items where id=$row[parent] and folder=1");
	$row = mysql_fetch_assoc($resp);
	if($row["parent"]==0) {
		$mass[] = $row["name"];
		return $mass;
	}
	else{
		return __fmt_find_item_parent_name($row["id"], $mass);
	}
}
//*******************************************
function __fmt_find_item_parent_id($db_table, $child, $mass=false){
	if($child==0) return false;
	$resp = mysql_query("select * from ".__tree_get_tree_name_from_index($db_table)." where id=$child and folder=1");
	$row = mysql_fetch_assoc($resp);
	if(!$mass) $mass = array($row["id"]);
	else $mass[] = $row["id"];
	//echo "<br/>mass:<br/>"; print_r($mass);
	if($row["parent"]=="0") return $mass;
	$resp = mysql_query("select * from ".__tree_get_tree_name_from_index($db_table)." where id=$row[parent] and folder=1");
	$row = mysql_fetch_assoc($resp);
	if($row["parent"]==0) {
		$mass[] = $row["id"];
		return $mass;
	}
	else{
		return __fmt_find_item_parent_id($db_table, $row["id"], $mass);
	}
}
//*******************************************
function __marabu_tree_test_for_child($id, $db_table){
	$resp = mysql_query("select * from ".__tree_get_tree_name_from_index($db_table)." where parent=$id && folder=1 && recc!=1 && tmp!=1   ");
	if(mysql_num_rows($resp)>0)
		return mysql_num_rows($resp); 	else return false;
}
//*******************************************
function __farmmed_rekursiya_show_items_for_js($all_parent, $edit_mass, $edit, $count){
	$ret_val="";
	if($all_parent!=0) for($i=0; $i<$count; $i++) $ret_val.= "  ";
	$ret_val.= "tree_array_$all_parent = new Array();\n";
	$a_count=0;
	$resp=mysql_query("select * from items where parent=$all_parent and folder=1 && recc!=1 && tmp!=1 order by prior asc, name asc");
	while($row=mysql_fetch_assoc($resp)){
		if($all_parent!=0) for($i=0; $i<$count; $i++) $ret_val.= "  ";
		$ret_val.= "tree_array_".$all_parent."[$a_count] = $row[id];\n";
		$ret_val.= __farmmed_rekursiya_show_items_for_js($row["id"], $edit_mass, $edit, $count+1)."";
		$a_count++;
	}
	return $ret_val;
}
//*****************************************************
function __farmmed_rekursiya_show_items($all_parent, $edit_mass, $edit, $count, $user=false){
	//echo "<script>alert('$all_parent')";<script>";
	$ret_val="";
	$resp=mysql_query("select * from items where parent=$all_parent and folder=1 order by prior asc, name asc");
	while($row=mysql_fetch_assoc($resp)){
		//if($edit_mass["id"]!=$row["id"]){
			$ret_val.= "<div class=\"tree-item\"";
			if($all_parent!=0) $ret_val.=" style=\"display:none;\" ";
			$ret_val.=" id=\"tree_item_$row[id]\">";
			if($all_parent!=0) for($i=0; $i<$count; $i++) $ret_val.= "<div class=\"tree-spacer\"></div>\n";
			if(__marabu_tree_test_for_child($row["id"], $db_table)) {
				$ret_val.= "<div class=\"tree-plus\" id=\"tree_plus_$row[id]\"><a href=\"javascript:show_tree_item($row[id], 0)\"><img src=\"tree/plus.jpg\" class=\"tree-img\"></a></div>\n";
				$ret_val.= "<div class=\"tree-minus\" style=\"display:none\"  id=\"tree_minus_$row[id]\"><a href=\"javascript:hide_tree_item($row[id], 0)\"><img src=\"tree/minus.jpg\" class=\"tree-img\"></a></div>\n";
			}
			else $ret_val.= "<div class=\"tree-spacer\"></div>\n";
			if($row["id"]==$edit_mass["id"] && $edit){ 
				$ret_val.= "<div class=\"tree-open-folder\"></div>\n";
			}else{
				if(!$user){
					if(__fmt_test_for_items($row["id"]))
						$ret_val.= "<div class=\"tree-folder-plus\"></div>\n";
					else
						$ret_val.= "<div class=\"tree-folder\"></div>\n";
				}
			}
			if(!$user){
				$ret_val.= "<div class=\"tree-content\"><a href=\"?parent=$row[id]\">$row[name]</a></div>\n"; 
				$ret_val.= "<div class=\"tree-new\">
								<a title=\"Добавить группу группу\" href=\"?new_folder=1&parent=$row[id]\">
								<img class=\"tree-image\" src=\"tree/new_item.gif\" border=\"1\"  /></a>
								</div>\n";
				$ret_val.= "<div class=\"tree-edit\">
								<a title=\"Редактировать группу\" href=\"?edit_folder=$row[id]&parent=$row[id]\">
								<img class=\"tree-image\" src=\"tree/edit_item.gif\" border=\"1\"  /></a>
								</div>\n";
				$ret_val.= "<div class=\"tree-delete\">
								<a title=\"Удалить группу\" href=\"?delete=$row[id]&parent=$row[parent]\">
								<img class=\"tree-image\" src=\"tree/delete_item.gif\" border=\"1\"  /></a>
								</div>\n"; 
			}
			else{
				$ret_val.= "<div class=\"tree-content\"><a href=\"?parent=$row[id]\">$row[name]</a></div>\n"; 
			}
			//$ret_val.= __farmmed_rekursiya_show_items($row["id"], $edit_mass, $edit, $count+1, $user);
			$ret_val.= "</div>\n";
		//}	
	}
	return $ret_val;
}
//*****************************************************
function __farmmed_rekursiya_show_items_user($db_table, $all_parent, $edit_mass, $edit, $count, $most_show=false){
	$ret_val="";
	$query="select * from ".__tree_get_tree_name_from_index($db_table)." where parent=$all_parent and folder=1 ORDER BY prior, name ASC";
	//echo $query;
	$resp=mysql_query($query);
	//echo "select * from items where parent=$all_parent and folder=1 order by name asc";
	//while($row=mysql_fetch_assoc($resp))
		//$test[]=$row;
	//echo "<pre>";
	//print_r($test);
	//echo "</pre>";
	while($row=mysql_fetch_assoc($resp)){
			$ret_val.= "<div id=\"tree_item_$row[id]\">";
			$ret_val.="<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr>";
			if(__marabu_tree_test_for_child($row["id"], $db_table)) {
					if($all_parent!=0) for($i=0; $i<$count; $i++) $ret_val.= "<td width=\"13\">&nbsp;</td>\n";
					if($row["id"] == $most_show[0]){
					$ret_val.= "<td width=\"13\" id=\"tree_plus_".$db_table."_$row[id]\">
									<a href=\"javascript:hide_tree_item($db_table, $row[id], $count)\">
									<img src=\"tree/minus.jpg\" class=\"tree-img\"></a></td>\n";
				}
				else{
					$ret_val.= "<td width=\"13\"  id=\"tree_plus_".$db_table."_$row[id]\">
									<a href=\"javascript:show_tree_item($db_table, $row[id], $count)\">
									<img src=\"tree/plus.jpg\" class=\"tree-img\"></a></td>\n";
				}
			}
			else {
				if($all_parent!=0) for($i=0; $i<$count-1; $i++) $ret_val.= "<td width=\"13\">&nbsp;</td>\n";
				if($all_parent!=0) {
					$ret_val.= "<td width=\"13\">
									<img width=\"12\" src=\"tree/spacer.gif\" class=\"tree-img\"></td>\n
									<td width=\"13\">";
					if($edit==$row["id"])
						$ret_val.= "<img src=\"tree/for_x_for_active.gif\" class=\"tree-img\">";
					else
						$ret_val.= "<img src=\"tree/for_x_for.gif\" class=\"tree-img\">";
					$ret_val.= "</td>\n";
				}
				else {
					$ret_val.= "<td width=\"13\">
									<img width=\"12\" src=\"tree/spacer.gif\" class=\"tree-img\"></td>\n";
				}
			}
			$ret_val.= "<td height=\"20\" class=\"td_treecontent\" 
							onMouseOver=\"this.bgColor='#D0EACC'\" onMouseOut=\"this.bgColor=''\">
							<a href=\"items.php?parent=$row[id]\">$row[name]</a>";
			//$ret_val.= "<div class=\"tree-content\"><a href=\"?parent=$row[id]\">$row[name]</a></div>\n"; 
				
			$ret_val.="</td></tr></table>\n"; 

			//***********************************
				if(__marabu_tree_test_for_child($row["id"], $db_table)){
					
					if($row["id"] == $most_show[0]){
						$ret_val .= "<div id=\"is_open_".$db_table."_$row[id]\" style=\"display:block;\">";
						$new_most_show = false;
						for($i=1; $i<count($most_show); $i++)
							$new_most_show[] = $most_show[$i];
						$ret_val.= __farmmed_rekursiya_show_items_user($db_table, $row["id"], $edit_mass, $edit, $count+1, $new_most_show);
					}
					else{
						$ret_val .= "<div id=\"is_open_".$db_table."_$row[id]\" style=\"display:none;\">";
						$ret_val .= "<img width=\"16\" height=\"16\" src=\"tree/clock.gif\" align=\"absmiddle\">Загрузка...";
					}
					$ret_val .= "</div>";
				}
			//***********************************
			$ret_val.= "</div>\n";
	}
	return $ret_val;
}
//*******************************************
//*****************************************************
function __farmmed_rekursiya_show_items_v2($db_table, $all_parent, $edit_mass, $edit, $count, $most_show=false){
	$ret_val="";
	if($all_parent==0){
		//$ret_val.= "<div class=\"tree-spacer\"></div>\n";
		$ret_val.= "<div id=\"tree_folder_0_0\" class=\"tree-root-folder\" onMouseOver=\"show_drag_folder(this);\"></div>\n";
		$ret_val.= "<div class=\"tree-content\"><a href=\"?parent=0\">Корневая группа</a></div>\n"; 
	}
	$query = "select * from ".__tree_get_tree_name_from_index($db_table)." where parent=$all_parent and folder=1 ORDER BY prior, name ASC";
	//echo $query;
	$resp=mysql_query($query);
	while($row=mysql_fetch_assoc($resp)){
		//if($edit_mass["id"]!=$row["id"]){
			$ret_val.= "<div class=\"tree-item\"";
			//if($all_parent!=0) $ret_val.=" style=\"display:none;\" ";
			$ret_val.=" id=\"tree_item_".$db_table."_$row[id]\">";
			if($all_parent!=0) for($i=0; $i<$count; $i++) $ret_val.= "<div class=\"tree-spacer\"></div>\n";
			if(__marabu_tree_test_for_child($row["id"], $db_table)){
				$s_plus=false;
				if($most_show){
					foreach($most_show as $key=>$val){
						if($val==$row["id"]){
							$s_plus = true;
							$ret_val.= "<div class=\"tree-minus\" id=\"tree_plus_".$db_table."_$row[id]\" onMouseOver=\"hide_drag_folder();\"><a href=\"javascript:hide_tree_item($db_table, $row[id], $count)\"><img src=\"tree/minus.jpg\" class=\"tree-img\"></a></div>\n";
							$ret_val.= "<div class=\"tree-plus\" style=\"display:none\"  id=\"tree_plus_".$db_table."_$row[id]\" onMouseOver=\"hide_drag_folder();\"><a href=\"javascript:show_tree_item($db_table, $row[id], $count)\"><img src=\"tree/plus.jpg\" class=\"tree-img\"></a></div>\n";
						}
					}
				}
				if(!$s_plus){
					$ret_val.= "<div class=\"tree-plus\" id=\"tree_plus_".$db_table."_$row[id]\" onMouseOver=\"hide_drag_folder();\"><a href=\"javascript:show_tree_item($db_table, $row[id], $count)\"><img src=\"tree/plus.jpg\" class=\"tree-img\"></a></div>\n";
					$ret_val.= "<div class=\"tree-minus\" style=\"display:none\"  id=\"tree_minus_".$db_table."_$row[id]\" onMouseOver=\"hide_drag_folder();\"><a href=\"javascript:hide_tree_item($db_table, $row[id], $count)\"><img src=\"tree/minus.jpg\" class=\"tree-img\"></a></div>\n";
					}
			}
			else $ret_val.= "<div class=\"tree-spacer\"></div>\n";
			
				if($edit==$row["id"] && $edit){ 
					$ret_val.= "<div id=\"tree_folder_".$db_table."_$row[id]\" class=\"tree-open-folder\" onMouseOver=\"show_drag_folder(this);\"></div>\n";
				}else{
					if(!$user){
						if(__fmt_test_for_items($db_table, $row["id"]))
							$ret_val.= "<div id=\"tree_folder_".$db_table."_$row[id]\"  class=\"tree-folder-plus\" onMouseOver=\"show_drag_folder(this);\"></div>\n";
						else
							$ret_val.= "<div id=\"tree_folder_".$db_table."_$row[id]\"  class=\"tree-folder\" onMouseOver=\"show_drag_folder(this);\"></div>\n";
					}
				}
			
			if(!$user){
				$ret_val.="<div onMouseOver=\"f_show_edit_folder($row[id]);hide_drag_folder()\" onMouseOut=\"f_hide_edit_folder($row[id])\">\n";
				$ret_val.= "<div class=\"tree-content\"><a href=\"?parent=$row[id]\">$row[name]</a></div>\n"; 
				$ret_val.= "<div id=\"show_edit_folder_$row[id]\" style=\"display: none;\">";
				$ret_val.= "<div class=\"tree-new\">
								<a title=\"Добавить группу группу\" href=\"?new_folder=1&parent=$row[id]\">
								<img class=\"tree-image\" src=\"tree/new_item.gif\" border=\"0\" alt=\"Новая подгруппа\" /></a>
								</div>\n";
				$ret_val.= "<div class=\"tree-edit\">
								<a title=\"Редактировать группу\" href=\"?edit_folder=$row[id]&parent=$row[id]\">
								<img class=\"tree-image\" src=\"tree/edit_item.gif\" border=\"0\" alt=\"Редактировать\" /></a>
								</div>\n";
				$ret_val.= "<div class=\"tree-delete\">
								<a title=\"Удалить группу\" href=\"?delete=$row[id]&parent=$row[parent]\">
								<img class=\"tree-image\" src=\"tree/delete_item.gif\" border=\"0\" alt=\"Удалить\" /></a>
								</div>\n";
				//$ret_val.= "<div class=\"tree-replace\">
				//				<a title=\"Переместить\" href=\"?delete=$row[id]&parent=$row[parent]\">
				//				<img class=\"tree-image\" src=\"tree/replace_item.jpg\" border=\"0\" alt=\"Переместить\" /></a>
				//				</div>\n";
				//$ret_val.= "<div class=\"tree-showitems\">
				//				<a title=\"Показать элементы\" href=\"javascript:tree_show_folder_items($db_table, $row[id], '$row[name]')\">
				//				<img class=\"tree-image\" src=\"tree/show_items.jpg\" border=\"0\" alt=\"Показать элементы\" /></a>
				//				</div>\n";
				$ret_val.= "</div>";
				$ret_val.="</div>" ;
			}
			else{
				$ret_val.= "<div class=\"tree-content\"><a href=\"?parent=$row[id]\">$row[name]</a></div>\n"; 
			}
			$ret_val.= "</div>\n";
		//}	
	
	$ret_val.="<div style=\"display:none;\" class=\"div_tree_item_frame\" id=\"tree_showitems_".$db_table."_$row[id]\"></div>";
	//***********************************/
				if(__marabu_tree_test_for_child($row["id"], $db_table)){
					
					if($row["id"] == $most_show[0]){
						$ret_val .= "<div id=\"is_open_".$db_table."_$row[id]\" style=\"display:block;\">";
						$new_most_show = false;
						for($i=1; $i<count($most_show); $i++)
							$new_most_show[] = $most_show[$i];
						$ret_val.= __farmmed_rekursiya_show_items_v2($db_table, $row["id"], $edit_mass, $edit, $count+1, $new_most_show);
					}
					else{
						$ret_val .= "<div id=\"is_open_".$db_table."_$row[id]\" style=\"display:none;\">";
						$ret_val .= "<img width=\"16\" height=\"16\" src=\"tree/clock.gif\" align=\"absmiddle\">Загрузка...";
					}
					$ret_val .= "</div>";
				}
			//***********************************
	}
	return $ret_val;
}
//*******************************************
function __fmt_test_for_items($db_table, $id){
	$resp = mysql_query("select * from ".__tree_get_tree_name_from_index($db_table)." where parent=$id and folder=0");
	if(mysql_num_rows($resp)>0)
		return true;
	return false;
}
//*******************************************
function __tree_get_tree_name_from_index($index){
	global $tree_array;
	return $tree_array[$index];
}
?>