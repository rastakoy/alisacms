<?
function __ft_search_first_data($table, $id, $field){
	$image = false;
	//Есть ли изображения в текущей группе
	$query = "select $field from $table where folder=0 && parent=$id && $field!='' limit 0,1";
	$resp = mysql_query($query); 
	if(mysql_num_rows($resp)<1){ // Если изображений нет
		$sresp = mysql_query("select id from $table where parent=$id && folder=1"); // Есть ли группы в текущей группе
		if(mysql_num_rows($sresp)>0){ // Если группы есть
			while($srow=mysql_fetch_assoc($sresp)) { // Прогнать группы по порядку
				return __ft_search_first_data($table, $srow["id"], $field);
			}
		} else {
			return false; //Если в текущей папке папок нет ни хуя :)   ,|, - это хуй
		}
	} else {
		$row = mysql_fetch_assoc($resp);
		return $row["link"];
	}
}
//*******************************************
function __ft_way_to_item($table, $id, $self=false){
	$resp = mysql_query("select * from $table where id=$id");
	$row = mysql_fetch_assoc($resp);
	$mass = false;
	$par=$row["parent"];
	while($par!=0){
		$resppar = mysql_query("select * from items where id=$par");
		$rowpar = mysql_fetch_assoc($resppar);
		$par = $rowpar["parent"];
		$mass[] = $rowpar;
	}
	if($mass) $mass = array_reverse ($mass, false);
	if($self) $mass[] = $row;
	return $mass;
}
//*******************************************
function __ft_get_item($table, $id){
	$resp = mysql_query("select * from $table where id=$id order by prior asc, name asc");
	if(!$resp) return false;
	return mysql_fetch_assoc($resp);
}
//*******************************************
function __ft_test_item_for_child($table, $id){
	$folders=0;
	$items = 0;
	$resp = mysql_query("select * from $table where parent=$id");
	while($row = mysql_fetch_assoc($resp))
		if($row["folder"]=="1") $folders=1;
		else $items=1;
	return array($folders, $items);
}
//*****************************************************
function __ft_test_item_for_child_no_folder($id){
	$resp = mysql_query("select * from items where parent=$id");
	if(mysql_num_rows($resp)>0)
		return mysql_num_rows($resp); 	else return false;
}
//*******************************************
function __fmt_rekursiya_show_items_for_select($all_parent, $edit_mass, $edit, $count, $most_sel=0){
	//echo "<script>alert('$all_parent')";<script>";
	$ret_val="";
	$resp=mysql_query("select * from  items  where parent=$all_parent and folder=1 order by prior asc");
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
				$ret_val.= __fmt_rekursiya_show_items_for_select($row["id"], $edit_mass, $edit, $count+1, $most_sel);
			else
				$ret_val.= __fmt_rekursiya_show_items_for_select($row["id"], $edit_mass, $edit, $count+1);
		}	
	}
	return $ret_val;
}
//*******************************************
function __fmt_find_item_parent_name($child, $mass=false){
	if($child==0) return false;
	$resp = mysql_query("select * from  items  where id=$child and folder=1");
	$row = mysql_fetch_assoc($resp);
	if(!$mass) $mass = array($row["name"]);
	else $mass[] = $row["name"];
	//echo "<br/>mass:<br/>"; print_r($mass);
	if($row["parent"]=="0") return $mass;
	$resp = mysql_query("select * from  items  where id=$row[parent] and folder=1");
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
function __fmt_find_item_parent_name_v2($child, $mass=false){
	if($child==0) return false;
	$resp = mysql_query("select * from  items  where id=$child and folder=1");
	$row = mysql_fetch_assoc($resp);
	if(!$mass) $mass = array("<a href=\"items.php?parent=$row[id]\">".$row["name"]."</a>");
	else $mass[] = "<a href=\"items.php?parent=$row[id]\">".$row["name"]."</a>";
	//echo "<br/>mass:<br/>"; print_r($mass);
	if($row["parent"]=="0") return $mass;
	$resp = mysql_query("select * from  items  where id=$row[parent] and folder=1");
	$row = mysql_fetch_assoc($resp);
	if($row["parent"]==0) {
		$mass[] = "<a href=\"items.php?parent=$row[id]\">".$row["name"]."</a>";
		return $mass;
	}
	else{
		return __fmt_find_item_parent_name_v2($row["id"], $mass);
	}
}
//*******************************************
function __fmt_find_item_parent_id($child, $mass=false){
	if($child==0) return false;
	$resp = mysql_query("select * from  items  where id=$child and folder=1");
	$row = mysql_fetch_assoc($resp);
	if(!$mass) $mass = array($row["id"]);
	else $mass[] = $row["id"];
	//echo "<br/>mass:<br/>"; print_r($mass);
	if($row["parent"]=="0") return $mass;
	$resp = mysql_query("select * from  items  where id=$row[parent] and folder=1");
	$row = mysql_fetch_assoc($resp);
	if($row["parent"]==0) {
		$mass[] = $row["id"];
		return $mass;
	}
	else{
		return __fmt_find_item_parent_id($row["id"], $mass);
	}
}

//*******************************************
function __farmmed_rekursiya_show_items_for_js($all_parent, $edit_mass, $edit, $count){
	$ret_val="";
	if($all_parent!=0) for($i=0; $i<$count; $i++) $ret_val.= "  ";
	$ret_val.= "tree_array_$all_parent = new Array();\n";
	$a_count=0;
	$resp=mysql_query("select * from  items  where parent=$all_parent and folder=1 order by prior asc");
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
	$query = " select * from items where parent=$all_parent and folder=1 order by prior asc";
	//echo $query;
	$resp=mysql_query($query);
	while($row=mysql_fetch_assoc($resp)){
		//if($edit_mass["id"]!=$row["id"]){
			$ret_val.= "<div class=\"tree-item\"";
			if($all_parent!=0) $ret_val.=" style=\"display:none;\" ";
			$ret_val.=" id=\"tree_item_$row[id]\">";
			if($all_parent!=0) for($i=0; $i<$count; $i++) $ret_val.= "<div class=\"tree-spacer\"></div>\n";
			if(__marabu_tree_test_for_child($row["id"])) {
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
				$ret_val.= "<div class=\"tree-content\"><a href=\"?parent=$row[id]\">$row[name]</a> <b>($row[prior])</b></div>\n"; 
				$ret_val.= "<div class=\"tree-new\">
								<a title=\"Добавить группу группу\" href=\"?new_folder=1&parent=$row[id]\">
								<img class=\"tree-image\" src=\"tree/new_item.gif\" border=\"1\"  /></a>
								</div>\n";
				$ret_val.= "<div class=\"tree-edit\">
								<a title=\"Редактировать группу\" href=\"?edit_folder=$row[id]&parent=$row[id]\">
								<img class=\"tree-image\" src=\"tree/edit_item.gif\" border=\"1\"  /></a>
								</div>\n";
				$ret_val.= "<div class=\"tree-edit\">
								<a title=\"Удалить группу\" href=\"?delete=$row[id]&parent=$row[id]\">
								<img class=\"tree-image\" src=\"tree/delete_item.gif\" border=\"1\"  /></a>
								</div>\n"; 
				if(!__marabu_tree_test_for_child($row["id"])) {
				$ret_val.= "<div class=\"tree-delete\">
								<a title=\"Получить прайс-лист группы\" href=\"__g_price.php?&parent=$row[id]\">
								<img class=\"tree-image\" src=\"tree/price_item.gif\" border=\"1\"  /></a>
								</div>\n"; 
				}
			}
			else{
				$ret_val.= "<div class=\"tree-content\"><a href=\"?parent=$row[id]\">$row[name]</a></div>\n"; 
			}
			$ret_val.= __farmmed_rekursiya_show_items($row["id"], $edit_mass, $edit, $count+1, $user);
			$ret_val.= "</div>\n";
		//}	
	}
	return $ret_val;
}
//*****************************************************
function __farmmed_rekursiya_show_items_user($all_parent, $edit_mass, $edit, $count, $most_show=false){
	$ret_val="";
	$resp=mysql_query("select * from  items  where parent=$all_parent and folder=1 order by prior asc");
	while($row=mysql_fetch_assoc($resp)){
			$tstm = __ft_test_item_for_child("items", $row["id"]);
			//echo "count=$count<br />";
			$ret_val.= "<div";
			if(__marabu_tree_test_for_child($row["id"])) {
				if($row["parent"]==0){
					$ret_val.= "  >";
				}
				else { 
					$ret_val.=" id=\"tree_item_$row[id]\"   onMouseOut=\"className='div_mvis0'\" class=\"div_mvis0\">";
					//$ret_val.=" id=\"tree_item_$row[id]\"  onMouseOver=\"className='div_mvis'\" onMouseOut=\"className='div_mvis0'\" class=\"div_mvis0\">";
				}
			} else {
				$ret_val.=" id=\"tree_item_$row[id]\">";
			}
			
			$ret_val.="<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr>";
			//echo "count=$count<br />";
			if(__marabu_tree_test_for_child($row["id"])) {
					if($all_parent!=0) {
					for($i=0; $i<$count-1; $i++) $ret_val.= "<td width=\"13\">&nbsp;</td>\n";
						if($row["id"] == $most_show[0]){
						$ret_val.= "<td width=\"13\" id=\"tree_plus_$row[id]\">
									<a href=\"javascript:hide_tree_item($row[id], $count)\">
									<img src=\"/tree/minus.jpg\" class=\"tree-img\"></a></td>\n";
						}
						else{
						$ret_val.= "<td width=\"13\"  id=\"tree_plus_$row[id]\">
									<a href=\"javascript:show_tree_item($row[id], $count)\">
									<img src=\"/tree/plus.jpg\" class=\"tree-img\"></a></td>\n";
						}
					}
				}
				else {
					if($all_parent!=0) for($i=0; $i<$count-1; $i++) $ret_val.= "<td width=\"13\">&nbsp;</td>\n";
					if($all_parent!=0) $ret_val.= "\n
														<td width=\"13\">
														<img src=\"/tree/for_x_for.gif\" class=\"tree-img\"></td>\n";
					else
						 if(!$tstm[0]) $ret_val .= "";
						 else $ret_val.= "<td width=\"13\">
														<img width=\"12\" src=\"/tree/spacer.gif\" class=\"tree-img\"></td>\n";
						
			}
			if($row["parent"]==0){
				$img_link =  __ft_search_first_data("items", $row["id"], "link");
				$img_link = __images_create_images_array($img_link);
				$img_link = explode("|", $img_link[0]);
				$img_link = $img_link[0];
				if($img_link) $img_link= "models_images/".$img_link;
				else $img_link = "images/not_img.jpg";
				//echo "count=$count<br />";
				$ret_val.= "<td height=\"40\" style=\"/*padding-left: 3px; font-weight: bold;*/\" 
								onMouseOver=\"this.bgColor='#E3EEF4'\" onMouseOut=\"this.bgColor=''\" class=\"td_m_img\" >
								<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
								<tr><td>";
								if(!$tstm[0]) $ret_val .= "<a href=\"items.php?parent=$row[id]\"  style=\"color: #BD271C;\">";
								else $ret_val .= "<a href=\"javascript:show_tree_item($row[id], $count)\"  style=\"color: #BD271C;\">";
								$ret_val .= "<b>$row[name]</b></a></td></tr></table>
								</td></tr></table>\n"; 
			}
			else{
				$ret_val.= "<td height=\"20\" style=\"padding-left: 3px;\" 
								onMouseOver=\"this.bgColor='#D0EACC'\" onMouseOut=\"this.bgColor=''\">
								<a href=\"/items.php?parent=$row[id]\">";
								if($row["id"]==$edit) $ret_val.="<font color=\"#D60000\">";
								$ret_val.="$row[name]";
								if($row["id"]==$edit) $ret_val.="</font>";
								$ret_val.="</a></td></tr></table>\n"; 
			}

			//***********************************
				if(__marabu_tree_test_for_child($row["id"])){
					if($row["id"] == $most_show[0]){
						$ret_val .= "<div id=\"is_open_$row[id]\" style=\"display:;";
						if($count==0) $ret_val.="padding-left:25px;";
						$ret_val .= "\">";
						$new_most_show = false;
						for($i=1; $i<count($most_show); $i++)
							$new_most_show[] = $most_show[$i];
						$ret_val.= __farmmed_rekursiya_show_items_user($row["id"], $edit_mass, $edit, $count+1, $new_most_show);
					}
					else{
						$ret_val .= "<div id=\"is_open_$row[id]\" style=\"display:none;";
						if($count==0) $ret_val.="padding-left:25px;";
						$ret_val .= "\"><img width=\"16\" height=\"16\" src=\"/tree/clock.gif\" align=\"absmiddle\">Загрузка...";
					}
					$ret_val .= "</div>";
				}
			//***********************************
			$ret_val.= "</div>\n";
	}
	return $ret_val;
}
//*******************************************
function __fmt_test_for_items($id){
	$resp = mysql_query("select * from items where parent=$id and folder=0");
	if(mysql_num_rows($resp)>0)
		return true;
	return false;
}
//*******************************************
function delete_items($delete){
	$resp = mysql_query("select * from  items  where parent = $delete");
	while($row = mysql_fetch_assoc($resp)){
		if(file_exists("../sp_images/".$row["sp_link"]) && $row["sp_link"]!="")
			unlink("../sp_images/".$row['link']);
		if(file_exists("../models_images/$row[link]") && $row['link']!=""){
			unlink("../models_images/$row[link]");
		}
		if(file_exists("../csv/$row[csv]") && $row['csv']!=""){
			unlink("../csv/$row[csv]");
		}
		if(file_exists("../models_images2/$row[image_tree]") && $row['image_tree']!=""){
			unlink("../models_images2/$row[image_tree]");
		}
		if($row["folder"] == 1){
			delete_items($row["id"]);
		}
	}
	$resp = mysql_query("delete from  items  where parent=$delete");
	delete_item($delete);
}
//*******************************************
function delete_item($delete){
	$resp = mysql_query("select * from  items  where id = $delete");
	$row = mysql_fetch_assoc($resp);
		if(file_exists("../sp_images/".$row["sp_link"]) && $row["sp_link"]!="")
			unlink("../sp_images/".$row['link']);
		if(file_exists("../models_images/$row[link]") && $row['link']!=""){
			unlink("../models_images/$row[link]");
		}
		if(file_exists("../csv/$row[csv]") && $row['csv']!=""){
			unlink("../csv/$row[csv]");
		}
		if(file_exists("../models_images2/$row[image_tree]") && $row['image_tree']!=""){
			unlink("../models_images2/$row[image_tree]");
		}
	$resp = mysql_query("delete from  items  where id=$delete");
}
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
function __tree_get_tree_name_from_index($index){
	global $tree_array;
	return $tree_array[$index];
}
//*******************************************
function __arsenal_search_menu_img($parent){
	$ret_val = "";
	$query = "select * from  items  where folder=0 and parent=$parent and menu_img=1";
	$resp = mysql_query($query);
	if(mysql_num_rows($resp)==0){
		$query_s = "select * from  items  where folder=1 and parent=$parent";
		$resp_s = mysql_query($query_s);
		while($row = mysql_fetch_assoc($resp_s)){
			$ret_val = __arsenal_search_menu_img($row["id"]);
			if($ret_val) return $ret_val;
		}
	}
	else{
		$row = mysql_fetch_assoc($resp);
		$ret_val = $row["link"];
		return $ret_val;
	}
	
}
//*****************************************************
function __farmmed_rekursiya_show_items_v3($all_parent, $edit_mass, $edit, $count, $user=false){
	//echo "<script>alert('$all_parent')";<script>";
	$ret_val="";
	//if(__marabu_tree_test_for_child_v3($all_parent))
		$query = " select * from items where parent=$all_parent order by prior asc";
		//echo "$query";
	//else
		//$query = " select * from items where parent=$all_parent and folder=0 order by prior asc";
	//echo $query;
	$resp=mysql_query($query);
	while($row=mysql_fetch_assoc($resp)){
		//if($edit_mass["id"]!=$row["id"]){
			$ret_val.= "<div class=\"tree-item\"";
			if($count!=0) $ret_val.=" style=\"display:none;\" ";
			$ret_val.=" id=\"tree_item_$row[id]\">";
			if($count!=0) for($i=0; $i<$count; $i++) $ret_val.= "<div class=\"tree-spacer\" style=\"width:15px;float:left;height:10px;\"></div>\n";
			if(__marabu_tree_test_for_child_v3($row["id"]) && $row["folder"]==1) {
				$ret_val.= "<div class=\"tree-plus\" id=\"tree_plus_$row[id]\" style=\"float:left;\"><a href=\"javascript:show_tree_item($row[id], 0)\"><img src=\"tree/plus.jpg\" class=\"tree-img\"></a></div>\n";
				$ret_val.= "<div class=\"tree-minus\" style=\"display:none;float:left;\"  id=\"tree_minus_$row[id]\">
				<a href=\"javascript:hide_tree_item($row[id], 0)\"><img src=\"tree/minus.jpg\" class=\"tree-img\"></a></div>\n";
			}
			//else $ret_val.= "<div class=\"tree-spacer\"></div>\n";
			$ret_val.= "<div class=\"tree-content\">";
			if(  $row["folder"]==0  )
				$ret_val.="<a href=\"javascript:top.insert_semp($row[id], '$row[name]')\">$row[name]</a></div>\n"; 
			else $ret_val.="$row[name]</div>\n"; 
			$ret_val.= __farmmed_rekursiya_show_items_v3($row["id"], $edit_mass, $edit, $count+1, $user);
			$ret_val.= "</div>\n";
		//}	
	}
	return $ret_val;
}
//*******************************************

function __farmmed_rekursiya_show_items_for_js_v3($all_parent, $edit_mass, $edit, $count){
	$ret_val="";
	if($all_parent!=0) for($i=0; $i<$count; $i++) $ret_val.= "  ";
	$ret_val.= "tree_array_$all_parent = new Array();\n";
	$a_count=0;
	$resp=mysql_query("select * from  items  where parent=$all_parent order by prior asc");
	while($row=mysql_fetch_assoc($resp)){
		if($all_parent!=0) for($i=0; $i<$count; $i++) $ret_val.= "  ";
		$ret_val.= "tree_array_".$all_parent."[$a_count] = $row[id];\n";
		$ret_val.= __farmmed_rekursiya_show_items_for_js_v3($row["id"], $edit_mass, $edit, $count+1)."";
		$a_count++;
	}
	return $ret_val;
}
//*****************************************************
function __marabu_tree_test_for_child($id){
	$resp = mysql_query("select * from items where parent=$id and folder=1");
	if(mysql_num_rows($resp)>0)
		return mysql_num_rows($resp); 	else return false;
}
//*****************************************************
function __marabu_tree_test_for_child_v3($id){
	$resp = mysql_query("select * from items where parent=$id");
	if(mysql_num_rows($resp)>0)
		return mysql_num_rows($resp); 	else return false;
}
//*******************************************
?>