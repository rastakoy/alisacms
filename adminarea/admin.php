<?php
$__tree_show_image = 1;
$tree_index = 0;
//**************************************
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
require_once("../__config.php");
require_once("../core/__functions.php");
require_once("../core/__functions_csv.php");
require_once("../core/__functions_tree_semantic.php");
require_once("../core/__functions_images.php");
require_once("../core/__functions_pages.php");
require_once("../core/__functions_sitemap_0.1.php");
dbgo();
$outinfo = "";
//require_once("__class_csvToArray.php"); // Загрузка файла библиотеки
//$csv_class =& new csvToArray("csv_class"); //Объявление класса csv 
$__page_parent=$_GET["parent"];
//print_r($_POST);

?>

<html>
<?  require_once("__head.php"); ?>

<body id="root_body">

<?  require_once("__tiny.php"); ?>
<div id="divinfo" style="display:none;"></div>
<div id="popupmy" style="display:none;">Тестируем проверку попапов для редактирования, скажем названия и описания изображения</div>
<div class="menu" id="inleftmenu"><div class="submenu">
	<div class="menutitle">Главное меню</div>
	<?  require_once("__menu.php"); ?>
</div></div>
<img src="images/green/left_panel_close.gif" id="left_panel_close" width="10" height="50"/>
<table border="0" cellpadding="0" cellspacing="0" class="adminarea">
  <tr>
    <td class="adminarealeft" id="tdadminarealeft"><img src="images/spacer.gif" width="350" height="5"/></td>
    <td class="adminarearight" valign="top">
		<div class="admintitle">
		<a href="javascript:addItemToCatalog(0)" id="add_item_to_cat_button">Добавить запись</a>
		<a href="javascript:addUserToUsers()" id="add_user_button" style="display:none;">Добавить пользователя</a>
		<a href="javascript:addItemToCatalog(1)" id="add_folder_to_cat_button">Добавить группу</a>
		<a href="javascript:editItemToCatalog('1');" id="edit_folder_cat_button">Свойства группы</a>
		<a href="javascript:" id="deletefolderbutton">Удалить группу</a>
		<a href="javascript:show_ritems('help');" id="outerhelp">?</a>
		<span style="padding-top:5px; display:block;">&nbsp;AlisaCMS 5.3</span>
	    <?  //echo $__page_title; ?>
		</div>
		<div style="float:none; clear:both;"></div>
		<div class="manageadminforms" id="edit_content" style="display:none;">
		  А вот сюда загрузится модуль редактирования папки
		</div>
		<div class="manageadminforms" id="help_content" style="display:none;">
		  Справка будет тут
		</div>
		
	  <div id="nztime"></div>
	  
</td></tr></table>
<div id="div_uc_window" style="display:none;"><img src="images/green/icon_close_ucw.gif" class="img_icucw" onClick="close_ucw()">
<h3>Комментарии пользователя</h3><div id="div_ucw_cont"></div></div>

<div class="ui-state-default-3" id="helptitles" style="display:none;">
<div id="helptitles_title">Справка :: AlisaCMS 2.2
<img src="images/green/myitemname_popup/help_close.gif" align="right" style="cursor:pointer;"
onclick="close_help_titles()" />
<img src="images/green/myitemname_popup/help_sver.gif" align="right" style="cursor:pointer;"
onclick="help_sver_menu_toggle(this)" />
</div><div id="helptitles_cont"></div></div>

<script>
get_menu("0");
show_ritems("0");
</script>
<? if($error) echo "<script>alert('$error')</script>"; ?>
<?  require_once("__footer.php"); ?>
<? 
//$resp = mysql_query("select * from zakaz where remember=1 order by adddate desc limit 0,1");
//$row=mysql_fetch_assoc($resp);
//echo "<script>nztime=$row[adddate]; test_new_zakaz();</script>";
?>
</body>
</html>