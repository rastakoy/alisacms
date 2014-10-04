<?
//*******************************************
function __fmt_rekursiya_show_items_for_select($db_table, $all_parent, $edit_mass, $edit, $count, $most_sel=0){
	//echo "<script>alert('$all_parent')";<script>";
	$ret_val="";
	$resp=mysql_query("select * from ".__tree_get_tree_name_from_index($db_table)." where parent=$all_parent and folder=1 order by prior asc, name asc");
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
function __fmt_find_item_parent_id_user($db_table, $child, $mass=false){
	if($child==0) return false;
	$resp = mysql_query("select * from ".__tree_get_tree_name_from_index($db_table)." where id=$child");
	$row = mysql_fetch_assoc($resp);
	//echo "child=$child=="; echo "row=>"; print_r($row); echo "mass=>"; print_r($mass);
	if(!$mass) $mass = array($row["id"]);
	else $mass[] = $row["id"]; 
	//echo "<br/>mass: ---$row[id]---<br/>"; print_r($mass);
	if($row["parent"]=="0" ) return $mass;
	$query = "select * from ".__tree_get_tree_name_from_index($db_table)." where id=$row[parent]";
	//echo $query."<br />\n";
	$resp = mysql_query($query);
	$row = mysql_fetch_assoc($resp);
	if($row["parent"]==0  and $row["folder"]==0) {
		$mass = array($row["id"]);
		return $mass;
	}
	else{
		return __fmt_find_item_parent_id($db_table, $row["id"], $mass);
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
function __marabu_tree_test_for_child($id, $db_table, $is_user=false){
	if($is_user) $resp = mysql_query("select * from ".__tree_get_tree_name_from_index($db_table)." where parent=$id");
	else $resp = mysql_query("select * from ".__tree_get_tree_name_from_index($db_table)." where parent=$id and folder=1");
	
	if(mysql_num_rows($resp)>0)
		return mysql_num_rows($resp); 	else return false;
}
//*******************************************
function __farmmed_rekursiya_show_items_for_js($all_parent, $edit_mass, $edit, $count){
	$ret_val="";
	if($all_parent!=0) for($i=0; $i<$count; $i++) $ret_val.= "  ";
	$ret_val.= "tree_array_$all_parent = new Array();\n";
	$a_count=0;
	$resp=mysql_query("select * from items where parent=$all_parent and folder=1 order by prior asc, name asc");
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
	$ret_val="<UL style=\"list-style:none; margin:0px; padding:0px;\">";
	$query = "select * from ".__tree_get_tree_name_from_index($db_table)." where parent=$all_parent ORDER BY prior, name ASC";
	$resp=mysql_query($query);
	while($row=mysql_fetch_assoc($resp)){
		$ret_val .= "<li><div class=\"div_tree_m_item\">";
		//Настройка изаображений и плюсиков
		if(__marabu_tree_test_for_child($row["id"], $db_table, 1)) { //Есть ли элементы дочерние
			if($row["id"] == $most_show[0]){
				$ret_val.= "<span id=\"tree_plus_".$db_table."_$row[id]\">
								<a href=\"javascript:hide_tree_item($db_table, $row[id], $count)\">
								<img src=\"tree/minus.gif\" class=\"tree-img\" border=\"0\" align=\"absmiddle\"></a></span>\n";
			} else {
				$ret_val.= "<span id=\"tree_plus_".$db_table."_$row[id]\">
								<a href=\"javascript:show_tree_item($db_table, $row[id], $count)\">
								<img src=\"tree/plus.gif\" class=\"tree-img\" border=\"0\" align=\"absmiddle\"></a></span>\n";
			}
		} else {
			$ret_val .= "<span>";
			//if($all_parent!=0) {} else {}
			if($edit==$row["id"])
					$ret_val.= "<img src=\"tree/activ_page2.gif\" width=\"10\" height=\"8\" align=\"absmiddle\">";
				else
					$ret_val.= "<img src=\"tree/for_x_for2.gif\" class=\"tree-img\" align=\"absmiddle\">";
				$ret_val.= "</span>\n";
		}
		//Конец настройки плюсиков
		//Настройка текста
		//$ret_val .= "<span>";
		if($row["id"] == $edit){
			$ret_val.= "$row[name]";
		} else {
			$ret_val.= "<a href=\"$row[page_name]\" class=\"amenu\">$row[name]</a>";
		}
		//$ret_val .= "</span>";
		$ret_val .= "</div>";
		//Конец настройки текста
		// Рекурсия ***********************************
		if(__marabu_tree_test_for_child($row["id"], $db_table, 1)){
			if($row["id"] == $most_show[0]){
				$ret_val .= "<div id=\"is_open_".$db_table."_$row[id]\" style=\"display:block;padding-left:14px;\">";
				$new_most_show = false;
				for($i=1; $i<count($most_show); $i++)
					$new_most_show[] = $most_show[$i];
				//echo "new_most_show"; print_r($new_most_show);
				$ret_val.= __farmmed_rekursiya_show_items_user($db_table, $row["id"], $edit_mass, $edit, $count+1, $new_most_show);
			}
			else{
				$ret_val .= "<div id=\"is_open_".$db_table."_$row[id]\" style=\"display:none; padding-left:14px;\">";
				$ret_val .= "<img width=\"16\" height=\"16\" src=\"tree/clock.gif\" align=\"absmiddle\">Загрузка...";
			}
			$ret_val .= "</div>";
		}
		//***********************************
		$ret_val .= "</li>\n\n";
	}
	return $ret_val."</UL>";
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
	//echo __tree_get_tree_name_from_index($db_table);
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
				$ret_val.= "<div class=\"tree-content\"><a href=\"?parent=$row[id]\">";
				if($row["hot_item"]==1) $ret_val.= "<b>";
				$ret_val.= "$row[name]</b></a></div>\n"; 
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