<?
if(!$folder) $folder="0";
	$resp = mysql_query("select * from items where id=$id ");
	$row = mysql_fetch_assoc($resp);
	$edit_mass = $row;
	//if(!$row["name"]) $row["name"]="Корневая директория";
	//if(!$row["prior"]) $row["prior"]="999";
?>
<div class="folders_all">
Редактирование директории
<h1 id="folders_title" style="margin-bottom: 20px;">«<?  echo $edit_mass["name"]; ?>»</h1>
<form action="" method="post" enctype="multipart/form-data" name="form_edit_folder" id="form_edit_folder">
<input type="hidden" id="edit_folder_id" name="edit_folder_id" value="<?  echo $row["name"]; ?>"/>
<table style="border: 4px solid #A9C9A7;" width="100%" border="0" cellpadding="5" cellspacing="0" bgcolor="#FFFFFF">
<tr>
    <td width="250" height="35" class="folders_td_left">Название:</td>
    <td width="30">&nbsp;</td>
    <td width="400" class="folders_td_cont">
	<input type="text" name="folder_name" id="folder_name" class="folder_inputt" value="<?  echo $row["name"]; ?>"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="250" height="35" class="folders_td_left">Приоритет:</td>
    <td>&nbsp;</td>
    <td class="folders_td_cont" id="td_folder_prior">
	<input type="text" name="folder_prior" id="folder_prior" class="folder_inputt" value="<?  echo $row["prior"]; ?>">	</td>
    <td>&nbsp;</td>
  </tr>
  <?  if($parent=="0" || !$parent) { ?>
  <tr>
    <td width="250" height="35" class="folders_td_left">HTML-путь</td>
    <td>&nbsp;</td>
    <td class="folders_td_cont" id="td_folder_itemtype"><input type="text" 
	name="folder_href_name" id="folder_href_name" class="folder_inputt" value="<?  echo $row["href_name"]; ?>" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="250" height="35" class="folders_td_left">Родительская группа:</td>
    <td>&nbsp;</td>
    <td class="folders_td_cont" id="td_folder_parent">
	<?  echo "<div id=\"edit_folder_select_parent_tmp\"><input type=\"hidden\" id=\"edit_folder_id_tmp\" name=\"edit_folder_id_tmp\" value=\"$row[id]\" />";
		  echo "<select name=\"folder_parent\" class=\"folder_select\" id=\"folder_parent\">
				<option value=\"0\">Корневая</option>";
				if($id)
					echo __fmt_rekursiya_show_items_for_select("0", 0, $edit_mass, $id, 0);
				else
					echo __fmt_rekursiya_show_items_for_select("0", 0, false, false, 0, $parent);
	    echo "</select></div>"; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="250" height="35" valign="top" class="folders_td_left">Отображать на сайте: </td>
    <td valign="top">&nbsp;</td>
    <td valign="top" class="folders_td_folder_icon" id="td_folder_folder_icon"><input name="fpage_show" type="checkbox" id="fpage_show" value="1" <?  if($row["page_show"]) echo "checked"; ?> /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="250" valign="top" style="padding-top: 10px;">Изображения
      <hr size="1"/ style="width: 180px;" />
      <font color="#FF0000">Все действия<br/>
        с изображениями<br/>
        сохраняются мгновенно</font></td>
    <td colspan="3" valign="top" style="padding: 5px; margin-bottom: 20px; min-height:220px;"><div id="myDiv">
      <?  echo show_images_for_items($row["id"]); ?>
    </div>
        <div style="float:none; clear:both"></div>
      <ul id="sortable" style="display:none; margin-top:30px;">
      </ul>
      <div style="float:none; clear:both"></div></td>
	  </tr>
	  <tr>
    <td colspan="4" valign="top" class="folders_td_left"><fieldset>
	<legend id="folder_cont_leg"><b>Описание</b> —
	  <a href="javascript:fc_togtiny()">Включть редактор HTML</a></legend>
	  <textarea name="folder_cont" id="folder_cont"
	  style="width:100%; height:150px;"><?  echo $row["cont"]; ?></textarea>
	  </fieldset></td>
    </tr>
  <tr>
    <td height="35" colspan="4" valign="top" class="folders_td_left"><div align="center">
      <input type="hidden" 
	id="ffolder_id" name="ffolder_id" value="<?  echo $row["id"]; ?>" />
      <input type="button" name="Button" 
	value="Сохранить"  onclick="editItemToCatalog_post(<?  echo $row["id"]; ?>)"/>
    </div></td>
    </tr>
</table>
<p><img src="images/green/dop_folder_prop.jpg" width="30" height="30" align="absmiddle" /> <a href="javascript:show_dop_prop_folder()">Дополнительные настройки</a></p>
<table width="100%" border="0" cellspacing="0" cellpadding="5" id="folder_dop_prop" style="display:;">
  <tr>
    <td width="250" height="35" class="folders_td_left">Тип директории:</td>
    <td>&nbsp;</td>
    <td class="folders_td_cont" id="td_folder_itemtype"><select name="folder_item_type" class="folder_select" id="folder_item_type">
      <option value="0">Не задано</option>
      <? $respit = mysql_query("select * from itemstypes order by id asc");
		while($rowit = mysql_fetch_assoc($respit)){
			if($row["itemtype"] == $rowit["id"]) $selected = "selected"; else $selected = "";
			echo "<option value=\"$rowit[id]\" $selected >$rowit[name]</option>";
		} ?>
    </select>    </td>
    <td>&nbsp;</td>
  </tr>
  <?  } ?>
  <tr>
    <td width="250" height="35" class="folders_td_left">Сассоциировать с записью:</td>
    <td>&nbsp;</td>
    <td class="folders_td_cont" id="td_fassoc"><?  echo "<select name=\"fassoc\" class=\"folder_select\" id=\"fassoc\">
				<option value=\"0\">Не задано</option>";
				echo __fts_get_assoc_item($row["id"], $row["fassoc"]);
	    echo "</select></div>"; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="250" height="35" class="folders_td_left">Псевдономер:</td>
    <td>&nbsp;</td>
    <td class="folders_td_cont" id="td_fassoc"><input type="text" 
	name="psevdonum" id="psevdonum" class="folder_inputt" value="<?  echo $row["psevdonum"]; ?>" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="250" height="35" valign="top" class="folders_td_left">Ссылка на иконку-логотип:</td>
    <td valign="top">&nbsp;</td>
    <td valign="top" class="folders_td_folder_icon" id="td_folder_folder_icon"><input type="text" 
	name="folder_icon" id="folder_icon" class="folder_inputt" value="<?  echo $row["folder_icon"]; ?>" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="250" height="35" valign="top" class="folders_td_left">Meta title:</td>
    <td valign="top">&nbsp;</td>
    <td valign="top" class="folders_td_folder_icon" id="td_folder_folder_icon"><input type="text" 
	name="folder_title" id="folder_title" class="folder_inputt" value="<?  echo $row["mtitle"]; ?>" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="250" height="35" valign="top" class="folders_td_left">Meta description:</td>
    <td valign="top">&nbsp;</td>
    <td valign="top" class="folders_td_folder_icon" id="td_folder_folder_icon"><input type="text" 
	name="folder_desc" id="folder_desc" class="folder_inputt" value="<?  echo $row["mdesc"]; ?>" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="250" height="35" valign="top" class="folders_td_left">Артикул:</td>
    <td valign="top">&nbsp;</td>
    <td valign="top" class="folders_td_folder_icon" id="td_folder_folder_icon"><input type="text" 
	name="folder_art" id="folder_art" class="folder_inputt" value="<?  echo $row["item_art"]; ?>" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="250" height="35" valign="top" class="folders_td_left">Код:</td>
    <td valign="top">&nbsp;</td>
    <td valign="top" class="folders_td_folder_icon" id="td_folder_folder_icon"><input type="text" 
	name="folder_code" id="folder_code" class="folder_inputt" value="<?  echo $row["item_code"]; ?>" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="250" height="35" valign="top" class="folders_td_left">Активировать фильтр</td>
    <td valign="top"><input type="checkbox" id="cb_active_filter" onchange="active_filter(this, <?  echo $row["id"]; ?>)"></td>
    <td valign="top" class="folders_td_folder_icon" id="td_folder_folder_icon">asd<div id="div_active_filter_<?  echo $row["id"]; ?>" style="height:300px;"></div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="250" height="35" valign="top" class="folders_td_left">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top" class="folders_td_cont" id="td_folder_cont"><input type="hidden" 
	id="ffolder_id" name="ffolder_id" value="<?  echo $row["id"]; ?>" />
        <input type="button" name="Button" 
	value="Сохранить"  onclick="editItemToCatalog_post(<?  echo $row["id"]; ?>)"/></td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
</div>
<?  require("__context_menu.php"); ?>