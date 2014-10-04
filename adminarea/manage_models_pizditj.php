<?php
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
require_once("../__config.php");
require_once("../__functions.php");
require_once("../__functions_csv.php");
require_once("../__functions_tree.php");
require_once("../__functions_images.php");
dbgo();
require_once("__class_csvToArray.php"); // Загрузка файла библиотеки
$csv_class =& new csvToArray("csv_class"); //Объявление класса csv 

eval(strip_get_vars_eval($HTTP_GET_VARS));
eval(strip_post_vars_eval($HTTP_POST_VARS));
if($name_folder) $name=$name_folder;
//print_r($_POST);

if(!$parent) $parent="0";
$__page_name = "manage_models";
if($parent){
$resp = mysql_query("select * from items_arsenal where id=$parent");
$row = mysql_fetch_assoc($resp);
}
$__parafraf_name = $row["name"];
$__page_title = "Каталог продукции";
if($parent) $__page_title.= " — $__parafraf_name";
$__delete_link = "manage_models_pizditj.php?delete=$delete&access=true&parent=$parent";
$__cancel_link = "manage_models_pizditj.php?parent=$parent";
?>
<html>
<?  require_once("__head.php"); ?>
<?  require_once("__js_select_open_window_models.php"); ?>
<?  require_once("__js_show_block.php"); ?>
<?  //require_once("__catch_pizd.php"); ?>
<script><!--
function test_frame(){
	//alert(document.getElementById("data_csv_0_0").value); // = tdList[j].innerHTML;
	alert("OK!");
}
--></script>
<?  //require_once("__catch_pizd.php"); ?>
<?
//PROGRAM CODE HERE
//****************
if($delete && $access){
	delete_items($delete);
	$parent = "0";
}
//****************
if($edit){
	$resp = mysql_query("select * from items_arsenal where id=$edit");
	$row = mysql_fetch_assoc($resp);
	$edit_mass = $row;
}
//****************
if($edit_folder){
	$resp = mysql_query("select * from items_arsenal where id=$edit_folder");
	$row = mysql_fetch_assoc($resp);
	$edit_mass = $row;
}
//****************
if($edited){
	$resp = mysql_query("select * from items_arsenal where id=$edited");
	$row = mysql_fetch_assoc($resp);
	$edited_mass = $row;
}
//****************
if($name!="") //Если отправлена информация о обновлении
{
if(!$prior) $prior="0";
if(!$hot_item) $hot_item="0";
if(!$out_price) $out_price = "0";
if(!$parent2) $parent2="0";
if(!$parent3) $parent3="0";

//-----------------Загрузка рисунка-----------------------
if ($_FILES["userfile"]["name"]!="") {
	$image1 = __images_load_and_convert($HTTP_POST_FILES, "userfile", 2000000, "../tmp/", "../models_images/", 800);
	//echo "test return = ".$image1."<br/>\n";
}
//********************************************************************************************
//********************************************************************************************
if($_POST["data_csv"]){
if(!$edited_folder && !$new_folder){
	$filename_csv = trim($filename_csv);
	if(!$filename_csv) $filename_csv="temp";
	$csv_file = set_name_csv("../csv/", $filename_csv.".csv", 0);
	if($edited)
		if($edited_mass["csv"]!="")
			if(file_exists("../csv/".$edited_mass["csv"]))
				$csv_file = $edited_mass["csv"];
	
	$not_null = false;
	foreach($HTTP_POST_VARS["data_csv"] as $key=>$val)
		foreach($val as $k=>$v)
			if($v!="") $not_null =true;
	
	if($not_null && !$del2){
		$image2 = $csv_file;
		if($edit_mass["csv"]!=""){
			$fp=fopen("../csv/".$csv_file, "w");
			@fclose($fp);
		}
		//*****************
		foreach($HTTP_POST_VARS["data_csv"] as $key=>$val){
			for($i=0; $i<$cells_csv; $i++){
				if($i==$cells_csv-1){
					//print_r($val);
					$conte.=add_kav_csv($val[$i]);
				}
				else{
					//print_r($val);
					$conte.=add_kav_csv($val[$i]).";";
				}
			}
			$conte.="\n";
		}
		//echo"--$csv_file--";
		//if (!is_writeable("../csv/".$csv_file)){chmod("../csv/".$csv_file, 0777);}
		$fp=fopen("../csv/".$csv_file, "w");
		fwrite($fp, $conte);
		@fclose($fp);
		//*****************
	}
}
}
if ($_FILES["userfile2"]["name"]) {
// uploading file to the server dir
    if ($_FILES["userfile2"]["size"]>$max_csv_file_size) { echo "Слишком большой файл $userfile2_name!<br>\n"; exit; }
	if($edited){
		if(file_exists("../csv/".$_FILES["userfile2"]["name"])){
			echo "Задайте другое имя, так как csv-файл с таким именем уже существует";
			if($_FILES["userfile2"]["name"]!="")
				unlink("../models_images/".$_FILES["userfile2"]["name"]);
			exit();
		}
	}
   	$res = copy($_FILES["userfile2"]["tmp_name"], "../csv/".$_FILES["userfile2"]["name"]);
   	if (!$res){
		echo "Ошибка загрузки!<br>\nНевозможно скопировать файл"; exit;
	}
$image2 = $_FILES["userfile2"]["name"];
}
//-----------------Загрузка рисунка-----------------------
if ($_FILES["userfile3"]["name"]!="") {
	$image3 = __images_load_and_convert($HTTP_POST_FILES, "userfile3", 2000000, "../tmp/", "../models_images2/", 800);
	//echo "test return = ".$image1."<br/>\n";
}
//********************************************************************************************
$itemadddate = mktime (date("G") ,date("i") ,date("s") , date("m")  ,date("d"),date("Y"));
if(!$hot_item) $hot_item="0";
if($codes){
	$cresp = mysql_query("select * from managers where codes='$codes' ");
	$crow = mysql_fetch_assoc($cresp);
	$codes=$crow["id"];
} else {
	$codes="0";
}

require_once("__pizd_img.php");

$query = "insert into items_arsenal 
(id, name, link, parent, cont, csv, prior, price, model_name, out_price, image_tree, itemadddate, hot_item, out_mark, out_manager,
parent2, parent3, dop_page, source)  	
				VALUES 
(NULL, '$name' , '$image1', $parent, '$cont', '$image2', 
$prior, '$price', '$model_name', '$out_price', '$image3', 
$itemadddate, $hot_item, $out_mark, $codes, $parent2, $parent3, $dop_page, '$source')";
if($new_folder==2){
	$query = "insert into items_arsenal (id, name, parent, folder, prior)  	
				VALUES (NULL, '$name', $parent, 1, $prior)";
}
if($edited)
{
	$i_m = "";
	$i_i = "";
	$i_3 = "";
	if( $image1 != "" ) { $i_m   = " link =  '$image1'   , "  ;}
	if( $image2 != "" ) {  $i_i   = " csv =  '$image2'   , "  ;}
	if( $image3 != "" ) {  $i_3   = " image_tree =  '$image3'   , "  ;}
	
	if($del1){  $i_m   = " link=  ''   , "  ;
	//Delete code here...
	$respt = mysql_query("select link from items_arsenal where id = $edited");
	$rowt = mysql_fetch_assoc($respt);
	if(file_exists("../models_images/$rowt[link]") && $rowt['pic']!=""){
		unlink("../models_images/$rowt[link]");
		}
	}
	if($del2){  $i_m   = " csv=  ''   , "  ;
	//Delete code here...
	$respt = mysql_query("select csv from items_arsenal where id = $edited");
	$rowt = mysql_fetch_assoc($respt);
	if(file_exists("../csv/$rowt[csv]") && $rowt['csv']!=""){
		unlink("../csv/$rowt[csv]");
		}
	}
	if($del3){  $i_3   = " image_tree =  ''   , "  ;
	//Delete code here...
	$respt = mysql_query("select image_tree from items_arsenal where id = $edited");
	$rowt = mysql_fetch_assoc($respt);
	if(file_exists("../models_images2/$rowt[image_tree]") && $rowt['image_tree']!=""){
		unlink("../models_images2/$rowt[image_tree]");
		}
	}
	$query = "update items_arsenal SET $i_m  $i_i  $i_3  name='$name', cont='$cont' , 
							prior=$prior, price='$price', model_name='$model_name', out_price=$out_price, 
							hot_item=$hot_item, parent=$parent, out_mark=$out_mark, parent2=$parent2,
							parent3=$parent3, dop_page=$dop_page  where id = $edited";
}
if($edited_folder)
{
	$query = "update items_arsenal SET $i_m  $i_i  $i_3  name='$name', parent=$parent, prior=$prior  where id = $edited_folder";
}
	echo $query;
	$resp = mysql_query($query);
}//Конец условия
//*******************************************************
//****************
?>

