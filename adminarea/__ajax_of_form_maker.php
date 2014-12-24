<?
header("Content-type: text/plain; charset=windows-1251");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
require_once("../__config.php");
require_once("../core/__functions.php");
require_once("../core/__functions_tree_semantic.php");
require_once("../core/__functions_format.php");
require_once("../core/__functions_images.php");
require_once("../core/__functions_forms.php");
require_once("../core/__functions_loadconfig.php");
require_once("../core/__functions_full.php");
require_once("../core/__functions_pages.php");
require_once("../core/__functions_csv.php");
require_once("../filter/__functions_filter.php");

//require_once("__functions_register.php");
//require_once("__functions_rating.php");
dbgo();
//*************************
require_once("__class_csvToArray.php"); // Загрузка файла библиотеки
$csv_class = new csvToArray("csv_class"); //Объявление класса csv 
//*************************
$paction = $_POST["paction"];
//*************************
$defaultFields = array(
"id",
"semp",
"dindiscount",
"kolvo",
"kolvov",
"kolvo_ediz",
"redirect",
"sfmany",
"grabber",
"mtm_cont",
"cont",
"name",
"href_name",
"parent",
"is_multi",
"multi_config",
"discount",
"itemtype",
"link",
"galtype",
"fassoc",
"hot_item",
"hot_group",
"page_show",
"dont_assoc",
"csv",
"folder",
"prior",
"item_code",
"item_art",
"item_psevdoart",
"item_price",
"price",
"out_price",
"model_name",
"image_tree",
"minicont",
"itemadddate",
"itemeditdate",
"datepicker",
"datepicker2",
"developers",
"out_manager",
"parent2",
"parent3",
"dop_page",
"menu_img",
"model_assoc",
"sp_link",
"is_news",
"is_new",
"csv_shablon",
"cont_ukr",
"minicont_ukr",
"tmp",
"recc",
"mtitle",
"mdesc",
"mh",
"name_title_new",
"name_title",
"rtf",
"assocfile",
"reiting_all",
"reiting_plus",
"psevdonum",
"folder_icon",
"cfg_file",
"bust_size",
"show_as_folder",
"price_diller",
"mtm",
"show_kav",
"show_snow",
"show_conf",
"show_lmenu",
"source",
"dost_pod_zakaz",
"pricedigit",
"multiprice",
"is_admin",
"coder",
"is_akc",
"zuserinfo",
"comm",
"orderstatus",
"zakprice",
"color",
"adress",
"is_sale",
"tkanpic",
"tkantype",
"is_rests"
);
//*************************
$typesmass[] = "inputtext";
$typesmass_comment[] = "Текстовое поле";
$typesmass[] = "number";
$typesmass_comment[] = "Числовое поле";
$typesmass[] = "double";
$typesmass_comment[] = "Поле цифр с запятой";
$typesmass[] = "parent";
$typesmass_comment[] = "Выбор родительской папки";
$typesmass[] = "datepicker";
$typesmass_comment[] = "Поле даты";
$typesmass[] = "hidden";
$typesmass_comment[] = "Скрытое поле";
$typesmass[] = "images";
$typesmass_comment[] = "Изображения";
$typesmass[] = "textarea";
$typesmass_comment[] = "Текстовое поле в форматированием";
$typesmass[] = "selectgaltype";
$typesmass_comment[] = "Тип галереи";
$typesmass[] = "saveblock";
$typesmass_comment[] = "Блок сохранения информации";
$typesmass[] = "usercomments";
$typesmass_comment[] = "Комментарии пользователей";
$typesmass[] = "inputcheckbox";
$typesmass_comment[] = "Чекбокс (галочка)";
$typesmass[] = "selectrectofolder";
$typesmass_comment[] = "Быбор из папки";
$typesmass[] = "selectoutmark";
$typesmass_comment[] = "???";
$typesmass[] = "selectassocfile";
$typesmass_comment[] = "Ассоциированный файл (для автопереходов)";
$typesmass[] = "artikul";
$typesmass_comment[] = "Поле артикула";
$typesmass[] = "selectmanytomany";
$typesmass_comment[] = "...";
$typesmass[] = "selectfromitems";
$typesmass_comment[] = "Выбор из папки (для фильтра)";
$typesmass[] = "pricedigit";
$typesmass_comment[] = "Поле цены";
$typesmass[] = "multiprice";
$typesmass_comment[] = "...";
$typesmass[] = "grabber";
$typesmass_comment[] = "Граббер информации (не готов)";
$typesmass[] = "coder";
$typesmass_comment[] = "Текстареа без визивига";
$typesmass[] = "selectfromitems_many";
$typesmass_comment[] = "...";
$typesmass[] = "color";
$typesmass_comment[] = "Цвет";
$typesmass[] = "semp";
$typesmass_comment[] = "С этой моделью покупают";
//*************************
function inside_item_2($key, $vmass, $typesmass, $typesmass_comment, $id){
							echo "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\" >";
							echo "<tr><td width=\"200\" height=\"35\">Тип записи</td><td>";
								//print_r($typesmass);
								echo " <select id=\"0_prm_$key\"  onChange=\"__aofm_getItemTeplate($key, $id, this.value)\">";
								echo "	<option value=\"0\" >Тип поля</option>";
								foreach($typesmass as $k=>$v){
									echo "	<option value=\"$v\" ";
									if($v==$vmass[0])  echo " selected ";
									echo ">$v</option>";
								}
								echo "</select> ";
								echo "</td></tr>";
								//******
								if($vmass[0]!='pricedigit' && $vmass[0]!='saveblock' && $vmass[0]!='images' 
								&& $vmass[0]!='pricedigit' && $vmass[0]!='parent' && $vmass[0]!='coder'
								&& $vmass[0]!='textarea'){
									echo "<tr><td width=\"200\" height=\"35\">Поле в базе данных</td><td>";
									if($vmass[0] == "inputtext"){
										echo __ff_get_textfield_fields($vmass[1], $key, $id);
									}
									if($vmass[0] == "number")
										echo __ff_get_numfield_fields($vmass[1], $key);
									if($vmass[0] == "double")
										echo __ff_get_double_fields($vmass[1], $key);
									if($vmass[0] == "inputcheckbox")
										echo __ff_get_checkbox_fields($vmass[1], $key);
									if($vmass[0] == "selectrectofolder")
										echo " <input id=\"1_prm_$key\" type=\"hidden\"  value='rtf' / > ";
									if($vmass[0] == "selectfromitems")
										echo __ff_get_selectfromitems_fields( $vmass[1], $key, $id );
									if($vmass[0] == "selectfromitems_many")
										echo __ff_get_selectfromitems_many_fields( $vmass[1], $key );
									echo "</td></tr>";
								}
								//******
								if($vmass[0]!='pricedigit' && $vmass[0]!='saveblock' && $vmass[0]!='images' 
								&& $vmass[0]!='pricedigit' && $vmass[0]!='parent' && $vmass[0]!='coder'
								&& $vmass[0]!='textarea'){
									echo "<tr><td width=\"200\" height=\"35\">Название поля</td><td>";
									echo " <input id=\"2_prm_$key\" type=\"text\" style=\"width:150px;\" value='$vmass[3]' / > ";
									echo "</td></tr>";
								}
								//******
								switch($vmass[0]){
									case 'inputtext':
										echo "<tr><td width=\"200\" height=\"35\">Стиль</td><td>";
										echo " <input id=\"3_prm_$key\" type=\"text\" style=\"width:150px;\" value='$vmass[4]' / > ";
										echo "</td></tr>";
										break;
								}
								//******
								switch($vmass[0]){
									case 'inputtext':
										echo "<tr><td width=\"200\" height=\"35\">Стиль</td><td>";
										$eventArray = explode(";", $vmass[5]);
										$aEventArray = array();
										foreach($eventArray as $eventVal){
											$eventVal = explode("=", $eventVal);
											$aEventArray[$eventVal[0]] = $eventVal[1];
										}
										$eventArray = $aEventArray;
										echo " <select id=\"5_prm_$key\"  onChange=\"__aofm_getTextEvent(this)\" >";
											echo "<option value=\"\"></option>";
											echo "<option value=\"onChange\">onChange</option>";
											echo "<option value=\"onKeyUp\">onKeyUp</option>";
											echo "<option value=\"onKeyDown\">onKeyDown</option>";
											echo "<option value=\"onFocus\">onFocus</option>";
											//foreach($eventArray as $eventKey=>$eventVal){
											//	echo "<option value=\"$eventKey\">$eventKey</option>";
											//}
											//echo "<option value=\"onKeyUp\">onChange</option>";
											//echo "<option value=\"onKeyDown\">onChange</option>";
										echo "</select>";
										//print_r($eventArray);
										echo "<script>\n";
											echo "var eventArray_$key = {};\n";
											foreach($eventArray as $eventKey=>$eventVal){
												echo "eventArray_".$key."['$eventKey']='$eventVal';\n";
											}
											//echo "alert(eventArray_$key+'eventArray_$key');\n";
										echo "</script>\n";
										echo "&nbsp;&nbsp;&nbsp;<input id=\"6_prm_$key\" type=\"text\" style=\"width:150px;\" value='$vmass[6]'  ";
										echo " onKeyUp=\"__aofm_setTextEvent(this)\" style=\"display:none;\" / >  ";
										echo "<img src=\"images/green/icons/delete.gif\" align=\"absmiddle\" id=\"off_prm_$key\" style=\"display:none;\">";
										echo "</td></tr>";
										break;
									case 'selectfromitems':
										echo "<tr><td width=\"200\" height=\"35\">Таблица</td><td>";
										echo " <input id=\"3_prm_$key\" type=\"text\" style=\"width:200px;\"  value='$vmass[4]' / > ";
										echo "</td></tr>";
										echo "<tr><td width=\"200\" height=\"35\">Путь к дирректории выбора</td><td>";
										echo " <input id=\"4_prm_$key\" type=\"text\" style=\"width:200px;\"  value='$vmass[5]' / > ";
										echo "</td></tr>";
										echo "<tr><td width=\"200\" height=\"35\">Название (латинское) для фильтра</td><td>";
										echo " <input id=\"5_prm_$key\" type=\"text\" style=\"width:60px;\"  value='$vmass[6]' / > ";
										echo "</td></tr>";
										break;
								}
								//echo "<pre>"; print_r($vmass); echo "</pre>";
								echo "</table>";
								//******
								if($vmass[0] == "selectfromitems_many"){
									echo " <input id=\"4_prm_$key\" type=\"text\" style=\"width:60px;\"  value='$vmass[5]' / > ";
									echo " <input id=\"5_prm_$key\" type=\"text\" style=\"width:60px;\"  value='$vmass[6]' / > ";
								}
								echo "<br/><br/>";
								echo "<a onclick=\"save_code($key);\" href=\"javascript:\">";
								echo "<img src=\"images/green/save.gif\" width=\"100\" height=\"18\" border=\"0\"></a> ";
								echo "<a href=\"javascript:cancel_field($id)\">";
								echo "<img src=\"images/green/cancel.gif\" width=\"100\" height=\"18\" border=\"0\"></a> ";
								echo "<a href=\"javascript:delete_fm_field($key, $id)\">";
								echo "<img src=\"images/green/delete.gif\" width=\"100\" height=\"18\" border=\"0\"></a>";
								//echo "<pre>"; print_r($vmass); echo "</pre>";
							echo "</div>";
}
//*************************
function inside_item($key, $vmass, $typesmass){
							echo "<div id=\"ssprm_$key\"  style=\"display:;\">";
								//print_r($typesmass);
								echo " <select id=\"0_prm_$key\"  onChange=\"get_template_fields(this.value)\">";
								echo "	<option value=\"0\" >Тип поля</option>";
								foreach($typesmass as $k=>$v){
									echo "<option value=\"$v\" ";
									if($v==$vmass[0])  echo " selected ";
									echo ">$v</option>";
								}
								echo "</select> ";
								//******
								if($vmass[0] == "inputtext")
									echo __ff_get_textfield_fields($vmass[1], $key);
								if($vmass[0] == "number")
									echo __ff_get_numfield_fields($vmass[1], $key);
								if($vmass[0] == "double")
									echo __ff_get_double_fields($vmass[1], $key);
								if($vmass[0] == "inputcheckbox")
									echo __ff_get_checkbox_fields($vmass[1], $key);
								if($vmass[0] == "selectrectofolder")
									echo " <input id=\"1_prm_$key\" type=\"hidden\"  value='rtf' / > ";
								if($vmass[0] == "selectfromitems")
									echo __ff_get_selectfromitems_fields( $vmass[1], $key );
								if($vmass[0] == "selectfromitems_many")
									echo __ff_get_selectfromitems_many_fields( $vmass[1], $key );
								//******
								echo " <input id=\"2_prm_$key\" type=\"text\" style=\"width:150px;\" value='$vmass[3]' / > ";
								echo " <input id=\"3_prm_$key\" type=\"text\" style=\"width:150px;\" value='$vmass[4]' / > ";
								//******
								if($vmass[0] == "inputtext"){
									$eventArray = explode(";", $vmass[5]);
									$aEventArray = array();
									foreach($eventArray as $eventVal){
										$eventVal = explode("=", $eventVal);
										$aEventArray[$eventVal[0]] = $eventVal[1];
									}
									$eventArray = $aEventArray;
									echo " <select id=\"5_prm_$key\"  onChange=\"__aofm_getTextEvent(this)\" >";
										echo "<option value=\"\"></option>";
										echo "<option value=\"onChange\">onChange</option>";
										echo "<option value=\"onKeyUp\">onKeyUp</option>";
										echo "<option value=\"onKeyDown\">onKeyDown</option>";
										echo "<option value=\"onFocus\">onFocus</option>";
										//foreach($eventArray as $eventKey=>$eventVal){
										//	echo "<option value=\"$eventKey\">$eventKey</option>";
										//}
										//echo "<option value=\"onKeyUp\">onChange</option>";
										//echo "<option value=\"onKeyDown\">onChange</option>";
									echo "</select>";
									//print_r($eventArray);
									echo "<script>\n";
										echo "var eventArray_$key = {};\n";
										foreach($eventArray as $eventKey=>$eventVal){
											echo "eventArray_".$key."['$eventKey']='$eventVal';\n";
										}
										//echo "alert(eventArray_$key+'eventArray_$key');\n";
									echo "</script>\n";
									echo "&nbsp;&nbsp;&nbsp;<input id=\"6_prm_$key\" type=\"text\" style=\"width:150px;\" value='$vmass[6]'  ";
									echo " onKeyUp=\"__aofm_setTextEvent(this)\" style=\"display:none;\" / >  ";
									echo "<img src=\"images/green/icons/delete.gif\" align=\"absmiddle\" id=\"off_prm_$key\" style=\"display:none;\">";
								}
								//echo "<pre>"; print_r($vmass); echo "</pre>";
								//******
								if($vmass[0] == "selectfromitems"){
									echo " <input id=\"4_prm_$key\" type=\"text\" style=\"width:200px;\"  value='$vmass[5]' / > ";
									echo " <input id=\"5_prm_$key\" type=\"text\" style=\"width:60px;\"  value='$vmass[6]' / > ";
								}
								if($vmass[0] == "selectfromitems_many"){
									echo " <input id=\"4_prm_$key\" type=\"text\" style=\"width:60px;\"  value='$vmass[5]' / > ";
									echo " <input id=\"5_prm_$key\" type=\"text\" style=\"width:60px;\"  value='$vmass[6]' / > ";
								}
								echo "<br/><br/>";
								echo "<a onclick=\"save_code();\" href=\"javascript:\">";
								echo "<img src=\"images/green/save.gif\" width=\"100\" height=\"18\" border=\"0\"></a> ";
								echo "<a href=\"javascript:cancel_field()\">";
								echo "<img src=\"images/green/cancel.gif\" width=\"100\" height=\"18\" border=\"0\"></a> ";
								echo "<a href=\"javascript:delete_fm_field($key)\">";
								echo "<img src=\"images/green/delete.gif\" width=\"100\" height=\"18\" border=\"0\"></a>";
								//echo "<pre>"; print_r($vmass); echo "</pre>";
							echo "</div>";
}
//*************************
if($paction=="get_template"){ 
	$id = $_POST["tid"];
	if($id){
		$query = "select * from itemstypes where id=$id";
		$resp = mysql_query($query);
		$row = mysql_fetch_assoc($resp);
		$mass = explode("\n", $row["pairs"]);
		//echo "<div id=\"div_myitemname\">test test</div>";
		echo "<div class=\"ui-state-default-3\" id=\"myitems_sortable\">";
			foreach($mass as $key=>$val){
				$vmass = explode("===", $val);
				echo "<div  class=\"ui-state-default-2\" id=\"prm_$key\">";
					echo "<div id=\"sprm_$key\" class=\"div_myitemname\" style=\"cursor:pointer;\">";
						echo "<img width=\"16\" height=\"16\" src=\"images/of/fm_add_$vmass[0].gif\" align=\"absmiddle\"> ";
						//echo "vmass=".$vmass[count($vmass)-1];
						//***********************************************************
						$vmass[count($vmass)-1] = trim($vmass[count($vmass)-1]);
						if($vmass[count($vmass)-1] == "alisa_activefilter"){
							echo "<img id=\"f_prm_$key\" onClick=\"toggle_filter(this.id);return false;\"  
							src=\"images/green/icons/infilter.gif\" align=\"absmiddle\" title=\"Включить в фильтр\"> ";
						} else {
							echo "<img id=\"f_prm_$key\" onClick=\"toggle_filter(this.id);return false;\"  
							src=\"images/green/icons/infilter_no.gif\" align=\"absmiddle\" title=\"Включить в фильтр\"> ";
						}
						//***********************************************************
						$vmass[count($vmass)-2] = trim($vmass[count($vmass)-2]);
						if($vmass[count($vmass)-2] == "alisa_activemultiitem"){
							echo "<img id=\"f_prm_$key\" onClick=\"toggle_filter(this.id);return false;\"  
							src=\"images/green/myitemname_popup/multiitem_active.gif\" align=\"absmiddle\" title=\"Включить в фильтр\"> ";
						} else {
							echo "<img id=\"f_prm_$key\" onClick=\"toggle_filter(this.id);return false;\"  
							src=\"images/green/myitemname_popup/multiitem.gif\" align=\"absmiddle\" title=\"Включить в фильтр\"> ";
						}
						//***********************************************************
						if($vmass[0] == "artikul"){
							echo "Код-Артикул-P/N";
							echo " <input id=\"1_prm_$key\" type=\"hidden\"  value='' / > ";
						} elseif($vmass[0] == "parent"){
							echo "Родительский модуль";
							echo " <input id=\"1_prm_$key\" type=\"hidden\"  value='' / > ";
						} elseif($vmass[0] == "images"){
							echo "Изображения";
							echo " <input id=\"1_prm_$key\" type=\"hidden\"  value='' / > ";
						} elseif($vmass[0] == "textarea"){
							echo "Текстовый блок";
							echo " <input id=\"1_prm_$key\" type=\"hidden\"  value='' / > ";
						} elseif($vmass[0] == "saveblock"){
							echo "Блок сохранения информации";
							echo " <input id=\"1_prm_$key\" type=\"hidden\"  value='' / > ";
						} elseif($vmass[0] == "usercomments"){
							echo "Комментарии пользователей";
							echo " <input id=\"1_prm_$key\" type=\"hidden\"  value='' / > ";
						} elseif($vmass[0] == "pricedigit"){
							echo "Опция цены";
							echo " <input id=\"1_prm_$key\" type=\"hidden\"  value='' / > ";
						} elseif($vmass[0] == "semp"){
							echo "Присоединяемые модели";
							echo " <input id=\"1_prm_$key\" type=\"hidden\"  value='' / > ";
						} elseif($vmass[0] == "grabber"){
							echo "Определить граббер";
							echo " <input id=\"1_prm_$key\" type=\"hidden\"  value='' / > ";
						} elseif($vmass[0] == "color"){
							echo "Цвет";
							echo " <input id=\"1_prm_$key\" type=\"hidden\"  value='' / > ";
						} elseif($vmass[0] == "coder"){
							echo "Поле программного кода";
							echo " <input id=\"1_prm_$key\" type=\"hidden\"  value='' / > ";
						} else {
							echo "$vmass[3]";
						}
						//inside_item	($key, $vmass, $typesmass);
					echo "</div>";
				echo "</div>";
			}
		echo "</div>";
	}
}
//*************************
if($paction=="save_template"){
	$tid = $_POST["tid"];
	$code = iconv("UTF-8", "CP1251", $_POST["code"]);
	$query = "select * from itemstypes where id=$tid ";
	$resp = mysql_query($query);
	$row = mysql_fetch_assoc($resp);
	echo $row['cont'];
	//$query = "update itemstypes set pairs='$code' where id=$tid ";
	//$resp = mysql_query($query);
	echo "tid=$tid\n\n$code";
}
//*************************
if($paction=="save_template_2"){
	$tid = $_POST["tid"];
	$index = $_POST['index'];
	$code = iconv("UTF-8", "CP1251", $_POST["code"]);
	$query = "select * from itemstypes where id=$tid ";
	$resp = mysql_query($query);
	$row = mysql_fetch_assoc($resp);
	//echo $row['pairs']."\n\n";
	$mass = explode("\n", $row['pairs']);
	//print_r($mass);
	$ncode = "";
	foreach($mass as $key=>$value){
			if($index==$key){
				$ncode .= $code."\n";
			}else{
				$ncode .= $value."\n";
			}
	}
	$ncode = preg_replace("/\\n$/", "", $ncode);
	$query = "update itemstypes set pairs='$ncode' where id=$tid ";
	$resp = mysql_query($query);
	echo "tid=$tid :: index=$index\n\n$ncode";
}
//*************************
if($paction=="save_newtype"){
	$nrus = iconv("UTF-8", "CP1251", $_POST["nrus"]);
	$neng = iconv("UTF-8", "CP1251", $_POST["neng"]);
	$query = "insert into itemstypes (name, rus_name, pairs) VALUES ('$neng',  '$nrus', 'saveblock===') ";
	//echo $query;
	$resp = mysql_query($query);
	$resp = mysql_query("select id from itemstypes order by id desc limit 0,1");
	$row = mysql_fetch_assoc($resp);
	echo $row["id"];
}
//*************************
if($paction=="get_field_template"){
	$id = $_POST["tid"];
	$prmKey = $_POST["prmkey"];
	$value = $_POST["value"];
	if($id){
		$query = "select * from itemstypes where id=$id";
		$resp = mysql_query($query);
		$row = mysql_fetch_assoc($resp);
		$mass = explode("\n", $row["pairs"]);
		foreach($mass as $key=>$val){
			if($prmKey==$key){
				$vmass = explode("===", $val);
				if($value!='undefined'){
					$vmass['0'] = $value;
				}
				echo "<div id=\"sprm_$key\" class=\"div_myitemname\" style=\"height:auto;\">";
				inside_item_2	($key, $vmass, $typesmass, $typesmass_comment, $id);
				echo "</div>";
			}
		}
	}
}
//*************************
if($paction=="add_item_to_teplate"){
	$tid = $_POST["tid"];
	$type = $_POST["type"];
	$query = "select * from itemstypes where id=$tid ";
	$resp = mysql_query($query);
	$row = mysql_fetch_assoc($resp);
	$query = "update itemstypes set pairs='$row[pairs]\n".$type."===' where id=$tid ";
	$resp = mysql_query($query);
}
//*************************
if($paction=="delete_item_from_teplate"){
	$id = $_POST["id"];
	$key = $_POST["key"];
	$query = "select * from itemstypes where id=$id ";
	$resp = mysql_query($query);
	$row = mysql_fetch_assoc($resp);
	$mass = explode("\n", $row['pairs']);
	$code = "";
	foreach($mass as $key2=>$value){
		if($key2!=$key){
			$code .= $value."\n";
		}
	}
	$code = preg_replace("/\\n$/", "", $code);
	$query = "update itemstypes set pairs='$code' where id=$id ";
	$resp = mysql_query($query);
}
//*************************
if($paction=="get_database"){
	global $defaultFields;
	echo "<div style=\"background-color:#FFFFFF;padding:10px;\"><h2>Управление полями в базе</h2>";
	$query = "SHOW FIELDS FROM items";
	$resp = mysql_query($query);
	while($row=mysql_fetch_assoc($resp)){
		$test = true;
		foreach($defaultFields as $value){
			if($value == $row['Field']){
				$test = false;
			}
		}
		if($test){ ?>
		<div style="border-bottom:solid 1px #CCCCCC; cursor:pointer; padding:5px;" 
		onmouseover="this.style.backgroundColor='#CCCCCC'"
		onmouseout="this.style.backgroundColor='#FFFFFF'"
		><?=$row['Field']?>
		<img src="images/green/myitemname_popup/delete_item.gif" align="absmiddle" style="float:right;margin-left:10px;"
		onClick="__aofm_deleteFlieldFromDatabase('<?=$row['Field']?>')"  />&nbsp;
		<!--<img src="images/green/myitemname_popup/edit_item.gif" align="absmiddle" style="float:right;margin-left:10px;"  />&nbsp;-->
		</div>
	<? } }
	echo "</div>";
}
//*************************
if($paction=="add_field_to_database"){
	$name = $_POST['name'];
	$type = $_POST['type'];
	$length = $_POST['length'];
	$default = $_POST['default'];
	if($type=="text"){
		$query = "ALTER TABLE  `items` ADD  `$name` VARCHAR( $length ) NOT NULL DEFAULT  '$default' ";
	}
	if($type=="int"){
		$query = "ALTER TABLE  `items` ADD  `$name` INT( $length ) NOT NULL DEFAULT  '$default' ";
	}
	if($type=="double"){
		$query = "ALTER TABLE  `items` ADD  `$name` DOUBLE NOT NULL DEFAULT  '$default' ";
	}
	//echo $query;
	$resp = mysql_query($query);
	if(!$resp) echo "Произошла ошибка";
}
//*************************
//*************************
if($paction=="delete_field_from_database"){
	$name = $_POST['name'];
	$query = "ALTER TABLE `items` DROP `$name` ";
	$resp = mysql_query($query);
	if(!$resp) echo "Произошла ошибка";
}
//*************************

//*************************

//*************************
?>