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
$typesmass[] = "inputtext";
$typesmass[] = "number";
$typesmass[] = "parent";
$typesmass[] = "datepicker";
$typesmass[] = "hidden";
$typesmass[] = "images";
$typesmass[] = "textarea";
$typesmass[] = "selectgaltype";
$typesmass[] = "saveblock";
$typesmass[] = "usercomments";
$typesmass[] = "inputcheckbox";
$typesmass[] = "selectrectofolder";
$typesmass[] = "selectoutmark";
$typesmass[] = "selectassocfile";
$typesmass[] = "artikul";
$typesmass[] = "selectmanytomany";
$typesmass[] = "selectfromitems";
$typesmass[] = "pricedigit";
$typesmass[] = "multiprice";
$typesmass[] = "grabber";
$typesmass[] = "coder";
$typesmass[] = "selectfromitems_many";
$typesmass[] = "color";
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
							echo "<div id=\"ssprm_$key\"  style=\"display:none;\">";
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
									echo " onChange <input id=\"5_prm_$key\" type=\"text\" value='$vmass[5]'  />";
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
	$query = "update itemstypes set pairs='$code' where id=$tid ";
	$resp = mysql_query($query);
	echo "tid=$tid\n\n$code";
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

?>