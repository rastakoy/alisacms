<?
//*************************
function get_file($filename){
	$mytext = "";
	$fp = fopen(  $filename  , "r"  ); // Открываем файл в режиме чтения
	if(  $fp  ) while(  !feof(  $fp  )  ) $mytext .= fgets(  $fp, 4096  );
	else echo "Ошибка при открытии файла";
	fclose(  $fp  );
	return $mytext;
}
//*****************************************************
function wright_log($log_info){
	file_put_contents("../error.log", $log_info." \r\n", FILE_APPEND);
}
//*****************************************************
function __f_search_and_replace($str){
	$rv = "";
	for($i=0; $i<strlen($str); $i++){
		$char=true;
		if(substr($str, $i, 1) == "'"){
			$rv.= "\\'";
			$char=false;
		}
		if($char){
			$rv.= substr($str, $i, 1);
		}
	}
	return $rv;
}
//*****************************************************
function search_kav($string){
	$ret_val = "";
	for($i=0; $i<strlen($string); $i++){
		if(substr($string, $i, 1) == "\""){
			if($i==0){
				//$ret_val.="«";
			}
			else if($i == strlen($string)-1){
				//$ret_val.="»";
			}
			else{
				if(substr($string, $i+1, 1) == " "){
					//$ret_val.="»";
				}
				else{
					//$ret_val.="«";
				}
			}
		}
		else{
			$ret_val.=substr($string, $i, 1);
		}
	}
	//$string = eregi_replace('"', "", $string);
	//$string = preg_replace('/(^|\s)"(\S)/', '$1&laquo;$2 ', $string);
	//$string = preg_replace('/(\S)"([ .,?!])/', '$1&raquo;$2', $string);
	return $ret_val;
}
//*****************************************************
function strip_post_vars_eval($vars){
	$ret_val = "";
	//$vars = eregi_replace("'", "`", $vars);
	if(is_array($vars)>0){
		foreach($vars as $key=>$val){
			if(is_array($val)){
				foreach($val as $s_key=>$s_val){
					if($key!="multycont"  && $key!="minicont" && $key!="minicont_ukr"){
						//$s_val = search_kav($s_val);
					}
					$ret_val.="\$".$key."[$s_key] = \"".addslashes($s_val)."\";\n";
				}
			}
			else{
				if($key!="multycont"  && $key!="minicont" && $key!="minicont_ukr" && $key!="cont_ukr" && $key!="cont"){
					//$val = search_kav($val);
					$val = htmlspecialchars($val, ENT_QUOTES);
				}
				$ret_val.="\$".$key." = \"".addslashes($val)."\";\n";
				$ret_val.="\$".$key." = \"".__f_search_and_replace($val)."\";\n";
			}
		}
	}
	return $ret_val;
}
//*****************************************************
function strip_get_vars_eval($vars){
	$ret_val = "";
	if(is_array($vars)>0){
		foreach($vars as $key=>$val){
			if(is_array($val)){
				foreach($val as $s_key=>$s_val){
					$ret_val.="\$".$key."[$s_key] = \"".addslashes($s_val)."\";\n";
				}
			}
			else{
				$ret_val.="\$".$key." = \"".addslashes($val)."\";\n";
			}
		}
	}
	return $ret_val;
}
//*******************************************
function get_pages_count($c, $a)
{
	$count = 0;
	for($i=0; $i<$a; $i+=$c)
		$count++;
	return $count;
}
//*******************************************
function create_table_($parent){
	$ret_val = "";
	$query = "select * from katalog where parent=$parent";
	$resp = mysql_query($query);
	$vsp_height = 224;
	$ret_val .= "\n<!--START CREATE MENU TABLE LEVEL=$parent-->\n";
	if($parent){
		$ret_val .= "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
		$ret_val .= "<tr><td height=\"5\"><img src=\"images/kmenu_up.gif\" width=\"229\" height=\"5\"></td></tr>\n";
		$ret_val .= "<tr><td valign=\"top\">\n";
	}
	$ret_val .= "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
	$count = 0;
	while($row = mysql_fetch_assoc($resp)){
		if($count == mysql_num_rows($resp)-1)
			$ret_val .= create_row($row["id"], $row["name"], $row["parent"], $vsp_height, true, false);
		else if($count == 0)
			$ret_val .= create_row($row["id"], $row["name"], $row["parent"], $vsp_height, false, true);
		else
			$ret_val .= create_row($row["id"], $row["name"], $row["parent"], $vsp_height, false, false);
		$vsp_height+=30;
		$count++;
	}
	$ret_val .= "</table>\n";
	if($parent){
		$ret_val .= "</td></tr>\n";
		$ret_val .= "<tr><td height=\"5\"><img src=\"images/kmenu_bottom.gif\" width=\"229\" height=\"5\"></td></tr></table>\n";
	}
	$ret_val .= "<!--END CREATE MENU TABLE LEVEL=$parent-->\n";

	return $ret_val;
}
//*******************************************
function create_row($id, $name, $parent, $vsp_height, $lost, $first){
	$ret_val = "";
	if($first && $parent){
		$ret_val .= "<tr>
		<td height=\"4\"  class=\"kmenuleft\"><img src=\"images/spacer.gif\" width=\"10\" height=\"4\"></td>
		<td height=\"4\" bgcolor=\"#FFFFFF\"><img src=\"images/spacer.gif\" width=\"10\" height=\"4\"></td>
		<td height=\"4\" class=\"kmenuright\"><img src=\"images/spacer.gif\" width=\"10\" height=\"4\"></td>
		</tr>";
	}
	$ret_val.="<tr> 
    <td width=\"10\"  class=\"kmenuleft\">&nbsp;</td>";
	if(test_for_child($id)){
		$ret_val .= "<td id=\"vspmenu_$id\" class=\"kmenuname\" onMouseOver=\"show_block('$id', $vsp_height, ".test_for_child($id).")\" onMouseOut=\"hide_block('$id')\">";
		$ret_val .= "<span class=\"psevdolink\">$name</span>";
		$ret_val .= "<div  id=\"childmenu_$id\"  class=\"vspmenu\" style=\"display:none\" onMouseOver=\"color_bg('$id', 1)\" onMouseOut=\"color_bg('$id', false)\">\n";
		$ret_val .= create_table($id);
		$ret_val .="</div>";
	}
	else{
		$ret_val .= "<td class=\"kmenuname\">";
		$ret_val .= "<a href=\"models.php?modelparent=$id\" class=\"akmenuname\">$name</a>";
	}
	$ret_val .= "</td><td width=\"10\" class=\"kmenuright\">&nbsp;</td></tr>";
	if(!$lost){
		$ret_val .= "<tr>
		<td height=\"8\"  class=\"kmenuleft\"><img src=\"images/spacer.gif\" width=\"10\" height=\"8\"></td>
		<td height=\"8\" class=\"kmenuhr\"><img src=\"images/kmenu_hr.jpg\" width=\"10\" height=\"8\"></td>
		<td height=\"8\" class=\"kmenuright\"><img src=\"images/spacer.gif\" width=\"10\" height=\"8\"></td>
		</tr>";
	}
	
	return $ret_val;
}
//*******************************************
function test_for_child($id){
	$resp = mysql_query("select * from items where parent=$id");
	if(mysql_num_rows($resp)>0)
		return mysql_num_rows($resp); 	else return false;
}
//*******************************************
function read_words($text, $long)//
{
$count=0;//
for($i=0; $i<strlen($text); $i++)
{
	$temp = substr($text, $i, 1); //
	if($temp==" ") {$count++;} //
	if($count>$long) //
	{
		$temp1 = substr($text, $i-1, 1);
		if($temp1==".") //
			$text=substr($text, 0, $i).".."; 
		else //
			$text=substr($text, 0, $i)."..."; 
		break;
	}
}
return $text;
}
//*******************************************
function site_map($parent, $exp_val){
	$ret_val = "";
	$mass = false;
	$count = 0;
	$resp = mysql_query("select * from katalog where parent=$parent");
	while($row=mysql_fetch_assoc($resp)){
		$ret_val .= "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr>";
		if($count==0 && $parent==0) $exp_val_1 = $exp_val."g~";
		else if ($count == mysql_num_rows($resp)-1) $exp_val_1 = $exp_val."l~";
		else $exp_val_1 = $exp_val."e~";
		$mass = explode("~", $exp_val_1);
		//print_r ($mass);
		if(count($mass)>0){
			foreach($mass as $key=>$val){
				if($val!=""){
					$ret_val .= "<td width=\"21\" height=\"21\"><img src=\"images/e/$val.jpg\"></td>";
				}
			}
		}
		if($parent==0)
			$ret_val .= "<td class=\"tree\"><strong>$row[name]</strong></td>";
		else
			$ret_val .= "<td class=\"tree\"><a href=\"models.php?modelparent=$row[id]\">$row[name]</a></td>";
		$ret_val .= "</tr></table>";
		if($count==0) $ret_val .= site_map($row['id'], $exp_val."i~");
		else if ($count == mysql_num_rows($resp)-1) $ret_val .= site_map($row['id'], $exp_val."o~");
		else $exp_val_1 = $ret_val .= site_map($row['id'], $exp_val."i~");
		$count++;
	}
	return $ret_val;
}
//*******************************************
/*function delete_item($tree_index, $delete){
	$resp = mysql_query("select * from ".__tree_get_tree_name_from_index($tree_index)." where id = $delete");
	$row = mysql_fetch_assoc($resp);
		$tmp = __images_create_images_array($row["link"]);
		foreach($tmp as $key=>$val){
			if(file_exists("../models_images/$val") && $val!=""){
				unlink("../models_images/$val");
			}
		}
		if(file_exists("../csv/$row[csv]") && $row['csv']!=""){
			unlink("../csv/$row[csv]");
		}
		if(file_exists("../models_images/$row[link2]") && $row['link2']!=""){
			unlink("../models_images/$row[link2]");
		}
	$resp = mysql_query("delete from ".__tree_get_tree_name_from_index($tree_index)." where id=$delete");
}*/
//*******************************************
/*function delete_items($tree_index, $delete){
	$resp = mysql_query("select * from ".__tree_get_tree_name_from_index($tree_index)." where parent = $delete");
	while($row = mysql_fetch_assoc($resp)){
		$tmp = __images_create_images_array($row["link"]);
		foreach($tmp as $key=>$val){
			if(file_exists("../models_images/$val") && $val!=""){
				unlink("../models_images/$val");
			}
		}
		if(file_exists("../csv/$row[csv]") && $row['csv']!=""){
			unlink("../csv/$row[csv]");
		}
		if(file_exists("../models_images/$row[link2]") && $row['link2']!=""){
			unlink("../models_images/$row[link2]");
		}
		if($row["folder"] == 1){
			delete_items($tree_index, $row["id"]);
		}
	}
	$resp = mysql_query("delete from ".__tree_get_tree_name_from_index($tree_index)." where parent=$delete");
	delete_item($tree_index, $delete);
} */
//*******************************************
function __ca_delete_photo($delete){	
	$resp=mysql_query("select * from photo where parent=$delete");
	while($row=mysql_fetch_assoc($resp)){
		if($row['link']!="") 
			if(file_exists("../pimages/".$row["link"]))
				unlink("../pimages/".$row["link"]);
		$resp_sub=mysql_query("delete from photo where id=$row[id]");
	}
}
//*******************************************
function test_for_digits_int($param){
	$ret_val = true;
	for($i=0; $i<strlen($param); $i++){
		$a = substr($param, $i, 1);
		if( $a != "1" && $a!="2" && $a!="3" && $a!="4" && $a!="5" && $a!="6" && $a!="7" && $a!="8" && $a!="9" && $a!="0"){
			$ret_val = false;
			//echo "Несовпадение в -$a-";
		}
	}
	return $ret_val;
}
//*******************************************
function __show_mini_kat($price, $hot=false, $parent=false, $search=false){
	//print_r($price);
	$ret_val = "<table width=\"480\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
	foreach($price as $key=>$val){
		$ret_val.= "<tr>";
		$count=0;
		foreach($val as $k=>$v){
			$resp_p = mysql_query("select * from items where parent = $v[id] order by prior asc limit 0,1");
			$row_p = mysql_fetch_assoc($resp_p);
			//print_r($row_p);
			$v["link"] = $row_p["link"];
			$ret_val.=  "<td ";
			//if($v["link"]!="")
				$ret_val.=   " valign=\"top\"   ";
			if(!$count)
				$ret_val.=   " class=\"specpred\">";
			else
				$ret_val.=   " class=\"specpred_r\">";
			$ret_val .= "<div class=\"div_hr\">";
			$ret_val .="<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr>";
			$ret_val .= "<td width=\"50%\" height=\"140\" valign=\"top\" class=\"td_item_g\">";
			//$ret_val .= "<img src=\"images/__tmp_01.jpg\" width=\"111\" height=\"121\">";
			if($v["link"]!=""){
				$tmp = __images_create_images_array($v['link']);
				$ret_val.=  "<img src=\"tmp/$tmp[0]\"  alt=\"$v[name]\" style=\"margin-bottom: 20px;\"><br/>";
			}
			else
				$ret_val.=  "<img src=\"images/nc_img.gif\" width=\"120\" height=\"90\" class=\"img-specpred\"><br/>";
			$ret_val .= "</td><td valign=\"top\" class=\"td_item_gs\"><a href=\"catalog.php?item=$v[id]\" class=\"item_gs\">$v[name]</a></td></tr></table>";
			//if($hot)  $ret_val.=  "<a href=\"show.php?item=$v[id]&hot=1\">";
			//else $ret_val.=  "<a href=\"show.php?item=$v[id]&parent=$parent&search=$search\">";
			
			
			//$ret_val.=  "$v[name]</a>";
			//if($v["price_name"])
				//$ret_val.=  "<br/><span class=\"mini-body-title\">Цена: ".__format_txt_price_format($v["price"])." $v[price_name].</span>";
			//else
				//$ret_val.=  "<br/><span class=\"mini-body-title\">Цена: ".__format_txt_price_format($v["price"])." грн.</span>";
			//$ret_val.=  "<br/><a href=\"rec.php?add=$v[id]\">В корзину</a>";
			$ret_val.=  "</div></td>\n";
			$count++;
			if($count==2) $count=0;
			//else $ret_val.=  "<td>&nbsp;</td>";
		}
		if($count!=0)
			for($i=$count; $i<2; $i++){
				$ret_val.=  "<td  class=\"index-price\">&nbsp;</td>\n";
				if($i!=1) $ret_val.=  "<td>&nbsp;</td>";
			}
		$ret_val.=  "</tr>\n";
	}
	$ret_val.=  "</table>";
	return $ret_val;
}
//*******************************************
function __show_mini_kat_2($price, $hot=false, $parent=false, $search=false){
	//print_r($price);
	$ret_val = "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
	foreach($price as $key=>$val){
		$ret_val.= "<tr>";
		$count=0;
		foreach($val as $k=>$v){
			$resp_p = mysql_query("select * from items where parent = $v[id] order by prior asc limit 0,1");
			$row_p = mysql_fetch_assoc($resp_p);
			//print_r($row_p);
			//$v["link"] = $row_p["link"];
			$ret_val.=  "<td ";
			//if($v["link"]!="")
				$ret_val.=   " valign=\"top\"   ";
			if(!$count)
				$ret_val.=   " class=\"specpred\">";
			else
				$ret_val.=   " class=\"specpred_r\">";
			$ret_val .= "<div class=\"div_hr\">";
			$ret_val .="<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr>";
			$ret_val .= "<td width=\"50%\" height=\"140\" valign=\"top\" class=\"td_item_g\">";
			//$ret_val .= "<img src=\"images/__tmp_01.jpg\" width=\"111\" height=\"121\">";
			if($v["link"]!=""){
				
				$tmp = __images_create_images_array($v['link']);
				$img = $tmp[0];
				if(count($tmp) > 1) 
					$img = $tmp[1];
				$ret_val.=  "<a href=\"items.php?item=$v[id]\" class=\"item_gs\">
				<img src=\"imgres.php?link=$img&resize=120\" width=\"120\" 
				height=\"90\" class=\"img-specpred\" alt=\"$v[name]\" style=\"margin-left: 5px;\"></a><br/>";
			}
			else
				$ret_val.=  "<img src=\"images/nc_img.gif\" width=\"120\" height=\"90\" class=\"img-specpred\"><br/>";
			$ret_val .= "</td><td valign=\"top\" class=\"td_item_gs\"><a href=\"items.php?item=$v[id]\" class=\"item_gs\">$v[name]</a>
			<br/><br/><font color=\"#999999\">Цена:</font> $v[price] <font color=\"#999999\">руб.</font>
			</td></tr></table>";
			//if($hot)  $ret_val.=  "<a href=\"show.php?item=$v[id]&hot=1\">";
			//else $ret_val.=  "<a href=\"show.php?item=$v[id]&parent=$parent&search=$search\">";
			
			
			//$ret_val.=  "$v[name]</a>";
			//if($v["price_name"])
				//$ret_val.=  "<br/><span class=\"mini-body-title\">Цена: ".__format_txt_price_format($v["price"])." $v[price_name].</span>";
			//else
				//$ret_val.=  "<br/><span class=\"mini-body-title\">Цена: ".__format_txt_price_format($v["price"])." грн.</span>";
			//$ret_val.=  "<br/><a href=\"rec.php?add=$v[id]\">В корзину</a>";
			$ret_val.=  "</div></td>\n";
			$count++;
			if($count==2) $count=0;
			//else $ret_val.=  "<td>&nbsp;</td>";
		}
		if($count!=0)
			for($i=$count; $i<2; $i++){
				$ret_val.=  "<td  class=\"index-price\">&nbsp;</td>\n";
				if($i!=1) $ret_val.=  "<td>&nbsp;</td>";
			}
		$ret_val.=  "</tr>\n";
	}
	$ret_val.=  "</table>";
	return $ret_val;
}
//*******************************************
function __show_mini_kat_rows($price, $hot=false, $parent=false, $search=false){
	//print_r($price);
	$ret_val = "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
	$color=false;
	foreach($price as $key=>$val){
		$color=!$color;
		$ret_val.= "<tr><td  class=\"items-lines\"";
		if($color)$ret_val.= "bgcolor=\"#EBEBEB\" ";
		else $ret_val.= "bgcolor=\"#F9F9F9\" ";
		$ret_val.= ">";
		$ret_val.=  "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
		$ret_val.=  "<tr>";
		if($val["link"]!=""){
			$tmp = __images_create_images_array($val['link']);
			$ret_val.=  "<td width=\"130\" valign=\"top\"> ";
			$ret_val.=  "<a href=\"show.php?item=$val[id]&parent=$parent&search=$search\">";
			$ret_val.=  "<img src=\"imgres.php?link=models_images/$tmp[0]&resize=120\" width=\"120\" height=\"90\" ";
			$ret_val.=  "class=\"img-specpred\" alt=\"$val[name]\" style=\"margin-top: 4px; margin-bottom: 4px;\"/></a>";
			$ret_val.=  "</td>";
		}
		$ret_val.=  "<td valign=\"top\">";
			$ret_val.=  "<div style=\"font-size: 14px; color: #C7131F;\">";
			$ret_val.=  "<strong>";
			$ret_val.=  "$val[name]</strong></div><br/>";
			if($val["minicont"]) 	$ret_val.=  $val["minicont"]."<br/><br/>";
			$ret_val.=  "<a href=\"show.php?item=$val[id]&parent=$parent&search=$search\">Подробнее</a><br/>";
		//else if($val["cont"]) $ret_val.=  "<strong>Краткое описание:</strong><br/>".read_words($val["cont"], 12);
		$ret_val.=  "</td>";
		$ret_val.=  "<td width=\"150\" align=\"center\">";
			if($val["price_name"])
			$ret_val.=  "<div style=\"font-size: 14px; font-weight: bold;\">".__format_txt_price_format($val["price"])." $val[price_name].</div><br/>";
			else
			$ret_val.=  "<div style=\"font-size: 14px; font-weight: bold;\">".__format_txt_price_format($val["price"])." грн.</div><br/>";
			$ret_val.=  "<a href=\"rec.php?add=$val[id]\">В корзину</a>";
		$ret_val.=  "</td>";
		$ret_val.=  "</tr>";
		$ret_val.=  "</table>";
		$ret_val.=  "</td></tr>\n";
		if($key!=count($price)-1){
			//$ret_val.=  "<tr><td class=\"body-delimiter\">\n";
			//$ret_val.=  "&nbsp;"; 
			//$ret_val.=  "</td></tr>\n";
		}
		else{
			$ret_val.=  "<tr><td >\n";
			$ret_val.=  "&nbsp;"; 
			$ret_val.=  "</td></tr>\n";
		}
	}
	$ret_val.=  "</table>";
	return $ret_val;
}
//*******************************************
function __fmt_find_item_control($query, $id){
	$resp = mysql_query($query);
	$ret_val = array();
	$prew = 0;
	$breaking = false;
	$count=0;
	while($row=mysql_fetch_assoc($resp)){
		if($breaking){
			$ret_val[2] = $row["id"];
			break;
		}
		if($row["id"] == $id){
			if($count!=0) $ret_val[0] = $prew;
			$ret_val[1] = $row["id"];
			$breaking = true;
		}
		$prew = $row["id"];
		$count++;
	}
	return $ret_val;
}
//*******************************************
?>