<!-- TinyMCE -->
<script language="javascript" type="text/javascript" src="tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
	tinyMCE.init({
		mode : "textareas",
		theme : "advanced",
		plugins : "table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,zoom,media,searchreplace,print,contextmenu,paste,directionality,fullscreen",
		//theme_advanced_buttons1_add_before : "save,newdocument,separator",
		//theme_advanced_buttons1_add : "fontselect,fontsizeselect",
		theme_advanced_buttons2_add : "separator,insertdate,inserttime,preview,zoom,separator,forecolor,backcolor",
		//theme_advanced_buttons2_add_before: "cut,copy,paste,pastetext,pasteword,separator,search,replace,separator",
		//theme_advanced_buttons3_add_before : "tablecontrols,separator",
		//theme_advanced_buttons3_add : "emotions,iespell,media,advhr,separator,print,separator,ltr,rtl,separator,fullscreen",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		//theme_advanced_statusbar_location : "bottom",
		//content_css : "example_word.css",
	    //plugi2n_insertdate_dateFormat : "%Y-%m-%d",
	    //plugi2n_insertdate_timeFormat : "%H:%M:%S",
		//external_link_list_url : "example_link_list.js",
		//external_image_list_url : "example_image_list.js",
		//media_external_list_url : "example_media_list.js",
		//file_browser_callback : "fileBrowserCallBack",
		paste_use_dialog : false,
		theme_advanced_resizing : true,
		theme_advanced_resize_horizontal : false,
		//theme_advanced_link_targets : "_something=My somthing;_something2=My somthing2;_something3=My somthing3;",
		paste_auto_cleanup_on_paste : true,
		//paste_convert_headers_to_strong : false,
		//paste_strip_class_attributes : "all",
		//paste_remove_spans : false,
		paste_remove_styles : false		
	});

	function fileBrowserCallBack(field_name, url, type, win) {
		// This is where you insert your custom filebrowser logic
		alert("Filebrowser callback: field_name: " + field_name + ", url: " + url + ", type: " + type);

		// Insert new URL, this would normaly be done in a popup
		win.document.forms[0].elements[field_name].value = "someurl.htm";
	}

