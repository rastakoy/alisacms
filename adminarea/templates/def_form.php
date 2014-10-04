<form name="itemformname" method="post" action="">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td colspan="2" class="td_itemedit_bbgtop" 
	  style="height:50px; font-size: 16px;"><strong><? echo $row["name"]; ?> (ред.)</strong></td>
    </tr>
	<tr>
      <td width="200" height="30">Название</td>
      <td><input name="item_name" type="text" id="item_name" value="<? echo $row["name"]; ?>" style="width:100%"></td>
    </tr>
    <tr>
      <td height="30">HTML-путь</td>
      <td><input name="item_href_name" type="text" id="item_href_name" value="<? echo $row["href_name"]; ?>" style="width:100%" /></td>
    </tr>
	<tr>
      <td height="30">head-Заголовок</td>
      <td><input name="item_mtitle" type="text" id="item_mtitle" value="<? echo $row["mtitle"]; ?>" style="width:100%" /></td>
    </tr>
	<tr>
      <td height="30">head-описание</td>
      <td><input name="item_mdesc" type="text" id="item_mdesc" value="<? echo $row["mdesc"]; ?>" style="width:100%" /></td>
    </tr>
	<tr>
      <td height="30">SEO-Заголовок</td>
      <td><input name="item_mh" type="text" id="item_mh" value="<? echo $row["mh"]; ?>" style="width:100%" /></td>
    </tr>
    <tr>
      <td height="30"><span class="inputtitle">Приоритет показа </span></td>
      <td><input name="item_prior" type="text" id="item_prior" value="<? echo $row["prior"]; ?>" style="width:100%"></td>
    </tr>
	<tr>
      <td width="200" height="30">Показывать страницу </td>
      <td><input name="page_show" type="checkbox" id="page_show" value="1" <?  if($row["page_show"] == 1) echo "checked"; ?> /></td>
	</tr>
	<tr>
      <td width="200" height="30">Тип галереи</td>
      <td><select name="galtype" id="galtype">
			<option value="0" <?  if($row["galtype"]==0) echo " selected "; ?>>Галерея не задана</option>
			<option value="1" <?  if($row["galtype"]==1) echo " selected "; ?>>Fancybox</option>
		</select></td>
    </tr>
	<tr>
      <td colspan="2" align="center" style="height:35px;">
	  <a href="javascript:getiteminfo_save(<?  echo $row["id"]; ?>)"><img src="images/green/save.gif" width="100" height="18" border="0"></a>
	  <a href="javascript:getiteminfo_close(<?  echo $row["id"]; ?>)"><img src="images/green/cancel.gif" width="100" height="18" border="0"></a><br/>	  </td>
    </tr>
	<tr>
      <td valign="top" style="padding-top: 10px;">Изображения<hr size="1"/ style="width: 180px;"><font color="#FF0000">Все действия<br/>с изображениями<br/>сохраняются мгновенно</font></td>
      <td valign="top" style="padding: 5px; margin-bottom: 20px; min-height:220px;">
<div id="myDiv"><?  echo show_images_for_items($row["id"]); ?></div>
<div style="float:none; clear:both"></div>
<ul id="sortable" style="display:none; margin-top:30px;"></ul>
<div style="float:none; clear:both"></div>	  </td>
    </tr>
	<tr>
      <td colspan="2" style="padding:5px;" valign="top" id="td_item_content"><?  echo get_item_content($row["id"]); ?></td>
    </tr>
    <tr>
      <td colspan="2" class="td_itemedit_bbg" style="height:70px;" align="center">
	  <a href="javascript:getiteminfo_save(<?  echo $row["id"]; ?>)"><img src="images/green/save.gif" width="100" height="18" border="0"></a>
	  <a href="javascript:getiteminfo_close(<?  echo $row["id"]; ?>)"><img src="images/green/cancel.gif" width="100" height="18" border="0"></a></td>
    </tr>
  </table>
</form>

<?  require("__context_menu.php"); ?>