</script>
<!-- /TinyMCE -->

<body>
<div class="menu" style="display:none"><div class="submenu">
	<div class="menutitle">Главное меню</div>
	<?  require_once("__menu.php"); ?>
</div></div>
<table border="0" cellpadding="0" cellspacing="0" class="adminarea">
  <tr>
    <td class="adminarealeft"><img src="images/spacer.gif" width="250" height="5"/></td>
    <td class="adminarearight" valign="top">
		<div class="admintitle"><?  echo $__page_title; ?></div>
		
		<?
		if($delete && !$access){
				$resp = mysql_query("select * from items_arsenal where id = $delete");
				$row = mysql_fetch_assoc($resp);
				if($row["folder"] == "1")
					$__delete_html_code = "Вы действительно желаете удалить группу <strong>";
				else
					$__delete_html_code = "Вы действительно желаете удалить объект <strong>";
				$__delete_html_code.="«$row[name]»? ";
				if($row["folder"] != "1"){
					if($row['link']!=""){
						$__delete_html_code.="<img src=\"../imgres.php?resize=60&link=models_images/$row[link]\" 
						width=\"60\" height=\"45\" class=\"imggal\" align=\"absmiddle\">";
					}
					else{
						$__delete_html_code.="<img src=\"../images/not_img.jpg\" alt=\"Изображене отсутствует\" 
						width=\"60\" height=\"45\" class=\"imggal\" align=\"absmiddle\">";
					}
				}
		  		$__delete_html_code.="</strong>";
				require_once("__delete_access.php");
		}
		else{
		?>
		<div class="manageadminforms">
		  <?  require_once("__manage_input_forms_02.php"); ?>
	  </div>
		<form action="manage_models_pizditj.php<? if($edit_folder) echo "?edited_folder=$edit_folder"; else echo "?new_folder=2"; ?>" method="post" enctype="multipart/form-data" name="form2" id="myform2">
		<div class="adminforms" id="adminforms2" <? if(!$edit_folder) echo "style=\"display:none\""; ?>>
		  <table width="100%" border="0" cellspacing="0" cellpadding="6">
            <tr>
              <td class="inputtitle" valign="middle">Название группы </td>
              <td class="inputinput" valign="middle"><span class="inputinput-comm">
                <input name="name_folder" type="text" id="name_folder" value="<? if($edit_folder) echo $edit_mass["name"]; ?>">
              </span></td>
              <td class="inputcomment" valign="middle"><strong>Пример введения информации :<br>
              </strong> Введите название группы. <font color="#FF0000"><br>
              <br>
              Параметр обязательный для заполнения! </font></td>
            </tr>
          </table>
		  <table width="100%" border="0" cellspacing="0" cellpadding="6">
            <tr>
              <td class="inputtitle" valign="middle">Приоритет показа </td>
              <td class="inputinput" valign="middle"><span class="inputinput-comm">
                <input name="prior" type="text" id="prior" value="<? if($edit_folder) echo $edit_mass["prior"]; ?>">
              </span></td>
              <td class="inputcomment" valign="middle"><strong>Пример введения информации :<br>
                </strong> Введите цифру приоритета. <font color="#FF0000">&nbsp;</font></td>
            </tr>
          </table>
		  <table width="100%" border="0" cellspacing="0" cellpadding="6">
            <tr>
              <td class="inputtitle" valign="middle">Родительская группа</td>
              <td class="inputinput" valign="middle"><span class="inputinput-comm">
                <select name="parent">
				<option value="0">--Выберите родительскую группу--</option>
				<?
				if($edit_folder)
					echo __fmt_rekursiya_show_items_for_select(0, $edit_mass, $edit_folder, 0);
				else
					echo __fmt_rekursiya_show_items_for_select(0, false, false, 0, $parent);
				?>
				</select>	
              </span></td>
              <td class="inputcomment" valign="middle"><strong>Пример введения информации :<br>
                </strong> Выберите родительскую групу. <br>
                <br>
                Если не выбирать ничего, то группа будет корневой </td>
            </tr>
          </table>
		  <?  
		  if($edit_mass["csv"]!="") {
		  	if(file_exists("../csv/$edit_mass[csv]")){
				$link_csv = "../csv/$edit_mass[csv]";
				$mass_csv = $csv_class->parse("../csv/".$edit_mass["csv"]);
			}
		  }
		  ?>
<div class="inputsubmit"><input type="submit" name="Submit" value="Отправить данные"></div>
		</div></form>
		<?
		echo "<hr size=\"1\">";
		echo "<div style=\"padding-top:10 px;\">
				<div style=\"height: 30px;\"><strong>Навигация</strong>
				</div>";
		require_once("tree/__js_show_tree_block.php");
		if($parent){
			$st_resp = mysql_query("select * from items_arsenal where id=$parent");
			$st_row = mysql_fetch_assoc($st_resp);
			echo __farmmed_rekursiya_show_items(0, $st_row, $parent, 0);
		}
		else{
			echo __farmmed_rekursiya_show_items(0, false, false, 0);
		}
		if($parent!="0") {
			$par_mass = __fmt_find_item_parent_id($parent);
			echo "<script>\n";
			for($i=count($par_mass)-1; $i>0; $i--)
				echo "show_tree_item($par_mass[$i], 0);\n" ;
			echo "</script>\n";
		}
		echo "<hr size=\"1\"></div>";
		if($parent){
		?>
		<div class="manageadminforms"><?  require_once("__manage_input_forms.php"); ?></div>
		<form name="load_form"></form>
		<form action="manage_models_pizditj.php?parent=<? echo $parent; ?><? if($edit) echo "&edited=$edit"; ?>" method="post" enctype="multipart/form-data" name="form1">
		<div class="adminforms" id="adminforms" <? if(!$edit) echo "style=\"display:none\""; ?>>
		 
		  <table width="100%" border="0" cellspacing="0" cellpadding="6">
            <tr>
              <td class="inputtitle" valign="middle">Название модели </td>
              <td class="inputinput" valign="middle">
                <input name="name" type="text" id="name" value="<? if($edit) echo $edit_mass["name"]; ?>" style="width: 400px;">
<?  require_once("__test_item_name.php"); ?>
			  </td>
              <td class="inputcomment" valign="middle"><strong>Пример введения информации :<br>
              </strong> Введите название модели. <font color="#FF0000"><br>
              <br>
              Параметр обязательный для заполнения! </font></td>
            </tr>
          </table>
		  <table width="100%" border="0" cellspacing="0" cellpadding="6">
            <tr>
              <td class="inputtitle" valign="middle">Родительская группа</td>
              <td class="inputinput" valign="middle"><span class="inputinput-comm">
                <select name="parent">
                  <option value="0">--Выберите родительскую группу--</option>
                  <?
				if($edit_folder)
					echo __fmt_rekursiya_show_items_for_select(0, $edit_mass, $edit_folder, 0);
				else
					echo __fmt_rekursiya_show_items_for_select(0, false, false, 0, $parent);
				?>
                </select>
              </span></td>
              <td class="inputcomment" valign="middle"><strong>Пример введения информации :<br>
                </strong> Выберите родительскую групу. <br>
                <br>
                Если не выбирать ничего, то группа будет корневой </td>
            </tr>
          </table>
		  <table width="100%" border="0" cellspacing="0" cellpadding="6">
            <tr>
              <td class="inputtitle" valign="middle">Родительская группа 2 </td>
              <td class="inputinput" valign="middle"><span class="inputinput-comm">
                <select name="parent2" id="parent2">
                  <option value="0">--Выберите родительскую группу--</option>
                  <?
				if($row["parent2"]){
					$edit_mass["parent"]=$row["parent2"];
				}
				if($row["parent2"])
					echo __fmt_rekursiya_show_items_for_select(0, $edit_mass, $row["parent2"], 0);
				else
					echo __fmt_rekursiya_show_items_for_select(0, false, false, 0, $parent);
				?>
                </select>
              </span></td>
              <td class="inputcomment" valign="middle"><strong>Пример введения информации :<br>
                </strong> Выберите родительскую групу. <br>
                <br>
                Если не выбирать ничего, то группа будет корневой </td>
            </tr>
          </table>
		  <table width="100%" border="0" cellspacing="0" cellpadding="6">
            <tr>
              <td class="inputtitle" valign="middle">Родительская группа 3 </td>
              <td class="inputinput" valign="middle"><span class="inputinput-comm">
                <select name="parent3" id="parent3">
                  <option value="0">--Выберите родительскую группу--</option>
                  <?
				if($row["parent3"]){
					$edit_mass["parent"]=$row["parent3"];
				}
				if($row["parent3"])
					echo __fmt_rekursiya_show_items_for_select(0, $edit_mass, $row["parent3"], 0);
				else
					echo __fmt_rekursiya_show_items_for_select(0, false, false, 0, $parent);
				?>
                </select>
              </span></td>
              <td class="inputcomment" valign="middle"><strong>Пример введения информации :<br>
                </strong> Выберите родительскую групу. <br>
                <br>
                Если не выбирать ничего, то группа будет корневой </td>
            </tr>
          </table>
		  <table width="100%" border="0" cellspacing="0" cellpadding="6">
            <tr>
              <td class="inputtitle-comm" valign="middle">Описание</td>
              <td valign="middle" class="inputcomment" id="asdqwe">
			  <textarea id="cont" name="cont" rows="15" cols="80" style="width: 100%"><? echo $row["cont"]; ?></textarea>
			  </td>
            </tr>
          </table>
		  <table width="100%" border="0" cellspacing="0" cellpadding="6">
            <tr>
              <td class="inputtitle" valign="middle">Изображение<br>
                модели </td>
              <td class="inputinput" valign="middle"><?
					 if($edit &&  $edit_mass['link']!=""){
						?>
                  <img src="../imgres.php?resize=60&link=<? echo "models_images/".$edit_mass['link']; ?>"  
						width="60" height="45" class="imggal"><br>
                Удалить изображение
                <input type="checkbox" name="del1" value="true">
                <? }
					else{
				   		?>
                <input name="userfile" type="file" id="userfile">
                <?
					}
					?>
              </td>
              <td class="inputcomment" valign="middle"><strong>Пример введения информации :<br>
                </strong> Выберите файл изображения в формате <strong>jpg, png </strong>или<strong> gif </strong>c пропорцией размера, желательно, <strong> 4:3</strong> (800х600, 
                например).<br>
                Размер файла не должен превышать 500 Кб. </td>
            </tr>
          </table>
		  <table width="100%" border="0" cellspacing="0" cellpadding="6">
            <tr>
              <td class="inputtitle" valign="middle">Изображение<br>
                модели (дополнительно) </td>
              <td class="inputinput" valign="middle"><?
					 if($edit &&  $edit_mass['image_tree']!=""){
						?>
                  <img src="../imgres.php?resize=60&link=<? echo "models_images2/".$edit_mass['image_tree']; ?>"  
						width="60" height="45" class="imggal"><br>
                Удалить изображение
                <input name="del3" type="checkbox" id="del3" value="true">
                <? }
					else{
				   		?>
                <input name="userfile3" type="file" id="userfile3">
                <?
					}
					?>
              </td>
              <td class="inputcomment" valign="middle"><strong>Пример введения информации :<br>
                </strong> Выберите файл изображения в формате <strong>jpg, png </strong>или<strong> gif </strong>c пропорцией размера, желательно, <strong> 4:3</strong> (800х600, 
                например).<br>
                Размер файла не должен превышать 500 Кб. </td>
            </tr>
          </table>
		  <table width="100%" border="0" cellspacing="0" cellpadding="6">
            <tr>
              <td class="inputtitle" valign="middle">Изображение<br>
                модели (<font color="#FF0000">СПЕЦ</font>) </td>
              <td class="inputinput" valign="middle"><input name="specimg" type="text" id="specimg" style="width: 100%;"></td>
              <td class="inputcomment" valign="middle">&nbsp;</td>
            </tr>
          </table>
		  <table width="100%" border="0" cellspacing="0" cellpadding="6">
            <tr>
              <td class="inputtitle" valign="middle">Торговая марка </td>
              <td class="inputinput" valign="middle"><input name="model_name" type="text" id="model_name" value="<? if($edit) echo $edit_mass["model_name"]; ?>">
              </td>
              <td class="inputcomment" valign="middle"><strong>Пример введения информации :<br>
              </strong> Введите название торговой марки. <font color="#FF0000">&nbsp;</font></td>
            </tr>
          </table>
		  <table width="100%" border="0" cellspacing="0" cellpadding="6">
            <tr>
              <td class="inputtitle" valign="middle">Торговая марка </td>
              <td class="inputinput" valign="middle"><select name="out_mark" id="out_mark">
                  <option value="0">Выберите торговую марку</option>
                  <?
				$resp_mark = mysql_query("select * from marks order by name asc");
				while($row_mark= mysql_fetch_assoc($resp_mark)){
					echo "<option value=\"$row_mark[id]\" ";
					if($row_mark["id"] == $edit_mass["out_mark"] && $edit){ 
						echo " selected ";
					}
					if(!$edit && $row_mark["id"]==63) echo "  selected ";
					echo ">$row_mark[name]</option>\n\n";
				}
				?>
                </select>
              </td>
              <td class="inputcomment" valign="middle"><strong>Пример введения информации :<br>
              </strong> Выберите соответствующий прайс. <font color="#FF0000">&nbsp;</font></td>
            </tr>
          </table>
		  <table width="100%" border="0" cellspacing="0" cellpadding="6">
            <tr>
              <td class="inputtitle" valign="middle">Присоединенный прайс </td>
              <td class="inputinput" valign="middle"><select name="out_price" id="out_price">
                <option value="0">Выберите прайс-лист</option>
				<?
				$resp_price = mysql_query("select * from prices");
				while($row_price= mysql_fetch_assoc($resp_price)){
					echo "<option value=\"$row_price[id]\" ";
					if($row_price["id"] == $edit_mass["out_price"] && $edit){ 
						echo " selected ";
					}
					echo ">$row_price[name]</option>\n\n";
				}
				?>
              </select>
              </td>
              <td class="inputcomment" valign="middle"><strong>Пример введения информации :<br>
              </strong> Выберите соответствующий прайс. <font color="#FF0000">&nbsp;</font></td>
            </tr>
          </table>
		  <table width="100%" border="0" cellspacing="0" cellpadding="6">
            <tr>
              <td class="inputtitle" valign="middle">Присоединить дополнительную информацию </td>
              <td class="inputinput" valign="middle"><select name="dop_page" id="dop_page">
                  <option value="0">Выберите страницу</option>
                  <?
				$resp_dp = mysql_query("select * from items_02 where folder=0 order by name asc");
				while($row_dp= mysql_fetch_assoc($resp_dp)){
					echo "<option value=\"$row_dp[id]\" ";
					if($row_dp["id"] == $edit_mass["dop_page"] && $edit){ 
						echo " selected ";
					}
					echo ">$row_dp[name]</option>\n\n";
				}
				?>
                </select>
              </td>
              <td class="inputcomment" valign="middle"><strong>Пример введения информации :<br>
              </strong> Выберите соответствующую страницу. <font color="#FF0000">&nbsp;</font></td>
            </tr>
          </table>
		  <table width="100%" border="0" cellspacing="0" cellpadding="6">
            <tr>
              <td class="inputtitle" valign="middle">Приоритет показа </td>
              <td class="inputinput" valign="middle">
			  <?
			  if(!$edit){
			  $resp_prior = mysql_query("select * from items_arsenal where parent=$parent order by prior desc limit 0,1");
			  $row_prior=mysql_fetch_assoc($resp_prior);
			  }
			  ?>
			  <input name="prior" type="text" id="prior" value="<? if($edit) echo $edit_mass["prior"]; else echo $row_prior["prior"]+5; ?>"></td>
              <td class="inputcomment" valign="middle"><strong>Пример введения информации :<br>
              </strong> Введите цену изделия. <font color="#FF0000">&nbsp;</font></td>
            </tr>
          </table>
		  <table width="100%" border="0" cellspacing="0" cellpadding="6">
            <tr>
              <td class="inputtitle" valign="middle">Специальное предложение </td>
              <td class="inputinput" valign="middle">
			  <input name="hot_item" type="checkbox" 
			  id="hot_item" value="1" <?  if($edit_mass["hot_item"]) echo "checked"; ?>>
			  </td>
              <td class="inputcomment" valign="middle"><strong>Пример введения информации :<br>
              </strong> поставьте галочку, если хотите, чтобы товар попал в спис сециальных предложений, показанных на главной странице сайта. <font color="#FF0000">&nbsp;</font></td>
            </tr>
          </table>
		  <table width="100%" border="0" cellspacing="0" cellpadding="6">
            <tr>
              <td class="inputtitle" valign="middle">Источник  </td>
              <td class="inputinput" valign="middle">
			  <input name="source" type="text" id="source" value="<? if($edit) echo $edit_mass["source"]; ?>" style="width: 100%"></td>
              <td class="inputcomment" valign="middle"><strong>Пример введения информации :<br>
              </strong> Введите адрес страницы-источника. <font color="#FF0000">&nbsp;</font></td>
            </tr>
          </table>
		  <? if(!$edit) { ?>
		  <table width="100%" border="0" cellspacing="0" cellpadding="6">
            <tr>
              <td class="inputtitle" valign="middle">Код ответственного лица  </td>
              <td class="inputinput" valign="middle"><input name="codes" type="text" id="codes" value="186654" >
              </td>
              <td class="inputcomment" valign="middle"><strong>Пример введения информации :<br>
              </strong> Введите код ответственного лица, если код не будет введен, то будет неизвестно, кто добавил данные. <font color="#FF0000">&nbsp;</font></td>
            </tr>
          </table>
		  <? } ?>
		  <?  
		  if($edit_mass["csv"]!="") {
		  	if(file_exists("../csv/$edit_mass[csv]")){
				$link_csv = "../csv/$edit_mass[csv]";
				$mass_csv = $csv_class->parse("../csv/".$edit_mass["csv"]);
			}
		  }
		  ?>
<? 
		  require_once("__manage_csv.php"); 
		  ?>
<div class="inputsubmit"><input type="submit" name="Submit" value="Отправить данные"></div>
		</div></form>
		<div class="adminitems">
		<div style="height: 30px;"><a href="javascript:show_hide_pizd()">Показать фрейм</a></div>
		<script>
		function show_hide_pizd(){
			//alert(window.clipboardData.getData('Text'));
			d = window.prompt ("Адес страницы", "");
			if(d!="") document.getElementById("source").value=d;
			//d= "http://dewalt.vseinstrumenti.ru/pila_nastolnaya_dewalt_dw_745.html";
			obj_p = document.getElementById("pizd");
			if(obj_p.innerHTML=="") obj_p.innerHTML = "<iframe width=\"100%\" height=\"500\"  frameborder=\"0\"  src=\"virus.php?adres="+d+"&site=makita.ua\" />";
			else obj_p.innerHTML = "";
		}
		</script>
		<div id="pizd" ></div>
		</div>
		<div class="adminitems">
		  <div class="itemstitle">Модели пункта "<?  echo $__parafraf_name; ?>":</div>
		  <table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#CCCCCC">
            <?
	  $resp = mysql_query("select * from items_arsenal where parent=$parent and folder=0 order by prior asc ");
	  while($row=mysql_fetch_assoc($resp)){
 	  ?>
            <tr bgcolor="#FFFFFF">
              <td width="70" height="47" bgcolor="#FFFFFF"><div align="center">
                  <?
		  if($row['link']!=""){
		  ?>
                  <img src="../imgres.php?resize=60&link=<? 
		  echo "models_images/".$row['link'];
		  ?>" width="60" height="45" class="imggal">
                  <?
		  }
		  else{?>
                  <img src="../images/not_img.jpg" alt="Изображене отсутствует" width="60" height="45" class="imggal">
                  <?
		  }
		  ?>
              </div></td>
              <td width="180" bgcolor="#FFFFFF"><div align="left">
			  <? 
			  	if($row["hot_item"] == 1)
			  		echo "<font color=\"red\">".$row['name']."</font>"; 
				else
			    	echo $row['name']; 
			  ?>
			  </div></td>
              <td width="40"><div align="center"><strong><? echo $row['prior']; ?></strong></div></td>
              <td width="110"><a href="<? echo "?parent=$parent&edit=$row[id]"; ?>">Редактировать</a></td>
			  <td width="110"><?  if($row["source"])  { ?><a href="<? echo "$row[source]"; ?>" target="_blank">Источник</a><? } ?></td>
              <td><a href="<? echo "?parent=$parent&delete=$row[id]"; ?>"><font color="#FF0000">Удалить</font></a></td>
            </tr>
            <? 
		} 
		?>
          </table>
		</div>
		<?
		}
		}
		?>
	</td>
  </tr>
</table>
<?  require_once("__footer.php"); ?>
</body>
</html>